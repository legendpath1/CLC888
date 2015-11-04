<?php
include 'ZLP_PHP/Config2.php';
include 'ZLP_PHP/Sign.php';
require_once 'conn.php';

// 从request中获取post数据json格式字符串
$command =  isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");
$map = json_decode($command,TRUE);//true,转化成数组

//$myFile = "map_json.txt";
//$fh = fopen($myFile, 'w') or die("can't open file");
//$stringData = "".$command;
//fwrite($fh, $stringData);

// ------------------- 验签开始 -------------------
// 参与签名字段
$sign_fields = Array("merchantCode", "instructCode", "transType", "outOrderId", "transTime","totalAmount");
$s = new Sign();
$sign = $s->sign_mac($sign_fields, $map, $md5Key);
// 将小写字母转成大写字母
$sign = strtoupper($sign);
$reqSign = $map["sign"];
// response 响应
if($sign === $reqSign) {
	echo "{'code':'00'}";

	//$stringData = "Success";
	//fwrite($fh, $stringData);

	$sqla = "SELECT * FROM ssc_savelist WHERE dan='" . $map['outOrderId'] ."' order by adddate desc";
	$rsa = mysql_query($sqla);
	$rowa = mysql_fetch_array($rsa);
	$money = $rowa['money'];
	$zt = $rowa['zt'] + 0;

	//fwrite($fh, "; uid=" . $rowa['uid']);
	//fwrite($fh, "; money=" . $rowa['money']);
	//fwrite($fh, "; zt=" . $rowa['zt']);
	
	$sqlb = "select * from ssc_member where id='" . $rowa['uid'] . "'";
	$rsb = mysql_query($sqlb);
	$rowb = mysql_fetch_array($rsb);
	
	//fwrite($fh, "; leftmoney=" . $rowb['leftmoney']);
	
	if ( $zt == 0) {
		$sqld="update ssc_member set leftmoney=".($money + $rowb['leftmoney'])." where id='".$rowa['uid']."'";
		$exed=mysql_query($sqld);
		$sqlc = "UPDATE ssc_savelist set zt='1' WHERE uid='" . $rowa['uid'] ."'";
		$exec=mysql_query($sqlc);
	}
}else {
	echo "{'code':'01'}";
}
// ------------------- 验签结束 -------------------

//fclose($fh);
?>