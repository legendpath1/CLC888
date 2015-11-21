<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body onLoad="document.dinpayForm.submit()">
<form name="dinpayForm" method="post" action="https://pay.dinpay.com/gateway?input_charset=UTF-8">
 
	<input type="hidden" name="sign" value="<?php echo $_POST["sign"]?>" />
	<input type="hidden" name="merchant_code" value="<?php echo $_POST["merchant_code"]?>" />
	<input type="hidden" name="bank_code" value="<?php echo $_POST["bank_code"]?>"/>
	<input type="hidden" name="order_no" value="<?php echo $_POST["order_no"]?>"/>
	<input type="hidden" name="order_amount" value="<?php echo $_POST["order_amount"]?>"/>
	<input type="hidden" name="service_type" value="<?php echo $_POST["service_type"]?>"/>
	<input type="hidden" name="input_charset" value="<?php echo $_POST["input_charset"]?>"/>
	<input type="hidden" name="notify_url" value="<?php echo $_POST["notify_url"]?>">
	<input type="hidden" name="interface_version" value="<?php echo $_POST["interface_version"]?>"/>
	<input type="hidden" name="sign_type" value="<?php echo $_POST["sign_type"]?>"/>
	<input type="hidden" name="order_time" value="<?php echo $_POST["order_time"]?>"/>
	<input type="hidden" name="product_name" value="<?php echo $_POST["product_name"]?>"/>
	<input Type="hidden" Name="client_ip" value="<?php echo $_POST["client_ip"]?>"/>
	<input Type="hidden" Name="extend_param" value="<?php echo $_POST["extend_param"]?>"/>
	<input Type="hidden" Name="extra_return_param" value="<?php echo $_POST["extra_return_param"]?>"/>
	<input Type="hidden" Name="product_code" value="<?php echo $_POST["product_code"]?>"/>
	<input Type="hidden" Name="product_desc" value="<?php echo $_POST["product_desc"]?>"/>
	<input Type="hidden" Name="product_num" value="<?php echo $_POST["product_num"]?>"/>
	<input Type="hidden" Name="return_url" value="<?php echo $_POST["return_url"]?>"/>
	<input Type="hidden" Name="show_url" value="<?php echo $_POST["show_url"]?>"/>
	</form>
</body>
</html>