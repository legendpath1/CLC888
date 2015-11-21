<? header("content-Type: text/html; charset=utf-8");?> 
 
<?php
 


require_once("dinpay_key.php");
/* *
 功能：智付页面跳转同步通知页面
 版本：3.0
 日期：2013-08-01
 说明：
 以下代码仅为了方便商户安装接口而提供的样例具体说明以文档为准，商户可以根据自己网站的需要，按照技术文档编写。

 * */
	//获取智付GET过来反馈信息
//商号号
	@$merchant_code	= $_POST["merchant_code"];

	//通知类型
	@$notify_type = $_POST["notify_type"];

	//通知校验ID
	@$notify_id = $_POST["notify_id"];

	//接口版本
	@$interface_version = $_POST["interface_version"];

	//签名方式
	@$sign_type = $_POST["sign_type"];

	//签名
	@$dinpaySign = $_POST["sign"];

	//商家订单号
	@$order_no = $_POST["order_no"];

	//商家订单时间
	@$order_time = $_POST["order_time"];

	//商家订单金额
	@$order_amount = $_POST["order_amount"];

	//回传参数
	@$extra_return_param = $_POST["extra_return_param"];

	//智付交易定单号
	@$trade_no = $_POST["trade_no"];

	//智付交易时间
	@$trade_time = $_POST["trade_time"];

	//交易状态 SUCCESS 成功  FAILED 失败
	@$trade_status = $_POST["trade_status"];

	//银行交易流水号
	@$bank_seq_no = $_POST["bank_seq_no"];


	/**
	 *签名顺序按照参数名a到z的顺序排序，若遇到相同首字母，则看第二个字母，以此类推，
	*同时将商家支付密钥key放在最后参与签名，组成规则如下：
	*参数名1=参数值1&参数名2=参数值2&……&参数名n=参数值n&key=key值
	**/


	//组织订单信息
	$signStr = "";
	if($bank_seq_no != "") {
		$signStr = $signStr."bank_seq_no=".$bank_seq_no."&";
	}
	if($extra_return_param != "") {
	    $signStr = $signStr."extra_return_param=".$extra_return_param."&";
	}
	$signStr = $signStr."interface_version=V3.0&";
	$signStr = $signStr."merchant_code=".$merchant_code."&";
	if($notify_id != "") {
	    $signStr = $signStr."notify_id=".$notify_id."&notify_type=page_notify&";
	}

        $signStr = $signStr."order_amount=".$order_amount."&";
        $signStr = $signStr."order_no=".$order_no."&";
        $signStr = $signStr."order_time=".$order_time."&";
        $signStr = $signStr."trade_no=".$trade_no."&";
        $signStr = $signStr."trade_status=".$trade_status."&";

	if($trade_time != "") {
	     $signStr = $signStr."trade_time=".$trade_time."&";
	}
	//$key="123456789a123456789_";
	$signStr = $signStr."key=".$key;
	$signInfo = $signStr;
	//将组装好的信息MD5签名
	$sign = md5($signInfo);
	//echo "sign=".$sign."<br>";

	//比较智付返回的签名串与商家这边组装的签名串是否一致
	
//	$sign=1;
//	$dinpaySign=1;
//	$order_no="893870";
//	$order_amount=1;
	
	
	
	if($dinpaySign==$sign) {
		//验签成功

	 
	 $r6_Order=$order_no;
     $r3_Amt=$order_amount;
	 

 


	 
	
      $result = mysql_query("select count(*) from ssc_savelist where zt=0 and dan='{$r6_Order}'");
      $num = mysql_result($result,"0");
      if($num==1){
	  
	  
					$resultuser = mysql_query("select * from ssc_member where username='{$extra_return_param}'");
					$rowuser = mysql_fetch_array($resultuser);		
					$userid=$rowuser['id'];	
//					
//					$resultuser2 = mysql_query("select * from user_bank where userid={$attach}");
//					$rowuser2 = mysql_fetch_array($resultuser2);		
//					$hig_amount=$rowuser2['hig_amount']+$amount;		
//					
					 
					
			        $s="update ssc_member set leftmoney=leftmoney+{$r3_Amt} where  username='{$extra_return_param}'";
					 if (mysql_query($s)){echo "";}
					 else{echo "Error creating database: " . mysql_error();}  
				

					$datetime=date("Y-m-d H:i:s");
					//$sql3="INSERT INTO  ssc_savelist set dan='".$r6_Order."',username='{$r8_MP}',uid={$userid},bank='ok',bankid='0',money=".$r3_Amt.",rmoney=0,sxmoney=0,adddate='".$datetime."',zt=1, types='2',xf=0";	
					$sql3="update ssc_savelist set zt=1 where   dan='{$r6_Order}'";
					
					
					if (mysql_query($sql3)){echo "";}
					 else{echo "Error creating database: " . mysql_error();}  


	  
	  }

 
	 
	 
	 
	 
	 
	   echo("<script>alert('在线充值成功');window.close();</script>");
	 
	 
	 
	 
	 


	}else
        {
  echo('在线充值不成功，请重试！');

  die();

	}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<!-- 此处可添加页面展示  提示相关信息给消费者  -->
</body>
</html>