<?php
session_start();
error_reporting(0);
require_once 'conn.php';

$name = trim($_POST['username']);
$pwd = trim($_POST['loginpass']);

if ($name == "") {
	echo "<script language=javascript>window.location='findpwd.php';</script>";
	exit;
}


$sql = "select * from ssc_member WHERE username='" . $name . "'";
$query = mysql_query($sql);
$dduser = mysql_fetch_array($query);

if(empty($dduser)){
	echo "<script>alert('帐号和资金密码验证失败');window.location='findpwd.php';</script>"; 
	exit;
}else{
	$pwd2 = $dduser['cwpwd'];
	if($pwd2==$pwd){
//	if($pwd2==$pwd){
		$_SESSION['finduser']=$name;
	}else{
		echo "<script language=javascript>alert('帐号和资金密码验证失败!');window.location='findpwd.php';</script>";
		exit;
	}
}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>找回密码</title>
    <link rel="stylesheet" href="/css/v1/base.css" />
    <link rel="stylesheet" href="/css/v1/safe.css" />
	
	<style>
	html,body {height:100%;position:relative;overflow-x:hidden;}
	.footer {position:absolute;bottom:0;}
	.j-ui-miniwindow {width:590px;}
	</style>
<script language="javascript" type="text/javascript" src="./js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="./js/jquery.md5.js"></script>
<script language="javascript"> 
            $(document).ready(function(){
                $("#loginpass_source").focus();
            }); 
            function LoginNow() 
            { 
				var loginpass = $("#loginpass_first").val();
				var typepw = $("#loginpass_source").val();
				if( loginpass == '' ){
					alert('请填写 新的登录密码');
					return false;
				}
				if( loginpass != typepw ){
					$("#loginpass_first")[0].value = '';
					$("#loginpass_source")[0].value = '';
					$("#loginpass_first").focus();
					alert('两次输入的密码不一致，请重新确认');
					return false;
				}
				document.forms['login'].submit();                 }

			function input_hover(obj, color)
			{
				obj.style.border = '1px solid ' + color;
			}
</script>	
	
</head>
<body>
    
    <div class="header">
	<div class="g_33">
		<h1 class="logo"><a title="首页" href="/">PH158</a></h1>
	</div>
</div>    
    <!-- step-num star -->
    <div class="step-num">
        <ul>
            <li ><i class="step-num-1">1</i>输入用户名</li>
            <li ><i class="step-num-2">2</i>选择找回密码方式</li>
            <li class="current"><i class="step-num-3">3</i>重置密码</li>
            <li ><i class="step-num-4">4</i>完成</li>
        </ul>
    </div>
    <!-- step-num end -->
    
    <div class="g_33">
			<div class="find-select-content">
            <form action="findpwd4.php?stp=0" method="post" name="login" id="login" onSubmit="javascript:LoginNow(); return false;">
			<input type="hidden" name="username" id="username" value="<?=$name?>">
            <div class="find-reset-content" style="padding:0;">
                <ul class="ui-form">
                    <li class="ui-text"><strong class="highbig">设置新的登录密码</strong><br />您申请了找回密码，为保护您的账号安全，请立即修改为您常用的新的密码。</li>
                    <li>
                        <label for="name" class="ui-label">请输入新的密码：</label>
                        <input type="password" value="" id="loginpass_first" name="loginpass_first" class="input">
						<span class="ui-check-right"></span>
                         <div class="ui-prompt" style="display:none">6-20位字符组成，区分大小写</div>      
                        <div class="ui-check"><i class="error"></i>登录密码应为6-20位字符</div>
                    </li>
                    <li>
                        <label for="pwd" class="ui-label">再次输入新密码：</label>
                        <input type="password" value="" id="loginpass_source" name="loginpass_source" class="input">
						<span class="ui-check-right"></span>
						 <div class="ui-prompt" style="display:none">请再次输入登陆密码</div>
						<div class="ui-check"><i class="error"></i>两次输入的密码不一致</div>
                    </li>
                    <li class="ui-btn"><input id="J-button-step1" class="btn" type="submit" value="确定"></li>
                </ul>
            </div>
            </form>

            			
			</div>

    </div>
    
    ﻿</body>
<div class="footer footer-bottom">
		<div class="g_33 text-center">
			<span>&copy;2003-2014 如意彩 All Rights Reserved</span>
		</div>
		<div class="g_33" style="display:none;">
		<!-- <center>运行时间:0.08766818</center> -->
		</div>
	</div>
</html>    



<script>
(function($){
    var footer = $('#footer');
    footer.css('position','fixed');
    if($(document).height()>$(window).height()){
        footer.css('position','static');
    }
	
})(jQuery);
</script>


</body>
</html>