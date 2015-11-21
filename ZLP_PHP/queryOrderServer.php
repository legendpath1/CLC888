<?php
/****** 代码仅供参考  ***/

include 'Config.php';
include 'Sign.php';
include 'Http.php';

$outOrderId = $_POST ['outOrderId'];
$param = Array ("outOrderId" => $outOrderId, "merchantCode" => $merchantCode );
// -------------- 签名开始 --------------
$s = new Sign ( );
// 参与签名字段
$sign_fields = Array ("merchantCode", "outOrderId" );
$sign = $s->sign_mac ( $sign_fields, $param, $md5Key );
// 将小写字母转成大写字母
$sign = strtoupper ( $sign );
//-----------------签名结束-------------------


$paramMac = Array ("outOrderId" => $outOrderId, "merchantCode" => $merchantCode, "sign" => $sign );
$paramMacJson = json_encode ( $paramMac );

$pak = Array ("project_id" => $projectId, "param" => $paramMacJson );
$pakJson = json_encode ( $pak );

$p = new Http();
$retJson = $p->request_by_other ( $queryUrl, $pakJson );
//true,转化成数组
$retArr = json_decode ( $retJson, TRUE );
$code = $retArr ["code"];
$msg = $retArr ["msg"];
$data = $retArr ["data"];
$tips = "";
if ("00" === $code && $data != null) {
	$sign_fields = Array ("merchantCode", "outOrderId", "amount", "replyCode" );
	$sign = $s->sign_mac ( $sign_fields, $data, $md5Key );
	// 将小写字母转成大写字母
	$sign = strtoupper ( $sign );
	$respSign = $data ["sign"];
	$replyCode = $data["replyCode"];
	// 验签通过
	if ($sign != null && $sign == $respSign) {
		if("00" == $replyCode) {
			$tips = "success";
		}else {
			$tips = "fail";
		}
	} else {
		$tips = "resp verify fail";
	}
} else {
	$tips = "query fail[" . $code . "]";
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body onLoad="document.zlinepay1.submit();">
<form action="queryOrder.php" name="zlinepay1" method='post'>
<input  type="text" name="outOrderId" id="outOrderId" value="<?php echo($outOrderId) ?>" />
<input  type="text" name="tips" id="tips" value="<?php echo($tips) ?>" />
<input  type="text" name="state" id="state" value="<?php echo($replyCode) ?>" />
</form>
</body>
</html>