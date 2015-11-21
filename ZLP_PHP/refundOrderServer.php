<?php
/****** 代码仅供参考  ***/

include 'Config.php';
include 'Sign.php';
include 'Http.php';

$oriInstructCode = $_POST ['oriInstructCode'];
$amount = $_POST ['amount'];
$param = Array ("oriInstructCode" => $oriInstructCode, "merchantCode" => $merchantCode, "amount" => $amount );
// -------------- 签名开始 --------------
$s = new Sign ( );
// 参与签名字段
$sign_fields = Array ("merchantCode", "oriInstructCode", "amount");
$sign = $s->sign_mac ( $sign_fields, $param, $md5Key );
// 将小写字母转成大写字母
$sign = strtoupper ( $sign );
//-----------------签名结束-------------------


$paramMac = Array ("oriInstructCode" => $oriInstructCode, "merchantCode" => $merchantCode, "amount" => $amount, "sign" => $sign );
$paramMacJson = json_encode ( $paramMac );

$pak = Array ("project_id" => $projectId, "param" => $paramMacJson );
$pakJson = json_encode ( $pak );

$p = new Http ( );
$retJson = $p->request_by_other ( $returnsUrl, $pakJson );
//true,转化成数组
$retArr = json_decode ( $retJson, TRUE );
$code = $retArr ["code"];
$msg = $retArr ["msg"];
$data = $retArr ["data"];
$tips = "";
if ("00" === $code && $data != null) {
	$sign_fields = Array ("merchantCode","oriInstructCode","returnInstructCode","returnTransTime","amount" );
	$sign = $s->sign_mac ( $sign_fields, $data, $md5Key );
	// 将小写字母转成大写字母
	$sign = strtoupper ( $sign );
	$respSign = $data ["sign"];
	
	// 验签通过
	if ($sign != null && $sign == $respSign) {
		$tips = "success";
	} else {
		$tips = "resp verify fail";
	}
} else {
	$tips = "refund fail[" . $code . "]";
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body onLoad="document.zlinepay1.submit();">
<form action="refundOrder.php" name="zlinepay1" method='post'>
<input  type="text" name="oriInstructCode" id="oriInstructCode" value="<?php echo($oriInstructCode) ?>" />
<input  type="text" name="tips" id="tips" value="<?php echo($tips) ?>" />
<input  type="text" name="amount" id="amount" value="<?php echo($amount) ?>" />
</form>
</body>
</html>