<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$sqla = "SELECT * FROM ssc_member WHERE username='" . $_SESSION["username"] . "'";
$rsa = mysql_query($sqla);
$rowa = mysql_fetch_array($rsa);


$sql = "SELECT * FROM ssc_member WHERE id='" . $_REQUEST['uid'] . "'";
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs);
if(empty($row)){
	$_SESSION["backtitle"]="操作失败，无此用户";
	$_SESSION["backurl"]="users_list.php";
	$_SESSION["backzt"]="failed";
	$_SESSION["backname"]="用户列表";
	echo "<script language=javascript>window.location='sysmessage.php';</script>";
	exit;
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<head>
    <title>娱乐平台  - 账户充值</title>
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
</div><script type="text/javascript"> 
    function checkForm(obj)
    {
        var m_min = 10;
        var m_max = <?=$rowa['czxg']?>;
        if (obj.money.value < m_min){
            alert("充值金额不符合要求, 最低: "+m_min+" 元");
            obj.money.focus();
            return false;
        }
        if (obj.money.value > m_max){
            alert("充值金额不符合要求, 最高: "+m_max+" 元");
            obj.money.focus();
            return false;
        }
    }
</script>
<div class="rc_con system">
    <div class="rc_con_lt"></div>
    <div class="rc_con_rt"></div>
    <div class="rc_con_lb"></div>
    <div class="rc_con_rb"></div>
    <h5><div class="rc_con_title">账户充值</div></h5>
    <div class="rc_con_to">
        <div class="rc_con_ti">
            <table width="100%" class="ct" border="0" cellspacing="0" cellpadding="0">
                <form action="users_saveupok.php" method="post" onsubmit="return checkForm(this)">
                    <input type="hidden" name="uid" value="<?=$_GET['uid']?>" />
                    <input type="hidden" name="flag" value="insert" />
                    <tr>
                        <td class="nl" width="20%">充值限额: </td>
                        <td>单笔充值最低：10 元， 最高：<?=$rowa['czxg']?> 元。</td>
                    </tr>
                    <tr>
                        <td class="nl">您的当前余额: </td>
                        <td><?=$rowa['leftmoney']?></td>
                    </tr>
                    <tr>
                        <td width='300' class="nl">充值账户: </td>
                        <td><?=$row['username']?></td>
                    </tr>
                    <tr>
                        <td class="nl">充值金额: </td>
                        <td>
                            <input type="text" name="money" size="20" onkeyup="checkIntWithdraw(this,'chineseMoney',<?=$rowa['leftmoney']?>);" />
                        </td>
                    </tr>
                    <tr>
                        <td class="nl">充值金额(大写): </td>
                        <td><span id="chineseMoney"></span></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="submit" value="充值确认" class="btn_next" /></td>
                    </tr>
                </form>
            </table>
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
