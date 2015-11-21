<?php
error_reporting(0);
require_once 'conn.php';

		$url="http://trade.11x5w.com/static/public/dcq/xml/newlyopenlist.xml";

		$doc = new DOMDocument();
		$doc->load($url); //读取xml文件
		$lst = $doc->getElementsByTagName('row');
//	//    for ($i=0; $i<$lst->length; $i++) {
		for ($i=0; $i<1; $i++) {
			$iframe= $lst->item($i);
			$t1=$iframe->attributes->getNamedItem('expect')->value;
			$t2=$iframe->attributes->getNamedItem('opencode')->value;
			$t3=$iframe->attributes->getNamedItem('opentime')->value;

//			$t1=substr($t1,-8);	
			kjdata($t2,10,$t1,"2000-01-01 01:01:01");
		 } 
		 
?>
