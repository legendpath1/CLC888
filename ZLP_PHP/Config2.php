<?php
#测试设置
#zlinepay 商户号
#生产平台 测试用商户号
$merchantCode="1000000447";
#签名密钥-与商户号一一对应
#生产 1000000447对应KEY
$md5Key="d39a72fd-e815-4e3d-b3e1-41e2d8a64e89";
#生产
$commonUrl="https://payment.kklpay.com/";
$payUrl=$commonUrl."ebank/pay.do";
$returnsUrl=$commonUrl."return/return.do";
$queryUrl=$commonUrl."query/queryOrder.do";
#支付平台分配产品ID
$projectId="WEPAYPLUGIN_PAY";
?> 