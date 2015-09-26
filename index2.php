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

if($webzt!='1'){
	echo "<script>window.location='".$gourl."';</script>"; 
	exit;
}

if($_SESSION["uid"]!="" && $_SESSION["username"]!="" && $_SESSION["valid"]!=""){
	$result = mysql_query("select * from ssc_online where valid='".$_SESSION["valid"]."' and username='".$_SESSION["username"]."'");  
	$total = mysql_num_rows($result);
	if($total!=0){
		echo "<script language=javascript>window.location='default_frame.php';</script>";
		exit;
	}
}

$sql = "select * from ssc_lockip WHERE ip='" . $_SERVER['REMOTE_ADDR'] . "'";
$query = mysql_query($sql);
$dduser = mysql_fetch_array($query);
if(empty($dduser)){
}else{
	echo "<script>window.location='".$gourl."';</script>"; 
	exit;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
    <HEAD><META http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <TITLE>用户登陆</TITLE>
        <SCRIPT LANGUAGE='JavaScript'>function ResumeError() {return true;} window.onerror = ResumeError; </SCRIPT> 
                <SCRIPT type="text/javascript" src="./js/jquery.js"></SCRIPT>
        <SCRIPT type="text/javascript" src="./js/jquery.md5.js"></SCRIPT>
                <LINK href="./css/v1/login2.css" rel="stylesheet" type="text/css" />
    </HEAD>
    <BODY>
        <script type="text/javascript">
            if(top.location != self.location) {top.location=self.location;}
            $(document).ready(function(){
                $("#username").value = '';
                $("#validcode_source")[0].value = '';
//                $("#validate").attr('src',"ValiCode_new.php?useValid="+Math.random());
                $("#username").focus();
            }); 
            function refreshimg(){
                $("#validate").attr('src',"ValiCode_new.php?useValid="+Math.random());
            }
            function LoginNow() 
            { 
                var loginuser = $("#username").val();
                var randnum = $("#validcode_source").val();
                if (loginuser == ''){
                    alert('请填写账号');
                    return false;
                }
                if (randnum == '') {
                    alert('请填写验证码');
                    return false;
                }
                var submitvc = $.md5(randnum);
                $("#validcode")[0].value = submitvc;
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
        <div class="ipt_h"></div>
        <div class="ipt_c">
            <form name='login' method="post" action="login.php" onSubmit="javascript:LoginNow(); return false;"">
                    <input type="hidden" name="validcode" id="validcode">
                    <input type="hidden" name="flag" value="login" />
                    <table width="308" border="0" cellspacing="3" cellpadding="0">
                    <tr>
                        <td width="74" align="right">账号：</td>
                        <td width="225" colspan="2">
                            <div class="ipt_i ipt_i_a"><input name="username" type="text" id="username" /></div>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">验证码：</td>
                        <td>
                            <div class="ipt_i ipt_i_b">
                                <input type="text" name="validcode_source" id="validcode_source" maxlength="4" value="" class="text"/>
                            </div>
                        </td>
                        <td>
                            <img src="ValiCode_New.php" name="validate" align="absbottom" id="validate" style="margin-left:6px;cursor:pointer; border: 1px solid #999" title="点击刷新" onclick="refreshimg()" valign="bottom" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="login_bottom">
                            <input name="Submit" type="submit" value="" id="Submit" class='inputNext' title="下一步" width="104" height="30"/><span class="forgetpwd"><a href="./default_getpass.php">忘记密码？</a></span>
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