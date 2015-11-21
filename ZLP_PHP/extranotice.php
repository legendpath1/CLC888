<?php
// 从request中获取post数据json格式字符串
$command =  isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");
$response = file_get_contents("http://www.clc888.com/ZLP_PHP/notice.php", null, stream_context_create(array(
    'http' => array(
        'protocol_version' => 1.1,
        'user_agent'       => 'PHPExample',
        'method'           => 'POST',
        'header'           => "Content-type: application/json\r\n".
                              "Connection: close\r\n" .
                              "Content-length: " . strlen($command) . "\r\n",
        'content'          => $command,
	),
)));
echo $response;
?>