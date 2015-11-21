<?php
session_start();
error_reporting(0);
require_once 'conn.php';

$name = trim($_POST['username']);
$pwd2 = trim($_POST['loginpass_source']);
$pwd1 = trim($_POST['loginpass_first']);

if ($name == "" || $pwd1 == "" || $pwd2 == "") {
	echo "<script language=javascript>window.location='findpwd.php';</script>";
	exit;
}
if ($pwd1 != $pwd2) {
	echo "<script language=javascript>alert('两次输入的密码不一致，请重新确认');window.location='findpwd.php';</script>";
	exit;
}

if(strlen($pwd1)<6 || strlen($pwd1)>16 || preg_match('/(.+)\\1{2}/',$pwd1)){
	echo "<script>alert('密码不符合规则');window.location.href='findpwd.php';</script>"; 
	exit;
}

$sql = "select * from ssc_member WHERE username='" . $name . "'";
$query = mysql_query($sql);
$dduser = mysql_fetch_array($query);

if(empty($dduser)){
	echo "<script>alert('帐号和资金密码验证失败');window.location='findpwd.php';</script>"; 
	exit;
}else{
	$pwd = $dduser['password'];
	$pwd3= $dduser['cwpwd'];
	
	$pwd1= md5($pwd1);
	if($pwd1 == $pwd3){
		echo "<script language=javascript>alert('登陆密码不能和资金密码一样!');window.location='findpwd.php';</script>";
		exit;	
	}
	if($pwd == $pwd1){
		echo "<script language=javascript>alert('登陆密码修改失败，新密码可能和原来密码一样');window.location='findpwd.php';</script>";
		exit;
	}else{
		$exe = mysql_query( "update ssc_member set password = '".$pwd1."' where username='".$name."'");

		require_once 'ip.php';
		$ip1 = get_ip();
		$iplocation = new iplocate();
		$address=$iplocation->getaddress($ip1);
		$iparea = $address['area1'].$address['area2'];

//		$ip1=$_SERVER['REMOTE_ADDR'];
//		$ip2=explode(".",$ip1);
//		if(count($ip2)==4){
//			$ip3=$ip2[0]*256*256*256+$ip2[1]*256*256+$ip2[2]*256+$ip2[3];
			
//			$sql = "select * from ssc_ipdata WHERE StartIP<=".$ip3." and EndIP>=".$ip3."";
//			$quip = mysql_query($sql) or  die("数据库修改出错");
//			$dip = mysql_fetch_array($quip);
//			$iparea = $dip['Country']." ".$dip['Local'];
//		}
		$exe = mysql_query( "insert into ssc_memberamend set username = '".$name."',uid = '".$dduser['id']."',nickname = '".$dduser['nickname']."', cont='修改登陆密码', ip='".$ip1."', area='".$iparea."', adddate='".date("Y-m-d H:i:s")."', level='".$dduser['level']."'");
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
            <li ><i class="step-num-3">3</i>重置密码</li>
            <li class="current"><i class="step-num-4">4</i>完成</li>
        </ul>
    </div>
    <!-- step-num end -->
    
    <div class="g_33">
			<div class="find-select-content">
                                <div class="content">
                        <div class="alert alert-success" style="text-align:left;padding-left:50px;">
                            <i></i>
                            <div class="txt">
                                <h4>恭喜您，密码重置成功！</h4>
                                <p><a class="btn" href="/">立即登录<b class="btn-inner"></b></a></p>
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
		<!-- <center>运行时间:0.09502196</center> -->
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