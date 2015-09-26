<?php
session_start();
error_reporting(0);
require_once 'conn.php';

$sqlzz = "select * from ssc_config";
$rszz = mysql_query($sqlzz);
$rowzz = mysql_fetch_array($rszz);
$webzt=$rowzz['zt'];
$webzt2=$rowzz['zt2'];
$count=$rowzz['counts'];
$webname=$rowzz['webname'];
$gourl=$rowzz['rurl'];

$name = trim($_POST['username']);
$vcode = trim($_POST['validcode_source']);

if ($name == "") {
	echo "<script language=javascript>window.location='./';</script>";
	exit;
}
if ($vcode != $_SESSION['valicode']) {
	echo "<script language=javascript>alert('验证码不正确，请重新输入');window.location='./';</script>";
	exit;
}

$sql = "select * from ssc_member WHERE username='" . $name . "'";
$query = mysql_query($sql);
$dduser = mysql_fetch_array($query);

if(empty($dduser)){
	echo "<script>window.location='".$gourl."';</script>"; 
	exit;
}else{
	$question = $dduser['question'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
    <HEAD>
        <META http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <TITLE>用户登陆</TITLE>
        <SCRIPT LANGUAGE='JavaScript'>function ResumeError() {return true;} window.onerror = ResumeError; </SCRIPT> 
                <SCRIPT type="text/javascript" src="./js/jquery.js"></SCRIPT>
        <SCRIPT type="text/javascript" src="./js/jquery.md5.js"></SCRIPT>
                <LINK href="./css/v1/login.css" rel="stylesheet" type="text/css" />
    </HEAD>
    <BODY>
        <script type="text/javascript">
            if(top.location != self.location) {top.location=self.location;}
            $(document).ready(function(){
                $("input.text").focus(
                function(){
                    $("input.text").parent().parent().removeClass("inputGreen");
                    $(this).parent().parent().addClass("inputGreen");}
            );
                $("input.text").blur(
                function(){ 
                    $(this).parent().parent().removeClass("inputGreen");}
            );
                $("#loginpass_source").focus();
            });
            function LoginNow() 
            { 
                var loginuser = $("#username").val();
                var typepw = $("#loginpass_source").val();
                var vc = 'e354fd90b2d5c777bfec87a352a18976';
                $("#loginpass_source")[0].value = '12345678901234567890';
                if( typepw == '' ){
                    alert('请填写用户密码');
                    return false;
                }
                var submitpw = $.md5( $.md5(typepw)+vc );
                $("#loginpass")[0].value = submitpw;
                document.forms['login'].submit();     
            }
        </script>
<div id="login">
<div class="logo">
    <img src="./images/login/logo.gif" width="295" height="97" alt="娱乐平台" />
</div>
<div class="clear"></div>
<div class="login_ipt">
    <div class="l_box_lt"></div><div class="l_box_lb"></div><div class="l_box_rt"></div><div class="l_box_rb"></div>
    <div class="l_ipt_l">
        <div class="title">登录</div>
        <div class="ipt_h">
        </div>
        <div class="ipt_c">
            <form name='login' method="post" action="login2.php" onSubmit="javascript:LoginNow(); return false;"">
                    <input type="hidden" name="loginpass" id="loginpass">
                    <input type="hidden" name="validcode" id="validcode">
                    <input type="hidden" name="flag" value="login2" />
                    <table width=100% border="0" cellspacing="3" cellpadding="0">
                        <tr>
                            <td width="74" align="right">账号：</td>
                            <td align="left">
                                <div class="form_word" style='font-size:14px;'><?=$name?></div>
                                <input type="hidden" name="username" id="username" value="<?=$name?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td width="74" align="right">问候语：</td>
                            <td align="left">
                                <p title="" class="qustion"><?php if($question==""){echo "<font style='color:#333;'>您还没有设置问候语，为了您的安全，请尽快设置！</font>";}else{echo $question;}?></p>
                                <p><span style="font-size:12px;color:#999;">如果问候语与您预设不一致，则为仿冒！不要输入密码！</span></p>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">登陆密码：</td>
                            <td>
                                <div class="ipt_i ipt_i_b">
                                    <div class="form_word"><span class="inputBox input180"><cite><input type="password" name="loginpass_source" id="loginpass_source" maxlength="20" value="" class="text"/></cite></span></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="login_bottom">
                                <input name="Submit" type="submit" value="" id="Submit" class='inputLogin' title="提交" width="104" height="30"/><span class="forgetpwd"><a href="./default_getpass.php">忘记密码？</a></span>
                            </td>
                        </tr>
                    </table>
            </form>
        </div>
    </div>
<div class="l_ipt_r">
    <div class="l_ipt_c">
    </div>
    <div class="ipt_h">
    </div>
    <div class="ipt_c">
        <p>建议使用IE 6.0以上浏览器，使用 <span>IE (Internet Explorer) 8.0</span> 浏览器，可达到最佳使用效果。</p>
    </div>
</div>
</div>
</div>
</body>
</html>