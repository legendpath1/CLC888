<SCRIPT type="text/javascript">
//if (top.location == self.location) top.location.href = "index.php"; </script>
<?php
session_start();
error_reporting(0);
require_once 'conn.php';

if (strpos($_SESSION['flag'],'34') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

$jb=array("用户","代理","总代理"); 

$uname=$_REQUEST['uname'];

$username=$_REQUEST['username'];
$starttime = $_REQUEST['starttime'];
$endtime = $_REQUEST['endtime'];

$dan=$_REQUEST['dan'];
$zt=$_REQUEST['zt'];

$t_VIP_Estate=$_GET['t_VIP_Estate'];
$Stop_ID=$_GET['Stop_ID'];

if($_GET['act']=="dels"){       //批量删除   
	echo "<script language=javascript>alert('该操作已被关闭！');window.history.go(-1);</script>";
	exit;

	$ids=$_POST['lids'];  
	$ids=implode(",", $ids);   //implode函数 把数组元素组合为一个字符串。   
	$sql="delete from ssc_drawlist where id in ($ids)";  
	mysql_query($sql);  
	echo "<script>alert('删除成功！');window.location.href='account_txlist.php';</script>"; 
	exit;	
}

if($_GET['act']=="del"){
	echo "<script language=javascript>alert('该操作已被关闭！');window.history.go(-1);</script>";
	exit;

	mysql_query("Delete from ssc_drawlist where id=".$_GET['id']);
	echo "<script>alert('删除成功！');window.location.href='account_txlist.php';</script>"; 
	exit;
}

if($_GET['act']=="tx"){
	if($_POST['button']=="成功"){
		$sqla="update ssc_drawlist set cno='".$_POST['dan']."', cdate='".date("Y-m-d H:i:s")."', zt='1' where id='".$_POST['sid']."'";
	}else if($_POST['button']=="失败"){
		$sqla="update ssc_drawlist set cno='".$_POST['dan']."', cdate='".date("Y-m-d H:i:s")."', zt='2' where id='".$_POST['sid']."'";	
	}
	
	$exe=mysql_query($sqla) or  die("数据库修改出错6!!!");
	
	echo "<script>window.location.href='?';</script>"; 
	exit;
}

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
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
	
if($username!=""){
	$s1=$s1." and username='".$username."'";
}else{
	if($uname!=""){
		$s1=$s1." and username='".$uname."'";
	}
}

if($dan!=""){
	$s1=$s1." and id='".$dan."'";
}

if($zt!=""){
	$s1=$s1." and zt='".$zt."'";
}else{
	$s1=$s1." and zt!='0'";
}

$urls="starttime=".$starttime."&endtime=".$endtime."username=".$username."&dan=".$dan."&uname=".$uname."&zt=".$zt;

$s1=$s1." order by id desc";
$sql="select * from ssc_drawlist where 1=1".$s1;

$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

$sql="select sum(money) as smoney,sum(rmoney) as srmoney from ssc_drawlist where 1=1".$s1;
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs);
$smoney=number_format($row['smoney'],2);
$srmoney=number_format($row['srmoney'],2);


$sql="select * from ssc_drawlist where 1=1".$s1." limit $page2,$pagesize";
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
<base target="mainframe" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="js/common.js"></script>
<script type="text/javascript" src="js/calendar/jquery.dyndatetime.js"></script>
<script type="text/javascript" src="js/calendar/lang/calendar-utf8.js"></script>
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
<body>
<br>
	<table width="95%" border="0" cellpadding="0" cellspacing="0" class="top_list">
      <tr>
        <td class="top_list_td icons_a3">　　您现在的位置是：财务管理 &gt; 提现记录</td>
      </tr>
    </table>
    <br>
    <form name="memberForm" method="post" action="?">
    <table width="95%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="top_list_td"><input name="starttime" type="text" class="inpa" id="starttime" style='width:144px;' value="<?=$starttime?>" size="19" />
          <img class='icons_mb4' src="images/comm/t.gif" id="time_min_button" style="cursor:pointer;" /> 至
          <input name="endtime" type="text" class="inpa" id="endtime" style='width:144px;' value="<?=$endtime?>" size="19" / >
          <img class='icons_mb4' src="images/comm/t.gif" id="time_min_button" style="cursor:pointer;" />&nbsp;&nbsp;用户名: 
        <input type="text" name="username" maxlength="30" size="15" class="inpa" id="username">
          &nbsp;提现编号:
          <input type="text" name="dan" maxlength="30" size="15" value="" class="inpa" id="dan">
          &nbsp;状态:
          <select name="zt" style='cursor: hand' id="zt">
            <option value="" <?php if($zt=="") echo "selected";?>>全部</option>
            <option value="2" <?php if($zt=="2") echo "selected";?>>提现失败</option>
            <option value="1" <?php if($zt=="1") echo "selected";?>>提现成功</option>
                    </select>
          <input name="Find_VN" type="submit" class="btnb" value="搜 索" style="position: relative; top: 2px;"></td>
        <td width="100" class="top_list_td">&nbsp;</td>
      </tr>
    </table>
    </form>
<br>
  	<form method=post action="?act=dels">

<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
  <tr>
    <td class="t_list_caption">选择</td>
    <td class="t_list_caption">用户编号</td>
    <td class="t_list_caption">用户名</td>
    <td class="t_list_caption">提现编号</td>
    <td class="t_list_caption">申请发起时间</td>
	<td class="t_list_caption">提现银行</td>
	<td class="t_list_caption">开户省市</td>
    <td class="t_list_caption">支行名称</td>
    <td class="t_list_caption">开户姓名</td>
    <td class="t_list_caption">银行帐号</td>
    <td class="t_list_caption">提现金额</td>
    <td class="t_list_caption">手续费</td>
    <td class="t_list_caption">到账金额</td>
    <td class="t_list_caption">状态</td>
    
    <td class="t_list_caption">提现单号</td>
    <td class="t_list_caption">操作</td>
  </tr>
  <?php
		while ($row = mysql_fetch_array($rsnewslist))
		{
		?>
  <tr class="t_list_tr_0" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
    <td><input name="lids[]" type="checkbox" id="checkbox2" value="<?=$row['id']?>"></td>
    <td><?=$row['uid']?></td>
    <td><?=$row['username']?></td>
    <td><?=$row['dan']?></td>
    <td><?=$row['adddate']?></td>
	<td><?=$row['bank']?></td>
	<td><?=$row['province'].$row['city']?></td>
    <td><?=$row['branch']?></td>
    <td><?=$row['realname']?></td>
    <td><?=$row['cardno']?></td>
    <td><?=number_format($row['money'],2)?></td>
    <td><?=number_format($row['sxmoney'],2)?></td>
    <td><?=number_format($row['rmoney'],2)?></td>
    <td id="status"><?php if($row['zt']=="0"){?><font color="0000FF">等待处理</font><?php }else if($row['zt']=="1"){?><font color=#669900>提现成功</font><?php }else if($row['zt']=="2"){?><font color="#FF0000">提现失败</font><?php }?></td>
    <td><?=$row['cno']?></td>
    <td><a href="?act=del&id=<?=$row['id']?>" onClick="return confirm('确认要删除吗?');">删除</a></td>
  </tr>
  <?php
		}
		?>
  <tr>
    <td colspan="16" class="t_list_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="170" height="35">　选择：<a href="javascript:select()">全选</a> - <a href="javascript:fanselect()">反选</a> - <a href="javascript:noselect()">不选</a></td>
                <td width="150"><input name="Submit" type="submit" class="btndel" onClick="return confirm('确认要删除吗?');" value=" " /></td>
                <td><div style='text-align:right;'>提现总额:<?=$smoney?>到帐总额:<?=$srmoney?>&nbsp;&nbsp;总计  <?=$total?> 条数据,  共 <?=$lastpg?> 页 , 当前第 <?=$page?> 页  |  <?php if($page>1){?> <A HREF="?<?=$urls?>&page=1">首页</A> <A HREF="?<?=$urls?>&page=<?=$page-1?>">上页</A><?php }?><?php for($i=$p1;$i<=$p2;$i++){
		if($i==$page){?> <span class='Font_R'><?=$i?></span> <?php }else{?> <A HREF="?<?=$urls?>&page=<?=$i?>"><?=$i?></A> <?php }}?><?php if($page!=$lastpg){?> <A HREF="?<?=$urls?>&page=<?=$page+1?>">下页</A> <A HREF="?<?=$urls?>&page=<?=$lastpg?>">尾页</A> <?php }?> | 转至 <SCRIPT LANGUAGE="JAVASCRIPT">function keepKeyNum(obj,evt){var  k=window.event?evt.keyCode:evt.which; if( k==13 ){ goPage(obj.value);return false; }} function goPage( iPage ){ if( !isNaN(parseInt(iPage)) ) { if(iPage< 0 ){iPage=0;} window.location.href="?<?=$urls?>&page="+iPage;}}</SCRIPT><INPUT onKeyPress="return keepKeyNum(this,event);" TYPE="TEXT" ID="iGotoPage" NAME="iGotoPage" size="3"> 页  &nbsp;<BUTTON onClick="javascript:goPage( document.getElementById('iGotoPage').value );return false;">GO</BUTTON></div></td>
              </tr>
            </table></td>
  </tr>
</table>
</form>
<br>


</body>
</html> 