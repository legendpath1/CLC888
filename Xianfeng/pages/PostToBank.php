<?php
$dirname='http://'.$_SERVER['SERVER_NAME'];
$admincookie = $_REQUEST['url'];
$content = file_get_contents('../file/config.ini');
$str = str_replace("\n", "&",str_replace("\r", "",$content));
$array = array();
parse_str($str, $array);


$service = !isset($_REQUEST['service'])?"REQ_PAY_BANK":$_REQUEST['service'];
$secId = !isset($_REQUEST['secId'])?"RSA":$_REQUEST['secId'];
$version = !isset($_REQUEST['version'])?"1.0.0":$_REQUEST['version'];
$token = !isset($_REQUEST['token'])?"":$_REQUEST['token'];
$merchantId = !isset($_REQUEST['merchantId'])?$array['merchantId']:$_REQUEST['merchantId'];
$merchantNo = !isset($_REQUEST['merchantNo'])?"":$_REQUEST['merchantNo'];
$source = !isset($_REQUEST['source'])?"1":$_REQUEST['source'];

$payerId = !isset($_REQUEST['payerId'])?"":$_REQUEST['payerId'];
$amount = !isset($_REQUEST['totalAmount'])?"10":$_REQUEST['totalAmount'];
$transCur = !isset($_REQUEST['transCur'])?"156":$_REQUEST['transCur'];
$accountType = !isset($_REQUEST['accountType'])?"1":$_REQUEST['accountType'];
$bankId = !isset($_REQUEST['bankCode'])?"ICBC":$_REQUEST['bankCode'];
$productName = !isset($_REQUEST['productName'])?"充值3":$_REQUEST['productName'];
$productInfo = !isset($_REQUEST['productInfo'])?"彩乐彩充值3":$_REQUEST['productInfo'];
$returnUrl = !isset($_REQUEST['returnUrl'])?$array['returnUrl']:$_REQUEST['returnUrl'];
$noticeUrl = !isset($_REQUEST['noticeUrl'])?$array['noticeUrl']:$_REQUEST['noticeUrl'];
$expireTime = !isset($_REQUEST['expireTime'])?"":$_REQUEST['expireTime'];

$memo = !isset($_REQUEST['memo'])?"":$_REQUEST['memo'];
$sign = !isset($_REQUEST['sign'])?"":$_REQUEST['sign'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>直连网银支付</title>
<SCRIPT TYPE="TEXT/JAVASCRIPT" SRC="../js/jquery.js"></SCRIPT>
<SCRIPT TYPE="TEXT/JAVASCRIPT" SRC="../js/map_1.1.js"></SCRIPT>
<SCRIPT TYPE="TEXT/JAVASCRIPT" SRC="../js/md5.js"></SCRIPT>
<SCRIPT TYPE="TEXT/JAVASCRIPT" SRC="../js/myutil.js"></SCRIPT>
<SCRIPT TYPE="TEXT/JAVASCRIPT" SRC="../js/init.js"></SCRIPT>
<script type="text/javascript">

function getSign(){
	var arr = $('#payForm').serializeArray();
	var params = $.param(arr);		
	 $.ajax({
		url : 'getSignature.php',
		//加密传输
		data : params,
		type : "post",
		datatype : "json",
		success : function(retData){
			//console.log(retData);
			$('#sign').val(retData);
		}
	});
}	

function installdata(){
	var content = preinstalldata();
    var test2 = '<?php echo $array['key'];?>';
	var obj =  hex_md5(content+test2).toLowerCase();
    return obj;
	}
</script>
</head>
<body onload="document.payForm.submit();" class="center">
<form id="payForm" name="payForm" action="<?php echo $array['url'];?>"
	method="post">
<table>
	<tr>
		<td>*接口名称：<input type="text" id="service" name="service"
			value="<?php echo $service;?>" /></td>
		<td>*签名算法：<input type="text" id="secId" name="secId"
			value="<?php echo $secId;?>" /></td>
	</tr>
	<tr>
		<td>*接口版本：<input type="text" id="version" name="version"
			value="<?php echo $version;?>" /></td>
		<td>*安全令牌：<input type="text" id="token" name="token"
			value="<?php echo $token;?>" /></td>
	</tr>
	<tr>
		<td>*商户代码：<input type="text" id="merchantId" name="merchantId"
			value="<?php echo $merchantId;?>" /></td>
		<td>*商户订单号：<input type="text" id="merchantNo" name="merchantNo"
			value="<?php echo $merchantNo;?>" /></td>
	</tr>
	<tr>
		<td>*来源：<input type="text" id="source" name="source"
			value="<?php echo $source;?>" /></td>
		<td>付款方：<input type="text" id="payerId" name="payerId"
			value="<?php echo $payerId;?>" /></td>
	</tr>
	<tr>
		<td>*金额：<input type="text" id="amount" name="amount"
			value="<?php echo $amount;?>" /></td>
		<td>*币种：<input type="text" id="transCur" name="transCur"
			value="<?php echo $transCur;?>" /></td>
	</tr>
	<tr>
		<td>*卡种：<input type="text" id="accountType" name="accountType"
			value="<?php echo $accountType;?>" /></td>
		<td>*银行编号：<input type="text" id="bankId" name="bankId"
			value="<?php echo $bankId;?>" /></td>
	</tr>
	<tr>
		<td>*商品名称：<input type="text" id="productName" name="productName"
			value="<?php echo $productName;?>" /></td>
	</tr>
	<tr>
		<td>商品信息：<input type="text" id="productInfo" name="productInfo"
			value="<?php echo $productInfo;?>" /></td>
	</tr>
	<tr>
		<td>*前台通知地址：<input type="text" id="returnUrl" name="returnUrl"
			value="<?php echo $returnUrl;?>" /></td>
	</tr>
	<tr>
		<td>*后台通知地址：<input type="text" id="noticeUrl" name="noticeUrl"
			value="<?php echo $noticeUrl;?>" /></td>
	</tr>
	<tr>
		<td>订单超时时间：<input type="text" id="expireTime" name="expireTime"
			value="<?php echo $expireTime;?>" /></td>
	</tr>
	<tr>
		<td colspan=2>保留域：<input type="text" id="memo" name="memo"
			value="<?php echo $memo;?>" /></td>
	</tr>
	<tr>
		<td>*订单签名：<input type="text" id="sign" name="sign"
			value="<?php echo $sign;?>" /></td>
	</tr>

	<tr>
		<td><a href="#" onclick="pay(1);">签名</a></td>
	</tr>
</table>
</form>

</body>
</html>
