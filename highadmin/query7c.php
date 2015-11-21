<?php
error_reporting(0);
require_once 'conn.php';

		$url="http://caipiao.163.com/order/preBet_resentAwardNum.html?gameEn=jxssc&stamp=".time();

		$content=file_get_contents($url);
//		echo $content;

		$stra=explode('{"number":"',$content);
//		echo $stra[1];
		$strb=explode('","period":"',$stra[1]);
		$strb[1]=str_replace('"},',"",$strb[1]);
		
		$t1=substr($strb[1],-9);

		$t2=$strb[0];
		$t2=str_replace(" ",",",$t2);
		
		$t3=date("Y-m-d H:i:s");
		
//		echo $t1.$t2.$t3;
//			$t1=substr($t1,-9);
		kjdata($t2,7,$t1,$t3);

		 
?>
