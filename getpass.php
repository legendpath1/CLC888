<?php
//session_start();
//error_reporting(0);
//require_once 'conn.php';

//$sqlzz = "select * from ssc_config";
//$rszz = mysql_query($sqlzz);
//$rowzz = mysql_fetch_array($rszz);
//$webzt=$rowzz['zt'];
//$webzt2=$rowzz['zt2'];
//$count=$rowzz['counts'];
//$webname=$rowzz['webname'];
//$gourl=$rowzz['rurl'];

//if($webzt!='1'){
//	echo "<script>window.location='".$gourl."';</script>"; 
//	exit;
//}

//if($_SESSION["uid"]!="" && $_SESSION["username"]!="" && $_SESSION["valid"]!=""){
//	$result = mysql_query("select * from ssc_online where valid='".$_SESSION["valid"]."' and username='".$_SESSION["username"]."'");  
//	$total = mysql_num_rows($result);
//	if($total!=0){
//		echo "<script language=javascript>window.location='default_frame.php';</script>";
//		exit;
//	}
//}

//$sql = "select * from ssc_lockip WHERE ip='" . $_SERVER['REMOTE_ADDR'] . "'";
//$query = mysql_query($sql);
//$dduser = mysql_fetch_array($query);
//if(empty($dduser)){
//}else{
//	echo "<script>window.location='".$gourl."';</script>"; 
//	exit;
//}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>如意彩　找回密码</title>
<script language="javascript" type="text/javascript" src="./js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="./js/jquery.md5.js"></script>
<script language="javascript"> 
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
                var typepw = $("#loginpass_source").val();
                var randnum = $("#validcode_source").val();
                $("#loginpass_source")[0].value = '12345678901234567890';
                if (loginuser == ''){
                    alert('请填写账号');
                    return false;
                }
                if  (typepw == '') {
                    alert('请填写资金密码');
                    return false;
                }
                if (randnum == '') {
                    alert('请填写验证码');
                    return false;
                }
                var submitvc = $.md5(randnum);
                var submitpw = $.md5(typepw);
                $("#loginpass")[0].value = submitpw;
                $("#validcode")[0].value = submitvc;
                document.forms['login'].submit();     
            }

			function input_hover(obj, color)
			{
				obj.style.border = '1px solid ' + color;
			}
</script>
<script type="text/javascript"> 
</script>
<style type="text/css"> 
<!--
input{
	font-size: 13px;
	font-weight: bold;
	color: #5C6670;
	width: 200px;
	height:20px;
	border:1px solid #FF9146;
}
body {
	background-image: url(/images/login/bg.png);
	margin-top: 0px;
	margin-left: 0px;
	margin-right: 0px;
	font-size: 13px;
	line-height: 18px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #111111;
}
.top_02 {
	background-image: url(/images/login/login01.png);
	background-repeat: no-repeat;
	background-position: 0px 0px;
	overflow:hidden;
	height: 32px;
	width: 5px;
}
.top_01{
	background-image: url(/images/login/login01.png);
	background-repeat: repeat-x;
	background-position: 0px -33px;
	height: 32px;
}
.top_03 {
	background-image: url(/images/login/login01.png);
	background-position: -6px 0px;
	height: 32px;
	width: 61px;
}
.top_04 {
	background-image: url(/images/login/login01.png);
	background-position: -68px 0px;
	height: 32px;
	width: 115px;
}
.top_05 {
	background-image: url(/images/login/login01.png);
	background-position: -184px 0px;
	overflow:hidden;
	height: 32px;
	width: 5px;
}
.bottom_01 {
	background-image: url(/images/login/login01.png);
	background-position: -190px -12px;
	height: 5px;
	width: 5px;
	overflow:hidden;
}
.bottom03 {
	height: 5px;
	overflow:hidden;
}
.bottom_02 {
	background-image: url(/images/login/login01.png);
	background-position: -196px -12px;
	height: 5px;
	width: 5px;
	overflow:hidden;
}
.center_01 {
	background-image: url(/images/login/login01.png);
	background-position: -190px 0px;
	height: 5px;
	width: 5px;
	overflow:hidden;
}
.center_02 {
	background-image: url(/images/login/login01.png);
	background-position: -196px 0px;
	height: 5px;
	width: 5px;
	overflow:hidden;
}
.center_03 {
	background-image: url(/images/login/login01.png);
	background-position: -190px -6px;
	height: 5px;
	width: 5px;
	overflow:hidden;
}
.center_04 {
	background-image: url(/images/login/login01.png);
	background-position: -196px -6px;
	height: 5px;
	width: 5px;
	overflow:hidden;
}
.loginbutton{
	font-size: 12px;
	font-weight: bold;
	color: #5C6670;
	width: 120px;
	height: 43px;
	border:none;
}
.STYLE1 {color: #FF0000}
.STYLE2 {
	font-size: 14px;
	font-weight: bold;
}

-->
</style>
</head>
<body>
<form action="getpass2.php" method="post" name="login" id="login" onSubmit="javascript:LoginNow(); return false;">
                    <input type="hidden" name="loginpass" id="loginpass">
                    <input type="hidden" name="validcode" id="validcode">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">
      <table width="900" height="515" border="0" cellpadding="0" cellspacing="15" background="/images/login/bg2.png">
        <tr>
          <td valign="top">&nbsp;</td>
          <td width="420" valign="top">
          <table width="280" border="0" cellspacing="0" cellpadding="20" align="left">
  			<tr>
    		  <td valign="top">
                <table width="240" border="0" cellpadding="0" cellspacing="5">
                  <tr>
                    <td width="50" height="100" align="left"></td>
                    <td align="right"></td>
                    <td width="20"></td>
                  </tr>
                  <tr>
                    <td align="left" colspan="3"><span class="STYLE2">忘记密码</span>&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="left" colspan="3"><span class="STYLE1">第一步:验证帐号和资金密码</span></td>
                  </tr>
                  <tr>
                    <td width="88" align="left">帐号</td>
                    <td align="right"></td>
                    <td width="20" align="right"></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="left"><input type="text" name="username" value="" id="username" class="lf-input" onmouseover="input_hover(this, '#ff0000');" onmouseout="input_hover(this, '#FF9146');" onfocus="input_hover(this, '#ff0000');" onblur="input_hover(this, '#FF9146');" tabindex="1" /></td>
                  </tr>
                </table>
                <table width="240" border="0" cellpadding="0" cellspacing="5">
                  <tr>
                    <td width="88" align="left">资金密码</td>
                    <td align="right"></td>
                    <td width="20" align="right"></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="left"><input type="password" name="loginpass_source" value="" id="loginpass_source" class="lf-input" onmouseover="input_hover(this, '#ff0000');" onmouseout="input_hover(this, '#FF9146');" onfocus="input_hover(this, '#ff0000');" onblur="input_hover(this, '#FF9146');" tabindex="2" /></td>
                    </tr>
                </table>
                <table id="tb_valid" width="240" border="0" cellspacing="5" cellpadding="0">
                  <tr>
                    <td align="left" width="88">验证码</td>
                    <td align="left" width="50"></td>
                    <td align="left"></td>
                  </tr>
                  <tr>
                    <td align="left"><input name="validcode_source" type="text" class="lf-input" id="validcode_source" style='width:90px;color: #A4A4A4;' tabindex="3" onmouseover="input_hover(this, '#ff0000');" onmouseout="input_hover(this, '#FF9146');" onfocus="input_hover(this, '#ff0000');" onblur="input_hover(this, '#FF9146');" value="" size="4" maxlength="4"></td>
                    <td width="100" align="left" >
                      <img src="ValiCode_New.php" name="validate" align="absbottom" id="validate" style="margin-left:6px;cursor:pointer; border: 1px solid #999" title="点击刷新" onclick="refreshimg()" valign="bottom" />
                    </td>
                    <td align="left">
                    </td>
                  </tr>
                </table>
                <br>
                <table width="100%" border="0" cellspacing="5" cellpadding="0">
                  <tr>
                    <td align="left">
                    <input type="image" src="/images/login/next.png" class="loginbutton" value="登陆"/>
                    </td>
                    <td width="80" align="left">
                    	<a href="./">返回登录</a>
                    </td>
                  </tr>
                </table>
                <input type="hidden" name="flag" value="login" />
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="40">浏览器建议：首选IE 8.0,Chrome浏览器，其次为火狐浏览器。</td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
 
          </td>

        </tr>
      </table>
</td>
  </tr>
</table>
</form>
</body>
</html>
