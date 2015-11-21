<?php
header("Content-type: text/html;charset=utf-8");

error_reporting(E_ERROR | E_PARSE);	//开发时注释掉，正式运营时，开启
//@ini_set("display_errors", "Off");

header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Pragma: no-cache");

include 'config.php';
include 'function.php';
include 'appfun.php';

//---检测传递过来的当前时间：必须60秒内方为有效操作，超过60秒，视为搜索引擎抓取的数据，全部无效
//设置当前为东八区（北京时间）
date_default_timezone_set('Etc/GMT-8');
//修正两服务器时间差，单位：秒。若对方服务器比本服务器快，则get time要+上时间差；反之则减去时间差。
$ad_time = 0;
//获取服务器时间
$server_time = $_SERVER['REQUEST_TIME'];
//获取传过来的时间
$time = $_GET['time'];
if($time == '')
{
	alerttips('抱歉，时间戳不能为空！',false,true);
}
$action_time = strtotime($time);
//计算时间差，单位为：秒
$spTime = $server_time - $action_time + $ad_time;
//判断
if ($spTime > 60) {
	alerttips('抱歉，时间戳错误！',false,true);
}

//---会员帐号
$username = trim($_GET['username']);
if($username == '')
{
	alerttips('抱歉，用户名不能为空！',false,true);
}

//---检测加密信息是否有效，有效方才允许操作
$sign = $_GET['sign'];
if($sign == '')
{
	alerttips('抱歉，签名不能为空！',false,true);
}
//签名=md5(加密key+用户名+时间戳)
$chkSign = md5($KEY . $username . $time);
if($sign != $chkSign)
{
	//alerttips('抱歉，签名错误！' . $username . $time,false,true);
	alerttips('抱歉，签名错误！',false,true);
}

//建立数据库连接
require_once 'mysql.php';
$db = new dbmysql();
$db->dbconn($con_db_host,$con_db_id,$con_db_pass,$con_db_name);

//---都验证通过了，这里可以操作相应的动作
//操作类型
$action = strtolower($_GET['action']);
switch($action)
{
	case "reg":
		reg_($username,$_GET['password'],$_GET['nickname'],true);
		break;
	case "login":
		login_();
		break;
	case "testlogin":
		testlogin_();
		break;
	case "logout":
		logout_();
		break;
	case "changepwd":
		changepwd_();
		break;
	case "changepwd2":
		changepwd2_();
		break;
	case "getgold_money":
		getgold_money_();
		break;
	case "changegold_money":
		changegold_money_();
		break;
	case "getmember_gold":
		getmember_gold_();
		break;
}

function getmember_gold_()
{
	global $db;
	global $username;
	
    $cb = $_GET['cb'];

	if ($cb)
	{
		echo $cb;
		echo '(';
	}
	
	echo '{';

	//查询
	$leftmoney = 0;
	$rs = $db->get_one("select * from `ssc_member` where username='" . $username . "'");
	if ($rs)
	{
		$leftmoney = (int)$rs['leftmoney'];
	}

	echo '"money":"' . $leftmoney . '"';

	echo '}';
	
	if ($cb)
	{
		echo ')';
	}
}

//---修改虚拟币
function changegold_money_()
{
	global $db;
	global $username;
	
	//值
	$num = (int)$_GET['num'];
	if($num == 0)
	{
		alerttips('抱歉，增减值不能为0！',false,true);
	}

	//查询
	$sql = "select * from ssc_member WHERE username='" . $username . "'";
	$rs = $db->get_one($sql);
	if(!$rs){alerttips('抱歉，会员帐号不存在',false,true);}
	
	//增或减
	$leftmoney = (float)$rs['leftmoney'];
	$overmoney = $leftmoney + $num;
	if($overmoney < 0)
	{
		alerttips('抱歉，转账后余额将为负数，操作失败！',false,true);
	}
	
	//更新
	$sql = "update ssc_member set leftmoney = leftmoney + (" . $num . ") WHERE username='" . $username . "'";
	$db->query($sql);
	
	//账变
	if($num > 0)
	{
		$sqlfield = 'smoney';
	}
	else
	{
		$sqlfield = 'zmoney';
	}
	
	$sql = "select * from ssc_record order by id desc limit 1";
	$rs1 = $db->get_one($sql);
	$dan = sprintf("%07s",strtoupper(base_convert($rs1['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));
	$sql="insert into ssc_record set dan='" . $dan . "',tag = '网站间转账', uid='".$rs['id']."', username='".$rs['username']."', types='999', " . $sqlfield . "=".abs($num).",leftmoney=".$overmoney.", regtop='".$rs['regtop']."', regup='".$rs['regup']."', regfrom='".$rs['regfrom']."', adddate='".date("Y-m-d H:i:s")."',virtual='" .$rs['virtual']. "'";
	$db->query($sql);

	alerttips('转账成功',true,true);
}



//---查询虚拟币：余额
function getgold_money_()
{
	global $db;
	global $username;

	//查询
	$rs = $db->get_one("select * from `ssc_member` where username='" . $username . "'");
	if ($rs)
	{
		alerttips($rs['leftmoney'],true,true);
	}
	else
	{
		alerttips('抱歉，会员帐号不存在，查询失败！',false,true);
	}
}

function changepwd2_()
{
	global $db;
	global $username;
	
	$password = $_GET['password'];
	$newpassword = $_GET['newpassword'];

	if($username == ''){alerttips('用户名不可为空',false,true);}
	//if($password == ''){alerttips('旧密码不可为空',false,true);}
	if($newpassword == ''){alerttips('新密码不可为空',false,true);}
	
	//密码md5
	$password_md5 = md5($password);
	
	//查询
	$sql = "select * from ssc_member WHERE username='" . $username . "'";
	$rs = $db->get_one($sql);
	if(!$rs){alerttips('抱歉，会员帐号不存在',false,true);}
	
	//判断旧密码
	//if($password_md5 != $rs['password']){alerttips('抱歉，旧密码错误',false,true);}
	
	//更新密码
	$sql = "update ssc_member set cwpwd = '" . md5($newpassword) . "' WHERE username='" . $username . "'";
	$rs = $db->query($sql);
	
	//修改成功
	alerttips('修改成功！',true,true);
}

//---修改密码
function changepwd_()
{
	global $db;
	global $username;
	
	$password = $_GET['password'];
	$newpassword = $_GET['newpassword'];

	if($username == ''){alerttips('用户名不可为空',false,true);}
	//if($password == ''){alerttips('旧密码不可为空',false,true);}
	if($newpassword == ''){alerttips('新密码不可为空',false,true);}
	
	//密码md5
	$password_md5 = md5($password);
	
	//查询
	$sql = "select * from ssc_member WHERE username='" . $username . "'";
	$rs = $db->get_one($sql);
	if(!$rs){alerttips('抱歉，会员帐号不存在',false,true);}
	
	//判断旧密码
	//if($password_md5 != $rs['password']){alerttips('抱歉，旧密码错误',false,true);}
	
	//更新密码
	$sql = "update ssc_member set password = '" . md5($newpassword) . "' WHERE username='" . $username . "'";
	$rs = $db->query($sql);
	
	//修改成功
	alerttips('修改成功！',true,true);
}


//---退出
//NET站先完成退出，然后跳到同步退出页，同步退出页中嵌入一个iframe，实现退出。退出后，iframe会自动实现跳转
function logout_()
{
	global $db;
	global $username;

	session_start();
	if(!$_SESSION['username'])
	{
		jstips('已经退出过了',false,true);
		return;
	}

	$db->query( "delete from ssc_online where username='" . $_SESSION['username'] . "'");
	if($username != '' && $username != $_SESSION['username'])
	{
		$db->query( "delete from ssc_online where username='" . $username . "'");
	}
	
	unset($_SESSION['username']);
	unset($_SESSION['uid']);
	unset($_SESSION['valid']);
	unset($_SESSION["pwd"]);
	
	//退出成功
	jstips('成功退出',true,true);
}

//---测试登录
//NET站登录时，如果本机密码正确、远程测试登录失败，则更新远程为本机密码；
//反之则更新本机密码为新密码；
//如果都失败，则提示密码错误
function testlogin_()
{
	global $db;
	global $username;
	
	$password = $_GET['password'];

	if($username == ''){alerttips('用户名不可为空',false,true);}
	if($password == ''){alerttips('密码不可为空',false,true);}
	
	$sql = "select * from ssc_member WHERE username='" . $username . "'";
	$rs = $db->get_one($sql);

	//$password2 = md5($rs['password']."e354fd90b2d5c777bfec87a352a18976");
	//if($password == $password2){
	$password = md5($password);
	if($password == $rs['password']){
		alerttips('测试正确',true,true);
	}
	else{
		alerttips('登陆失败，请检查您的帐户名与密码',false,true);
	}
}

//---登录
//NET站先完成登录，然后跳到同步登录页，同步登录页中嵌入一个iframe，实现登录。登录后，iframe会自动实现跳转
function login_()
{
	global $db;
	global $username;

	//这个是md5后的
	$password = $_GET['password'];

	session_start();
	//error_reporting(0);
	
	//如果已经登录，并且用户名一致，则不再登录
	if($_SESSION["username"] == $username)
	{
		if($_SESSION["pwd"] == strtolower($password))
		{
			jstips('已登录过',false,true);
			return;
		}
		else if (strlen($password) == 32)
		{
			$password = strtolower($password);

			//更新了密码
			$sql = "update ssc_member set password = '" . $password . "' WHERE username='" . $username . "'";
			$db->query($sql);

			$_SESSION["pwd"] = $password;

			jstips('更新了密码',false,true);
			return;
		}
	}

	if($username == ''){jstips('用户名不可为空',false,true);}
	//if($password == ''){alerttips('密码不可为空',false,true);}
	
	$sql = "select * from ssc_online where username='" . $username . "'";
	$rs = $db->get_one($sql);
	if($rs){jstips('该用户已在别处登录，请勿重复登陆，如有需要联系客服',false,true);}
	unset($rs);
	
	$sql = "select * from ssc_member WHERE username='" . $username . "'";
	$rs = $db->get_one($sql);
	if(!$rs){
		//直接注册
		if (strlen($password) == 32)
		{
			$password = strtolower($password);

			reg_($username,$password,FStrLeft($username,8),false);

			$sql = "select * from ssc_member WHERE username='" . $username . "'";
			$rs = $db->get_one($sql);
		}
		else
		{
			jstips('未找到该会员',false,true);
		}
	}
	if(!$rs){
		jstips('未找到该会员资料',false,true);
	}

	//$password2 = md5($rs['password']."e354fd90b2d5c777bfec87a352a18976");
	//if($password == $password2){
	//$password = md5($password);
	//if($password == $rs['password']){
		if($rs['zt']==2){jstips('您的帐户被锁定',false,true);}
		
		//退出当前session
		if($_SESSION["username"] != '')
		{
			$db->query("delete from ssc_online where username='" . $_SESSION['username'] . "'");
		}

		$_SESSION["uid"] = $rs['id']; 
		$_SESSION["username"] = $username; 
		$_SESSION["level"] = $rs['level'];
		$_SESSION["valid"] = mt_rand(100000,999999);
		$_SESSION["pwd"] = $rs['password'];

		require_once '../ip.php';
		$ip1 = get_ip();
		$iplocation = new iplocate();
		$address=$iplocation->getaddress($ip1);
		$iparea = $address['area1'].$address['area2'];

		$db->query("update ssc_member set lognums=lognums+1, lastip='".$ip1."', lastarea='".$iparea."', lastdate='".date("Y-m-d H:i:s")."' where username='".$username."'");
		$db->query("insert into ssc_memberlogin set uid='".$rs['id']."', username='".$username."', nickname='".$rs['nickname']."', loginip='".$ip1."', loginarea='".$iparea."', explorer='".$_SERVER['HTTP_USER_AGENT']."', logindate='".date("Y-m-d H:i:s")."', level='".$rs['level']."'");
		$db->query( "delete from ssc_online where username='".$username."'");
		$db->query("delete from ssc_online where username='".$username."'");
		$db->query("insert into ssc_online set uid='".$rs['id']."', username='".$username."', nickname='".$rs['nickname']."', ip='".$ip1."', addr='".$iparea."', adddate='".date("Y-m-d H:i:s")."', updatedate='".date("Y-m-d H:i:s")."', valid='".$_SESSION["valid"]."', level='".$rs['level']."'");
		$sql = "select * from ssc_total WHERE logdate='" . date("Y-m-d") . "'";
		$rs1 = $db->get_one($sql);
		if(!$rs1){
			$db->query("insert into ssc_total set nums".$rs['level']."=nums".$rs['level']."+1, logdate='" . date("Y-m-d") . "'");
		}else{
			$db->query("update ssc_total set nums".$rs['level']."=nums".$rs['level']."+1 where logdate='" . date("Y-m-d") . "'");
		}
		
		jstips('登录成功',true,true);
	//}
	//else{
	//	alerttips('登陆失败，请检查您的帐户名与密码',false,true);
	//}
}

//---注册
//NET站的会员要注册，必须先注册此PHP站会员，此站注册成功后，返回成功提示以通知NET站
//如果此PHP站注册失败，提示失败信息，NET站不可以直接注册，应当直接提示本错误信息，终止注册
function reg_($username,$password,$nickname,$write)
{
	global $db;
	//global $username;
	
	//$password = $_GET['password'];
	//$nickname = $_GET['nickname'];
	//密码是md5后的
	$usertype = 0;//$_GET['usertype'];// 1代理用户 0会员用户 2总代理
	$flevel = 0;//返点
	$zc = 0;//占成
	$banks = '0';//充值银行卡套餐
	$pe = '0;0;0;0';//用户配额
	$virtual = '';//虚拟用户

	if($username == ''){alerttips('用户名不可为空',false,$write);}
	if($password == ''){alerttips('密码不可为空',false,$write);}
	if(strpos($username," ") || strpos($username,"'") || strpos($username,"_")){alerttips('用户名不可以含特殊字符',false,$write);}
	if(preg_match("/[\x7f-\xff]/", $username)) {alerttips('用户名不可以含中文字符',false,$write);}

	$sql = "SELECT * FROM ssc_member where username='".$username."'";
	$rs = $db->get_one($sql);
	if($rs){alerttips('该用户名已存在，请重新输入',false,$write);}

	$sql = "insert into ssc_member set username='" . $username . "'";
	//$sql .= ", password='" . md5($password) . "'";
	$sql .= ", password='" . strtolower($password) . "'";
	$sql .= ", nickname='" . $nickname . "'";
	$sql .= ", regfrom='', regup='', regtop=''";
	$sql .= ", flevel='" . $flevel . "'";
	$sql .= ", zc='" . $zc . "'";
	$sql .= ", pe='" . $pe . "'";
	$sql .= ", banks='" . $banks . "'";
	$sql .= ", virtual='" . $virtual . "'";
	$sql .= ", level='" . $usertype . "'";
	$sql .= ", regdate='" . date("Y-m-d H:i:s") . "'";
	
	$db->query($sql);
	
	alerttips('注册成功',true,$write);
}

function alerttips($tips,$success,$write)
{
	if($write == true)
	{
		if($success)
			echo 'SUCCESS';
		else
			echo 'FAIL';
			
		echo '|';
		
		echo $tips;
	}
	exit();
}

function jstips($tips,$success,$write)
{
	if($write == true)
	{
		echo '//';
	}
	alerttips($tips,$success,$write);
	exit();
}
?>