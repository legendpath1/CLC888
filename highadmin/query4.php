<?php
error_reporting(0);
require_once 'conn.php';

		$url="http://cp.swlc.sh.cn/cams/xml/award_02.xml";

		$content=file_get_contents($url);
//		echo $content;

		$stra=explode('<dt><strong>时时乐</strong> ',$content);
//		echo $stra[1];
		$strb=explode('期</dt>',$stra[1]);
		$strc=explode('<em class="cred">',$strb[1]);
		
		$t1=$strb[0];
		$t2=substr($strc[1],0,1).",".substr($strc[2],0,1).",".substr($strc[3],0,1);
		
		$t3=date("Y-m-d H:i:s");
		//echo $t2;
		kjdata($t2,4,$t1,$t3);
?>
