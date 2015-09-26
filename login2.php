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
$pwd = trim($_POST['loginpass']);
$vcode = trim($_POST['validcode_source']);

if ($name == "" || $pwd == "") {
	echo "<script language=javascript>window.location='./';</script>";
	exit;
}

if ($vcode != $_SESSION['valicode']) {
	echo "<script language=javascript>alert('验证码不正确，请重新输入');window.location='./';</script>";
	exit;
}

$sqlu = "select * from ssc_online where username='".$name."'";
$rsu = mysql_query( $sqlu );
$numRows = mysql_num_rows( $rsu );
if ($numRows != 0) {
	$sqlux = "delete * from ssc_online where username='".$name."'";
	$rsux = mysql_query( $sqlux );
}

$sql = "select * from ssc_member WHERE username='" . $name . "'";
$query = mysql_query($sql);
$dduser = mysql_fetch_array($query);

if(empty($dduser)){
	echo "<script>window.location='".$gourl."';</script>"; 
	exit;
}else{
	$pwd2 = md5($dduser['password']."e354fd90b2d5c777bfec87a352a18976");
	$uid = $dduser['id'];
//	$pwd= md5(md5($pwd)."e354fd90b2d5c777bfec87a352a18976");
	if($pwd == $pwd2){
		if($dduser['zt']==2){
			echo "<script language=javascript>alert('您的帐户被锁定！');window.location='./';</script>";
			exit;
		}
		$_SESSION["uid"] = $uid; 
		$_SESSION["username"] = $name; 
		$_SESSION["level"] = $dduser['level'];
		$_SESSION["valid"] = mt_rand(100000,999999);
		session_set_cookie_params(3600); 

		require_once 'ip.php';
//		$ip1 = $_SERVER['REMOTE_ADDR'];
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
		$exe = mysql_query("update ssc_member set lognums=lognums+1, lastip='".$ip1."', lastarea='".$iparea."', lastdate='".date("Y-m-d H:i:s")."' where username='".$name."'");
		$exe = mysql_query("insert into ssc_memberlogin set uid='".$dduser['id']."', username='".$name."', nickname='".$dduser['nickname']."', loginip='".$ip1."', loginarea='".$iparea."', explorer='".$_SERVER['HTTP_USER_AGENT']."', logindate='".date("Y-m-d H:i:s")."', level='".$dduser['level']."'");
		$exe = mysql_query( "delete from ssc_online where username='".$name."'");
		$exe=mysql_query("delete from ssc_online where username='".$name."'") or  die("数据库修改出错");
//		$exe=mysql_query("insert into ssc_online set uid='".$dduser['id']."', username='".$name."', nickname='".$dduser['nickname']."', ip='".$ip1."', explorer='".$_SERVER['HTTP_USER_AGENT']."', addr='".$iparea."', adddate='".date("Y-m-d H:i:s")."', updatedate='".date("Y-m-d H:i:s")."', valid='".$_SESSION["valid"]."', level='".$dduser['level']."'") or  die("数据库修改出错");
		$exe=mysql_query("insert into ssc_online set uid='".$dduser['id']."', username='".$name."', nickname='".$dduser['nickname']."', ip='".$ip1."', addr='".$iparea."', adddate='".date("Y-m-d H:i:s")."', updatedate='".date("Y-m-d H:i:s")."', valid='".$_SESSION["valid"]."', level='".$dduser['level']."'") or  die("数据库修改出错");
		$sqla = "select * from ssc_total WHERE logdate='" . date("Y-m-d") . "'";
		$rsa = mysql_query($sqla);
		$rowa = mysql_fetch_array($rsa);
		if(empty($rowa)){
			$exe=mysql_query("insert into ssc_total set nums".$dduser['level']."=nums".$dduser['level']."+1, logdate='" . date("Y-m-d") . "'") or  die("数据库修改出错");
		}else{
			$exe=mysql_query("update ssc_total set nums".$dduser['level']."=nums".$dduser['level']."+1 where logdate='" . date("Y-m-d") . "'") or  die("数据库修改出错");
		}
		
		echo "<script language=javascript>window.location='default_frame.php';</script>";
		exit;
	}else{
		echo "<script language=javascript>alert('登陆失败，请检查您的帐户名与密码');window.location='./';</script>";
		exit;
	}
}
?>