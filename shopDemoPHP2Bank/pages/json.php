<?php
	$file = '../file/order.json';
	$content = file_get_contents($file); //读取文件中的内容
	
	/*$str = str_replace("\n", "&",str_replace("},", "}},",$content));*/
	$str = str_replace("},", "}},",$content);
	$newarr = explode("},",$str);
	var_dump($newarr);
	
	$sum = "";
	for($i=0;$i<count($newarr);$i++){
		$num = $newarr[$i];
		$json =  json_encode($num);
		$arr = json_decode($json,true);
		$jsonarr = json_decode($arr, true);
			
		/*$float=floatval($num['amount']);*/
		$sum += intval($jsonarr['amount']);
	}
	
	/*foreach ($newarr as $a){
	 $json =  json_encode($a);
	 $arr = json_decode($json,true);
	 $jsonarr = json_decode($arr, true);
	
	 echo $jsonarr['merchantNo'],"<br/>";
	 }
	 echo count($newarr);
	 var_dump(json_decode($content));
	 $json =  json_encode($content);
	 $arr = json_decode($json,true);
	 $jsonarr = json_decode($arr, true);
	 echo $jsonarr['merchantNo'];*/
			 
?>