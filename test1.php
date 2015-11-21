<?php
session_start();
error_reporting(0);
require_once 'conn.php';


$sql="select * from ssc_class where cid=1 order by id asc";
//echo $sql;
$rs = mysql_query($sql);
while ($row = mysql_fetch_array($rs)){
	$sql="insert into ssc_class set cid=16,cname='如意分分彩',mid='".($row['mid']+670)."',name='".$row['name']."',jname='".$row['jname']."',rates='".$row['rates']."',maxbei='".$row['maxbei']."',maxzhu='".$row['maxzhu']."',zt='".$row['zt']."',sign='".$row['sign']."',sorts='".$row['sorts']."',isrx='".$row['isrx']."',descs='".$row['descs']."',help='".$row['help']."',example='".$row['example']."'";
	$exe = mysql_query($sql) or  die("数据库修改出错6!!!".mysql_error());
}
echo "ok"
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<head>
</head>
<body>


</body>
</html>