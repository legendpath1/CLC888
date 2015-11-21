<?php
session_start();
error_reporting(0);
require_once 'conn.php';

$starttime = $_REQUEST['starttime'];
$endtime = $_REQUEST['endtime'];
$username=$_REQUEST['username'];
$isrequery = $_REQUEST['isrequery'];
$hrecord = $_REQUEST['hrecord'];


$jb=array("用户","代理","总代理"); 

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=50;
$page2=($page-1)*$pagesize;

if($starttime==""){
	$starttime=date("Y-m-d");
}
	$s1=$s1." and ccdate>='".$starttime."'";

if($endtime==""){
	$endtime=date("Y-m-d");
}
	$s1=$s1." and ccdate<='".$endtime."'";

if($username!=""){
	$s2=" (username='".$username."' or regup='".$username."') and regfrom like '%&".$_SESSION["username"]."&%'";
	$s4=" (username='".$username."' or regfrom like '%&".$username."&%') and regfrom like '%&".$_SESSION["username"]."&%'";
}else{
	$s2=" (username='".$_SESSION["username"]."' or regup='".$_SESSION["username"]."')";
	$s4=" (username='".$_SESSION["username"]."' or regfrom like '%&".$_SESSION["username"]."&%')";
}

if($isrequery!="1"){
	$s2=$s2." and 1=0";	
}

$urls="starttime=".$starttime."&endtime=".$endtime."&username=".$username."&isrequery=".$isrequery."&hrecord=".$hrecord;

$s2=$s2." order by id asc";
$sql="select * from ssc_member where ".$s2;
$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

$sql="select * from ssc_member where ".$s2." limit $page2,$pagesize";
//echo $sql;
$rsnewslist = mysql_query($sql) or  die("数据库修改出错!!!!");
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
    <title>娱乐平台  - 盈亏报表</title>
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
        $(".icons_q1").toggle(function(){
            $("#report_desc").show();
        },function(){
            $("#report_desc").hide();
        });
        jQuery("#starttime").dynDateTime({
            ifFormat: "%Y-%m-%d",
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
                alert("时间格式不正确,正确的格式为:2011-01-01 10:59");
            }
            if($("#endtime").val()!="")
            {
                if($("#starttime").val()>$("#endtime").val())
                {
                    $("#starttime").val("");
                    alert("输入的时间不符合逻辑, 起始时间大于结束时间");
                }
            }
        });
        jQuery("#endtime").dynDateTime({
            ifFormat: "%Y-%m-%d",
            daFormat: "%l;%M %p, %e %m,  %Y",
            align: "Br",
            electric: true,
            singleClick: false,
            button: ".next()", //next sibling
            showOthers: true,
            onUpdate:function(){
                $("#endtime").change();
            },
            weekNumbers: true,
            showsTime: true
        });
        jQuery("#endtime").change(function(){
            if(! validateInputDate(jQuery("#endtime").val()) )
            {
                jQuery("#endtime").val('');
                alert("时间格式不正确,正确的格式为:2011-01-01");
            }
            if($("#starttime").val()!="")
            {
                if($("#starttime").val()>$("#endtime").val())
                {
                    $("#endtime").val("");
                    alert("输入的时间不符合逻辑, 起始时间大于结束时间");
                }
            }
        });
        $("span[id^=showself_]").click(function(){
            var aid = $(this).attr("id").split("_");
            if($("#self_"+aid[1]).css("display") == "none"){
                $("#self_"+aid[1]).show(); 
            }else{
                $("#self_"+aid[1]).hide(); 
            } 
        });
        $(".closeself").click(function(){
            $(this).parent().parent().hide();
        });
    });
</script>
<div class="top_menu">
    <div class="tm_left"></div>
    <div class="tm_title"></div>
    <div class="tm_right"></div>
    <div class="tm_menu">
                <!--总代才显示-->
                <a href="/report_teambalance.php">团队余额</a>        <a class="act"  href="/report_profit.php">盈亏报表</a>
                <a  href="/report_list.php">账变列表</a>
    </div>
</div>
<div class="rc_con ac_list">
<div class="rc_con_lt"></div>
<div class="rc_con_rt"></div>
<div class="rc_con_lb"></div>
<div class="rc_con_rb"></div>
<div><a class="title_menu" href="/report_profit.php">盈亏报表</a></div>
<h5><div class="rc_con_title">往期报表</div></h5>
<div class="rc_con_to">
<div class="rc_con_ti">
<div class="betting_input">
    <table class='st' border="0" cellspacing="0" cellpadding="0" width="100%">
        <form action="" method="GET" name="searchForm">
            <input type="hidden" name="isrequery" value="1">
            <tr>
                <td>
                    <img src="./images/icon_search.gif" width="26" height="22" border="0" TITLE="SEARCH" />
                    时间: 
                    <input type="text" name="starttime" id="starttime" value="<?=$starttime?>" size="15" />
                    <img class='icons_mb4' src="./images/comm/t.gif">
                    &nbsp;&nbsp;至&nbsp;&nbsp;
                    <input type="text" name="endtime" id="endtime" value="<?=$endtime?>" size="15"/>
                    <img class='icons_mb4' src="./images/comm/t.gif">
                                        &nbsp;&nbsp;&nbsp;
                    代理: <input type="text" name="username" id="username" value="<?=$username?>" size="15"/>&nbsp;&nbsp;&nbsp;
                    <input name="hrecord" type="checkbox" id="hrecord" value="1" <?php if($hrecord==1){?>checked="checked"<?php }?> />
                    隐藏无帐变
                                        <button name="submit" type="submit" width='69' height='26' class="btn_search" /></button>
                    <img src="./images/comm/t.gif" class='icons_q1' height="13">
                </td>
            </tr>
            <tr>
                <td>
                    <div style="display: none;" id="report_desc">
                    说明：查询日期不是自然日期<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;1)查询时间固定为开始日期的03:00:00到结束日期的03:00:00,只能修改查询日期<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;2)所有金额总额为指定时间内产生对应账变的总金额:如果前一天购买的单子，今天进行派奖或者返点，此时的派奖金额与返点金额计入当天报表中。
                    </div>
                </td>
            </tr>
        </form>
    </table>
</div>
<div class="rc_list">
<div class="rl_list">
    <table class="lt" border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr>
            <th align="center"><div>用户名</div></th>
                        <th align="center"><div class='line'>所属组</div></th>
                        <th align="center"><div class='line'>充值总额</div></th>
            <th align="center"><div class='line'>提现总额</div></th>
            <th align="center"><div class='line'>投注总额</div></th>
            <th align="center"><div class='line'>返点总额</div></th>
            <th align="center"><div class='line'>中奖总额</div></th>
            <th align="center"><div class='line'>活动总额</div></th>
            <th align="center"><div class='line'>游戏总盈亏</div></th>
                        <th align="center"><div class='line'>操作</div></th>
        </tr>
<?php if($total==0){?>
        <tr class="no-records">
        	<td colspan="9" class=needq><span>请选择查询条件之后进行查询</span></td>
        </tr>
<?php }else{?>
<?php
			$czm=0;
			$tzm=0;
			$txm=0;
			$fdm=0;
			$zjm=0;
			$hdm=0;
			$tm=0;
			while ($row = mysql_fetch_array($rsnewslist)){
				if($row['username']==$username || $row['username']==$_SESSION["username"]){
					$sqla="select SUM(cmoney) as tcmoney,SUM(tmoney) as ttmoney,SUM(gmoney) as tgmoney,SUM(fmoney) as tfmoney,SUM(wmoney) as twmoney,SUM(hmoney) as thmoney from ssc_membert where username='".$row['username']."'".$s1."";
				}else{
					$sqla="select SUM(cmoney) as tcmoney,SUM(tmoney) as ttmoney,SUM(gmoney) as tgmoney,SUM(fmoney) as tfmoney,SUM(wmoney) as twmoney,SUM(hmoney) as thmoney from ssc_membert where (username='".$row['username']."' or regfrom like '%&".$row['username']."&%')".$s1."";
				}
				$rsa = mysql_query($sqla);
				$rowa = mysql_fetch_array($rsa);
				$ts=$rowa['twmoney']+$rowa['thmoney']+$rowa['tfmoney']-$rowa['tgmoney']; 
				if($hrecord==1 && $rowa['tcmoney']=="" && $rowa['ttmoney']=="" && $rowa['tgmoney']=="" && $rowa['tfmoney']=="" && $rowa['twmoney']=="" && $rowa['thmoney']==""){}else{
?>
        <tr align="center" <?php if($row['username']==$username || $row['username']==$_SESSION["username"]){?>style="font-weight: bold;"<?php }?>>
            <td <?php if($row['username']==$username || $row['username']==$_SESSION["username"]){?>style="color:red;"<?php }?>><?=$row['username']?></td>
            <td <?php if($row['username']==$username || $row['username']==$_SESSION["username"]){?>style="color:red;"<?php }?>><?=$jb[$row['level']]?></td>
            <td <?php if($row['username']==$username || $row['username']==$_SESSION["username"]){?>style="color:red;"<?php }?>><?=number_format($rowa['tcmoney'],2)?></td>
            <td <?php if($row['username']==$username || $row['username']==$_SESSION["username"]){?>style="color:red;"<?php }?>><?=number_format($rowa['ttmoney'],2)?></td>
            <td <?php if($row['username']==$username || $row['username']==$_SESSION["username"]){?>style="color:red;"<?php }?>><?=number_format($rowa['tgmoney'],2)?></td>
            <td <?php if($row['username']==$username || $row['username']==$_SESSION["username"]){?>style="color:red;"<?php }?>><?=number_format($rowa['tfmoney'],2)?></td>
            <td <?php if($row['username']==$username || $row['username']==$_SESSION["username"]){?>style="color:red;"<?php }?>><?=number_format($rowa['twmoney'],2)?></td>
            <td <?php if($row['username']==$username || $row['username']==$_SESSION["username"]){?>style="color:red;"<?php }?>><?=number_format($rowa['thmoney'],2)?></td>
            <td <?php if($row['username']==$username || $row['username']==$_SESSION["username"]){?>style="color:red;"<?php }?>><?=number_format($ts,2)?></td>
            <td><?php if($row['username']==$username || $row['username']==$_SESSION["username"]){?><a href="./report_list.php?isrequery=1&username=<?=$row['username']?>&ordertime_min=<?=$starttime?> 00:00:00&ordertime_max=<?=$endtime?> 23:59:59" target="_bank">查看明细</a><?php }else{?><span id="showself_<?=$row['id']?>" style="cursor:pointer;text-decoration: underline;">自身盈亏</span><?php }?></td>
        </tr>
 <?php if($row['username']!=$username && $row['username']!=$_SESSION["username"]){
 				$sqla="select SUM(cmoney) as tcmoney,SUM(tmoney) as ttmoney,SUM(gmoney) as tgmoney,SUM(fmoney) as tfmoney,SUM(wmoney) as twmoney,SUM(hmoney) as thmoney from ssc_membert where username='".$row['username']."'".$s1."";
				$rsa = mysql_query($sqla);
				$rowa = mysql_fetch_array($rsa);
				$ts=$rowa['twmoney']+$rowa['thmoney']+$rowa['tfmoney']-$rowa['tgmoney']; 

 ?>
        <tr align="center" style="display: none;" id="self_<?=$row['id']?>">
            <td colspan="2"><font color="blue"><b>自身盈亏</b></font></td>
            <td><font color="blue"><?=number_format($rowa['tcmoney'],2)?></font></td>
            <td><font color="blue"><?=number_format($rowa['ttmoney'],2)?></font></td>
            <td><font color="blue"><?=number_format($rowa['tgmoney'],2)?></font></td>
            <td><font color="blue"><?=number_format($rowa['tfmoney'],2)?></font></td>
            <td><font color="blue"><?=number_format($rowa['twmoney'],2)?></font></td>
            <td><font color="blue"><?=number_format($rowa['thmoney'],2)?></font></td>
            <td><font color="blue"><?=number_format($ts,2)?></font></td>
            <td><a href="./report_list.php?isrequery=1&username=<?=$row['username']?>&ordertime_min=<?=$starttime?> 00:00:00&ordertime_max=<?=$endtime?> 23:59:59" target="_bank">查看明细</a>
                <span class="closeself" style="cursor:pointer;">【关闭】</span>
            </td>
			<?php 
}}}
			?>

<?php
		$sqla="select SUM(cmoney) as tcmoney,SUM(tmoney) as ttmoney,SUM(gmoney) as tgmoney,SUM(fmoney) as tfmoney,SUM(wmoney) as twmoney,SUM(hmoney) as thmoney from ssc_membert where ".$s4.$s1."";
		$rsa = mysql_query($sqla);
		$rowa = mysql_fetch_array($rsa);
				$ts=$rowa['twmoney']+$rowa['thmoney']+$rowa['tfmoney']-$rowa['tgmoney']; 

?>
        <tr align="center">
            <td colspan="2"><b>总合计</b></td>
            <td><b><?=number_format($rowa['tcmoney'],2)?></b></td>
            <td><b><?=number_format($rowa['ttmoney'],2)?></b></td>
            <td><b><?=number_format($rowa['tgmoney'],2)?></b></td>
            <td><b><?=number_format($rowa['tfmoney'],2)?></b></td>
            <td><b><?=number_format($rowa['twmoney'],2)?></b></td>
            <td><b><?=number_format($rowa['thmoney'],2)?></b></td>
            <td><b><?=number_format($ts,2)?></b></td>
            <td></td>
        </tr>

    <tr class="page"><td class='b' colspan="10"><div style='text-align:right;'><ul class="pager">总计 <?=$total?> 条数据,  共 <?=$lastpg?> 页 , 当前第 <?=$page?> 页  |  <?php if($page>1){?><LI><A HREF="?<?=$urls?>&page=1">首页</A></LI><LI><A HREF="?<?=$urls?>&page=<?=$page-1?>">上页</A></LI><?php }?><?php for($i=$p1;$i<=$p2;$i++){
		if($i==$page){?><LI CLASS='current' ><A HREF="#"><?=$i?></A></LI><?php }else{?><LI><A HREF="?<?=$urls?>&page=<?=$i?>"><?=$i?></A></LI><?php }}?><?php if($page!=$lastpg){?><LI><A HREF="?<?=$urls?>&page=<?=$page+1?>">下页</A></LI><LI><A HREF="?<?=$urls?>&page=<?=$lastpg?>">尾页</A></LI><?php }?> | 转至 <SCRIPT LANGUAGE="JAVASCRIPT">function keepKeyNum(obj,evt){var  k=window.event?evt.keyCode:evt.which; if( k==13 ){ goPage(obj.value);return false; }} function goPage( iPage ){ if( !isNaN(parseInt(iPage)) ) { if(iPage> <?=$lastpg?> ){iPage=<?=$lastpg?>;} window.location.href="?<?=$urls?>&page="+iPage;}}</SCRIPT><INPUT onKeyPress="return keepKeyNum(this,event);" TYPE="TEXT" ID="iGotoPage" NAME="iGotoPage" size="3"> 页  &nbsp;<BUTTON onclick="javascript:goPage( document.getElementById('iGotoPage').value );return false;">GO</BUTTON>&nbsp;&nbsp;</ul></div></td></tr>    
			<?php 
}
			?>
            </table>
</div>
</div>
<div class="clear"></div>
</div>
</div>
</div>
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