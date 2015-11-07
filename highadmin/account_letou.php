<SCRIPT type="text/javascript">
//if (top.location == self.location) top.location.href = "index.php"; </script>
<?php
session_start();
error_reporting(0);
require_once 'conn.php';

if (strpos($_SESSION['flag'],'41') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

$starttime = $_REQUEST['starttime'];
$endtime = $_REQUEST['endtime'];
$status=$_REQUEST['status'];
$username=$_REQUEST['username'];
$id=$_REQUEST['id'];

if($_GET['act']=="dels"){       //批量删除   
	$ids=$_POST['lids'];  
	$ids=implode(",", $ids);   //implode函数 把数组元素组合为一个字符串。   
	$sql="delete from clg_letourecords where id in ($ids)";  
	mysql_query($sql); 
}

if($_GET['act']=="edit"){
	$sql="select * from clg_letourecords where dan='".$_POST['cdan']."'";
	$rs = mysql_query($sql);
	$row = mysql_fetch_array($rs);
	if($row['zt']==0){
			mysql_query("update clg_letourecords set nums='".$_POST['nums']."' where id='".$_POST['id']."'");		
			echo "<script>alert('修改成功！');window.location.href='account_letou.php;</script>";
			exit;
	}else{
		echo "<script>alert('该单不能被处理！');window.location.href='account_letou.php;</script>"; 
		exit;
	}
}

if($_GET['act']=="del"){
	mysql_query("Delete from clg_letourecords where id=".$_GET['id']);
	echo "<script>window.location.href='account_tz.php';</script>"; 
	exit;
}

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=50;
$page2=($page-1)*$pagesize;

if($starttime==""){
	if(date("H:i:s")<"03:00:00"){
		$starttime=date("Y-m-d",strtotime("-1 day"))." 03:00:00";
	}else{
		$starttime=date("Y-m-d")." 03:00:00";
	}
}
	$s1=$s1." and adddate>='".$starttime."'";

if($endtime==""){
	if(date("H:i:s")<"03:00:00"){
		$endtime=date("Y-m-d")." 03:00:00";
	}else{
		$endtime=date("Y-m-d",strtotime("+1 day"))." 03:00:00";
	}
}
	$s1=$s1." and adddate<='".$endtime."'";

if($status=="1"){//中奖
	$s1=$s1." and status='1'";
}else if($status=="2"){
	$s1=$s1." and status='2'";
}else if($status=="3"){
	$s1=$s1." and status='0'";
}else if($status=="4"){
	$s1=$s1." and (status='4' or status='5' or status='6')";//6开错奖撤
}

if($username!=""){
	$s1=$s1." and username='".$username."'";
}

if($id!=""){
	$s1=$s1." and dan='".$id."'";
}

$urls="starttime=".$starttime."&endtime=".$endtime."&username=".$username."&id=".$id."&status=".$status;
$s1=$s1." order by id desc";
$sql="select * from clg_letourecords where 1=1".$s1;

$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

$sql="select * from clg_letourecords where 1=1".$s1." limit $page2,$pagesize";
$rsnewslist=mysql_query($sql);

$lastpg=ceil($total/$pagesize); //最后页，也是总页数
$page=min($lastpg,$page);
$prepg=$page-1; //上一页
$nextpg=($page==$lastpg ? 0 : $page+1); //下一页

if($page<5){
	$p1=1;
	$p2=min($lastpg,10);
}else{
	$p2=min($lastpg,$page+5);
	$p1=max($p2-9,1);
}
?>
<html>
<head>
<link href="css/index.css" rel="stylesheet" type="text/css">
<link href="./css/v1/all2.css?modidate=20130201001" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="js/common.js"></script>
<script type="text/javascript" src="js/calendar/jquery.dyndatetime.js"></script>
<script type="text/javascript" src="js/calendar/lang/calendar-utf8.js"></script>
<script language="javascript" src="js/dialog/jquery.dialogUI.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="js/calendar/css/calendar-blue2.css"  />
<script type="text/javascript">
jQuery(document).ready(function() {		
	jQuery("#starttime").dynDateTime({
		ifFormat: "%Y-%m-%d %H:%M:00",
		daFormat: "%l;%M %p, %e %m,  %Y",
		align: "Br",
		electric: true,
		singleClick: false,
		button: ".next()", //next sibling
		onUpdate:function(){
			$("#starttime").change();
		},
		showOthers: true,
		weekNumbers: true,
		showsTime: true
	});
	jQuery("#starttime").change(function(){
		if(! validateInputDate(jQuery("#starttime").val()) )
		{
			jQuery("#starttime").val('');
			alert("时间格式不正确,正确的格式为:2011-01-01 12:01");
		}
		if($("#endtime").val()!="")
		{
			if($("#starttime").val()>$("#endtime").val())
			{
				$("#starttime").val("");
				alert("输入的时间不符合逻辑.");
			}
		}
	});
	jQuery("#endtime").dynDateTime({
		ifFormat: "%Y-%m-%d %H:%M:00",
		daFormat: "%l;%M %p, %e %m,  %Y",
		align: "Br",
		electric: true,
		singleClick: false,
		button: ".next()", //next sibling
		onUpdate:function(){
			$("#endtime").change();
		},
		showOthers: true,
		weekNumbers: true,
		showsTime: true
	});
	jQuery("#endtime").change(function(){
		if(! validateInputDate(jQuery("#endtime").val()) )
		{
			jQuery("#endtime").val('');
			alert("时间格式不正确,正确的格式为:2011-01-01 12:01");
		}
		if($("#starttime").val()!="")
		{
			if($("#starttime").val()>$("#endtime").val())
			{
				$("#endtime").val("");
				alert("输入的时间不符合逻辑.");
			}
		}
	});
});

var checkall=document.getElementsByName("lids[]");  
function select(){                          //全选   
	for(var $i=0;$i<checkall.length;$i++){  
		checkall[$i].checked=true;  
	} 
}  
function fanselect(){                        //反选   
	for(var $i=0;$i<checkall.length;$i++){  
		if(checkall[$i].checked){  
			checkall[$i].checked=false;  
		}else{  
			checkall[$i].checked=true;  
		}  
	}  
}           
function noselect(){                          //全不选   
	for(var $i=0;$i<checkall.length;$i++){  
		checkall[$i].checked=false;  
	}  
}  
</script>
<base target="mainframe" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body>
<br>
	<table width="95%" border="0" cellpadding="0" cellspacing="0" class="top_list">
      <tr>
        <td class="top_list_td icons_a4">　　您现在的位置是：业务流水 &gt; 投注记录</td>
      </tr>
    </table>
    <br>
    <form name="memberForm" method="post" action="?">
    <table width="95%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="top_list_td">投注时间:
          <input name="starttime" type="text" class="inpa" id="starttime" style='width:144px;' value="<?=$starttime?>" size="19" /><img class='icons_mb4' src="images/comm/t.gif" id="time_min_button" style="cursor:pointer;" />
            至
             <input name="endtime" type="text" class="inpa" id="endtime" style='width:144px;' value="<?=$endtime?>" size="19" / ><img class='icons_mb4' src="images/comm/t.gif" id="time_min_button" style="cursor:pointer;" />
             &nbsp;游戏状态:
             <select name="status">
               <option value="0" <?php if($status==0 || $status==""){echo "selected='selected'";}?> >全部</option>
               <option value="1" <?php if($status==1){echo "selected='selected'";}?> >已中奖</option>
               <option value="2" <?php if($status==2){echo "selected='selected'";}?>>未中奖</option>
               <option value="3" <?php if($status==3){echo "selected='selected'";}?>>未开奖</option>
               <option value="4" <?php if($status==4){echo "selected='selected'";}?>>已撤单</option>
             </select>
          &nbsp;注单编号:
        <input name="id" type="text" class="inpa" value="" size="15" maxlength="30" id="id">
&nbsp;用户名:
<input name="username" type="text" class="inpa" id="username" size="15" maxlength="30"></td>
      </tr>
    </table>
</form>
<br>
  	<form method=post action="?act=dels">
	<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
        <tr>
            <td class="t_list_caption">选择</td>
            <td class="t_list_caption">注单编号</td>
          <td class="t_list_caption">用户名</td>
          <td class="t_list_caption">投注时间</td>
            <td class="t_list_caption">期号</td>
            <td class="t_list_caption">投注内容</td>
            <td class="t_list_caption">投注金额</td>
            <td class="t_list_caption">奖金</td>
            <td class="t_list_caption">状态</td>
          <td class="t_list_caption">操作</td>
      </tr>
        <?php
		while ($row = mysql_fetch_array($rsnewslist))
		{
		?>
           <tr class="t_list_tr_0" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                <td><input name="lids[]" type="checkbox" id="checkbox2" value="<?=$row['id']?>"></td> 
                <td><a href="javascript:"  title="查看投注详情" class="blue" rel="projectinfo"><?=$row['dan']?></a></td>
                <td><?=$row['id']?></td>
                <td><?=$row['username']?></td>
                <td><?=$row['timestamp']?></td>
                <td><?=$row['letouid']?></td>
                <td><?php echo $row['nums'];?> </td>
                <td><?=$row['money']?></td>
                <td <?php if($row['prize_won']>=500){?>bgcolor="#FF0000"<?php }?>><?=$row['prize_won']?></td>
                <td><?php if($row['zt']==0){echo "未开奖";}else if($row['zt']==1){echo "<font color=#D90000>已派奖</font>";}else if($row['zt']==2){echo "<font color=#639300>未中奖</font>";}else if($row['zt']==4){echo "管理员撤单";}else if($row['zt']==5){echo "本人撤单";}else if($row['zt']==6){echo "开错奖撤单";}?></td>
                <td><a href="?act=cd&dan=<?=$row['dan']?>"  onClick="return confirm('确认要撤单吗?');">撤单</a> <a href="?act=del&id=<?=$row['id']?>"  onClick="return confirm('确认要删除吗?');">删除</a></td>
	  </tr>
 		<?php
		}
		?>

      <tr>
            <td colspan="17" class="t_list_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="170" height="35">　选择：<a href="javascript:select()">全选</a> - <a href="javascript:fanselect()">反选</a> - <a href="javascript:noselect()">不选</a></td>
                <td width="150"><input name="Submit" type="submit" class="btndel" onClick="return confirm('确认要删除吗?');" value=" " /></td>
                <td><div style='text-align:right;'>总计  <?=$total?> 条数据,  共 <?=$lastpg?> 页 , 当前第 <?=$page?> 页  |  <?php if($page>1){?> <A HREF="?<?=$urls?>&page=1">首页</A> <A HREF="?<?=$urls?>&page=<?=$page-1?>">上页</A><?php }?><?php for($i=$p1;$i<=$p2;$i++){
		if($i==$page){?> <span class='Font_R'><?=$i?></span> <?php }else{?> <A HREF="?<?=$urls?>&page=<?=$i?>"><?=$i?></A> <?php }}?><?php if($page!=$lastpg){?> <A HREF="?<?=$urls?>&page=<?=$page+1?>">下页</A> <A HREF="?<?=$urls?>&page=<?=$lastpg?>">尾页</A> <?php }?> | 转至 <SCRIPT LANGUAGE="JAVASCRIPT">function keepKeyNum(obj,evt){var  k=window.event?evt.keyCode:evt.which; if( k==13 ){ goPage(obj.value);return false; }} function goPage( iPage ){ if( !isNaN(parseInt(iPage)) ) { if(iPage< 0 ){iPage=0;} window.location.href="?<?=$urls?>&page="+iPage;}}</SCRIPT><INPUT onKeyPress="return keepKeyNum(this,event);" TYPE="TEXT" ID="iGotoPage" NAME="iGotoPage" size="3"> 页  &nbsp;<BUTTON onClick="javascript:goPage( document.getElementById('iGotoPage').value );return false;">GO</BUTTON></div></td>
              </tr>
            </table></td>
      </tr>
</table>
</form>
<br>

</body>
</html> 