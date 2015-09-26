<?php
error_reporting(0);
require_once 'conn.php';

		$url="http://www.bwlc.gov.cn/buy/trax/queryWininfo.jsp?random=3616";
		$content=file_get_contents($url);
//		echo $content;

		$stra=explode('<h3>PK拾</h3>',$content);
		$strb=explode('<span class="ml10 b red fa f14">',$stra[1]);
		$strc=explode('</span>',$strb[1]);
		$strd=explode('<div class="pk10_bg">',$content);
		$stre=explode('<li>',$strd[1]);

		$t1=$strc[0];
		$t2=substr($stre[1],0,2);
		for ($i=2; $i<=10; $i++) {
			$t2=$t2.",".substr($stre[$i],0,2);
		}
		$t3=date("Y-m-d H:i:s");
		//echo $t2;

		
		kjdata($t2,15,$t1,$t3);
		 
?>
