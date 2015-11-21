<?php
session_start();
error_reporting(0);
require_once 'conn.php';

$flag=$_REQUEST['flag'];
if($flag=="confirm"){
    if ($_POST['validate'] != $_SESSION['valicode']) {
			$_SESSION["backtitle"]="验证码不正确，请重新输入";
			$_SESSION["backurl"]="register.php?id=".$_REQUEST['id'];
			$_SESSION["backzt"]="failed";
			$_SESSION["backname"]="用户注册";
			echo "<script language=javascript>window.location='sysmessage.php';</script>";
			exit;
    }

	$sql = "select * from ssc_member WHERE id='" . $_REQUEST['id'] . "'";
	$rs = mysql_query($sql);
	$total = mysql_num_rows($rs);
	$row = mysql_fetch_array($rs);
	if($total==0){
		$_SESSION["backtitle"]="推荐人不存在";
		$_SESSION["backurl"]="register.php?id=".$_REQUEST['id'];
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="用户注册";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}
	//推荐人
	$comUser = $row['username'];

	if($_REQUEST['username']!="" && $_REQUEST['pwd']!="" && $_REQUEST['nickname']!=""){

		$sqla = "SELECT * FROM ssc_member where username='".$_REQUEST['username']."'";
		$rsa = mysql_query($sqla);
		$nums=mysql_num_rows($rsa);
		if($nums>0){
			$_SESSION["backtitle"]="用户名已存在";
			$_SESSION["backurl"]="register.php?id=".$_REQUEST['id'];
			$_SESSION["backzt"]="failed";
			$_SESSION["backname"]="用户注册";
			echo "<script language=javascript>window.location='sysmessage.php';</script>";
			exit;
		}

//		$modes="1;1;1;1;";
		$regtop=$row['regtop'];
		if($regtop==""){
			$regtop=$row['username'];
		}
		
		
		//远程注册
		if($SOPEN == 1)
		{
			$sapi_regResult = SAPI_Reg($_REQUEST['username'], $_REQUEST['pwd'], $comUser, $_REQUEST['nickname']);
			if ($sapi_regResult[0] != 'SUCCESS')
			{
				$_SESSION["backtitle"]=$sapi_regResult[1];
				$_SESSION["backurl"]="/register.php?id=".$_REQUEST['id'];
				$_SESSION["backzt"]="failed";
				$_SESSION["backname"]="用户注册";
				echo "<script language=javascript>window.location='sysmessage.php';</script>";
				exit;
			}
		}
		
		$sql = "insert into ssc_member set username='" . $_REQUEST['username'] . "', password='" . md5($_REQUEST['pwd']) . "', nickname='" . $_REQUEST['nickname'] . "', regfrom='&" .$row['username']."&".$row['regfrom'] . "', regup='" . $row['username'] . "', regtop='" . $regtop . "', flevel='" . $row['xjlevel'] . "', level='1', regdate='" . date("Y-m-d H:i:s") . "', virtual='" . $row['virtual'] . "'";
		$exe = mysql_query($sql);
		
		$_SESSION["backtitle"]="操作成功";
		$_SESSION["backurl"]="index.php";
		$_SESSION["backzt"]="successed";
		$_SESSION["backname"]="用户登陆";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>如意彩自动注册</title>
<SCRIPT type="text/javascript" src="js/jquery.js"></SCRIPT>
<SCRIPT type="text/javascript" src="js/jquery.md5.js"></SCRIPT>
<script language="javascript" type="text/javascript" src="js/common.js"></script>

        <style type="text/css">
            body {
                margin: 0;
                background-color: #B34C11;
                background-image: url(images/register/bg.png);
            }
            .aa1 {
                color: #ffffff;
				font-size:18px;
				height:30px;
            }
            .aa2 {
                color: #ffffff;
				font-size:13px;
            }
		.inputb{
			width: 50px;
		}


        </style>
        <script>
		
function refreshimg(){
document.getElementById("vcsImg").src="ValiCode_new.php?"+  new Date().getTime();
}

function LoginNow() 
{ 
   var username=$("#username").val();
   var nickname=$("#nickname").val();
    var typepw = $("#pwd").val();
    
    var randnum = $("#validate").val();
	//$("#pwd")[0].value = '12345678901234567890';

	if( !validateUserName(username) )
	  {
	     alert("登陆帐号 不符合规则，请重新输入");
	     $("#username").focus();
		 return false;
	  }
	  if( !validateNickName(nickname) )
	  {
	  	alert("呢称 不符合规则，请重新输入");
	  	$("#nickname").focus();
		return false;
	  }
	
	 if( !validateUserPss(typepw) )
	 {
	  	alert("为了您的帐号安全,密码必须由数字和字母组成!\n不允许使用纯数字或纯字母做密码,请重新填写!");
	  	$("#pwd").focus();
		return false;
	 }
	 
    if (randnum == '') {
        alert('请填写 图片验证码');
        return false;
    }
  
   
    $("#loginpass")[0].value = typepw;
   
    document.forms['login'].submit();     
}
</script>
</head>

<body>
		<form name='login' method="post" action="?" onSubmit="javascript:LoginNow(); return false;">
					<input type="hidden" name="loginpass" id="loginpass">
					<input type="hidden" name="validcode" id="validcode">
					<input type="hidden" name="flag" value="confirm" />
					<input type="hidden" name="id" value="<?=$_GET['id']?>" />

<div align="center">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" background="images/register/topbg.png">
    <tr>
      <td height="135" valign="top"><div align="center">
        <table width="1150" border="0" cellpadding="0" cellspacing="0" background="images/register/top.png">
          <tr>
            <td height="113">&nbsp;</td>
          </tr>
        </table>
      </div></td>
    </tr>
  </table>
  <table width="1100" border="0" cellpadding="0" cellspacing="0" background="images/register/mainbg3.png">
    <tr>
      <td width="712" height="523" valign="top" align="center"><br />
        <br />
      <img src="images/register/222.png" width="631" height="406" /></td>
      <td width="388" valign="top" align="left"><table width="300" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td height="90" width=100></td>
          <td width=200></td>
        </tr>
        <tr>
          <td class="aa1">登陆帐号</td>
          <td><input type="text" id="username" name="username"/></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td class="aa2">由0-9,a-z,A-Z组成的4-13个字符</td>
        </tr>
        <tr>
          <td class="aa1">登陆密码</td>
          <td><input type="password" id="pwd" name="pwd"/></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td class="aa2">由数字和字母同时组成6-16个字<br />
            符；不允连续三位相同</td>
        </tr>
        <tr>
          <td class="aa1">用户昵称</td>
          <td><input type="text" id="nickname" name="nickname"/></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td class="aa2"></td>
        </tr>
        <tr>
          <td class="aa1">验证码</td>
          <td><input name="validate" type="text" id="validate" class="inputb">
            <img id="vcsImg" src="ValiCode_New.php"  name="validate" align="absbottom" style="margin-left:6px;cursor:pointer; border: 1px solid #999" onClick="refreshimg()" alt="点击图片更新验证码"></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><a href="#" onclick="LoginNow();return false;"><img src="images/register/ljkh.png" border="0" /></a></td>
        </tr>
        <tr>
          <td colspan="2"><a href="/soft/game.rar"><img src="images/register/down.png" width="297" height="67" border="0" /></a></td>
        </tr>
      </table></td>
    </tr>
  </table>
</div>
</form>
</body>
</html>
