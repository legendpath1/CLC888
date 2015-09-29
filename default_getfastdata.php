<?php
session_start();
error_reporting(0);
require_once 'conn.php';

//$_SESSION["uid"]="";
if($_SESSION["uid"]=="" || $_SESSION["username"]==""){
	echo " {\"money\":\"Error\"}";
}else{
	$result = mysql_query("select count(*) from ssc_online where session_id='".session_id()."'");   
	$num = mysql_result($result,"0");
	mysql_free_result($result); 
	if($num!=0){
		$exe=mysql_query("update ssc_online set updatedate='".date("Y-m-d H:i:s")."' where session_id='".session_id()."'"); 
		mysql_free_result($exe); 
		$sqla="select * from ssc_member where session_id='".session_id()."'";
		$rsa=mysql_query($sqla) or  die("数据库修改出错!!!!");
		$rowa = mysql_fetch_array($rsa);
		mysql_free_result($rsa); 
		if(empty($rowa)){
			$lmoney="empty";
		}else{
			$lmoney=$rowa['leftmoney'];
		}
		echo " {\"money\":\"".$lmoney."\"}";
		$ddf=date( "Y-m-d H:i:s",time()-600);
		$exe=mysql_query( "delete from ssc_online where updatedate<'".$ddf."'");
		mysql_free_result($exe); 
	}else{
		echo " {\"money\":\"Error\"}";
	}

}
?>