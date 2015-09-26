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
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>如意彩 找回密码</title>
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
	font-size: 12px;
	font-weight: bold;
	color: #5C6670;
	width: 200px;
}
body {
	background-color: #333333;
	margin-left: 0px;
	margin-right: 0px;
	font-size: 12px;
	line-height: 18px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #666666;
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
	width: 100px;
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
<table width="100%" height="100%" border="0" cellspacing="10" cellpadding="0">
  <tr>
    <td align="center"><table width="985" border="0" cellspacing="0" cellpadding="0" class="top_01">
      <tr>
        <td class="top_02">&nbsp;</td>
        <td class="top_03">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="top_04">&nbsp;</td>
        <td class="top_05">&nbsp;</td>
      </tr>
    </table>
      <table width="985" border="0" cellpadding="0" cellspacing="15" bgcolor="#d5d8de">
        <tr>
          <td width="280" valign="top"><table width="280" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
            <tr>
              <td class="center_01"></td>
              <td width="270"></td>
              <td class="center_02"></td>
            </tr>
          </table>
          <table width="280" border="0" cellspacing="0" cellpadding="20">
  <tr>
    <td height="330" valign="top" bgcolor="#FFFFFF"><table width="240" border="0" cellpadding="0" cellspacing="5">
      <tr>
        <td align="left"><span class="STYLE2">忘记密码</span>&nbsp;</td>
        </tr>
      <tr>
        <td align="left"><span class="STYLE1">第一步:验证帐号和资金密码</span></td>
      </tr>
    </table>
    <table width="240" border="0" cellpadding="0" cellspacing="5">
      <tr>
        <td width="88" align="left">帐号</td>
        <td width="103" align="right">&nbsp;</td>
        <td width="29" align="right"></td>
      </tr>
      <tr>
        <td colspan="3" align="left"><input type="text" name="username" value="" id="username" class="lf-input" onmouseover="input_hover(this, '#FF9146');" onmouseout="input_hover(this, '#a4a4a4');" onfocus="input_hover(this, '#FF9146');" onblur="input_hover(this, '#a4a4a4');" tabindex="1" /></td>
      </tr>
    </table>
      <table width="240" border="0" cellpadding="0" cellspacing="5">
        <tr>
          <td width="88" align="left">资金密码</td>
          <td width="102" align="right">&nbsp;</td>
          <td width="30" align="right"></td>
        </tr>
        <tr>
          <td colspan="3" align="left"><input type="password" name="loginpass_source" value="" id="loginpass_source" class="lf-input" onmouseover="input_hover(this, '#FF9146');" onmouseout="input_hover(this, '#a4a4a4');" onfocus="input_hover(this, '#FF9146');" onblur="input_hover(this, '#a4a4a4');" tabindex="2" /></td>
          </tr>
      </table>
      <table id="tb_valid" width="240" border="0" cellspacing="5" cellpadding="0">
        <tr>
          <td align="left" width="91">验证码</td>
          <td align="left" width="99"></td>
          <td width="30" align="left"></td>
        </tr>
        <tr>
          <td align="left"><input name="validcode_source" type="text" class="lf-input" id="validcode_source" style='width:90px;color: #A4A4A4;' tabindex="3" onfocus="input_hover(this, '#FF9146');" onblur="input_hover(this, '#a4a4a4');" onmouseover="input_hover(this, '#FF9146');" onmouseout="input_hover(this, '#a4a4a4');" value="" size="4" maxlength="4"></td>
          <td width="99" align="left" >
              <img src="ValiCode_New.php" name="validate" align="absbottom" id="validate" style="margin-left:6px;cursor:pointer; border: 1px solid #999" title="点击刷新" onclick="refreshimg()" valign="bottom" />          </td>
          <td align="left">
          </td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="20" cellpadding="0">
        <tr>
          <td align="center">
          <input type="image" src="/images/login/login03.jpg"  class="loginbutton" value="登陆"/>
          </td>
        </tr>
      </table>
      <input type="hidden" name="flag" value="login" />
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="80">为了更好的操作体验首选IE8浏览器<br><a href="./">登陆系统</a></td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
            <tr>
              <td class="center_03"></td>
              <td width="270"></td>
              <td class="center_04"></td>
            </tr>
          </table>
 
          </td>
          <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
            <tr>
              <td class="center_01"></td>
              <td width="649"></td>
              <td class="center_02"></td>
            </tr>
          </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><img src="/images/login/login_main.jpg" width="635" height="350" /></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
            <tr>
              <td class="center_03"></td>
              <td width="649"></td>
              <td class="center_04"></td>
            </tr>
          </table>
 
          </td>
        </tr>
      </table>
      <table width="985" border="0" cellpadding="0" cellspacing="0" bgcolor="#d5d8de">
        <tr>
          <td class="bottom_01"></td>
          <td width="975"></td>
          <td class="bottom_02"></td>
        </tr>
      </table></td>
  </tr>
</table>
</form>
</body>
</html>
