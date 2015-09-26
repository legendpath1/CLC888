<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$flag = trim($_POST['flag']);
if($flag=="update"){
	$tlen=mb_strlen($_REQUEST['nickname'],'UTF8'); //strLength($_REQUEST['nickname']
	if($tlen<2 || $tlen>8 ){
		echo "呢称不合法:长度为2到8位的字符";
		exit;
	}else{
		$sql = "update ssc_member set nickname='".trim($_POST['nickname'])."' WHERE username='" . $_SESSION["username"] . "'";
		$rs = mysql_query($sql);
		amend("修改呢称");
		echo "操作成功";
	}
}

function strLength($str,$charset='utf-8'){
	$str = iconv('utf-8','gb2312',$str);
	$num = strlen($str);
	$cnNum = 0;
	for($i=0;$i<$num;$i++){
		if(ord(substr($str,$i+1,1))>127){
			$cnNum++;
			$i++;
		}
	}
	$enNum = $num-($cnNum*2);
	$number = ($enNum/2)+$cnNum;
	return ceil($number);
}
?>