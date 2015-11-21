<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$sql="update ssc_message set zt='1' where id='" . $_GET["mid"] . "'";
$rs = mysql_query($sql);

$sql="select * from ssc_message where id='" . $_GET["mid"] . "'";
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<head>
    <title>娱乐平台  - 查看消息</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
        <link href="./css/v1/all.css?modidate=20130201001" rel="stylesheet" type="text/css" />
    <script>var pri_imgserver = '';</script>
        <script language="javascript" type="text/javascript" src="./js/jquery.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/common.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/lottery/min/message.js?modidate=20130415002"></script>
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
</div><div class="top_menu">
    <div class="tm_left"></div>
    <div class="tm_title"></div>
    <div class="tm_right"></div>
    <div class="tm_menu">
        <a href="/users_info.php?check=">奖金详情</a>
        <a class="act" href="/users_message.php">我的消息</a>
        <a href="/account_banks.php?check=">我的银行卡</a>
        <a href="/account_update.php?check=">修改密码</a>
    </div>
</div>
<div class="rc_con betting">
    <div class="rc_con_lt"></div>
    <div class="rc_con_rt"></div>
    <div class="rc_con_lb"></div>
    <div class="rc_con_rb"></div>
    <h5><div class="rc_con_title">查看消息</div></h5>
    <div class="rc_con_to">
        <div class="rc_con_ti">            
            <div class="clear"></div>
            <div class="rc_list">
                <div class="rl_list">
                                <table class="lt" id="tabbar_txt__" border="0" cellspacing="0" cellpadding="0" width="100%">
                                        <tr>
    	<th style="height:30px; line-height:30px; font-size:14px;"><?=$row['topic']?></th>
    </tr>
    <tr><td style="border-bottom:0; color:#666666; text-align:center;"><?=$row['adddate']?></td></tr>
    <tr>
        <td style="padding-left:50px;" align="left">
<?=$row['content']?>
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 感谢您的支持，祝您游戏愉快！</p>
<p style="text-align: right; width: 98%"><font color="#666666">-----信誉保证，用心服务</font></p>
        </td>
    </tr>
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