<?php
//error_reporting(0);
require_once 'conn.php';

$t2="23:59:40";

for($i=1;$i<=120;$i=$i+1){
	if($i==61){
		$t3=date("H:i:s",mktime(date("H",strtotime($t2))+6,date("i",strtotime($t2))+5,date("s",strtotime($t2)),01,01,2012));
	}else{
		$t3=date("H:i:s",mktime(date("H",strtotime($t2)),date("i",strtotime($t2))+5,date("s",strtotime($t2)),01,01,2012));
	}
	$t4=date("H:i:s",mktime(date("H",strtotime($t3)),date("i",strtotime($t3)),date("s",strtotime($t3))+30,01,01,2012));
//	$sql="update ssc_nums set nums='".sprintf("%02d",$row['nums'])."' where id='".$row['id']."'";
	$sql="insert into ssc_nums set cid='16',name='如意分分彩',nums='".sprintf("%03d",$i)."',starttime='".$t2."',endtime='".$t3."',endtimes='".$t3."',opentime='".$t4."'";
//	$sql="update ssc_nums set starttime='".$t2."',endtime='".$t3."',endtimes='".$t3."',opentime='".$t4."' where cid=7 and nums='".sprintf("%03d",$i)."'";
	echo $i.$sql."<br>";
//	$exe=mysql_query($sql) or  die("数据库修改出错!!!!".mysql_error());
	$t2=$t3;
}
?>
