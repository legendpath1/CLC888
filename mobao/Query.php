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
	
	// 调用查询交易
	$cMbPay= new MbPay($pfxFile, $pubFile, $pfxpasswd, $queryReqUrl);
	echo $cMbPay->mobaopayTranQuery($data);
?>  