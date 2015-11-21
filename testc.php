<?php
//error_reporting(0);
require_once 'conn.php';

$sqlb="select username,leftmoney from ssc_member order by id asc";
$rsb=mysql_query($sqlb) or  die("数据库修改出错!!!!");	
while($rowb = mysql_fetch_array($rsb)){
	$sqlc="select leftmoney from ssc_record where username='".$rowb['username']."' order by id desc limit 1";
	$rsc=mysql_query($sqlc) or  die("数据库修改出错!!!!");	
	$rowc = mysql_fetch_array($rsc);

	echo "用户:".$rowb['username']." 帐面余额".$rowb['leftmoney']." 帐变余额".$rowc['leftmoney']."<br>";
}
?>
