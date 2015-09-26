<?php
//error_reporting(0);
require_once 'conn.php';

$sqls="select * from ssc_nums where cid='17' and DATE_FORMAT(opentime, '%H:%i:%s')<='".date("H:i:s")."' order by id desc limit 1";
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
$sqla="select * from ssc_data where cid='17' and issue='".$tissue."'";
$rsa=mysql_query($sqla) or  die("数据库修改出错3".mysql_error());
$rowa = mysql_fetch_array($rsa);
if(empty($rowa)){
//	echo "a";
	$tn1=rand(0,9);
	$tn2=rand(0,9);
	if($tn1==$tn2){
		$tn2=rand(0,9);
	}
	$tn3=rand(0,9);
	
	$tn4=rand(0,9);
	if($tn4==$tn1 || $tn4==$tn2){
		$tn4=rand(0,9);
	}
	$tn5=rand(0,9);
//	if($tn5==$tn1 || $tn5==$tn2 || $tn5==$tn4){
//		$tn5=rand(0,9);
//	}
//	for($i=0; $i<10; $i++) {
//		echo $tissue."_".$tn1.$tn2.$i.$tn4.$tn5."|";
//		$cals[$i]=ckj($tissue,$tn1,$tn2,$i,$tn4,$tn5);
//		echo $cals[$i]."<br>";
//	}
//	echo "b";

//	$tmax=$cals[0];
//	$tn3=0;
//	for($i=1; $i<10; $i++) {
//		if($cals[$i]>$tmax){
//			$tmax=$cals[$i];
//			$tn3=$i;
//		}
//	}
//	$tlist="";
//	for($i=0; $i<10; $i++) {
//		if($cals[$i]==$cals[$tn3]){
//			$tlist=$tlist.",".$i;
//		}
//	}
//	$tta=explode(",",$tlist);
//	//echo $tlist."|".count($tta);
//	$tn3=$tta[rand(1,count($tta)-1)];
//	echo "c";

	$codes=$tn1.",".$tn2.",".$tn3.",".$tn4.",".$tn5;
	$sql="INSERT INTO ssc_data set cid='17', name='如意五分彩', issue='".$tissue."', code='".$codes."', opentime='".date("Y-m-d H:i:s")."', addtime='".date("Y-m-d H:i:s")."'";
//				echo $row['name']."第".$t1."期:".$t2."<br>";
	$exe=mysql_query($sql) or  die("数据库修改出错!!!!".mysql_error());

//	echo "vvv".$cals[$tn3];
	echo "如意五分彩 第".$tissue."期 开奖号码：".$codes;
}else{
echo "kkk".$tissue;
}

?>
