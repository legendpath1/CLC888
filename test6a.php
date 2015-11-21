<?php
//error_reporting(0);
require_once 'conn.php';

$sqlb="select id,pe from ssc_member order by id asc";
$rsb=mysql_query($sqlb) or  die("数据库修改出错!!!!");	
while($rowb = mysql_fetch_array($rsb)){
	$sql="update ssc_member set pe=concat(pe,';0;0;0;0') where id='".$rowb['id']."'";
	echo $i.$sql."<br>";
	$exe=mysql_query($sql) or  die("数据库修改出错!!!!".mysql_error());
}
?>
