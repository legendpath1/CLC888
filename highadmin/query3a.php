<?php
error_reporting(0);
require_once 'conn.php';

		$url="http://www.bwlc.gov.cn/buy/keno/queryWininfo.jsp?random=3616";
		$content=file_get_contents($url);
//		echo $content;

		$stra=explode("|",$content);
		$t2=$stra[1];
//		$t2 = str_replace("|",",",$t2);	
		
		$t1=$stra[0];
		
//		echo $t2.$t1;
		
		kjdata($t2,3,$t1,"2000-01-01 01:01:01");
		 
?>
