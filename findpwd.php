
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
            <li class="current"><i class="step-num-1">1</i>输入用户名</li>
            <li ><i class="step-num-2">2</i>选择找回密码方式</li>
            <li ><i class="step-num-3">3</i>重置密码</li>
            <li ><i class="step-num-4">4</i>完成</li>
        </ul>
    </div>
    <!-- step-num end -->
    
    <div class="g_33">
			<div class="find-select-content">
            <form action="findpwd2.php?stp=0" method="post" name="login" id="login" onSubmit="javascript:LoginNow(); return false;">
			<input type="hidden" name="validcode" id="validcode">
            <ul class="ui-form">
                <li>
                    <label for="name" class="ui-label">用户名：</label>
                    <input type="text" value="" id="username" name="username"  class="input">
					<span class="ui-check-right"></span>
                    <div class="ui-check"></div>
                </li>
                <li>
                    <label for="pwd" class="ui-label">验证码：</label>
                    <input type="text" name="validcode_source" value="" maxlength="4" id="validcode_source" class="input w-3">
                    <img id="validate" class="verify-code" src="ValiCode_New.php" alt="验证码"  style="cursor:pointer; border: 1px solid #999" onClick="refreshimg()" />
                    <div class="ui-check"><i class="error"></i>请输入验证码</div>
					<span class="ui-check-right"></span>
                </li>
                <li class="ui-btn"><input id="J-button-step1" class="btn" type="submit" value="下一步"></li>
            </ul>
			</form>

            			
			</div>

    </div>
    
    ﻿</body>
<div class="footer footer-bottom">
		<div class="g_33 text-center">
			<span>&copy;2003-2014 如意彩 All Rights Reserved</span>
		</div>
		<div class="g_33" style="display:none;">
		<!-- <center>运行时间:0.09859490</center> -->
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