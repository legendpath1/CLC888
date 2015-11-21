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
	$leftmoney = $rowb['leftmoney'];
	
	//fwrite($fh, "; leftmoney=" . $rowb['leftmoney']);
	
	if ( $zt == 0) {
		$lmoney=$leftmoney+$money;
		
		$sqld="update ssc_member set leftmoney=".$lmoney." where id='".$rowa['uid']."'";
		$exed=mysql_query($sqld);
		$sqlc = "UPDATE ssc_savelist set zt='1' WHERE id='" . $rowa['id'] ."' and dan='" . $map['outOrderId'] ."'";
		$exec=mysql_query($sqlc);
		
		$sqle = "select * from ssc_record order by id desc limit 1";		//帐变
		$rse = mysql_query($sqlc);
		$rowe = mysql_fetch_array($rsc);
		$dan1 = sprintf("%07s",strtoupper(base_convert($rowe['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));
		
		$sqlf="insert into ssc_record set dan='".$dan1."', uid='".$rowb['id']."', username='".$rowb['username']."', types='1', smoney=".$money.",leftmoney=".$lmoney.", regtop='".$rowb['regtop']."', regup='".$rowb['regup']."', regfrom='".$rowb['regfrom']."', adddate='".date("Y-m-d H:i:s")."',virtual='" .$rowb['virtual']. "', tag='中联支付2'";
		$exe=mysql_query($sqlf) or  die("数据库修改出错6!!!");

		$sqlg="insert into ssc_message set username='".$rowb["username"]."',types='充提消息',topic='&nbsp;&nbsp;&nbsp;&nbsp;恭喜您，充值成功', content='<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;您成功充值".$cmoney."元, 请注意查看您的帐变信息，如果有任何疑问请联系我们在线客服。</p>',adddate='".date("Y-m-d H:i:s")."'";
		$exe=mysql_query($sqlg) or  die("数据库修改出错6!!!");
	}
}else {
	echo "{'code':'01'}";
}
// ------------------- 验签结束 -------------------

//fclose($fh);
?>