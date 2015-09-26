<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$flag = trim($_POST['flag']);
if($flag=="check"){
	$sql = "select * from ssc_bankcard WHERE id='" . $_POST["verifyid"] . "'";
	$rs = mysql_query($sql);
	$row = mysql_fetch_array($rs);
	
//	echo $sql;
//	echo $_POST['cardno'].$_POST['realname'];
//	echo $row['cardno'].$row['realname'];
	if($_POST['cardno']==$row['cardno'] && $_POST['realname']==$row['realname']){
		$_SESSION["cardflag"]="ok";
		echo "<script language=javascript>window.location='".$_SESSION["cardurl"]."';</script>";
		exit;
	}else{
		$_SESSION["cardflag"]="failed";
		$_SESSION["backtitle"]="旧卡信息验证失败，请仔细检查";
		$_SESSION["backurl"]="account_banks.php?check=114";
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="我的银行卡";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}
}

$bid=$_GET["id"];
if($bid==""){
$sqla = "select * from ssc_bankcard WHERE username='" . $_SESSION["username"] . "'";
}else{
$sqla = "select * from ssc_bankcard WHERE id='" . $bid . "' and username='" . $_SESSION["username"] . "'";
}
$rsa = mysql_query($sqla);
$rowa = mysql_fetch_array($rsa);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<head>
    <title>娱乐平台  - 验证银行卡信息</title>
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
        getNumKeyBoard($('#cardno'));
        $("#copyright").css("margin-bottom","100px");
    });
</script>
<script type="text/javascript">
    jQuery("document").ready( function(){
	
    });
    function exceptSpecial(obj){
        obj.value = obj.value.replace(/[\<\>\~\!\@\#\$\%\^\&\*\-\+\=\|\\\'\?\,\/\[\]\{}\(\)\"]{1,}/,'');
    }
    function checkform(obj){
        var repSpecial = /[\<\>\~\!\@\#\$\%\^\&\*\-\+\=\|\\\'\"\?\,\/\[\]\{}\(\)]{1,}/;
        var re = /^(.){1,15}$/;
        if( !re.test(obj.realname.value) || repSpecial.test(obj.realname.value) || obj.realname == ""){
            alert('"开户人姓名" 不符合规则, 请重新输入');
            obj.realname.focus();
            return false;
        }
<?php if($rowa['bankid']==19){ ?>
    var re = /^.{5,35}$/;
<?php }else if($rowa['bankid']==20){?>
  	  var re = /^.{5,35}$/;
<?php }else{ ?>
    var re = /^\d{16}$|^\d{19}$/;
<?php } ?>

        var cardno = document.getElementById("cardno");
        if (!re.test(cardno.value)){
            alert('"银行账号" 不符合规则, 请重新输入');
            cardno.focus();
            return false;
        }
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
    <h5><div class="rc_con_title">验证银行卡信息</div></h5>
    <div class="rc_con_to">
        <div class="rc_con_ti">
            <div class="binding_ts">
                <div class="binding_tsn">
                    <h4>使用提示：</h4>
                    <p>请输入您已绑定银行卡的相关信息进行安全验证。</p>
                </div>
            </div>
            <div class="clear"></div>
            <div class="binding_input">
                <table class="ct" border="0" cellspacing="0" cellpadding="0" width="100%">
                    <form action="" method="post" name="addform" id='addform' onsubmit="return checkform(this)">
                        <input type="hidden" name="verifyid" value="<?=$rowa['id']?>" />
                        <input type="hidden" name="flag" value="check" />
                        <tr>
                            <td class="nl">已绑定的<font color="#0066FF"><?=$rowa['bankname']?></font>卡:</td>
                            <td>***************<?=substr($rowa['cardno'],-4)?></td>
                        </tr>
                        <tr>
                            <td class="nl"><font color="#FF0000">*</font>&nbsp;银行账号:</td>
                            <td>
                                <input class="needdesc" maxlength="19" type="text" name="cardno" id="cardno" style="width:220px;" />
                                <span class="pop"><s class="pop-l"></s><span>（请输入对应绑定卡的银行卡号）</span><s class="pop-r"></s></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="nl"><font color="#FF0000">*</font>&nbsp;开户人姓名:</td>
                            <td>
                                <input class="needdesc" type="text" name="realname" maxlength="15" id="realname" onkeyup="exceptSpecial(this);" onchange="exceptSpecial(this);" style='width:220px;' />
                                <span class="pop"><s class="pop-l"></s><span>（请输入对应绑定卡的银行开户人姓名）</span><s class="pop-r"></s></span>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                                <input value="下一步" name="submit" type="submit" width='69' height='26' class="btn_next" />
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
