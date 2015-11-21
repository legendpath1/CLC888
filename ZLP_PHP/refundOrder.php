<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>中联支付</title>
<meta name="keywords" content="" />
<meta http-equiv="description" content="" />
<link href="css/yeepaytest.css" type="text/css" rel="stylesheet" />
</head>
<body>
<table width="60%" border="0" align="center" cellpadding="0"
	cellspacing="0" style="border: solid 1px #40506b;">
	<tr>
		<td>
		<form method="post" action="refundOrderServer.php">
		<table width="100%" border="0" align="center" cellpadding="5"
			cellspacing="1" style="border-spacing: 0;">
			<tr>
				<td><a href="#"><img src="images/logo.png" alt="zlinepay"
					width="150" height="45" border="0" /></a></td>
				<td style="text-align: right;"><span style="color: #868B94;">感谢您使用中联支付平台</span></td>
			</tr>
			<tr>
			</tr>
			<tr>
				<td colspan="2"
					style="color: #fff; font-size: 14px; height: 40px; background: #2C69C1;">中联支付产品通用支付接口演示</td>
			</tr>
			<?php 
				$tips = $_POST['tips'];
				$state = $_POST['state'];
				if($tips != null && $tips != "") {
					echo "<tr><td colspan='2'>&nbsp;</td></tr>";
					echo "<tr><td colspan='2'>退货结果:".$tips.";</td></tr>";
				}
			?>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td>中联支付订单号</td>
				<td>&nbsp;&nbsp;<input size="50" type="text" name="oriInstructCode" id="oriInstructCode" value="<?php echo($_POST['oriInstructCode']) ?>" />&nbsp;<span
					style="color: #FF0000; font-weight: 100;">*</span></td>
			</tr>
			<tr>
				<td>退款金额(分)</td>
				<td>&nbsp;&nbsp;<input size="50" type="text" name="amount" id="amount" value="<?php echo($_POST['amount']) ?>" />&nbsp;<span
					style="color: #FF0000; font-weight: 100;">*</span></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td align="left">&nbsp;&nbsp;<input type="submit" value="马上提交" /></td>
			</tr>
		</table>
		</form>
		</td>
	</tr>
</table>
</body>
</html>