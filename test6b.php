<?php
//error_reporting(0);
require_once 'conn.php';

$t2="08:58:22";

$sqlb="select * from ssc_record where username='y8y888' and types=12 order by id asc";
$rsb=mysql_query($sqlb) or  die("数据库修改出错!!!!");	
while($rowb = mysql_fetch_array($rsb)){

	$sql="update ssc_bills set iscancel=iscancel+1 where dan='".$rowb['dan1']."'";
	$exe=mysql_query($sql) or  die("数据库修改出错!!!!".mysql_error());
	$sql="update ssc_record set tag=1 where dan1='".$rowb['dan1']."'";
	$exe=mysql_query($sql) or  die("数据库修改出错!!!!".mysql_error());
}
?>
