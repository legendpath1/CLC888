<?php
	$params = $_REQUEST;
	if (isset($params['type']) && $params['type'] == 'token') {
	    unset($params['type'],$params['bizType']);
	}
	
	unset ( $params ['sign'] );
	$content = file_get_contents ( '../file/config.ini' );
	$str = str_replace ( "\n", "&", str_replace ( "\r", "", $content ) );
	$array = array ();
	parse_str ( $str, $array );
	ksort ( $params );
	$paramsJoin = array ();
	foreach ( $params as $key => $value ) {
		$paramsJoin [] = "$key=$value";
	}
	$paramsString = implode ( '&', $paramsJoin );
	$md5val = strtolower ( md5 ( $paramsString ) );
	$public_key = include_once '../file/publickey.php';
	$pem = chunk_split ( ($public_key), 64, "\n" );
	$pem = "-----BEGIN PUBLIC KEY-----\n" . $pem . "-----END PUBLIC KEY-----\n";
	$publicKey = openssl_pkey_get_public ( $pem );
	openssl_public_encrypt ( $md5val, $crypted, $publicKey );
	echo  base64_encode ( $crypted );
