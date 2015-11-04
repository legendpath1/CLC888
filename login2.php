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

$sql = "select * from ssc_member WHERE username='" . $name . "'";
$query = mysql_query($sql);
$dduser = mysql_fetch_array($query);

//api接口
if($SOPEN == 1)
{
	if(empty($dduser)){
		//未找到该会员，那么：远程获取会员数据
		//如果存在，则注册，并再次登录
		//如果不存在，往后执行代码
		$arr = SAPI_GetMemberInfo($name);
		if($arr['username'] != '' && $arr['password'] != '')
		{
			//妫€娴嬬敤鎴峰悕
			$sapi_canReg = 1;
			if($arr['username'] == ''){$sapi_canReg = 0;}
			if($arr['password'] == ''){$sapi_canReg = 0;}
			if(strpos($arr['username']," ") || strpos($arr['username'],"'") || strpos($arr['username'],"_")){$sapi_canReg = 0;}
			if(preg_match("/[\x7f-\xff]/", $arr['username'])) {$sapi_canReg = 0;}
		
			if($sapi_canReg == 1)
			{
				$sql = "insert into ssc_member set username='" . $arr['username'] . "'";
				//$sql .= ", password='" . md5($password) . "'";
				$sql .= ", password='" . strtolower($arr['password']) . "'";
				$sql .= ", nickname='" . FStrLeft($arr['username'],8) . "'";
				$sql .= ", regfrom='', regup='', regtop=''";
				$sql .= ", flevel='0'";
				$sql .= ", zc='0'";
				$sql .= ", pe='0;0;0;0'";
				$sql .= ", banks='0'";
				$sql .= ", virtual=''";
				$sql .= ", level='0'";
				$sql .= ", regdate='" . date("Y-m-d H:i:s") . "'";
				
				mysql_query($sql);
				
				unset($query);
				unset($dduser);
				$sql = "select * from ssc_member WHERE username='" . $name . "'";
				$query = mysql_query($sql);
				$dduser = mysql_fetch_array($query);
			}
		}
	}
	else
	{
		//net站若改了密码，这里要同步更新
		$arr = SAPI_GetMemberInfo($name);
		if($arr['username'] != '' && $arr['password'] != '')
		{
			if(strtolower($arr['password']) != $dduser['password'] && strlen($arr['password']) == 32)
			{
				$sql = "update ssc_member set password='" . strtolower($arr['password']) . "' where username='" . $arr['username'] . "'";
				mysql_query($sql);
				
				unset($query);
				unset($dduser);
				$sql = "select * from ssc_member WHERE username='" . $name . "'";
				$query = mysql_query($sql);
				$dduser = mysql_fetch_array($query);
			}
		}
	}
}

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
		$_SESSION["pwd"] = $dduser['password'];
		session_set_cookie_params(900);

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
	
		// If it's first login since 2am today, then refresh counts for activities
		$cutofftime = strtotime('today +2hour');
		if (time() < cutofftime) {
			$cutofftime = strtotime('yesterday +2hour');
		}
		if (strtotime($dduser['lastdate']) < $cutofftime && time() > $cutofftime) {
			$activity1 = floor($dduser['tempmoney'] / 1888);
			$exe = mysql_query("update ssc_member set tempmoney=0, activity1=activity+".$activity1." where id='".$uid."'");
		}
		
		$sqlu = "select * from ssc_online where username='".$name."'";
		$rsu = mysql_query( $sqlu );
		$rowu = mysql_fetch_array($rsu);
		$session_file = session_save_path()."\sess_".$rowu['session_id'];
		unlink($session_file);
		$exe = mysql_query( "delete * from ssc_online where username='".$name."'" );

		$exe = mysql_query("update ssc_member set lognums=lognums+1, lastip='".$ip1."', lastarea='".$iparea."', lastdate='".date("Y-m-d H:i:s")."' where username='".$name."'");
		$exe = mysql_query("insert into ssc_memberlogin set uid='".$dduser['id']."', username='".$name."', nickname='".$dduser['nickname']."', loginip='".$ip1."', loginarea='".$iparea."', explorer='".$_SERVER['HTTP_USER_AGENT']."', logindate='".date("Y-m-d H:i:s")."', level='".$dduser['level']."'");
		$exe = mysql_query("insert into ssc_online set uid='".$dduser['id']."', session_id='".session_id()."', username='".$name."', nickname='".$dduser['nickname']."', ip='".$ip1."', addr='".$iparea."', adddate='".date("Y-m-d H:i:s")."', updatedate='".date("Y-m-d H:i:s")."', valid='".$_SESSION["valid"]."', level='".$dduser['level']."'") or  die("数据库修改出错");
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