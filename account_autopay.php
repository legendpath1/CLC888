<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

if(Get_member(virtual)==1){
	$_SESSION["backtitle"]="虚拟用户，禁止充值。";
	$_SESSION["backurl"]="help_security.php";
	$_SESSION["backzt"]="failed";
	$_SESSION["backname"]="系统公告";
	echo "<script language=javascript>window.location='sysmessage.php';</script>";
	exit;
}

$outOrderId = "";
for($i = 0; $i < 32; $i ++) {
	$outOrderId .= rand ( 0, 9 );
}

$sqla = "SELECT * FROM ssc_banks WHERE tid='" . $_POST['bankinfo'] ."'";
$rsa = mysql_query($sqla);
$rowa = mysql_fetch_array($rsa);

$cmoney=round($_POST["real_money"],2);
if ($cmoney<1) {

}
if ($cmoney>=$rowa['climit']){
	$sxmoney=round(($cmoney*$rowa['crates'])/100,2);
	$rmoney=$cmoney+$sxmoney;
}else{
	$sxmoney=0;
	$rmoney=$cmoney;
}

$sqla="insert into ssc_savelist set dan='".$outOrderId."', uid='".$_SESSION["uid"]."', username='".$_SESSION["username"]."', bank='".$rowa['name']."', bankid='".$rowa['tid']."',  cardno='', money=".$cmoney.", sxmoney=".$sxmoney.", rmoney=".$rmoney.", adddate='".date("Y-m-d H:i:s")."',zt='0',types='1'";
$exe=mysql_query($sqla) or  die("数据库修改出错6!!!");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>中联支付</title>
<meta name="keywords" content="" />
<link href="css/yeepaytest.css" type="text/css" rel="stylesheet" />
<script src="http://lib.sinaapp.com/js/jquery/1.4.2/jquery.min.js"
	type="text/javascript"></script>
</head>

<body>
<?php if ( $_POST['bankinfo'] == 21 ) {?>
<table width="60%" border="0" align="center" cellpadding="0"
	cellspacing="0" style="border: solid 1px #40506b;">
	<tr>
		<td>
		<form method="post" action="ZLP_PHP/payMac.php">
		<table width="100%" border="0" align="center" cellpadding="5"
			cellspacing="1" style="border-spacing: 0;">
			<tr>
				<td><a href="#"><img src="ZLP_PHP/images/logo.png" alt="zlinepay"
					width="150" height="45" border="0" /></a></td>
				<td style="text-align: right;"><span style="color: #868B94;">感谢您使用中联支付平台</span></td>
			</tr>
			<tr>
			</tr>
			<tr>
				<td colspan="2"
					style="color: #fff; font-size: 14px; height: 40px; background: #2C69C1;">中联支付产品通用支付接口演示</td>
			</tr>
			<tr>
				<td>商户订单号</td>
				<td>&nbsp;&nbsp;<?php
				echo ($outOrderId)?></td>
				<td><input type="hidden" name="outOrderId" id="outOrderId"
					value="<?php
					echo ($outOrderId)?>" /></td>
			</tr>
			<tr>
				<td>充值金额（元）</td>
				<td>&nbsp;&nbsp;<?php echo $cmoney?></td>
			</tr>			
			<tr>
				<td>手续费（元）</td>
				<td>&nbsp;&nbsp;<?php echo $sxmoney?></td>

			</tr>			
			<tr>
				<td>总支付金额（元）</td>
				<td>&nbsp;&nbsp;<?php echo $rmoney?></td>
				<td><input type="hidden" name="totalAmount" id="totalAmount"
					value="<?php echo $rmoney*100?>" /></td>
			</tr>
			<tr>
				<td><input type="hidden" name="goodsName" id="goodsName" value="充值" /></td>
			</tr>
			<tr>
				<td><input type="hidden" name="goodsExplain" id="goodsExplain"
					value="彩乐彩充值" /></td>
			</tr>
			<tr>
				<td><input type="hidden" name="merUrl" id="merUrl"
					value="http://www.zgbaicha.cn/jump.php" /></td>
			</tr>
			<tr>
				<td><input type="hidden" name="noticeUrl" id="noticeUrl"
					value="http://www.zgbaicha.cn/extranotice.php" /></td>
			</tr>
			<tr>
				<td><input type="hidden" name="bankCardType" id="bankCardType" value="01" /></td>
			</tr>
			<tr>
				<td style="vertical-align: sub;">支付方式</td>
				<td>
				
					<div style="margin-bottom: 20px;">
					<div class="ra-img"><input type="radio" name="bankCode"
						id="bankCode" value="BOC" /> <img
						src="ZLP_PHP/images/perBank/BOC.gif" /></div>
					<div class="ra-img"><input type="radio" name="bankCode"
						id="bankCode" value="ABC" /> <img
						src="ZLP_PHP/images/perBank/ABC.gif" /></div>
					<div class="ra-img"><input type="radio" name="bankCode"
						id="bankCode" value="ICBC" /> <img
						src="ZLP_PHP/images/perBank/ICBC.gif" /></div>
					<div class="ra-img"><input type="radio" name="bankCode"
						id="bankCode" value="CCB" /> <img
						src="ZLP_PHP/images/perBank/CCB.gif" /></div>
					</div>
				</td>
				<td>
					<div style="margin-bottom: 20px;">
					<div class="ra-img"><input type="radio" name="bankCode"
						id="bankCode" value="BCM" /> <img
						src="ZLP_PHP/images/perBank/BCM.gif" /></div>
					<div class="ra-img"><input type="radio" name="bankCode"
						id="bankCode" value="CMB" /> <img
						src="ZLP_PHP/images/perBank/CMB.gif" /></div>
					<div class="ra-img"><input type="radio" name="bankCode"
						id="bankCode" value="CEB" /> <img
						src="ZLP_PHP/images/perBank/CEB.gif" /></div>
					<div class="ra-img"><input type="radio" name="bankCode"
						id="bankCode" value="SPDB" /> <img
						src="ZLP_PHP/images/perBank/SPDB.gif" /></div>
					</div>
				</td>
			</tr>
			<tr>
				<td style="vertical-align: sub;"></td>
				<td>
					<div style="margin-bottom: 20px;">
					<div class="ra-img"><input type="radio" name="bankCode"
						id="bankCode" value="PAB" /> <img
						src="ZLP_PHP/images/perBank/PAB.gif" style="padding-right: 18px;" /></div>
					<div class="ra-img"><input type="radio" name="bankCode"
						id="bankCode" value="BOS" /> <img
						src="ZLP_PHP/images/perBank/BOS.gif" /></div>
					<div class="ra-img"><input type="radio" name="bankCode"
						id="bankCode" value="CIB" /> <img
						src="ZLP_PHP/images/perBank/CIB.gif" /></div>
					</div>
				</td>
				<td>
					<div style="margin-bottom: 20px;">
					<div class="ra-img"><input type="radio" name="bankCode"
						id="bankCode" value="PSBC" /> <img
						src="ZLP_PHP/images/perBank/PSBC.gif" /></div>
					<div class="ra-img"><input type="radio" name="bankCode"
						id="bankCode" value="CMBC" /> <img
						src="ZLP_PHP/images/perBank/CMBC.gif" /></div>
					<div class="ra-img"><input type="radio" name="bankCode"
						id="bankCode" value="GDB" /> <img
						src="ZLP_PHP/images/perBank/GDB.gif" /></div>
					</div>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;&nbsp;<input type="submit" value="马上支付" id="pay" /></td>
			</tr>
		</table>
		</form>
		</td>
	</tr>
</table>
<?php } 
else if ( $_POST['bankinfo'] == 22 ) {?>
<table width="60%" border="0" align="center" cellpadding="0"
	cellspacing="0" style="border: solid 1px #40506b;">
	<tr>
		<td>
		<form method="post" action="ZLP_PHP/payMac2.php">
		<table width="100%" border="0" align="center" cellpadding="5"
			cellspacing="1" style="border-spacing: 0;">
			<tr>
				<td><a href="#"><img src="ZLP_PHP/images/logo.png" alt="zlinepay"
					width="150" height="45" border="0" /></a></td>
				<td style="text-align: right;"><span style="color: #868B94;">感谢您使用中联支付平台</span></td>
			</tr>
			<tr>
			</tr>
			<tr>
				<td colspan="2"
					style="color: #fff; font-size: 14px; height: 40px; background: #2C69C1;">中联支付产品通用支付接口演示</td>
			</tr>
			<tr>
				<td>商户订单号</td>
				<td>&nbsp;&nbsp;<?php
				echo ($outOrderId)?></td>
				<td><input type="hidden" name="outOrderId" id="outOrderId"
					value="<?php
					echo ($outOrderId)?>" /></td>
			</tr>
			<tr>
				<td>充值金额（元）</td>
				<td>&nbsp;&nbsp;<?php echo $cmoney?></td>
			</tr>			
			<tr>
				<td>手续费（元）</td>
				<td>&nbsp;&nbsp;<?php echo $sxmoney?></td>

			</tr>			
			<tr>
				<td>总支付金额（元）</td>
				<td>&nbsp;&nbsp;<?php echo $rmoney?></td>
				<td><input type="hidden" name="totalAmount" id="totalAmount"
					value="<?php echo $rmoney*100?>" /></td>
			</tr>
			<tr>
				<td><input type="hidden" name="goodsName" id="goodsName" value="充值2" /></td>
			</tr>
			<tr>
				<td><input type="hidden" name="goodsExplain" id="goodsExplain"
					value="彩乐彩充值2" /></td>
			</tr>
			<tr>
				<td><input type="hidden" name="merUrl" id="merUrl"
					value="http://pay.lolk.cn/jump.php" /></td>
			</tr>
			<tr>
				<td><input type="hidden" name="noticeUrl" id="noticeUrl"
					value="http://pay.lolk.cn/index.php" /></td>
			</tr>
			<tr>
				<td><input type="hidden" name="bankCardType" id="bankCardType" value="00" /></td>
			</tr>
			<tr>
				<td style="vertical-align: sub;">支付方式</td>
				<td>
				
					<div style="margin-bottom: 20px;">
					<div class="ra-img"><input type="radio" name="bankCode"
						id="bankCode" value="BOC" /> <img
						src="ZLP_PHP/images/perBank/BOC.gif" /></div>
					<div class="ra-img"><input type="radio" name="bankCode"
						id="bankCode" value="ABC" /> <img
						src="ZLP_PHP/images/perBank/ABC.gif" /></div>
					<div class="ra-img"><input type="radio" name="bankCode"
						id="bankCode" value="ICBC" /> <img
						src="ZLP_PHP/images/perBank/ICBC.gif" /></div>
					<div class="ra-img"><input type="radio" name="bankCode"
						id="bankCode" value="CCB" /> <img
						src="ZLP_PHP/images/perBank/CCB.gif" /></div>
					</div>
				</td>
				<td>
					<div style="margin-bottom: 20px;">
					<div class="ra-img"><input type="radio" name="bankCode"
						id="bankCode" value="BCM" /> <img
						src="ZLP_PHP/images/perBank/BCM.gif" /></div>
					<div class="ra-img"><input type="radio" name="bankCode"
						id="bankCode" value="CMB" /> <img
						src="ZLP_PHP/images/perBank/CMB.gif" /></div>
					<div class="ra-img"><input type="radio" name="bankCode"
						id="bankCode" value="CEB" /> <img
						src="ZLP_PHP/images/perBank/CEB.gif" /></div>
					<div class="ra-img"><input type="radio" name="bankCode"
						id="bankCode" value="SPDB" /> <img
						src="ZLP_PHP/images/perBank/SPDB.gif" /></div>
					</div>
				</td>
			</tr>
			<tr>
				<td style="vertical-align: sub;"></td>
				<td>
					<div style="margin-bottom: 20px;">
					<div class="ra-img"><input type="radio" name="bankCode"
						id="bankCode" value="PAB" /> <img
						src="ZLP_PHP/images/perBank/PAB.gif" style="padding-right: 18px;" /></div>
					<div class="ra-img"><input type="radio" name="bankCode"
						id="bankCode" value="BOS" /> <img
						src="ZLP_PHP/images/perBank/BOS.gif" /></div>
					<div class="ra-img"><input type="radio" name="bankCode"
						id="bankCode" value="CIB" /> <img
						src="ZLP_PHP/images/perBank/CIB.gif" /></div>
					</div>
				</td>
				<td>
					<div style="margin-bottom: 20px;">
					<div class="ra-img"><input type="radio" name="bankCode"
						id="bankCode" value="PSBC" /> <img
						src="ZLP_PHP/images/perBank/PSBC.gif" /></div>
					<div class="ra-img"><input type="radio" name="bankCode"
						id="bankCode" value="CMBC" /> <img
						src="ZLP_PHP/images/perBank/CMBC.gif" /></div>
					<div class="ra-img"><input type="radio" name="bankCode"
						id="bankCode" value="GDB" /> <img
						src="ZLP_PHP/images/perBank/GDB.gif" /></div>
					</div>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;&nbsp;<input type="submit" value="马上支付" id="pay" /></td>
			</tr>
		</table>
		</form>
		</td>
	</tr>
</table>
<?php } ?>
<script type="text/javascript">
$(document).ready(function() {
//    /*调用方法如下：*/
    $.jqtab("#tabs",".tab_con");
    
	$('.tab_conbox :radio').attr("checked",false);   //默认不点中
	$(':radio').click(function(){
		var raVal = $(this).attr("checked");
		if(raVal==true){
			$(this).parent().siblings().children(":radio").attr("checked",false)
			       .parent().parent().siblings().children().children(":radio").attr("checked",false);
			$("#pay").removeAttr("disabled");
			
		}
		//$("#bankCode").val($(this).val());//设置文本框银行编码
	});
	
	if(!($(":radio").is(':checked'))){
		$("#pay").attr("disabled","disabled");		
	}
	
	if((isFirefox=navigator.userAgent.indexOf("Firefox")>0) || (isIE = navigator.userAgent.indexOf("MSIE")>0) || (Object.hasOwnProperty.call(window, "ActiveXObject") && !window.ActiveXObject)){  
		$('.tabs').css({"margin-bottom":"-17px"});
	}
});
</script>
</body>
</html>
