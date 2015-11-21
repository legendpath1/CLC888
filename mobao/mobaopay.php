<?php
	include 'php.config';
	include 'MobaoPay.class.php';

	header('Content-Type:text/html;charset=utf-8');

	// 请求数据赋值
	$data = "";
	$data['apiName']="WEB_PAY_B2C";//接口名字
	$data['apiVersion'] = "1.0.0.0";//接口版本
	$data['platformID'] = "zhmy123";//商户ID
	$data['merchNo'] = "210001440003529";//商户帐号
	$data['orderNo'] = date('YmdHis');//商户订单号
	$data['tradeDate'] = date('Ymd');//交易日期
	$data['amt'] = number_format($_POST['real_money'], 2, '.', '');//金额
	$data['merchUrl'] = "http://www.ruyi901.com/mobao/callback.php";//通知地址
	$data['merchParam'] = $_POST['uid'];//商户参数
	$data['tradeSummary'] = mt_rand(1000000,9999999);//交易摘要
	$data['bankCode']= $_POST["banks"];
	
	// 将中文转换为UTF-8
	if(!preg_match("/[\xe0-\xef][\x80-\xbf]{2}/", $data['merchUrl']))
	{
  	$data['merchUrl'] = iconv("GBK","UTF-8", $data['merchUrl']);
	}
	
	if(!preg_match("/[\xe0-\xef][\x80-\xbf]{2}/", $data['merchParam']))
	{

  	$data['merchParam'] = iconv("GBK","UTF-8", $data['merchParam']);
	}

	if(!preg_match("/[\xe0-\xef][\x80-\xbf]{2}/", $data['tradeSummary']))
	{
  	$data['tradeSummary'] = iconv("GBK","UTF-8", $data['tradeSummary']);
	}
	
	// 调用支付交易	
	$cMbPay = new MbPay($pfxFile, $pubFile, $pfxpasswd, $payReqUrl);	
	echo $cMbPay->mobaopayOrder($data);
?> 