<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$flag = trim($_POST['flag']);
if($flag=="confirm"){
	$sql = "select * from ssc_member where username='".$_SESSION["username"]."'";
	$rs = mysql_query($sql);
	$row = mysql_fetch_array($rs);

	if(md5($_REQUEST['secpass'])==$row['cwpwd']){
		$sql = "insert into ssc_bankcard set uid='" . $_SESSION["uid"] . "', username='" . $_SESSION["username"] . "', realname='" . trim($_POST['realname']) . "', bankid='" . trim($_POST['bank']) . "', bankname='" .Get_bank($_POST['bank']) . "', province='" . trim($_POST['province']) . "', city='" . trim($_POST['city']) . "', bankbranch='" . trim($_POST['branch']) . "', cardno='" . trim($_POST['cardno']) . "', adddate='" . date("Y-m-d H:i:s") . "'";
		$exe = mysql_query($sql);
		amend("绑定银行卡".$_POST['cardno']);
		$_SESSION["backtitle"]="操作成功";
		$_SESSION["backurl"]="account_banks.php?check=114";
		$_SESSION["backzt"]="successed";
		$_SESSION["backname"]="我的银行卡";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}else{
		$_SESSION["backtitle"]="操作失败，资金密码错误";
		$_SESSION["backurl"]="account_cardadd.php?check=114";
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="新增银行卡";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}

}else{
	$bank = trim($_POST['bank']);
	$province = trim($_POST['province']);
	$city = trim($_POST['city']);
	$branch = trim($_POST['branch']);
	$realname = trim($_POST['realname']);
	$cardno = trim($_POST['cardno']);
	$cardno_again = trim($_POST['cardno_again']);

	if($cardno != $cardno_again){
		$_SESSION["backtitle"]="操作失败，卡号不一致";
		$_SESSION["backurl"]="account_cardadd.php?check=114";
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="新增银行卡";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}
	$sqla = "select * from ssc_bankcard WHERE username='" . $_SESSION["username"] . "'";
	$rsa = mysql_query($sqla);
	$rowa = mysql_fetch_array($rsa);
	if(empty($rowa)){
	}else{
		if($rowa['realname']!=$realname){
			$_SESSION["backtitle"]="操作失败，开户人姓名不一致";
			$_SESSION["backurl"]="account_cardadd.php?check=114";
			$_SESSION["backzt"]="failed";
			$_SESSION["backname"]="新增银行卡";
			echo "<script language=javascript>window.location='sysmessage.php';</script>";
			exit;
		}
	}
//	$sqla = "select * from ssc_bankcard WHERE cardno='" . $cardno . "'";
//	$rsa = mysql_query($sqla);
//	$rowa = mysql_fetch_array($rsa);
//	if(empty($rowa)){
//	}else{
//		$_SESSION["backtitle"]="操作失败，该卡已被其它用户绑定";
//		$_SESSION["backurl"]="account_cardadd.php?check=114";
//		$_SESSION["backzt"]="failed";
//		$_SESSION["backname"]="新增银行卡";
//		echo "<script language=javascript>window.location='sysmessage.php';</script>";
//		exit;
//	}

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<head>
    <title>娱乐平台  - 增加银行卡 (确认页)</title>
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
        getKeyBoard($('#secpass'));
        $("#formpass").submit(function(){
            if($("#secpass").val() == ""){
                alert("请输入资金密码");
                return false;
            }
            return true;
        });
    });
</script>
<div class="top_menu">
    <div class="tm_left"></div>
    <div class="tm_title"></div>
    <div class="tm_right"></div>
    <div class="tm_menu">
        <a href="/users_info.php?check=416">奖金详情</a>
        <a href="/users_message.php">我的消息</a>
        <a class="act" href="/account_banks.php?check=416">我的银行卡</a>
        <a href="/account_update.php?check=416">修改密码</a>
    </div>
</div>
<div class="rc_con binding">
    <div class="rc_con_lt"></div>
    <div class="rc_con_rt"></div>
    <div class="rc_con_lb"></div>
    <div class="rc_con_rb"></div>
    <div class="title_menu">增加银行卡 (确认页)</div>
    <h5><div class="rc_con_title">增加银行卡 (确认页)</div></h5>
    <div class="rc_con_to">
        <div class="rc_con_ti">
            <div class="binding_ts">
                <div class="binding_tsn">
                    <h4>使用提示：</h4>
                    <p>请仔细确认以下信息后, 点击 <font color=#ff0000>"立即绑定"</font> 按钮。</p>
                </div>
            </div>
            <div class="clear"></div>
            <div class="binding_input">
                <table class="ct" border="0" cellspacing="0" cellpadding="0" width="100%">
                    <form action="" method="post" name="addform" id ="formpass">
                        <input type="hidden" name="flag" value="confirm" />
                        <input type="hidden" name="nickname"	value="<?=$realname?>" />
                        <input type="hidden" name="bank"	value="<?=$bank?>" />
                        <input type="hidden" name="province"	value="<?=$province?>" />
                        <input type="hidden" name="city"	value="<?=$city?>" />
                        <input type="hidden" name="branch"	value="<?=$branch?>" />
                        <input type="hidden" name="realname" value="<?=$realname?>" />
                        <input type="hidden" name="cardno"	value="<?=$cardno?>" />
                        <input type="hidden" name="isverify" value="yes" />
                        <tr><td class="nl">开户银行:</td><td><?=Get_bank($bank)?></td></tr>
<?php if($bank==1 || $bank==2 || $bank==3){?>
                        <tr><td class="nl">开户银行省份:</td><td><?=Get_province($province)?></td></tr>
                        <tr><td class="nl">开户银行城市:</td><td><?=Get_city($city)?></td></tr>
<?php }?>
<?php if($bank==2){?>
						<tr><td class="nl">支行名称:</td><td><?=$branch?></td></tr>
<?php }?>
                        <tr><td class="nl">开户人姓名:</td><td><?=$realname?></td></tr>
                        <tr><td class="nl"><?php if($bank==19){echo "财付通";}else if($bank==20){echo "支付宝";}else{echo "银行";}?>账号:</td>
                            <td><font style='font-family:Verdana,Arial,Tahoma;line-height:36px;height:36px;font-size:26px;background-color:#000;color:#fC0;padding:0px 8px 0px 8px;'><?=$cardno?></font></td></tr>
                        <tr>
                        <td class="nl">输入资金密码: </td>
                        <td>
                            <input id='secpass' type="password" name="secpass" value="" /><font color="red"> 请输入资金密码</font>
                        </td>
                    </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="submit" name="submit" value="立即绑定" class="btn_submit" />　
                                <input type="button" value="返回" onclick="history.back();" class="btn_back" />
                            </td>
                        </tr>
                    </form>
                </table>
                <br><br><br><br>
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