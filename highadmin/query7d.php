<?php
error_reporting(0);
require_once 'conn.php';
if(date("H:i:s")<"09:00:00"){echo "今天未开始";exit;}
$url="http://baidu.lecai.com/lottery/draw/sorts/ajax_get_draw_data.php?lottery_type=202&date=".date("Y-m-d");

$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
$context = stream_context_create($opts);
$content=file_get_contents($url,False, $context);
//$content=iconv("GB2312", "UTF-8//IGNORE", $content);
//echo $content;

		$stra=explode('phase":"',$content);
		$strb=explode('data":[',$stra[1]);
		$strc=explode(',',$strb[0]);
//		echo $stra[1];
		$strd=explode(']',$strb[1]);

		$strc[0]=str_replace('"',"",$strc[0]);
		
		$t1=substr($strc[0],-9);

		$t2=$strd[0];
		$t2=str_replace('"',"",$t2);
		
		$t3=date("Y-m-d H:i:s");
		
//		echo $t1.$t2.$t3;
//			$t1=substr($t1,-9);
		kjdata($t2,7,$t1,$t3);

		 
?>
