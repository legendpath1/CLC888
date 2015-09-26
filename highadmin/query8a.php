<?php
error_reporting(0);
require_once 'conn.php';

$url="http://www.cailele.com/static/jxdlc/newlyopenlist.xml";

$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
$context = stream_context_create($opts);
$content=file_get_contents($url,False, $context);
//echo $content;
		$stra=explode('<row expect="',$content);
		$strb=explode('" opencode="',$stra[1]);
		$strc=explode('"',$strb[1]);
		
		$t1=substr($strb[0],-8);

		$t2=$strc[0];
		$t2=str_replace('"',"",$t2);
		
		$t3=date("Y-m-d H:i:s");
		
//		echo $t1.$t2.$t3;
//			$t1=substr($t1,-9);
		kjdata($t2,8,$t1,$t3);

?>
