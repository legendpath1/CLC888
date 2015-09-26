<?php
error_reporting(0);
require_once 'conn.php';

		$url="http://kaijiang.cjcp.com.cn/tjssc/";

		$content=file_get_contents($url);
		//echo $content;

		$stra=explode('<table class="qgkj_table">',$content);
		$strb=explode('<td class="qihao">',$stra[1]);
		$strc=explode('</td>',$strb[1]);
		$strd=explode('<td class="time">',$stra[1]);
		$stre=explode('</td>',$strd[1]);
		$strf=explode('<input type="button" value="',$stra[1]);
		
		$t1=preg_replace('/[^0-9]/','',$strc[0]);
		$t2=substr($strf[1],0,1).",".substr($strf[2],0,1).",".substr($strf[3],0,1).",".substr($strf[4],0,1).",".substr($strf[5],0,1);		
		$t3=$stre[0];
		
		//echo $t2.$t3;
		kjdata($t2,14,$t1,$t3);
?>
