<?php
error_reporting(0);
require_once 'conn.php';

		$url="http://cp.360.cn/k3js";

		$content=file_get_contents($url);
		//echo $content;
		 
		$stra=explode('<em class="red" id="open_issue">',$content);
		$strb=explode('</em>',$stra[1]);
		$strc=explode('<li class="ico-ball3">', $strb[1]);
		$t1=preg_replace('/[^0-9]/','',$strb[0]);
		$t2=substr($strc[1],0,1).",".substr($strc[2],0,1).",".substr($strc[3],0,1);
		$t3=date("Y-m-d H:i:s");
		
		//echo $t3;
		$temp = preg_replace('/[^0-9]/','',$t2);
		if (strlen($temp) !== 3) echo "Fetching Data";
		else kjdata($t2,13,$t1,$t3);
?>
