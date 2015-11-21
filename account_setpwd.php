<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$flag = trim($_POST['flag']);
if($flag=="insert"){
//资金密码不能和登陆密码一样

$sql = "select * from ssc_member where username='".$_SESSION["username"]."'";
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs);

		if($_REQUEST['secpass']=="" || $_REQUEST['resecpass']==""){
			echo "<script>alert('请填写资金密码');window.location.href='account_setpwd.php';</script>"; 
			exit;
		}
		if($_REQUEST['secpass']!=$_REQUEST['resecpass']){
			echo "<script>alert('两次资金密码不一致，请重新输入');window.location.href='account_setpwd.php';</script>"; 
			exit;
		}
		if(strlen($_REQUEST['secpass'])<6 || strlen($_REQUEST['secpass'])>16 || preg_match('/(.+)\\1{2}/',$_REQUEST['newpass'])){
			echo "<script>alert('资金密码不符合规则，请重新输入');window.location.href='account_setpwd.php';</script>"; 
			exit;
		}

		if(md5($_REQUEST['secpass'])==$row['password']){
					$_SESSION["backtitle"]="资金密码不能和登陆密码一样";
					$_SESSION["backurl"]="account_setpwd.php";
					$_SESSION["backzt"]="failed";				
					$_SESSION["backname"]="返回上一页";
					echo "<script language=javascript>window.location='sysmessage.php';</script>";
					exit;
		}else{
			$sql = "update ssc_member set cwpwd='".md5($_POST['secpass'])."' WHERE username='" . $_SESSION["username"] . "'";
			$rs = mysql_query($sql);
			amend("设置资金密码");
				
			$_SESSION["backtitle"]="资金密码设置成功";
			$_SESSION["backurl"]=$_SESSION["cwurl"];
			$_SESSION["backzt"]="successed";	
			$_SESSION["backname"]="返回上一页";
			echo "<script language=javascript>window.location='sysmessage.php';</script>";
			exit;
		}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<head>
    <title>娱乐平台  - 设置资金密码</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
        <link href="./css/v1/all.css?modidate=20130201001" rel="stylesheet" type="text/css" />
    <script>var pri_imgserver = '';</script>
        <script language="javascript" type="text/javascript" src="./js/jquery.js?modidate=20130726001"></script>
    <script language="javascript" type="text/javascript" src="./js/common.js?modidate=20130726001"></script>
    <script language="javascript" type="text/javascript" src="./js/lottery/min/message.js?modidate=20130726001"></script>
    <script language="javascript" type="text/javascript" src="./js/keyboard/keyboard.js?modidate=20130726001"></script>
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
        var top = $("#password").offset().top+$("#password").height()-4;
        $(".password").css("top",top+"px");
        getKeyBoard($('#repassword'));
        var top = $("#repassword").offset().top+$("#repassword").height()-4;
        $(".repassword").css("top",top+"px");
        $("#copyright").css("margin-bottom","100px");
    });
</script>
<script type="text/javascript"> 
    function checkform(obj){
        if( !validateUserPss(obj.secpass.value) || !validateUserPss(obj.resecpass.value)){
            alert("资金密码不符合规则，请重新输入");
            obj.secpass.focus();
            return false;
        }
        if(obj.secpass.value != obj.resecpass.value){
            alert("两次资金密码不一致，请重新输入");
            obj.secpass.focus();
            return false;
        }
        return true;
    }
</script>
<div class="clear"></div>
<div class="rc_con system">
    <div class="rc_con_lt"></div>
    <div class="rc_con_rt"></div>
    <div class="rc_con_lb"></div>
    <div class="rc_con_rb"></div>
    <h5><div class="rc_con_title">设置资金密码</div></h5>
    <div class="rc_con_to">
        <div class="rc_con_ti">
            <table class="lt" border="0" cellspacing="0" cellpadding="0">
                <form action="" method="post" name="updateform" onsubmit="return checkform(this)">
                    <input type="hidden" name="flag" value="insert" />
                    <input type="hidden" name="controller" value="security" />
                    <input type="hidden" name="action"	value="setsecurity" />
                    <input type="hidden" name="nextcon" value="account" />
                    <input type="hidden" name="nextact" value="banks" />
                    <tr>
                        <td class="narrow-label"><b>输入资金密码:</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td>
                            你还没有设置资金密码，请先设置<br/>
                            <input type="password" name="secpass" value="" id="password"/><font color="red">&nbsp;&nbsp;请输入资金密码</font><br />
                            <input type="password" name="resecpass" value="" id="repassword"/><font color="red">&nbsp;&nbsp;请再次输入资金密码</font><br />
                            (由字母和数字组成6-16个字符；且必须包含数字和字母，不允许连续三位相同，不能和登陆密码相同)
                        </td>
                    </tr>
                    <tr><td></td><td><input type="submit" name="submit" value="提交" class="btn_submit" />&nbsp;&nbsp;<input type="button" value="重置" onclick="this.form.reset()" class="btn_normal" /></td></tr>
                </form>
            </table>
            <div class="clear"></div>
        </div>
    </div>
</div>
<br><br><br><br><br><br><br><br>
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
