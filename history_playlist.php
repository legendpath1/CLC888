<?php
session_start();
error_reporting(0);
require_once 'conn.php';
$_SESSION["mainframe"] = '"./history_playlist.php"';

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=25;
$page2=($page-1)*$pagesize;

$starttime = $_REQUEST['starttime'];
$endtime=$_REQUEST['endtime'];
$status=$_REQUEST['status'];
$lotteryid=$_REQUEST['lotteryid'];
$methodid=$_REQUEST['methodid'];
$issue=$_REQUEST['issue'];
$mode=$_REQUEST['mode'];
$projectno=$_REQUEST['projectno'];
$username=$_REQUEST['username'];
$ranges=$_REQUEST['ranges'];
$isgetdata = $_REQUEST['isgetdata'];

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
	$s1=$s1." and zt='1'";
}else if($status=="2"){
	$s1=$s1." and zt='2'";
}else if($status=="3"){
	$s1=$s1." and zt='0'";
}else if($status=="4"){
	$s1=$s1." and (zt='4' or zt='5')";
}
if($lotteryid==""){
	$lotteryid=0;
}
if($methodid==""){
	$methodid=0;
}
if($issue==""){
	$issue=0;
}

if($lotteryid!="" && $lotteryid!="0"){
	$s1=$s1." and lotteryid='".$lotteryid."'";
}else{
	$lotteryid=0;
}
if($methodid!="" && $methodid!="0"){
	$s1=$s1." and mid='".$methodid."'";
}else{
	$methodid=0;
}
if($issue!="" && $issue!="0"){
	$s1=$s1." and issue='".$issue."'";
}
if($mode!="" && $mode!="0"){
	$s1=$s1." and mode='".$mode."'";
}
if($projectno!=""){
	$s1=$s1." and dan='".$projectno."'";
}

if($username!=""){
	$s1=$s1." and username='".$username."'";
}

if($ranges==""){
	$ranges="6";
}
if($ranges!=""){
	if($ranges=="2"){//全部
		$s1=$s1." and (username='".$_SESSION["username"]."' or regfrom like '%&".$_SESSION["username"]."&%')";	
	}else if($ranges=="6"){	//自己
		$s1=$s1." and username='".$_SESSION["username"]."'";
	}else if($ranges=="3"){	//直接下载
		$s1=$s1." and regup='".$_SESSION["username"]."'";
	}else if($ranges=="4"){	//所有下级
		$s1=$s1." and regfrom like '%&".$_SESSION["username"]."&%'";
	}
}
if($isgetdata!="1"){
	$s1=$s1." and 1=0";	
}

$urls="starttime=".$starttime."&endtime=".$endtime."&status=".$status."&lotteryid=".$lotteryid."&methodid=".$methodid."&issue=".$issue."&mode=".$mode."&projectno=".$projectno."&username=".$username."&ranges=".$ranges."&isgetdata=".$isgetdata;

$s1=$s1." order by id desc";
$sql="select * from ssc_bills where 1=1".$s1;
//echo $sql;
$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

$sql="select * from ssc_bills where 1=1".$s1." limit $page2,$pagesize";
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<head>
    <title>娱乐平台  - 投注记录</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
        <script>var pri_imgserver = '';</script>
        <link href="./css/v1/all.css?modidate=20130201001" rel="stylesheet" type="text/css" />
    <link href="./js/calendar/css/calendar-blue2.css?modidate=20130201001" rel="stylesheet" type="text/css" />
    <script language="javascript" type="text/javascript" src="./js/jquery.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/common.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/lottery/min/message.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/calendar/jquery.dyndatetime.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/calendar/lang/calendar-utf8.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/lottery/min/jquery.dialogUI.js?modidate=20130415002"></script>
    <script LANGUAGE='JavaScript'>function ResumeError() {return true;} window.onerror = ResumeError; </script> 
</head>
<body>
<div id="rightcon">
<div id="msgbox" class="win_bot" style="display:none;">
    <h5 id="msgtitle"></h5> <div class="wb_close" onclick="javascript:msgclose();"></div>
    <div class="clear"></div>
    <div class="wb_con">
            <p id="msgcontent"></p>
    </div>
    <div class="clear"></div>
    <a class="wb_p" href="#" onclick="javascript:prenotice();" id="msgpre">上一条</a><a class="wb_n" href="#" onclick="javascript:nextnotice();">下一条</a>
</div><script>
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
                $.alert("时间格式不正确,正确的格式为:2011-01-01 12:01");
            }
            if($("#endtime").val()!="")
            {
                if($("#starttime").val()>$("#endtime").val())
                {
                    $("#starttime").val("");
                    $.alert("输入的时间不符合逻辑.");
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
                $.alert("时间格式不正确,正确的格式为:2011-01-01 12:01");
            }
            if($("#starttime").val()!="")
            {
                if($("#starttime").val()>$("#endtime").val())
                {
                    $("#endtime").val("");
                    $.alert("输入的时间不符合逻辑.");
                }
            }
        });
        jQuery("#lotteryid").change(function(){
            var data_method = {
<?php for($i=1;$i<=14;$i=$i+1){
		echo "\"".$i."\":{";
		$sqlm="select * from ssc_class where cid='".$i."' and sign=1";
		$rsm = mysql_query($sqlm);
		$totalm = mysql_num_rows($rsm);
		$ii=0;
		while ($rowm = mysql_fetch_array($rsm)){		
			echo "\"".$rowm['mid']."\":{\"lotteryid\":\"".$i."\",\"methodid\":\"".$rowm['mid']."\",\"methodname\":".json_encode($rowm['name'])."}";
			if($ii!=$totalm-1){
				echo ",";
			}
			$ii=$ii+1;
		}
		echo "}";
		if($i!=14){
			echo ",";
		}
	}
?>};

            var data_issue = {
		<?php 
			for($i=1;$i<=14;$i++){
				echo "\"".$i."\":[";
				if($i==11 || $i==12){
					for($ii=0;$ii<20;$ii++){
						$dateend=date("Y-m-d",strtotime("-".$ii." day"));
						$issuey=date("Y",strtotime("-".$ii." day"));
						$tnums=sprintf("%03d",date("z",strtotime("-".$ii." day"))+1-7);
						echo "{\"issue\":\"".$issuey.$tnums."\",\"lotteryid\":\"".$i."\",\"dateend\":\"".$dateend."\"}";
						if($ii!=24){
							echo ",";
						}
					}
				}else{
					$sqls="select * from ssc_nums where cid='".$i."' and DATE_FORMAT(endtime, '%H:%i:%s')>='".date("H:i:s")."' order by id asc limit 1";
					$rss=mysql_query($sqls) or  die("数据库修改出错1");
					$rows = mysql_fetch_array($rss);
					$in=intval($rows['nums']);
					for($ii=0;$ii<$in;$ii++){
						echo "{\"issue\":\"".date("ymd").sprintf("%03d",$in-$ii)."\",\"lotteryid\":\"".$i."\",\"dateend\":\"".date("Y-m-d")."\"}";
						if($ii!=$in-1){
							echo ",";
						}
					}
				}
				echo "]";
				if($i!=14){
					echo ",";
				}
			}
		?>
};
            var obj_method = $("#methodid")[0];
            var obj_issue  = $("#issue")[0];
            i =  $("#lotteryid").val();
            $("#methodid").empty();
            $("#issue").empty();
            addItem( obj_method,'所有玩法',0 );
            addItem( obj_issue,'所有奖期',0 );
            if(i>0)
            {
                $.each(data_method[i],function(j,k){
//                    $.each(k,function(i,m){
                        addItem( obj_method,k.methodname,k.methodid );
//                    });
                });
                $.each(data_issue[i],function(j,k){
                    addItem( obj_issue,k.issue,k.issue );
                });		
            }
            SelectItem(obj_method,0);
            SelectItem(obj_issue,'0');
        });
        $("#lotteryid").val(0);
        $("#lotteryid").change();
        $("a[rel='morecode']").click(function(){
            if( $('#JS_openFloat').length >0 ){
                $(this).closeFloat();
            }
            var $html = $('<div class=fbox><table border=0 cellspacing=0 cellpadding=0><tr class=t><td class=tl></td><td class=tm></td><td class=tr></td></tr><tr class=mm><td class=ml><img src="./images/comm/t.gif"></td><td>号码详情:<br /><textarea class="ta">'+$(this).next("input").val()+'</textarea><br /><center><a href="javascript:" id="codeinfos" style="color:#000;text-decoration:none;">[关&nbsp;闭]</a></center></td><td class=mr><img src="./images/comm/t.gif"></td></tr><tr class=b><td class=bl></td><td class=bm><img src="./images/comm/t.gif"></td><td class=br></td></tr></table><div class=ar><div class=ic></div></div></div>');
            var offset = $(this).offset();
            var left = offset.left-20;
            var top  = offset.top-107;
            $(this).openFloat($html,"",left,top);
            var me = this;
            $("#codeinfos").click(function(){
                $(me).closeFloat();
            });
        });

    });
</script>
<div class="top_menu">
    <div class="tm_left"></div>
    <div class="tm_title"></div>
    <div class="tm_right"></div>
    <div class="tm_menu">
        <a href="/history_tasklist.php">追号记录</a>
        <a class="act" href="/history_playlist.php">投注记录</a>
    </div>
</div>
<form action="" method="get">
<div class="rc_con betting">
<div class="rc_con_lt"></div>
<div class="rc_con_rt"></div>
<div class="rc_con_lb"></div>
<div class="rc_con_rb"></div>
<div class="act title_menu"><input type="reset" value="清空查询条件"></div>
<h5><div class="rc_con_title">投注记录</div></h5>
<div class="rc_con_to">
<div class="rc_con_ti">
<div class="betting_input">			
<table class='st' border="0" cellspacing="0" cellpadding="0" width="100%">
    
        <input type="hidden" name="isgetdata" value="1">
        <tr>
            <td>
                游戏时间：<input type="text" id="starttime" name="starttime" style="width:150px;" value="<?=$starttime?>" /> <img class='icons_mb4' src="./images/comm/t.gif" id="time_min_button" style="cursor:pointer;" /> 至
                <input type="text" name="endtime" id="endtime" style="width:150px;" value="<?=$endtime?>" /> <img class='icons_mb4' src="./images/comm/t.gif" id="time_min_button" style="cursor:pointer;" />&nbsp;&nbsp;
                状态:
                <select name="status">
                    <option value="0" <?php if($status==0 || $status==""){echo "selected='selected'";}?>>全部</option>
                    <option value="1" <?php if($status==1){echo "selected='selected'";}?>>已中奖</option>
                    <option value="2" <?php if($status==2){echo "selected='selected'";}?>>未中奖</option>
                    <option value="3" <?php if($status==3){echo "selected='selected'";}?>>未开奖</option>
                    <option value="4" <?php if($status==4){echo "selected='selected'";}?>>已撤单</option>
                </select>&nbsp;&nbsp;&nbsp;&nbsp;<button name="submit" type="submit" width='69' height='26' class="btn_search" /></button>
            </td>
        </tr>
        <tr>
            <td>
                游戏名称：<select name="lotteryid" id="lotteryid" style="width:100px;">
                    <option value="0">所有游戏</option>
                                        <option value="1">重庆时时彩</option>
                                        <option value="2">十一运夺金</option>
                                        <option value="3">北京快乐八</option>
                                        <option value="4">上海时时乐</option>
                                        <option value="5">新疆时时彩</option>
                                        <option value="6">黑龙江时时彩</option>
                                        <option value="7">江西时时彩</option>
                                        <option value="8">江西多乐彩</option>
                                        <option value="9">广东十一选五</option>
                                        <option value="10">重庆十一选五</option>
                                        <option value="11">福彩3D</option>
                                        <option value="12">排列三、五</option>
                                        <option value="13">江苏快三</option>
                                        <option value="14">天津时时彩</option>
                                        <option value="16">如意分分彩</option>
                                        <option value="17">如意五分彩</option>
                                    </select>
                    游戏玩法: <select name='methodid' id='methodid'><option value='0' selected="selected">所有玩法</option></select>
                    &nbsp;&nbsp;游戏奖期: <select name='issue' id='issue'><option value='0' selected="selected">所有奖期</option></select>
                &nbsp;&nbsp;游戏模式: 
                <select name="modes" id="modes" style="width:80px;">
                    <option value="0">所有模式</option>
                                        <option value="1">元</option>
                                        <option value="2">角</option>
                                        <option value="3">分</option>
                </select>
            </td>
        </tr>  
        <tr>
            <td>
                注单编号：<input style='width:60px;' type="text" id="projectno" name="projectno" value="" style="width:150px;" />
                                &nbsp;&nbsp;游戏用户：<input style='width:90px;' type="text" name="username" id="username" value="" />
                &nbsp;&nbsp;范围: <select name='ranges'><OPTION  value="2">全部</OPTION><OPTION selected value="6">自己</OPTION><OPTION  value="3">直接下级</OPTION><OPTION  value="4">所有下级</OPTION></select>                                &nbsp;&nbsp;<font color=#009900>温馨提示: 点击注单编号可以查看详细注单信息以及撤单.</font>
            </td>
        </tr>
</table>
</div>
<div class="rc_list">
<div class="rl_list">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <th height="43" align="center"><div>注单编号</div></th>
        <th align="center"><div class='line'>用户<div</th>
        <th align="center"><div class='line'>投注时间<div</th>
        <th align="center"><div class='line'>游戏<div</th>
        <th align="center"><div class='line'>玩法<div</th>
        <th align="center"><div class='line'>期号<div</th>
        <th align="center"><div class='line'>投注内容<div</th>
        <th align="center"><div class='line'>倍数<div</th>
        <th align="center"><div class='line'>模式<div</th>
        <th align="center"><div class='line'>总金额<div</th>
        <th align="center"><div class='line'>奖金<div</th>
        <th align="center" width="10%"><div class='line'>开奖号码</div></th>
        <th align="center"><div class='line'>状态</div></th>
    </tr>
<?php
  if($total==0){
?>
    <tr class="no-records">
    	<td height="37" colspan="13" align="center" class=needq><span>请选择查询条件之后进行查询<span></td>
    </tr>
<?php 
  }else{
  $tmoney=0;
  $tprize=0;
  while ($row = mysql_fetch_array($rsnewslist)){
  	$tmoney=$tmoney+$row['money'];
	$tprize=$tprize+$row['prize'];
  ?>
    <tr align="center" class="<?php if($row['zt']==4 || $row['zt']==5 || $row['zt']==6){echo "cancelline";}else{echo "needchangebg";}?>" >
        <td height="37" <?php if($row['zt']==4 || $row['zt']==5 || $row['zt']==6){echo 'style="background-color:#CCCCCC;"';}?>><a href="./history_playinfos.php?id=<?=$row['dan']?>" target="_blank" class="blue" title="点击查看详情"><?=$row['dan']?></a></td>
        <td <?php if($row['zt']==4 || $row['zt']==5 || $row['zt']==6){echo 'style="background-color:#CCCCCC;"';}?>><?=$row['username']?></td>
        <td <?php if($row['zt']==4 || $row['zt']==5 || $row['zt']==6){echo 'style="background-color:#CCCCCC;"';}?>><?=$row['adddate']?></td>
        <td <?php if($row['zt']==4 || $row['zt']==5 || $row['zt']==6){echo 'style="background-color:#CCCCCC;"';}?>><?=$row['lottery']?></td>
        <td <?php if($row['zt']==4 || $row['zt']==5 || $row['zt']==6){echo 'style="background-color:#CCCCCC;"';}?>><?=Get_mid($row['mid'])?></td>
        <td <?php if($row['zt']==4 || $row['zt']==5 || $row['zt']==6){echo 'style="background-color:#CCCCCC;"';}?>><?=$row['issue']?></td>
        <td class="codelist" <?php if($row['zt']==4 || $row['zt']==5 || $row['zt']==6){echo 'style="background-color:#CCCCCC;"';}?>><?php $codes=dcode($row['codes'],$row['lotteryid'],$row['mid']);if(strlen($codes)<30){echo $codes;}else{?><a href="javascript:" rel='morecode'>详细号码</a><input type="hidden" value="<?=$codes?>"><?php }?></td>
        <td <?php if($row['zt']==4 || $row['zt']==5 || $row['zt']==6){echo 'style="background-color:#CCCCCC;"';}?>><?=$row['times']?></td>
        <td <?php if($row['zt']==4 || $row['zt']==5 || $row['zt']==6){echo 'style="background-color:#CCCCCC;"';}?>><?=$row['mode']?></td>
        <td <?php if($row['zt']==4 || $row['zt']==5 || $row['zt']==6){echo 'style="background-color:#CCCCCC;"';}?>><?=number_format($row['money'],2)?></td>
        <td <?php if($row['zt']==4 || $row['zt']==5 || $row['zt']==6){echo 'style="background-color:#CCCCCC;"';}?>><?php if($row['zt']==0){echo "0.00";}else{echo number_format($row['prize'],2);}?></td>
        <td <?php if($row['zt']==4 || $row['zt']==5 || $row['zt']==6){echo 'style="background-color:#CCCCCC;"';}?>> <?=$row['kjcode']?> </td>
        <td <?php if($row['zt']==4 || $row['zt']==5 || $row['zt']==6){echo 'style="background-color:#CCCCCC;"';}?>><?php if($row['zt']==0){echo "未开奖";}else if($row['zt']==1){echo "<font color=#D90000>已派奖</font>";}else if($row['zt']==2){echo "<font color=#639300>未中奖</font>";}else if($row['zt']==4){echo "管理员撤单";}else if($row['zt']==5){echo "本人撤单";}else if($row['zt']==6){echo "开错奖撤单";}?></td>
    </tr>
  <?php }?>  
    <tr align="center" class="total">
        <td height="37">小结</td>
        <td colspan="8">&nbsp;</td>
        <td><?=number_format($tmoney,2)?></td>
        <td><?=number_format($tprize,2)?></td>
        <td colspan="2"></td>
    </tr>
    <tr align="right">
    	<td height="37" colspan="25"><ul class="pager">总计 <?=$total?> 条数据,  共 <?=$lastpg?> 页 , 当前第 <?=$page?> 页  |  <?php if($page>1){?><LI><A HREF="?<?=$urls?>&page=1">首页</A></LI><LI><A HREF="?<?=$urls?>&page=<?=$page-1?>">上页</A></LI><?php }?><?php for($i=$p1;$i<=$p2;$i++){
		if($i==$page){?><LI CLASS='current' ><A HREF="#"><?=$i?></A></LI><?php }else{?><LI><A HREF="?<?=$urls?>&page=<?=$i?>"><?=$i?></A></LI><?php }}?><?php if($page!=$lastpg){?><LI><A HREF="?<?=$urls?>&page=<?=$page+1?>">下页</A></LI><LI><A HREF="?<?=$urls?>&page=<?=$lastpg?>">尾页</A></LI><?php }?> | 转至 <SCRIPT LANGUAGE="JAVASCRIPT">function keepKeyNum(obj,evt){var  k=window.event?evt.keyCode:evt.which; if( k==13 ){ goPage(obj.value);return false; }} function goPage( iPage ){ if( !isNaN(parseInt(iPage)) ) { if(iPage> <?=$lastpg?> ){iPage=<?=$lastpg?>;} window.location.href="?<?=$urls?>&page="+iPage;}}</SCRIPT><INPUT onKeyPress="return keepKeyNum(this,event);" TYPE="TEXT" ID="iGotoPage" NAME="iGotoPage" size="3"> 页  &nbsp;<BUTTON onclick="javascript:goPage( document.getElementById('iGotoPage').value );return false;">GO</BUTTON>&nbsp;&nbsp;</ul></td>
    </tr>
  <?php }?>
        </table>
</div>
</div>
<div class="clear"></div>
</div>
</div>
</div>
</form>        
<div class="clear"></div>
<div class="rc_con">
    <div class="rc_con_lt"></div>
    <div class="rc_con_rt"></div>
    <div class="rc_con_lb"></div>
    <div class="rc_con_rb"></div>
    <div class="rc_con_to">
    	<table width=100% border="0" cellspacing="0" cellpadding="0">
            <tr><td height="25" align="center">浏览器建议：首选IE 8.0,Chrome浏览器，其次为火狐浏览器,尽量不要使用IE6。</td></tr>
            <tr><td height="25" align="center">资金安全建议：为了您的资金安全请定期更换资金密码。</td></tr>
        </table>
    </div>
</div>

</div>

</body>
</html>