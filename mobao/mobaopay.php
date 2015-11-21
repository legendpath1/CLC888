<?php
	include 'php.config';
	include 'MobaoPay.class.php';

	header('Content-Type:text/html;charset=utf-8');

	// �������ݸ�ֵ
	$data = "";
	$data['apiName']="WEB_PAY_B2C";//�ӿ�����
	$data['apiVersion'] = "1.0.0.0";//�ӿڰ汾
	$data['platformID'] = "zhmy123";//�̻�ID
	$data['merchNo'] = "210001440003529";//�̻��ʺ�
	$data['orderNo'] = date('YmdHis');//�̻�������
	$data['tradeDate'] = date('Ymd');//��������
	$data['amt'] = number_format($_POST['real_money'], 2, '.', '');//���
	$data['merchUrl'] = "http://www.ruyi901.com/mobao/callback.php";//֪ͨ��ַ
	$data['merchParam'] = $_POST['uid'];//�̻�����
	$data['tradeSummary'] = mt_rand(1000000,9999999);//����ժҪ
	$data['bankCode']= $_POST["banks"];
	
	// ������ת��ΪUTF-8
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
	
	// ����֧������	
	$cMbPay = new MbPay($pfxFile, $pubFile, $pfxpasswd, $payReqUrl);	
	echo $cMbPay->mobaopayOrder($data);
?> 