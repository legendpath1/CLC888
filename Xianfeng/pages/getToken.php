<?php 
    
    $dirname='http://'.$_SERVER['SERVER_NAME']; 
	$admincookie = $dirname.$_REQUEST['url'];
	//$dirname='http://'.$_SERVER['SERVER_NAME']; 
	$service = !isset($_REQUEST['service'])?"REQ_GET_TOKEN":$_REQUEST['service'];
	$bizType = !isset($_REQUEST['bizType'])?"":$_REQUEST['bizType'];
	$secId = !isset($_REQUEST['secId'])?"RSA":$_REQUEST['secId'];
	$version = !isset($_REQUEST['version'])?"1.0.0":$_REQUEST['version'];
	$content = file_get_contents('../file/config.ini');
	$str = str_replace("\n", "&",str_replace("\r", "",$content));
	$array = array();
	parse_str($str, $array);
	
	$merchantId = !isset($_REQUEST['merchantId'])?$array['merchantId']:$_REQUEST['merchantId'];
	$reqId = !isset($_REQUEST['reqId'])?"":$_REQUEST['reqId'];
	$sign = !isset($_REQUEST['sign'])?"":$_REQUEST['sign'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>申请安全令牌</title>
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
    		getSign();
 			return false;
    	}
    }

    function installdata(){
        var content = preinstalldata();
        var test2 = '<?php echo $array['key'];?>';
    	var obj =  hex_md5(content+test2).toLowerCase();
        return obj;
    	}

    function dealparam(){
    	var m = data2map();
        var arr = key4map(m);
       
        var content = "";
	    for(var i=0;i<arr.length;i++){
			var k = arr[i];
			if('gatewayUrl' != k && 'flag' != k && 'bizType' != k){
				var val = m.get(k);
				if(content==""){
					content = k+"="+val;
				}else{
					content = content+ "&"+k+"="+val;
					}
				}
		}
		return content;
     }

	function getToken_1(){
		var arr = $('#payForm').serializeArray();
		var params = $.param(arr);		
		var redir = $('#redir').val();
//         var obj = dealparam();
        var bizType = $('#bizType').val();
		 $.ajax({
			url : 'request.php',
			//加密传输
			data : params,
			type : "post",
			datatype : "json",
			success:function(json) {
				json=json.replace("<p>","").replace("</p>","");
				location.href=bizType+".php?token="+json+"&url="+redir;
			},
			error: function (msg) {
                alert('error:'+msg);
            },
			dataType:"text"
		});
	}
    
    function getToken(){
        var redir = $('#redir').val();
        var obj = dealparam();
        var bizType = $('#bizType').val();
        
    	$.ajax({
			type:'POST',
			async:true,
			timeout:30000,
			url:"test.php",
			data: {"param":"<?php echo $array['url'];?>?"+obj}, 
			crossDomain: true,
			success:function(json) {
				json=json.replace("<p>","").replace("</p>","");
				alert('success:'+json);
				location.href=bizType+".php?token="+json+"&url="+redir;
			},
			error: function (msg) {
                alert('error:'+msg);
            },
			dataType:"text"
		});
     }

  
</script>
</head>
<body>
    <form id="payForm" name="payForm" action="" method="post">
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
		    	<input type="hidden" id="bizType" name="bizType" value="<?php echo $bizType;?>" />
		    	<input type="hidden" name="type" value="token" />
			</td>
		</tr>
		
		<tr>
			<td>
			<a href="#" onclick="pay(1);">签名</a>
			<a href="#" onclick="getToken_1();">下一步</a>
			<a href="<?php echo $admincookie;?>">返回首页</a>
			<b> </b>
			</td>
		</tr>
	</table>
	</form>
	<div id="result"></div>
	<input type="hidden" id="redir" value="<?php echo $admincookie;?>"/>
</body>
</html>