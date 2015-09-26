<?php
	// 从request中获取post数据json格式字符串
	$command =  isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");
    $map = json_decode($command,TRUE);//true,转化成数组
    $response = http_post_fields("http://www.clc888.com/ZLP_PHP/notice.php", $map);
    echo $response;
?>