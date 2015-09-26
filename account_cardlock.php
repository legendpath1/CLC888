<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$sqla = "select * from ssc_bankcard WHERE  username='" . $_SESSION["username"] . "'";
$rsa = mysql_query($sqla);
$cardnums=mysql_num_rows($rsa);
if($cardnums==0){
	$_SESSION["backtitle"]="您暂时还没有绑定任何银行卡，请先绑定银行卡";
	$_SESSION["backurl"]="account_banks.php?check=114";
	$_SESSION["backzt"]="failed";
	$_SESSION["backname"]="我的银行卡";
	echo "<script language=javascript>window.location='sysmessage.php';</script>";
	exit;
}

if($_POST['flag']=="lock"){
	$sqlb = "select * from ssc_member WHERE username='" . $_SESSION["username"] . "'";
	$rsb = mysql_query($sqlb);
	$rowb = mysql_fetch_array($rsb);
	
	if(md5($_POST['spwd'])==$rowb['cwpwd']){
		$sqlb = "update ssc_member set cardlock='1' WHERE username='" . $_SESSION["username"] . "'";
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
        <script language="javascript">
        function ResumeError() {return true;} window.onerror = ResumeError; 
        document.onselectstart = function(event){
            if(window.event) {
                event =    window.event;
            }
            try {
                var the = event.srcElement ;
                if( !( ( the.tagName== "INPUT" && the.type.toLowerCase() == "text" ) || the.tagName== "TEXTAREA" || the.tagName.toLowerCase()=="p" || the.tagName.toLowerCase()=="span") )
                {
                    return false;
                }
                return true ;
            } catch(e) {
                return false;
            }
        } 
    </script>
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
<script>
    function checkform()
    {
        return confirm("警告：银行卡锁定后，将无法再增加、删除银行卡。\n您是否确定要锁定您账户的银行卡？");
    }
</script>
<div class="top_menu">
    <div class="tm_left"></div>
    <div class="tm_title"></div>
    <div class="tm_right"></div>
    <div class="tm_menu">
        <a href="/users_info.php?check=899">奖金详情</a>
        <a href="/users_message.php">我的消息</a>
        <a class="act" href="/account_banks.php?check=899">我的银行卡</a>
        <a href="/account_update.php?check=899">修改密码</a>
    </div>
</div>
<div class="rc_con binding">
    <div class="rc_con_lt"></div>
    <div class="rc_con_rt"></div>
    <div class="rc_con_lb"></div>
    <div class="rc_con_rb"></div>
    <h5><div class="rc_con_title">锁定银行卡</div></h5>
    <div class="rc_con_to">
        <div class="rc_con_ti">
            <div class="binding_ts">
                <div class="binding_tsn">
                    <h4>温馨提示：</h4>
                    <p>银行卡锁定以后，不能增加新的银行卡绑定，同时也不能解绑已绑定的银行卡。</p>
                </div>
            </div>
            <div class="clear"></div>
            <div class="binding_input">
                <table class="ct" border="0" cellspacing="0" cellpadding="0" width="100%">
                    <form action="" method="post" name="addform" onsubmit="return checkform()">
                        <input type="hidden" name="flag" value="lock" />
<?php
	while ($rowa = mysql_fetch_array($rsa)){
?>
                                                <tr><td class="nl"><?=$rowa['bankname']?>:</td><td>***************<?=substr($rowa['cardno'],-4)?></td></tr>
<?php }?>
                                                <tr><td class="nl"><font color="red">资金密码:</font></td><td><input type="password" name="spwd" maxlength="20" style='width:160px;' id="password"/></font><span class="pop"><s class="pop-l"></s><span>（请输入资金密码）</span><s class="pop-r"></s></span></td></tr>
                        <tr><td class="nl">温馨提示:</td><td style='line-height:24px;color:#693'>银行卡锁定，可以一定程度增强您的账户安全。<br/>
                                例：账户被他人盗用后，由于此功能的限制，您账户的资金不会被他人提现。<br/>
                                与此同时，客服<font color=red>不提供</font>账户银行卡解除锁定功能，所以：<font color=red>锁定前请自行斟酌</font>。</td></tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="submit" name="submit" value=" 立即锁定 " class="btn_normal" />
                            </td>
                        </tr>
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