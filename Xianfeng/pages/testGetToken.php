<?php 

    $dirname='http://'.$_SERVER['SERVER_NAME']; 
	$admincookie = $dirname.$_REQUEST['url'];
	//$dirname='http://'.$_SERVER['SERVER_NAME']; 
	$content = file_get_contents('../file/config.ini');
	$str = str_replace("\n", "&",str_replace("\r", "",$content));
	$array = array();
	parse_str($str, $array);
	$service = !isset($_REQUEST['service'])?"REQ_GET_TOKEN":$_REQUEST['service'];
	$bizType = !isset($_REQUEST['bizType'])?"RSA":$_REQUEST['bizType'];
	$secId = !isset($_REQUEST['secId'])?"RSA":$_REQUEST['secId'];
	$version = !isset($_REQUEST['version'])?"1.0.0":$_REQUEST['version'];
	$merchantId = !isset($_REQUEST['merchantId'])?$array['merchantId']:$_REQUEST['merchantId'];
	$reqId = !isset($_REQUEST['reqId'])?"":$_REQUEST['reqId'];
	$sign = !isset($_REQUEST['sign'])?"":$_REQUEST['sign'];
	
	

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>test get token</title>
<SCRIPT TYPE="TEXT/JAVASCRIPT" SRC="../js/jquery.js"></SCRIPT>
<SCRIPT TYPE="TEXT/JAVASCRIPT" SRC="../js/map_1.1.js"></SCRIPT>
<SCRIPT TYPE="TEXT/JAVASCRIPT" SRC="../js/md5.js"></SCRIPT>
<SCRIPT TYPE="TEXT/JAVASCRIPT" SRC="../js/myutil.js"></SCRIPT>
<script type="text/javascript">
	$(document).ready(function(){
		var d = producedate();
		var reqid = $('#reqId').val();
		if(reqid==''){
			$('#reqId').val(d);
			}
	});
	function installdata(){
	 	var content = "";
	    var m = new Map();
	   	$('table input').each(function(){
	   	    m.put(this.name,$(this).val());
	   	});
	   	var arr = new Array();
	    arr = m.keys();
	    arr=arr.sort();
	    for(var i=0;i<arr.length;i++){
			var k = arr[i];
			if('sign' !=k &&  'gatewayUrl' != k && 'flag' != k && 'bizType' != k){
				var val = m.get(k);
				if(content==""){
					content = k+"="+val;
				}else{
					content = content+ "&"+k+"="+val;
					}
				}
			
		}
		var test2 = '<?php echo $array['key'];?>';
		var obj =  hex_md5(content+test2).toLowerCase();
	    return obj;
		}
	//请求可以
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
			//window.location.href='http://106.39.35.10:9116/gateway.do';
		}
		payForm.submit();
	}
</script>
</head>
<body>
     <form id="payForm" name="payForm" action=''  method="post">
	<table>
		<tr>
			<td>申请安全令牌</td>
		</tr>
		<tr>
			<td>接口名称：<input type="text" id="service" name="service"
				value="<?php echo $service;?>" />
			</td>
		</tr>
		
		<tr>
			<td>签名算法：<input type="text" id="secId" name="secId"
				value="<?php echo $secId;?>" /></td>
		</tr>
		<tr>
			<td>接口版本：<input type="text" id="version" name="version"
				value="<?php echo $version;?>" /></td>
		</tr>
		<tr>
			<td>商户代码：<input type="text" id="merchantId" name="merchantId"
				value="<?php echo $merchantId;?>" /></td>
		</tr>
		<tr>
			<td>请求编号：<input type="text" id="reqId" name="reqId"
				value="<?php echo $reqId;?>" />
			</td>
		</tr>
		<tr>
			<td>订单签名：<input type="text" id="sign" name="sign"
				value="<?php echo $sign;?>" />
			</td>
		</tr>
		
		<tr>
			<td>
			<a href="javascript:void(0)" onclick="pay(1);">签名</a>
			<a href="javascript:void(0)" onclick="pay(2);">下一步</a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="<?php echo $admincookie;?>">返回首页</a>
			</td>
		</tr>
	</table>
	</form>
	
</body>
</html>