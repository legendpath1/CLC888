<?
session_start();
error_reporting(0);
require_once 'conn.php';

$name = trim($_POST['username']);
$vcode = trim($_POST['validcode']);
if ($name == "") {
	echo "<script language=javascript>window.location='findpwd.php';</script>";
	exit;
}

if ($vcode != md5($_SESSION['valicode'])) {
	echo "<script language=javascript>alert('验证码不正确，请重新输入');window.location='findpwd.php';</script>";
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
                var typepw = $("#loginpass_source").val();
                $("#loginpass_source")[0].value = '12345678901234567890';
                if  (typepw == '') {
                    alert('请填写资金密码');
                    return false;
                }
                var submitpw = $.md5(typepw);
                $("#loginpass")[0].value = submitpw;
                document.forms['login'].submit();     
            }

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
            <li class="current"><i class="step-num-2">2</i>选择找回密码方式</li>
            <li ><i class="step-num-3">3</i>重置密码</li>
            <li ><i class="step-num-4">4</i>完成</li>
        </ul>
    </div>
    <!-- step-num end -->
    
    <div class="g_33">
			<div class="find-select-content">
                        <strong class="highbig">您正在找回登录密码的账号是：<span class="highlight"><?=$name?></span>，请输入安全密码找回登录密码：</strong>
			<?php 	if($pwd2==""){?>
            <ul class="find-select-list">
                    <li class="disable">
                        <i class="ico-safecode"></i>
                        <p>通过安全密码找回登录密码</p>
                        <span>(未绑定，不可用)</span>
                    </li>
			</ul>
			<?php }else{?>
            <form action="findpwd3.php?stp=0" method="post" name="login" id="login" onSubmit="javascript:LoginNow(); return false;">
			<input type="hidden" name="username" id="username" value="<?=$name?>">
			<input type="hidden" name="loginpass" id="loginpass">
            <ul class="ui-form">
                <li>
                    <label for="name" class="ui-label">资金密码：</label>
                    <input type="password" value="" id="loginpass_source" name="loginpass_source"  class="input">
					<span class="ui-check-right"></span>
                    <div class="ui-check"></div>
                </li>
                <li class="ui-btn"><input id="J-button-step1" class="btn" type="submit" value="下一步"></li>
            </ul>
			</form>
			<?php }?>
                            </ul>
            <p>上面的方式不可用？您还可以通过<a title="客服" target="_blank" href="http://www2.53kf.com/webCompany.php?arg=10056146&style=1" />在线客服</a>进行人工申诉找回登录密码。</p>
            
            <div class="pop w-7" style="position: fixed; left: 50%; z-index: 1001; top: 50%; margin-top: -77.5px; margin-left: -186px; display: none;" id="divNoType">
	<div class="hd"><i class="close" name="divCloseUrl"></i>提示</div>
	<div class="bd">
		<h4 class="pop-title">安全问题连续三次错误，请30分钟后再试</h4>
		<div class="pop-btn">
			<a href="javascript:void(0);" class="btn btn-important " name="J-but-close">确 定<b class="btn-inner"></b></a>
		</div>
	</div>
</div>
			
            			
			</div>

    </div>
    
    ﻿</body>
<div class="footer footer-bottom">
		<div class="g_33 text-center">
			<span>&copy;2003-2014 如意彩 All Rights Reserved</span>
		</div>
		<div class="g_33" style="display:none;">
		<!-- <center>运行时间:0.10261893</center> -->
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