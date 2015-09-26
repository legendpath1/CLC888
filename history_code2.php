<?php 
session_start();
error_reporting(0);
require_once 'conn.php';
//require_once 'check.php';

$issuecount=$_REQUEST['issuecount'];
$wday=$_REQUEST['wday'];
$starttime=$_REQUEST['starttime'];
$endtime=$_REQUEST['endtime'];

if($issuecount==""){
	$issuecount=30;
}
if($wday=="b"){
	$starttime=date("Y-m-d",strtotime("-2 day"));
	$endtime=date("Y-m-d",strtotime("-2 day"));
}
if($wday=="y"){
	$starttime=date("Y-m-d",strtotime("-1 day"));
	$endtime=date("Y-m-d",strtotime("-1 day"));
}
if($wday=="t"){
	$starttime=date("Y-m-d");
	$endtime=date("Y-m-d");
}

$ss="";
if($starttime!="" && $endtime!=""){
	$sql="select * from ssc_data where cid='3' and (addtime >='".$starttime." 00:00:00' and addtime <='".$endtime." 23:59:59') order by issue asc";
}else{
	$sql="select id from ssc_data where cid='".$id."'";
	$rs=mysql_query($sql) or  die("数据库修改出错!!!!");
	$totala= mysql_num_rows($rs);
	if($totala-$issuecount<0){
		$tts=0;
	}else{
		$tts=$totala-$issuecount;
	}
	$sql="select * from ssc_data where cid='3' order by issue asc limit ".$tts.",".$issuecount."";
}


//echo $sql;
	$rs=mysql_query($sql) or  die("数据库修改出错!!!!");
	$total= mysql_num_rows($rs);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<head>
    <title>娱乐平台  - 历史号码</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
        <script>var pri_imgserver = 'http://commonuploader.b0.upaiyun.com';</script>
        <link href="./css/v1/all.css?modidate=20130201001" rel="stylesheet" type="text/css" />
    <link href="./js/calendar/css/calendar-blue2.css?modidate=20130201001" rel="stylesheet" type="text/css" />
    <script language="javascript" type="text/javascript" src="./js/jquery.js?modidate=20130820001"></script>
    <script language="javascript" type="text/javascript" src="./js/common.js?modidate=20130820001"></script>
    <script language="javascript" type="text/javascript" src="./js/lottery/min/message.js?modidate=20130820001"></script>
    <script language="javascript" type="text/javascript" src="./js/calendar/jquery.dyndatetime.js?modidate=20130820001"></script>
    <script language="javascript" type="text/javascript" src="./js/calendar/lang/calendar-utf8.js?modidate=20130820001"></script>
    <script language="javascript" type="text/javascript" src="./js/common/line.js?modidate=20130820001"></script>
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
</div><script language="javascript"> 
    fw.onReady(function(){
        jQuery("#starttime").dynDateTime({
            ifFormat: "%Y-%m-%d",
            daFormat: "%l;%M %p, %e %m,  %Y",
            align: "Br",
            electric: true,
            singleClick: true,
            button: ".next()", //next sibling
            onUpdate:function(){
                $("#starttime").change();
            },
            showOthers: true,
            weekNumbers: true,
            showsTime: false
        });
        jQuery("#starttime").change(function(){
            if(! validateInputDate(jQuery("#starttime").val()) )
            {
                jQuery("#starttime").val('');
                $.alert("日期格式不正确,正确的格式为:2011-01-01");
            }
            if($("#endtime").val()!="")
            {
                if($("#starttime").val()>$("#endtime").val())
                {
                    $("#starttime").val("");
                    $.alert("输入的时间不符合逻辑, 起始时间大于结束时间");
                }
                else
                {
                    if(daysBetween($("#starttime").val(),$("#endtime").val()) > 1)
                    {
                        $("#starttime").val("");
                        $.alert("输入的时间跨度不能超过2天！");
                    }
                }
            }
        });
        jQuery("#endtime").dynDateTime({
            ifFormat: "%Y-%m-%d",
            daFormat: "%l;%M %p, %e %m,  %Y",
            align: "Br",
            electric: true,
            singleClick: true,
            button: ".next()", //next sibling
            onUpdate:function(){
                $("#endtime").change();
            },
            showOthers: true,
            weekNumbers: true,
            showsTime: false
        });
        jQuery("#endtime").change(function(){
            if(! validateInputDate(jQuery("#endtime").val()) )
            {
                jQuery("#endtime").val('');
                $.alert("日期格式不正确,正确的格式为:2011-01-01");
            }
            if($("#starttime").val()!="")
            {
                if($("#starttime").val()>$("#endtime").val())
                {
                    $("#endtime").val("");
                    $.alert("输入的时间不符合逻辑, 起始时间大于结束时间");
                }
                else
                {
                    if(daysBetween($("#starttime").val(),$("#endtime").val()) > 1)
                    {
                        $("#endtime").val("");
                        $.alert("输入的时间跨度不能超过2天！");
                    }
                }
            }
        });
        var nols = $("div[class^='ball1']");
        $("#no_miss").click(function(){
            var checked = $(this).attr("checked");
            $.each(nols,function(i,n){
                if(checked==true){
                    n.style.display='none';
                }else{
                    n.style.display='block';
                }
            });
        });
    });
    function resize(){
        window.onresize = func;
        function func(){
            window.location.href=window.location.href;
        }
    }
    function daysBetween(start, end){
        var startY = start.substring(0, start.indexOf('-'));
        var startM = start.substring(start.indexOf('-')+1, start.lastIndexOf('-'));
        var startD = start.substring(start.lastIndexOf('-')+1, start.length);
  
        var endY = end.substring(0, end.indexOf('-'));
        var endM = end.substring(end.indexOf('-')+1, end.lastIndexOf('-'));
        var endD = end.substring(end.lastIndexOf('-')+1, end.length);
  
        var val = (Date.parse(endY+'/'+endM+'/'+endD)-Date.parse(startY+'/'+startM+'/'+startD))/86400000;
        return Math.abs(val);
    }
</script>
<style> 
    esun\:*{behavior:url(#default#VML)}
</style>
<div class="rc_con history">
    <div class="rc_con_lt"></div>
    <div class="rc_con_rt"></div>
    <div class="rc_con_lb"></div>
    <div class="rc_con_rb"></div>
    <h5><div class="rc_con_title">历史号码</div></h5>
    <div class="rc_con_to">
        <div class="rc_con_ti">
            <div class="history_code">
                <table width=100% id=tm border=0 cellpadding=0 cellspacing=0>
                    <tr>
                        <td align=left width=200>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>
                                <font color="#FF0000">北京快乐八：</font>
                                开奖号码
                            </strong>
                        </td>
                        <td align=left>
                            <form method="POST">
                                <a href="./history_code2.php?id=3&issuecount=30&frequencytype=0">最近30期</a>&nbsp;
                                <a href="./history_code2.php?id=3&issuecount=50&frequencytype=0">最近50期</a>&nbsp;
                                <a href="./history_code2.php?id=3&issuecount=50&frequencytype=0">最近100期</a>&nbsp;
                                <a href="./history_code2.php?id=3&wday=b&frequencytype=0">前天</a>&nbsp;
                                <a href="./history_code2.php?id=3&wday=y&frequencytype=0">昨天</a>&nbsp;
                                <a href="./history_code2.php?id=3&wday=t&frequencytype=0">今天</a>&nbsp;
                                                                <input class=in type="text" value="" name="starttime" id="starttime">
                                <img class='icons_mb4' src="./images/comm/t.gif" style="vertical-align:middle;">
                                &nbsp;至&nbsp;
                                <input class=in type="text" value="" name="endtime" id="endtime">
                                <img class='icons_mb4' src="./images/comm/t.gif" style="vertical-align:middle;">&nbsp;&nbsp;
                                <input type="submit" value="搜索" class="button">&nbsp;&nbsp;&nbsp;
                            </form>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="hrc_list">
                <div class="hrl_list">
                    <table id="chartsTable" width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor='#D0D0D0'>
                        <tr class="th">
                            <td width="10%">期号</td>
                            <td width="40%">开奖号码</td>
                            <td width="10%">奇偶盘</td>
                            <td width="10%">上下盘</td>
                            <td width="10%">和值</td>
                            <td width="10%">和值大小</td>
                            <td width="10%">和值单双</td>
                        </tr>
<?php
	while ($row = mysql_fetch_array($rs)){
		$na=explode(",",$row['code']);
		$ns=0;
		$nb=0;
		$nc=0;
		$nd=0;
		$ne=0;
		for($i=0;$i<count($na);$i++){
			$ns=$ns+$na[$i];
			if($na[$i]<=40){
				$nb=$nb+1;
			}else{
				$nc=$nc+1;
			}
			if($na[$i] % 2 ==1){
				$nd=$nd+1;
			}else{
				$ne=$ne+1;
			}
		}

?>
                        <tr>
                            <td class="issue"><?=$row['issue']?></td>
                            <td class="td1"><?=str_replace(","," ",$row['code'])?></td>
                            <td class="td0"><?php if($nd>$ne){echo "奇";}elseif($nd<$ne){echo "偶";}elseif($nd==$ne){echo "和";}?></td>
                            <td class="td1"><?php if($nb>$nc){echo "上";}elseif($nb<$nc){echo "下";}elseif($nb==$nc){echo "中";}?></td>
                            <td class="td0"><?=$ns?></td>
                            <td class="td1"><?php if($ns>810){echo "大";}else{echo "小";}?></td>
                            <td class="td0"><?php if($ns % 2 ==1){echo "单";}else{echo "双";}?></td>
                        </tr>
<?php }?>
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
