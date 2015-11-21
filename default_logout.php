<?php
session_start();
error_reporting(0);
require_once 'conn.php';
//if(!defined('PHPYOU')) {
//	exit('Access Denied');
//}
mysql_query( "delete from ssc_online where username='".$_SESSION['username']."'");

if($_SESSION['username'] != '')
{
	$sapiUrl = Create_SAPI_Url($_SESSION['username'], '', '', '', 0, 'logout');
	
	mysql_query( "delete from ssc_online where username='".$_SESSION['username']."'");
}
unset($_SESSION['username']);
unset($_SESSION['uid']);
unset($_SESSION['valid']);
unset($_SESSION["pwd"]);
//echo "<meta http-equiv=refresh content=\"0;URL=./\">";exit;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>退出中</title>
</head>
<body>
<script src="<?php echo $sapiUrl; ?>" type="text/javascript"></script>
<div style="border:3px solid #f0f0f0; margin:80px auto 0 auto;width:500px;">
	<div style="height:200px; line-height:200px; text-align:center; font-size:20px;font-weight:bold;">
            正在退出，请稍候（<span id="secondId"></span>）。。
	</div>
</div>
<script type="text/javascript">
    var second = 4;
    function timeout() {
        second--;
        if (second <= 0) {
            window.location.href = "/";
        }
        else {
            document.getElementById("secondId").innerHTML = second;
            setTimeout(timeout, 1000);
        }
    }
    timeout();
</script>
</body>
</html>
