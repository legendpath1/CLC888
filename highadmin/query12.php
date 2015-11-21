<?php
error_reporting(0);
require_once 'conn.php';

		$url="http://www.cailele.com/static/pw/newlyopenlist.xml";//p3p5

		$doc = new DOMDocument();
		$doc->load($url); //读取xml文件
		$lst = $doc->getElementsByTagName('row');
	//    for ($i=0; $i<$lst->length; $i++) {
		for ($i=0; $i<2; $i++) {
			$iframe= $lst->item($i);
			$t1=$iframe->attributes->getNamedItem('expect')->value;
			$t2=$iframe->attributes->getNamedItem('opencode')->value;
			$t3=$iframe->attributes->getNamedItem('opentime')->value;

			$t1=substr($t1,-5);
			kjdata($t2,12,$t1,$t3);
		 } 
		 
?>
