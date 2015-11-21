<?php
error_reporting(0);
require_once 'conn.php';

		$url="http://shishicai.cjcp.com.cn/heilongjiang/kaijiang/";

		$content=file_get_contents($url);
		//echo $content;

		$stra=explode('<table class="kjjg_table">',$content);
		$strb=explode('<td>',$stra[1]);
		$strc=explode('期</td>', $strb[1]);
		$strd=explode('</td>', $strb[2]);
		$stre=explode('</div><div class="hm_bg">', $strb[3]);
		$t1=preg_replace('/[^0-9]/','',$strc[0]);
		$t3=$strd[0];
		$t2=substr($stre[0], -1).",".$stre[1].",".$stre[2].",".$stre[3].",".$stre[4];

		//echo $t1."_".$t2;
		kjdata($t2,6,$t1,$t3);

?>
