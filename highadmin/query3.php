<?php
error_reporting(0);
require_once 'conn.php';

		$url="http://www.bjfcdt.gov.cn/DataCenter/GetTVPlusInfoNew.aspx?%5FtimeoutID=8";
		$content=file_get_contents($url);
//		echo $content;

		$stra=explode("peroidnum=",$content);
		$strb=explode("&",$stra[1]);
		$strc=explode("awardnum=",$content);
		$t2=substr($strc[1],0,59);
		$t2 = str_replace("|",",",$t2);	
		
		$t1=$strb[0];
		
//		echo $t2.$t1;
		
		kjdata($t2,3,$t1,"2000-01-01 01:01:01");
		 
?>
