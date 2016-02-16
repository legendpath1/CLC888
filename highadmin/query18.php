<?php
//error_reporting(0);
require_once 'conn.php';
include 'tempkj.php';

$sqls="select * from ssc_nums where cid='18' and DATE_FORMAT(opentime, '%H:%i:%s')<='".date("H:i:s")."' order by id desc limit 1";
//echo $sqls."<br>";
$rss=mysql_query($sqls) or  die("数据库修改出错1".mysql_error());
$nums=mysql_num_rows($rss);
$rows = mysql_fetch_array($rss);
$dymd=date("ymd");
$tissue=$dymd.$rows['nums'];
//echo $nums;
if($nums==0){
	$tissue=date("ymd",strtotime("-1 day"))."216";
}
//echo $tissue;
$sqla="select * from ssc_data where cid='18' and issue='".$tissue."'";
$rsa=mysql_query($sqla) or  die("数据库修改出错3".mysql_error());
$rowa = mysql_fetch_array($rsa);
$count = 0;
$limit = 0.95;
if(empty($rowa)){
//	echo "a";

	while (true) {
		$tn1=rand(0,9);
		$tn2=rand(0,9);
		$tn3=rand(0,9);
		$tn4=rand(0,9);
		$tn5=rand(0,9);
		
		$codes=$tn1.",".$tn2.",".$tn3.",".$tn4.",".$tn5;
		if ($count++ <= 20) {
			$limit = $limit + 0.001;
		} else {
			$limit = $limit + 0.05;
		}
		if (evaluateCode('16', $tissue, $codes, $limit)) {
			break;
		}
	}

	$sql="INSERT INTO ssc_data set cid='18', name='星城时时彩', issue='".$tissue."', code='".$codes."', opentime='".date("Y-m-d H:i:s")."', addtime='".date("Y-m-d H:i:s")."'";
//				echo $row['name']."第".$t1."期:".$t2."<br>";
	$exe=mysql_query($sql) or  die("数据库修改出错!!!!".mysql_error());

//	echo "vvv".$cals[$tn3];
	echo "星城时时彩 第".$tissue."期 开奖号码：".$codes;
}else{
echo "kkk".$tissue;
}

?>
