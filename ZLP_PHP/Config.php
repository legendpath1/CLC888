<?php
#测试设置
#zlinepay 商户号
#生产平台 测试用商户号
$merchantCode="1000000572";
#签名密钥-与商户号一一对应
#生产 1000000183对应KEY
$md5Key="1b8771ad-38ee-4f0d-b7b9-2e92f4e9052c";
#生产
$commonUrl="https://payment.kklpay.com/";
$payUrl=$commonUrl."ebank/pay.do";
$returnsUrl=$commonUrl."return/return.do";
$queryUrl=$commonUrl."query/queryOrder.do";
#支付平台分配产品ID
$projectId="WEPAYPLUGIN_PAY";
?> 