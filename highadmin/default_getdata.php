<?php
session_start();
error_reporting(0);
require_once 'conn.php';

if($_SESSION["aid"]=="" || $_SESSION["ausername"]=="" || $_SESSION["avalid"]==""){
	echo " {\"msga\":\"Error\"}";
}else{
	$result = mysql_query("select count(*) from ssc_online where valid='".$_SESSION["avalid"]."' and username='".$_SESSION["ausername"]."'");
	$num = mysql_result($result,"0");
	if($num!=0){
		$exe=mysql_query("update ssc_online set updatedate='".date("Y-m-d H:i:s")."' where valid='".$_SESSION["avalid"]."' and username='".$_SESSION["ausername"]."'"); 
		mysql_free_result($exe); 

		$msga=0;
//		if($_SESSION["ausername"]=="yinhe001"){
			$sqlb="select count(*) as numb from ssc_drawlist where zt=0";
			$rsb=mysql_query($sqlb) or  die("数据库修改出错!!!!");
			$rowb = mysql_fetch_array($rsb);
			mysql_free_result($rsb); 
			$msgb=$rowb['numb'];
	
			$sqlb="select count(*) as numd from ssc_drawlist where tags=0";
			$rsb=mysql_query($sqlb) or  die("数据库修改出错!!!!");
			$rowb = mysql_fetch_array($rsb);
			mysql_free_result($rsb);
			$msgd=$rowb['numd'];
			$sqlb="update ssc_drawlist set tags=1 where tags=0 or tags is null or tags=''";
			$rsb=mysql_query($sqlb) or  die("数据库修改出错!!!!");
//		}else{
//			$msgb=0;
//			$msgd=0;
//		}

		if(date("H:i:s")<"03:00:00"){
			$starttime=date("Y-m-d",strtotime("-1 day"))." 03:00:00";
		}else{
			$starttime=date("Y-m-d")." 03:00:00";
		}

		$sqlg = "SELECT count(*) as numa FROM ssc_online";
		$rsg = mysql_query($sqlg);
		$rowg = mysql_fetch_array($rsg);
		mysql_free_result($rsg); 
		$onums=$rowg['numa'];
	
		$sql="select SUM(IF(types = 1, smoney, 0)) as t1,SUM(IF(types = 2, zmoney, 0)) as t2,SUM(IF(types = 3, smoney, 0)) as t3,SUM(IF(types = 7, zmoney, 0)) as t7,SUM(IF(types = 11, smoney, 0)) as t11,SUM(IF(types = 12, smoney, 0)) as t12,SUM(IF(types = 13, smoney, 0)) as t13,SUM(IF(types = 15, zmoney, 0)) as t15,SUM(IF(types = 16, zmoney, 0)) as t16,SUM(IF(types = 32, smoney, 0)) as t32,SUM(IF(types = 40, smoney, 0)) as t40 from ssc_record where adddate >='".$starttime."' and (virtual is null or virtual<>'1')";
		$rs=mysql_query($sql);
		$row = mysql_fetch_array($rs);
		mysql_free_result($rs); 

		$ts=$row['t7']-$row['t11']-$row['t12']-$row['t13']+$row['t15']+$row['t16']-$row['t32']-$row['t40'];
		$msgc="在线".$onums."人 充值:".number_format($row['t1'],2)." 提现:".number_format($row['t2']-$row['t3'],2)." 投注:".number_format($row['t7']-$row['t13'],2)." 返点:".number_format($row['t11']-$row['t15'],2)." 中奖:".number_format($row['t12']-$row['t16'],2)." 盈亏:".$ts;

		echo " {\"msga\":\"".$msga."\",\"msgb\":\"".$msgb."\",\"msgc\":\"".$msgc."\",\"msgd\":\"".$msgd."\"}";
	}else{
		echo " {\"msga\":\"Error\"}";
	}
}
?>