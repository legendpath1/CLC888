<?php
	include 'php.config';
	include 'MobaoPay.class.php';

	// 请求数据赋值
	$data = "";
	$data['apiName']=$_POST["apiName"];
	$data['apiVersion']=$_POST["apiVersion"];
	$data['platformID']=$_POST["platformID"];
	$data['merchNo']=$_POST["merchNo"];
	$data['orderNo']=$_POST["orderNo"];
	$data['tradeDate']=$_POST["tradeDate"];
	$data['amt']=$_POST["amt"];
	$data['tradeSummary']=$_POST["tradeSummary"];
	
	// 将中文转换为UTF-8
	if(!preg_match("/[\xe0-\xef][\x80-\xbf]{2}/", $data['tradeSummary']))
	{
  		$data['tradeSummary'] = iconv("GBK","UTF-8", $data['tradeSummary']);
	}
	// 调用退款交易
	$cMbPay= new MbPay($pfxFile, $pubFile, $pfxpasswd, $refundReqUrl);	
	echo $cMbPay->mobaopayTranReturn($data);
?> 