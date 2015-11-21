<<<<<<< HEAD
<?php
session_start();
error_reporting(0);
require_once 'conn.php';

if($_SESSION["uid"]!="" && $_SESSION["username"]!="" && $_SESSION["valid"]!=""){
	$sqlu = "select * from ssc_online where username='".$_SESSION['username']."'";
	$rsu = mysql_query( $sqlu );
    $rowu = mysql_fetch_array( $rsu );
	if ($rowu['uid'] == $_SESSION["uid"]) {
		echo "<script language=javascript>window.location='default_frame.php';</script>";
	    exit;
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>彩乐彩 用户登陆</title>
<link rel="stylesheet" href="./css/v1/base.css" />
<link rel="stylesheet" href="./css/v1/new-login.css" />
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

			function input_hover(obj, color)
			{
				obj.style.border = '1px solid ' + color;
			}
</script>

</head>
<body class="bg-content new-login">
	<div class="wrap-login">
		 <div class="logo">
		 	<a herf="/"></a>
		 </div>
		 <div class="nav-wrap clearfix">
			<div class="guest-point guest-area">
				<span class="help-icon">有问题咨询在线客服？</span><a target="_blank" href="http://api.pop800.com/chat/167901">点击此处</a>
			</div>
			 <ul class="nav">
			 	<!--<li class="">
			 		<a href="#">旧平台登陆</a>
			 	</li>
			 	<li class="second current">
			 		<a href="#">新平台登陆</a><a id="J-question-button" href="#" class="question"></a>
			 	</li>
-->
<li class="current">
			 		<a href="#">平台登陆</a>
			 	</li>			
 </ul>
		 </div>
		 <div class="info-panel clearfix">
		 	<div class="left-shadow"></div>
		 	<div class="login-info-area">
		 		<form action="login2.php" method="post" name="login" id="login" onSubmit="javascript:LoginNow(); return false;">
				<input type="hidden" name="loginpass" id="loginpass">
		 			<div class="user-info clearfix">
		 				<input type="text" id="username" name="username" class="user-name" placeholder="用户名">
		 				<div class="line"></div>
		 				<input type="password" id="loginpass_source" name="loginpass_source" placeholder="密码" class="user-password">
		 				<a href="/findpwd.php" class="forget-password" tabindex="-1">忘记密码？</a>
		 				<a href="javascript:;" title="清除用户名" data-name="name" class="clear-name" tabindex="-1">清除用户名</a>
		 				<a href="javascript:;" title="清除密码" data-name="password" class="clear-password" tabindex="-1">清除密码</a>
		 				<input type="hidden" id="J-loginParam" data-name="loginParam" name="loginParam" value="606d8598d82deb17b5c25cdbd15fe54c" >
		 			</div>
		 			<div id="J-panel-vcode" class="user-info ver-area clearfix">
		 				<!--<div class="var-img-area"></div>-->
                        <img class="var-img-area" id="validate" src="ValiCode_new.php" style="cursor:pointer; border: 1px solid #999" onClick="refreshimg()" alt="点击图片刷新验证码" title="点击图片刷新验证码" />
		 				<input type="text" id="validcode_source" name="validcode_source" class="user-ver" placeholder="验证码" >
		 			</div>
		 			<div id="J-msg-show" data-display="hide" class="msg-show"></div>
		 			<input id="J-form-submit" class="submit-btn" type="submit" value="登 录">
		 			<div class="login-tips">浏览器建议：首选IE 8.0,Chrome浏览器，其次为火狐浏览器,尽量不要使用IE6。</div>
		 		</form>
		 	</div>
		 	<div class="banner-area">
				<div class="kkk">
                   <!--                                     <a href=""><img src="http://static.phl58.co/dynamic/50ec6a9355f430f8d8bbd3f0036b6329.jpg" alt="" style="background:#ccc;"></a>
				                      -->
					<a href="/"><img src="images/login2/ad.jpg" title="全面升级" alt="全面升级"></a>
				</div>
			</div>
		 	<div class="right-shadow"></div>
		 </div>
		 <div class="shadow-bottom"></div>
	</div>
	<div class="supper-bowser"></div>
</body>
</html>
=======
<?php
session_start();
error_reporting(0);
require_once 'conn.php';

if($_SESSION["uid"]!="" && $_SESSION["username"]!="" && $_SESSION["valid"]!=""){
	$sqlu = "select * from ssc_online where username='".$_SESSION['username']."'";
	$rsu = mysql_query( $sqlu );
    $rowu = mysql_fetch_array( $rsu );
	if ($rowu['uid'] == $_SESSION["uid"]) {
		echo "<script language=javascript>window.location='default_frame.php';</script>";
	    exit;
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>彩乐彩 用户登陆</title>
<link rel="stylesheet" href="./css/v1/base.css" />
<link rel="stylesheet" href="./css/v1/new-login.css" />
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

			function input_hover(obj, color)
			{
				obj.style.border = '1px solid ' + color;
			}
</script>

</head>
<body class="bg-content new-login">
	<div class="wrap-login">
		 <div class="logo">
		 	<a herf="/"></a>
		 </div>
		 <div class="nav-wrap clearfix">
			<div class="guest-point guest-area">
				<span class="help-icon">有问题咨询在线客服？</span><a target="_blank" href="http://api.pop800.com/chat/167901">点击此处</a>
			</div>
			 <ul class="nav">
				<li class="current">
			 		<a href="#">平台登陆</a>
			 	</li>			
 </ul>
		 </div>
		 <div class="info-panel clearfix">
		 	<div class="left-shadow"></div>
		 	<div class="login-info-area">
		 		<form action="login2.php" method="post" name="login" id="login" onSubmit="javascript:LoginNow(); return false;">
				<input type="hidden" name="loginpass" id="loginpass">
		 			<div class="user-info clearfix">
		 				<input type="text" id="username" name="username" class="user-name" placeholder="用户名">
		 				<div class="line"></div>
		 				<input type="password" id="loginpass_source" name="loginpass_source" placeholder="密码" class="user-password">
		 				<a href="/findpwd.php" class="forget-password" tabindex="-1">忘记密码？</a>
		 				<a href="javascript:;" title="清除用户名" data-name="name" class="clear-name" tabindex="-1">清除用户名</a>
		 				<a href="javascript:;" title="清除密码" data-name="password" class="clear-password" tabindex="-1">清除密码</a>
		 				<input type="hidden" id="J-loginParam" data-name="loginParam" name="loginParam" value="606d8598d82deb17b5c25cdbd15fe54c" >
		 			</div>
		 			<div id="J-panel-vcode" class="user-info ver-area clearfix">
		 				<!--<div class="var-img-area"></div>-->
                        <img class="var-img-area" id="validate" src="ValiCode_new.php" style="cursor:pointer; border: 1px solid #999" onClick="refreshimg()" alt="点击图片刷新验证码" title="点击图片刷新验证码" />
		 				<input type="text" id="validcode_source" name="validcode_source" class="user-ver" placeholder="验证码" >
		 			</div>
		 			<div id="J-msg-show" data-display="hide" class="msg-show"></div>
		 			<input id="J-form-submit" class="submit-btn" type="submit" value="登 录">
		 			<div class="login-tips">浏览器建议：首选IE 8.0,Chrome浏览器，其次为火狐浏览器,尽量不要使用IE6。</div>
		 		</form>
		 	</div>
		 	<div class="banner-area">
				<div class="kkk">
                   <!--                                     <a href=""><img src="http://static.phl58.co/dynamic/50ec6a9355f430f8d8bbd3f0036b6329.jpg" alt="" style="background:#ccc;"></a>
				                      -->
					<a href="/"><img src="images/login2/ad.jpg" title="全面升级" alt="全面升级"></a>
				</div>
			</div>
		 	<div class="right-shadow"></div>
		 </div>
		 <div class="shadow-bottom"></div>
	</div>
	<div class="supper-bowser"></div>
</body>
</html>
>>>>>>> 28d30127709bc3ffcf1f3aa6ae4cd69a1fbea527
