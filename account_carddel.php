<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$id = trim($_GET['id']);

if(Get_member(cardlock)=="1"){
	$_SESSION["backtitle"]="您的银行卡资料已锁定";
	$_SESSION["backurl"]="account_banks.php?check=114";
	$_SESSION["backzt"]="failed";
	$_SESSION["backname"]="我的银行卡";
	echo "<script language=javascript>window.location='sysmessage.php';</script>";
	exit;
}
	
	if($_SESSION["cardflag"]!="ok"){
		$_SESSION["cardurl"]="account_carddel.php?id=".$id;
		echo "<script language=javascript>window.location='account_confirm.php?id=".$id."';</script>";
		exit;
	}
	$_SESSION["cardflag"]="";

if($_POST['isverify']=="yes"){
	$_SESSION["cardflag"]="";
	$sqlb = "select * from ssc_member WHERE username='" . $_SESSION["username"] . "'";
	$rsb = mysql_query($sqlb);
	$rowb = mysql_fetch_array($rsb);
	
	if(md5($_POST['spwd'])==$rowb['cwpwd']){
		$sqlb = "delete from ssc_bankcard WHERE id='" . $_POST['delid'] . "'";
		$rsb = mysql_query($sqlb);
		$_SESSION["backtitle"]="操作成功";
		$_SESSION["backurl"]="account_banks.php?check=114";
		$_SESSION["backzt"]="successed";
		$_SESSION["backname"]="我的银行卡";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}else{
		$_SESSION["backtitle"]="资金密码错误";
		$_SESSION["backurl"]="account_banks.php?check=114";
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="我的银行卡";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}
}

$sqla = "select * from ssc_bankcard WHERE id='" . $id . "' and username='" . $_SESSION["username"] . "'";
$rsa = mysql_query($sqla);
$rowa = mysql_fetch_array($rsa);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<head>
    <title>娱乐平台  - 锁定银行卡</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
        <link href="./css/v1/all.css?modidate=20130201001" rel="stylesheet" type="text/css" />
    <script>var pri_imgserver = '';</script>
    <script language="javascript" type="text/javascript" src="./js/jquery.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/common.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/lottery/min/message.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/keyboard/keyboard.js?modidate=20130415002"></script>

    <style type="text/css">
        .keyboard{-moz-user-select: -moz-none;}
    </style>
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
    $(function(){
        getKeyBoard($('#password'));
        $("#copyright").css("margin-bottom","100px");
    });
</script>

<div class="top_menu">
    <div class="tm_left"></div>
    <div class="tm_title"></div>
    <div class="tm_right"></div>
    <div class="tm_menu">
        <a href="./users_info.php?check=899">奖金详情</a>
        <a href="./users_message.php">我的消息</a>
        <a class="act" href="./account_banks.php?check=899">我的银行卡</a>
        <a href="./account_update.php?check=899">修改密码</a>
    </div>
</div>
<div class="rc_con binding">
    <div class="rc_con_lt"></div>
    <div class="rc_con_rt"></div>
    <div class="rc_con_lb"></div>
    <div class="rc_con_rb"></div>
    <h5><div class="rc_con_title">解除绑定银行卡</div></h5>
    <div class="rc_con_to">
        <div class="rc_con_ti">
            <div class="binding_ts">
                <div class="binding_tsn">
                    <h4>使用提示:</h4>
                    <p>请仔细确认以下信息后, 点击 <font color=#ff0000>"解除绑定"</font> 按钮.</p>
                </div>
            </div>
            <div class="clear"></div>
            <div class="binding_input">
                <table class="ct" border="0" cellspacing="0" cellpadding="0" width="100%">
                    <form action="account_carddel2.php" method="post" name="addform" onsubmit="return checkform(this)">
                    <input type="hidden" name="delid" value="<?=$id?>" />
                    <input type="hidden" name="isverify" value="yes" />
                    <tr><td class="nl">开户银行:</td><td><?=Get_bank($rowa['bankid'])?></td></tr>
                    <tr><td class="nl">银行账号:</td><td>***************<?=substr($rowa['cardno'],-4)?></font></td></tr>
                    <tr><td class="nl">绑定时间</td><td><?=$rowa['adddate']?></td></tr>
                    <tr><td class="nl">资金密码:</td><td><input type="password" name="spwd" maxlength="20" style='width:160px;'  id="password"/></font></td></tr>
                    <tr><td></td><td><br/><input type="submit" name="submit" value="解除绑定" class="btn_normal" /><br/><br/></td></tr>
                    </form>
                </table>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
<div class="clear"></div>
<div id="copyright">
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