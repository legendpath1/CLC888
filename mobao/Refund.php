<?php
	include 'php.config';
	include 'MobaoPay.class.php';

	// �������ݸ�ֵ
	$data = "";
	$data['apiName']=$_POST["apiName"];
	$data['apiVersion']=$_POST["apiVersion"];
	$data['platformID']=$_POST["platformID"];
	$data['merchNo']=$_POST["merchNo"];
	$data['orderNo']=$_POST["orderNo"];
	$data['tradeDate']=$_POST["tradeDate"];
	$data['amt']=$_POST["amt"];
	$data['tradeSummary']=$_POST["tradeSummary"];
	
	// ������ת��ΪUTF-8
	if(!preg_match("/[\xe0-\xef][\x80-\xbf]{2}/", $data['tradeSummary']))
	{
  		$data['tradeSummary'] = iconv("GBK","UTF-8", $data['tradeSummary']);
	}
	// �����˿��
	$cMbPay= new MbPay($pfxFile, $pubFile, $pfxpasswd, $refundReqUrl);	
	echo $cMbPay->mobaopayTranReturn($data);
?> 