<?php
	//header("Content-Type:text/html;charset=gb2312");
	include 'php.config';
	include 'MobaoPay.class.php';
require_once 'conn.php';


	// 请求数据赋值
	$data = "";
	$data['apiName']=$_REQUEST["apiName"];
	$data['notifyTime']=$_REQUEST["notifyTime"];
	$data['tradeAmt']=$_REQUEST["tradeAmt"];//金额
	$data['merchNo']=$_REQUEST["merchNo"];//商户号
	$data['merchParam']=$_REQUEST["merchParam"];//商户参数
	$data['orderNo']=$_REQUEST["orderNo"];//订单号
	$data['tradeDate']=$_REQUEST["tradeDate"];
	$data['accNo']=$_REQUEST["accNo"];	
	$data['accDate']=$_REQUEST["accDate"];
	$data['orderStatus']=$_REQUEST["orderStatus"];
	$data['signMsg']=$_REQUEST["signMsg"];


	// 验证签名
	$cMbPay = new MbPay($pfxFile, $pubFile, $pfxpasswd);
	
	$str_to_sign = $cMbPay->prepareSign($data);
	if ($cMbPay->verify($str_to_sign, $data['signMsg']) ) 
	{
		if ($data['orderStatus'] == "1"){
			$ipsbillno=$_REQUEST["accNo"];
			$cmoney=floatval($_REQUEST["tradeAmt"]);
			$uid=str_replace("t1000","",$_REQUEST["merchParam"]);
			$sqla="select * from ssc_member where id= '".$uid."'";
			$rsa = mysql_query($sqla);
			$rowa = mysql_fetch_array($rsa);
			$username=$rowa['username'];
			$leftmoney=$rowa['leftmoney'];
			$lmoney=$leftmoney+$cmoney;
			
			$sqld="select * from ssc_savelist where username= '".$username."' and dan= '".$ipsbillno."' and zt='1' limit 1";
			$queryd = mysql_query($sqld);
			$rsd = mysql_fetch_array($queryd);
			if(empty($rsd)){
				$dan1 = Grecord();
				$sqla="insert into ssc_record set dan='".$dan1."', uid='".$uid."', username='".$username."', types='1', smoney=".$cmoney.",leftmoney=".$lmoney.", regtop='".$rowa['regtop']."', regup='".$rowa['regup']."', regfrom='".$rowa['regfrom']."',virtual='" .$rowa['virtual']. "', tag='魔宝支付',adddate='" .date("Y-m-d H:i:s"). "'";
				$exe=mysql_query($sqla) or  die("数据库修改出错6a!!!");

//				if(Get_ccdate($username,$ccdate)==0){
//					$sqla="insert into ssc_membert set username='".$username."', cmoney=".$cmoney.", regtop='".$rowa['regtop']."', regup='".$rowa['regup']."', regfrom='".$rowa['regfrom']."', ccdate='".$ccdate."'";
//				}else{
//					$sqla="update ssc_membert set cmoney=cmoney+".$cmoney." where username='".$username."' and ccdate='".$ccdate."' limit 1";
//				}
//				echo $sqla;
//				$exe=mysql_query($sqla) or  die("数据库修改出错6b!!!");
				
				$sqlb="insert into ssc_savelist set uid='".$uid."', username='".$username."', bank='魔宝支付', dan='".$ipsbillno."', bankid='0', cardno='', money=".$cmoney.", sxmoney='0', rmoney=".$cmoney.",zt='1',types='2', tag='',adddate='" .date("Y-m-d H:i:s"). "'";
				$exe=mysql_query($sqlb) or  die("数据库修改出错6c!!!");

				$sql="update ssc_member set leftmoney ='".$lmoney."',totalmoney=totalmoney+ '".$cmoney."' where id ='".$uid."'";
				if (!mysql_query($sql)){
					die('Error: ' );
				}		
			}
?>
<?php
session_start();
error_reporting(0);
require_once 'conn.php';
//require_once 'check.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=utf-8" />
<TITLE>系统消息</TITLE>
<link href="../css/v1/all.css?modidate=20130201001" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="rightcon">
<div class="rc_con system">
    <div class="rc_con_lt"></div>
    <div class="rc_con_rt"></div>
    <div class="rc_con_lb"></div>
    <div class="rc_con_rb"></div>
    <h5><div class="rc_con_title">系统提示</div></h5>
    <div class="rc_con_to">
        <div class="rc_con_ti">
                            <div class="system_title_y""><span></span>充值成功</div>
                        <div class="sy_txt">
                <div class="s_tit">您成功充值<?=$cmoney?>元，祝您游戏愉快！</div>
                <ul>
                <li><a href="javascript:window.close()">关闭本窗口</a></li>
                </ul>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
<div class="clear"></div>
<div class="rc_con">
    <div class="rc_con_lt"></div>
    <div class="rc_con_rt"></div>
    <div class="rc_con_lb"></div>
    <div class="rc_con_rb"></div>
    <div class="rc_con_to">
    	<table width=100% border="0" cellspacing="0" cellpadding="0">
            <tr><td height="25" align="center">浏览器建议：首选IE 8.0,Chrome浏览器，其次为火狐浏览器,尽量不要使用IE6。</td></tr>
            <tr><td height="25" align="center">资金安全建议：为了您的资金安全请定期更换资金密码。</td></tr>
        </table>
    </div>
</div>

</div>
<div class="clear"></div>
</div>
</BODY>
</HTML>
<?			
			}
		else
			echo "pay error";
		return true;
	}
	else
	{
		print_r("verify error");
		return false;
	}
?>