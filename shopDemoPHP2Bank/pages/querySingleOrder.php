	<?php 
	    
	    $dirname='http://'.$_SERVER['SERVER_NAME']; 
		$admincookie = $_REQUEST['url'];
		$content = file_get_contents('../file/config.ini');
		$str = str_replace("\n", "&",str_replace("\r", "",$content));
		$array = array();
		parse_str($str, $array);
		
		$service = !isset($_REQUEST['service'])?"REQ_ORDER_QUERY_BY_ID":$_REQUEST['service'];
		$secId = !isset($_REQUEST['secId'])?"RSA":$_REQUEST['secId'];
		$version = !isset($_REQUEST['version'])?"1.0.0":$_REQUEST['version'];
		$token = !isset($_REQUEST['token'])?"":$_REQUEST['token'];
		$merchantId = !isset($_REQUEST['merchantId'])?$array['merchantId']:$_REQUEST['merchantId'];
		$merchantNo = !isset($_REQUEST['merchantNo'])?$array['merchantNo']:$_REQUEST['merchantNo'];
		$sign = !isset($_REQUEST['sign'])?"":$_REQUEST['sign'];
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>get token</title>
<SCRIPT TYPE="TEXT/JAVASCRIPT" SRC="../js/jquery.js"></SCRIPT>
<SCRIPT TYPE="TEXT/JAVASCRIPT" SRC="../js/map_1.1.js"></SCRIPT>
<SCRIPT TYPE="TEXT/JAVASCRIPT" SRC="../js/md5.js"></SCRIPT>
<SCRIPT TYPE="TEXT/JAVASCRIPT" SRC="../js/myutil.js"></SCRIPT>

<SCRIPT TYPE="TEXT/JAVASCRIPT" SRC="../js/init.js"></SCRIPT>
<script type="text/javascript">

function getSign(){
	var arr = $('#payForm').serializeArray();
	var params = $.param(arr);		
	 $.ajax({
		url : 'getSignature.php',
		//加密传输
		data : params,
		type : "post",
		datatype : "json",
		success : function(retData){
			//console.log(retData);
			$('#sign').val(retData);
		}
	});
}	
function pay(step){
		var payForm =  $('#payForm');
		if(step==1){
			//进行签名操作
			getSign();
			return false;
		}else if(step==2){
			payForm.attr("action","<?php echo $array['url'];?>");
			payForm.submit();
		}
		
	}

function installdata(){
	var content = preinstalldata();
    var test2 = '<?php echo $array['key'];?>';
	var obj =  hex_md5(content+test2).toLowerCase();
    return obj;
	}
</script>
</head>
<body>
    <form id="payForm" action="" method="post">
	<table>
		<tr>
			<td>单笔订单查询</td>
		</tr>
		<tr>
			<td>*接口名称：<input type="text" id="service" name="service"
				value="<?php echo $service;?>" />
			</td>
		</tr>
		<tr>
			<td>*签名算法：<input type="text" id="secId" name="secId"
				value="<?php echo $secId;?>" /></td>
		</tr>
		<tr>
			<td>*接口版本：<input type="text" id="version" name="version"
				value="<?php echo $version;?>" /></td>
		</tr>
		<tr>
			<td>*安全令牌：<input type="text" id="token" name="token"
				value="<?php echo $token;?>" />
			</td>
		</tr>
		<tr>
			<td>*商户代码：<input type="text" id="merchantId" name="merchantId"
				value="<?php echo $merchantId;?>" /></td>
		</tr>
		<tr>
			<td>*商户订单号：<input type="text" id="merchantNo" name="merchantNo"
				value="<?php echo $merchantNo;?>" />
			</td>
		</tr>
		<tr>
			<td>*订单签名：<input type="text" id="sign" name="sign"
				value="<?php echo $sign;?>" /></td>
		</tr>
		<tr>
			<td>
			<a href="#" onclick="pay(1);">签名</a>
			<a href="#" onclick="pay(2);">查询</a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="<?php echo $admincookie;?>">返回首页</a>
			</td>
		</tr>
	</table>
	</form>
	
</body>
</html>