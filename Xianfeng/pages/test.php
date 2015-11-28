<?php
   
    
    function curlPost($url, $data = array(), $timeout = 30, $CA = true){    

    $cacert = getcwd() . '/cacert.pem'; //CA根证书  
    $SSL = substr($url, 0, 8) == "https://" ? true : false;  
   // var_dump($data);
    $ch = curl_init();  
    curl_setopt($ch, CURLOPT_URL, $url);  
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);  
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout-2);  
    if ($SSL && $CA) {  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);   // 只信任CA颁布的证书  
        curl_setopt($ch, CURLOPT_CAINFO, $cacert); // CA根证书（用来验证的网站证书是否是CA颁布） 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 检查证书中是否设置域名，并且是否与提供的主机名匹配  
    } else if ($SSL && !$CA) {  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书  
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1); // 检查证书中是否设置域名  
    }  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:')); //避免data数据过长问题  
    curl_setopt($ch, CURLOPT_HTTPGET, true);  
    //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  
    //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); //data with URLEncode  
    
    $ret = curl_exec($ch);  
   // var_dump(curl_error($ch));  //查看报错信息  

    curl_close($ch);  
    return $ret;    
}    
?>

<p>
<?php 
	$param = $_REQUEST['param'];
	var_dump($param);
//    $url = "https://mapi.ucfpay.com/gateway.do?service=REQ_GET_TOKEN&secId=MD5&version=1.0.0&merchantId=M100000240&reqId=20141031094904298&sign=7defd3e2269a8928803ea55d33971c70";
	$result = curlPost($param,array(),50,false);
	var_dump($result);
	$data = array();
	$php_json = json_decode($result,true);
	$data =(array) $php_json;
	$result2 = $data["result"];
    echo $result2;
?>

</p>
