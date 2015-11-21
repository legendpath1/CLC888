<?php
session_start();
error_reporting(0);
require_once 'conn.php';
if(date("H:i:s")<"03:15:00"){echo "03:00:00 later try!";exit;}
		$ccdate=date("Y-m-d",strtotime("-1 day"));
//		$ccdate="2015-04-02";
		echo $ccdate;
		$ccdatea=date("Y-m-d",strtotime("-1 day"))." 03:00:00";
		$ccdateb=date("Y-m-d")." 03:00:00";
//		$ccdatea="2015-04-02 03:00:00";
//		$ccdateb="2015-04-03 03:00:00";
		
		$sqlc = "select * from ssc_membert where ccdate='".$ccdate."' limit 1";
		$rsc = mysql_query($sqlc);
		$rowc = mysql_fetch_array($rsc);
		if(empty($rowc)){
			$sqla="select username,SUM(IF(types = 1, smoney, 0)) as t1,SUM(IF(types = 2, zmoney, 0)) as t2,SUM(IF(types = 3, smoney, 0)) as t3,SUM(IF(types = 7, zmoney, 0)) as t7,SUM(IF(types = 11, smoney, 0)) as t11,SUM(IF(types = 12, smoney, 0)) as t12,SUM(IF(types = 13, smoney, 0)) as t13,SUM(IF(types = 15, zmoney, 0)) as t15,SUM(IF(types = 16, zmoney, 0)) as t16,SUM(IF(types = 32, smoney, 0)) as t32 from ssc_record where adddate>='".$ccdatea."' and adddate<'".$ccdateb."' and (virtual is null or virtual<>'1') group by username";
//			echo $sqla;
			$rsa = mysql_query($sqla);
			while ($rowa = mysql_fetch_array($rsa)){
				$sqlb="select * from ssc_member where username='".$rowa['username']."'";
//				echo $sqlb;
				$rsb = mysql_query($sqlb);
				$rowb = mysql_fetch_array($rsb);

				$cmoney=floatval($rowa['t1']);//充值
				$tmoney=floatval($rowa['t2'])-floatval($rowa['t3']);//提现
				$gmoney=floatval($rowa['t7'])-floatval($rowa['t13']);//投注
				$fmoney=floatval($rowa['t11'])-floatval($rowa['t15']);
				$wmoney=floatval($rowa['t12'])-floatval($rowa['t16']);
				$hmoney=floatval($rowa['t32']);//活动
				$sqlb="insert into ssc_membert set username='".$rowa['username']."',level='".$rowb['level']."', cmoney='".$cmoney."', tmoney='".$tmoney."', gmoney='".$gmoney."', fmoney='".$fmoney."', wmoney='".$wmoney."', hmoney='".$hmoney."', ccdate='".$ccdate."', regup='".$rowb['regup']."',regfrom='".$rowb['regfrom']."',regtop='".$rowb['regtop']."'";
				$rsb = mysql_query($sqlb);
			}

		}else{
			echo "cancel";
		}
?>