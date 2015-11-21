<?php
//error_reporting(0);
require_once 'conn.php';
$name='lqz888';
$sqlb="update ssc_member set regfrom=CONCAT(regfrom,'&mangguo001&'),regtop='mangguo001' where regtop='".$name."'";
$rsb=mysql_query($sqlb) or  die("数据库修改出错!!!!");

$sqlb="update ssc_member set regfrom='&mangguo001&',regtop='mangguo001',regup='mangguo001' where username='".$name."'";
$rsb=mysql_query($sqlb) or  die("数据库修改出错!!!!");

$sqlb="update ssc_membert set regfrom=CONCAT(regfrom,'&mangguo001&'),regtop='mangguo001' where regtop='".$name."'";
$rsb=mysql_query($sqlb) or  die("数据库修改出错!!!!");

$sqlb="update ssc_membert set regfrom='&mangguo001&',regtop='mangguo001',regup='mangguo001' where username='".$name."'";
$rsb=mysql_query($sqlb) or  die("数据库修改出错!!!!");

$sqlb="update ssc_bills set regfrom=CONCAT(regfrom,'&mangguo001&'),regtop='mangguo001' where regtop='".$name."'";
$rsb=mysql_query($sqlb) or  die("数据库修改出错!!!!");

$sqlb="update ssc_bills set regfrom='&mangguo001&',regtop='mangguo001',regup='mangguo001' where username='".$name."'";
$rsb=mysql_query($sqlb) or  die("数据库修改出错!!!!");

$sqlb="update ssc_record set regfrom=CONCAT(regfrom,'&mangguo001&'),regtop='mangguo001' where regtop='".$name."'";
$rsb=mysql_query($sqlb) or  die("数据库修改出错!!!!");

$sqlb="update ssc_record set regfrom='&mangguo001&',regtop='mangguo001',regup='mangguo001' where username='".$name."'";
$rsb=mysql_query($sqlb) or  die("数据库修改出错!!!!");

$sqlb="update ssc_zbills set regfrom=CONCAT(regfrom,'&mangguo001&'),regtop='mangguo001' where regtop='".$name."'";
$rsb=mysql_query($sqlb) or  die("数据库修改出错!!!!");

$sqlb="update ssc_zbills set regfrom='&mangguo001&',regtop='mangguo001',regup='mangguo001' where username='".$name."'";
$rsb=mysql_query($sqlb) or  die("数据库修改出错!!!!");

$sqlb="update ssc_zdetail set regfrom=CONCAT(regfrom,'&mangguo001&'),regtop='mangguo001' where regtop='".$name."'";
$rsb=mysql_query($sqlb) or  die("数据库修改出错!!!!");

$sqlb="update ssc_zdetail set regfrom='&mangguo001&',regtop='mangguo001',regup='mangguo001' where username='".$name."'";
$rsb=mysql_query($sqlb) or  die("数据库修改出错!!!!");

?>
