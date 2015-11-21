<?php
set_magic_quotes_runtime(0);
@header("content-Type: text/html; charset=utf-8");
define('PHPYOU','v1.0');
//此软件仅供学习测试使用，不得用于非法用途！
if(function_exists('date_default_timezone_set')) {

	@date_default_timezone_set('Etc/GMT-8');

}

$cdate=date("Y-m-d H:i:s");
if(date("H:i:s")<"03:00:00"){
	$ccdate=date("Y-m-d",strtotime("-1 day"));
}else{
	$ccdate=date("Y-m-d");
}

if(!get_magic_quotes_gpc()){
	Add_S($_POST);
	Add_S($_GET);
	Add_S($_COOKIE);
}
Add_S($_FILES);

function Add_S(&$array){
	foreach($array as $key=>$value){
		if(!is_array($value)){
			$array[$key]=addslashes($value);
		}else{
			Add_S($array[$key]);
		}
	}
}

$conn = mysql_pconnect( "119.147.115.101:3306", "root", "hellocy666" );
//$conn = mysql_pconnect( "localhost", "a0703192544", "42518290" );
if (!$conn)
  {
  die('Could not connect: 165.49.38.132 ');// 
  }

mysql_select_db( "sscnew2" );
mysql_query( "SET NAMES 'utf8'" );



function Grecord(){
$result=mysql_query("Select id from ssc_record order by id desc limit 1"); 
$raa=mysql_fetch_array($result); 
mysql_free_result($result); 
return sprintf("%07s",strtoupper(base_convert($raa['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));
}

function Get_ccdate($rrr,$sss){   
$result=mysql_query("Select count(*) as nums from ssc_membert where ccdate='".$sss."' and username='".$rrr."'"); 
$raa=mysql_fetch_array($result); 
mysql_free_result($result); 
return $raa['nums'];
}

?>