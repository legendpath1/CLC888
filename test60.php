<?php
//error_reporting(0);
require_once 'conn.php';

$t2="08:58:22";
$sqlb="select * from ssc_nums where cid=1 order by id asc";
$rsb=mysql_query($sqlb) or  die("数据库修改出错!!!!");	
while($rowb = mysql_fetch_array($rsb)){
	$t1=$rowb['starttime'];
	$t2=$rowb['endtime'];
	$t3=date("H:i:s",mktime(date("H",strtotime($t1)),date("i",strtotime($t1)),date("s",strtotime($t1))+30,01,01,2012));
	$t4=date("H:i:s",mktime(date("H",strtotime($t2)),date("i",strtotime($t2)),date("s",strtotime($t2))+30,01,01,2012));
//	$sql="update ssc_nums set nums='".sprintf("%02d",$row['nums'])."' where id='".$row['id']."'";
//	$sql="insert into ssc_nums set cid='3',name='北京快乐八',nums='".sprintf("%03d",$i)."',starttime='".$t2."',endtime='".$t3."',endtimes='".$t3."',opentime='".$t4."'";
	$sql="update ssc_nums set starttime='".$t3."',endtime='".$t4."',endtimes='".$t4."' where id='".$rowb['id']."'";
	echo $i.$sql."<br>";
	$exe=mysql_query($sql) or  die("数据库修改出错!!!!".mysql_error());
}
?>
