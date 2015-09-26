<?php
	include 'Config.php';
	include 'Sign.php';
	require_once '../conn.php';
	require_once '../check.php';
	
	// 从request中获取post数据json格式字符串
	$command =  isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");
    $map = json_decode($command,TRUE);//true,转化成数组
    
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
		$sqla = "SELECT * FROM ssc_savelist WHERE dan='" . $outOrderId ."' order by adddate desc";
		$rsa = mysql_query($sqla);
		$rowa = mysql_fetch_array($rsa);
		$money = $rowa['money'];
		
		$sqlb = "select * from ssc_member where id='" . $rowa['uid'] . "'";
		$rsb = mysql_query($sqlb);
		$rowb = mysql_fetch_array($rsb);
		if ($rowa["zt"] == 0) {
			$sqld="update ssc_member set leftmoney=".($money + $rowb['leftmoney'])." where id='".$rowa['uid']."'";
		    $exed=mysql_query($sqld);
			$sqlc = "UPDATE ssc_savelist set z='1' WHERE id='" . $rowa["id"] ."'";
			$exe=mysql_query($sqlc);
		}
	}else {
		echo "{'code':'01'}";
	}
	// ------------------- 验签结束 -------------------
?>