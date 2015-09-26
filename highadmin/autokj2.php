<?php
session_start();
//error_reporting(0);
require_once 'conn.php';

//function autokj($na[0],$na[1],$na[2],$na[3],$na[4],$lid,$issue,$sign){
$sqly = "select * from ssc_config";
$rsy = mysql_query($sqly);
$rowy = mysql_fetch_array($rsy);
$gpprize=$rowy['gplimit'];
$dpprize=$rowy['dplimit'];

$sqlz = "select * from ssc_data2 where zt=0 order by issue asc limit 3";// or zt=2
$rsz = mysql_query($sqlz);
while ($rowz = mysql_fetch_array($rsz)){
	$na=explode(",",$rowz['code']);
	
	$lid=$rowz['cid'];
	$issue=$rowz['issue'];
	echo $issue."_".$lid;

	if($lid==11 || $lid==12){
		$maxprize=$dpprize;
	}else{
		$maxprize=$gpprize;
	}

//	if($rowz['zt']==2 and $rowz['sign']<2){
//		$sqlb="update ssc_data set sign=sign+1 where id ='".$rowz['id']."'";
//		$rsb=mysql_query($sqlb) or  die("数据库修改出错1");
//		exit;
//	}
	
//	if($rowz['zt']==2){
		$sign=1;
//	}else{
//		$sign=0;
//	}

	if($sign==1){
		$signa=1;
		$signb=2;
	}else{
		$signa=0;
		$signb=0;
	}
	
	if($lid==2 || $lid==3 || $lid==8 || $lid==9 || $lid==10){
		$kjcode=str_replace(","," ",$rowz['code']);
	}else{
		$kjcode=str_replace(",","",$rowz['code']);
	}

		$sqlb="select * from ssc_zdetail where lotteryid='".$lid."' and issue='".$issue."' and zt=0";
		$rsb = mysql_query($sqlb);
		while ($rowb = mysql_fetch_array($rsb)){
			$sqla = "update ssc_zbills set fnums=fnums+1, fmoney=fmoney+".$rowb['money']." where dan='".$rowb['dan']."'";
			$rsa = mysql_query($sqla);
		
			$sql = "select * from ssc_member where username='" . $rowb['username'] . "'";
			$rs = mysql_query($sql);
			$row = mysql_fetch_array($rs);
			$lmoney=$row['leftmoney'];

			$sstrb=$row['flevel'];
			$spoints=$sstrb/100;
		
//			if($rowb['mid']=="20" || $rowb['mid']=="21" || $rowb['mid']=="24" || $rowb['mid']=="25" || $rowb['mid']=="58" || $rowb['mid']=="59" || $rowb['mid']=="62" || $rowb['mid']=="63" || $rowb['mid']=="96" || $rowb['mid']=="97" || $rowb['mid']=="100" || $rowb['mid']=="101" || $rowb['mid']=="134" || $rowb['mid']=="135" || $rowb['mid']=="138" || $rowb['mid']=="139" || $rowb['mid']=="168" || $rowb['mid']=="169" || $rowb['mid']=="205" || $rowb['mid']=="206" || $rowb['mid']=="239" || $rowb['mid']=="240" || $rowb['mid']=="273" || $rowb['mid']=="274" || $rowb['mid']=="298" || $rowb['mid']=="299" || $rowb['mid']=="326" || $rowb['mid']=="327" || $rowb['mid']=="366" || $rowb['mid']=="367"){//point处理
//				$spoint=$spoints;
//			}else{
				$spoint=$rowb['point'];
//			}

			$sqla = "select id from ssc_record order by id desc limit 1";
			$rsa = mysql_query($sqla);
			$rowa = mysql_fetch_array($rsa);
			$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));//追号返款
			$sqla="insert into ssc_record set lotteryid='".$rowb['lotteryid']."', lottery='".$rowb['lottery']."', dan='".$dan1."', dan2='".$rowb['dan']."', uid='".$rowb['uid']."', username='".$rowb['username']."', issue='".$rowb['issue']."', types='10', mid='".$rowb['mid']."', mode='".$rowb['mode']."', smoney=".$rowb['money'].",leftmoney=".($lmoney+$rowb['money']).", cont='".$rowb['cont']."', regtop='".$rowb['regtop']."', regup='".$rowb['regup']."', regfrom='".$rowb['regfrom']."', adddate='".date("Y-m-d H:i:s")."',virtual='" .$rowb['virtual']. "'";
			$exe=mysql_query($sqla) or  die("数据库修改出错9!!!");

			$sqla = "select id from ssc_bills order by id desc limit 1";
			$rsa = mysql_query($sqla);
			$rowa = mysql_fetch_array($rsa);
			$dan2 = sprintf("%06s",strtoupper(base_convert($rowa['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));//转注单
						
			$sqla="INSERT INTO ssc_bills set lotteryid='".$rowb['lotteryid']."', lottery='".$rowb['lottery']."', dan='".$dan2."', dan1='".$rowb['dan']."', uid='".$rowb['uid']."', username='".$rowb['username']."', issue='".$rowb['issue']."', type='".$rowb['type']."', mid='".$rowb['mid']."',mname='".$rowb['mname']."', codes='".$rowb['codes']."', pos='".$rowb['pos']."', nums='".$rowb['nums']."', times='".$rowb['times']."', money='".$rowb['money']."', mode='".$rowb['mode']."', rates='".$rowb['rates']."', point='".$rowb['point']."', cont='".$rowb['cont']."', regtop='".$rowb['regtop']."', regup='".$rowb['regup']."', regfrom='".$rowb['regfrom']."', userip='".$rowb['userip']."', adddate='".date("Y-m-d H:i:s")."', canceldead='".$rowb['canceldead']."', autostop='".$rowb['autostop']."',virtual='" .$rowb['virtual']. "'";
			$exe=mysql_query($sqla) or  die("数据库修改出错10!!!!");
			
			$sqla = "update ssc_zdetail set danb='".$dan2."', zt=1 where id='".$rowb['id']."'";
			$rsa = mysql_query($sqla);
			
			$sqla = "select id from ssc_record order by id desc limit 1";
			$rsa = mysql_query($sqla);
			$rowa = mysql_fetch_array($rsa);
			$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));//投注扣款
			$sqla="insert into ssc_record set lotteryid='".$rowb['lotteryid']."', lottery='".$rowb['lottery']."', dan='".$dan1."', dan1='".$dan2."', dan2='".$rowb['dan']."', uid='".$rowb['uid']."', username='".$rowb['username']."', issue='".$rowb['issue']."', types='7', mid='".$rowb['mid']."', mode='".$rowb['mode']."', zmoney=".$rowb['money'].",leftmoney=".$lmoney.", cont='".$rowb['cont']."', regtop='".$rowb['regtop']."', regup='".$rowb['regup']."', regfrom='".$rowb['regfrom']."', adddate='".date("Y-m-d H:i:s")."',virtual='" .$rowb['virtual']. "'";
			$exe=mysql_query($sqla) or  die("数据库修改出错11!!!");
			
			if($spoint>0){
				$sqla = "select id from ssc_record order by id desc limit 1";
				$rsa = mysql_query($sqla);
				$rowa = mysql_fetch_array($rsa);
				$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));
				$sqla="insert into ssc_record set lotteryid='".$rowb['lotteryid']."', lottery='".$rowb['lottery']."', dan='".$dan1."', dan1='".$dan2."', dan2='".$rowb['dan']."', uid='".$rowb['uid']."', username='".$rowb['username']."', issue='".$rowb['issue']."', types='11', mid='".$rowb['mid']."', mode='".$rowb['mode']."', smoney=".$rowb['money']*$spoint.",leftmoney=".($lmoney+$rowb['money']*$spoint).", cont='".$rowb['cont']."', regtop='".$rowb['regtop']."', regup='".$rowb['regup']."', regfrom='".$rowb['regfrom']."', adddate='".date("Y-m-d H:i:s")."',virtual='" .$rowb['virtual']. "'";
				$exe=mysql_query($sqla) or  die("数据库修改出错4!!!");

				$sqla="update ssc_member set leftmoney=".($lmoney+$rowb['money']*$spoint)." where username='".$rowb['username']."'"; 
				$exe=mysql_query($sqla) or  die("数据库修改出错12!!!");
			}
		}
		mysql_free_result($rsb);
		
	$sql="select * from ssc_bills where lotteryid='".$lid."' and issue='".$issue."' and zt=0 order by id asc";
	$rs=mysql_query($sql) or  die("数据库修改出错1");
	while ($row = mysql_fetch_array($rs)){
		$mid=$row['mid'];
		if($row['mode']=="元"){
			$modes=1;
		}else if($row['mode']=="角"){
			$modes=0.1;
		}else if($row['mode']=="分"){
			$modes=0.01;
		}

		if($mid=="1" || $mid=="81" || $mid=="161" || $mid=="241" || $mid=="321" || $mid=="671"){//5星
			if($row['type']=="input"){//单式
				$cs=$na[0].$na[1].$na[2].$na[3].$na[4];
				$stra=explode("&",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$cs){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums.",zjnums='".$nums."' where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}
			}else if($row['type']=="digital"){//复式
				$stra=explode("|",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					$strb=explode("&",$stra[$i]);
					for ($ii=0; $ii<count($strb); $ii++) {
						if($strb[$ii]==$na[$i]){$nums=$nums+1;}
					}
				}
				if($nums==5){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times,zjnums=1 where id='".$row['id']."'");	
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");	
				}
			}
		}else if($mid=="2" || $mid=="82" || $mid=="162" || $mid=="242" || $mid=="322" || $mid=="672"){//五星组合
			$stra=explode("|",$row['codes']);
			$numa=0;
			$nums=0;
			for ($i=0; $i<count($stra); $i++) {
				$strb=explode("&",$stra[4-$i]);
				for ($ii=0; $ii<count($strb); $ii++) {
					if($strb[$ii]==$na[4-$i]){$numa=1;}
				}
				if($numa==1){
					$nums=$nums+1;
				}else{
					break;
				}
				$numa=0;
			}
			$rates=explode(";",Get_rate($mid));
			if($nums==1){
				$rate=$rates[4];
			}elseif($nums==2){
				$rate=$rates[4]+$rates[3];
			}elseif($nums==3){
				$rate=$rates[4]+$rates[3]+$rates[2];
			}elseif($nums==4){
				$rate=$rates[4]+$rates[3]+$rates[2]+$rates[1];
			}elseif($nums==5){
				$rate=$rates[4]+$rates[3]+$rates[2]+$rates[1]+$rates[0];
			}
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($rate*$modes)."*times,zjnums='".$nums."' where id='".$row['id']."'");	
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");	
			}
		}else if($mid=="4" || $mid=="84" || $mid=="164" || $mid=="244" || $mid=="324" || $mid=="674"){//五星组选120
			$nums=0;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2] || $stra[$i]==$na[3] || $stra[$i]==$na[4]){$nums=$nums+1;}
			}
			if($nums>=5){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times,zjnums=1 where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="5" || $mid=="85" || $mid=="165" || $mid=="245" || $mid=="325" || $mid=="675"){//五星组选60 2+1*3
			unset($nt);
			$stra=explode("|",$row['codes']);
			$numa=0;
			$numb=0;
			$strb=explode("&",$stra[0]);
			$nb=pnb($rowz['code']);
			for ($i=0; $i<count($strb); $i++) {
				if(($strb[$i]==$nb[0] && $strb[$i]==$nb[1]) || ($strb[$i]==$nb[1] && $strb[$i]==$nb[2]) || ($strb[$i]==$nb[2] && $strb[$i]==$nb[3]) || ($strb[$i]==$nb[3] && $strb[$i]==$nb[4])){$nt[$numa]=$strb[$i];$numa=$numa+1;}
			}
			$strc=explode("&",$stra[1]);
			for ($i=0; $i<count($strc); $i++) {
				if($strc[$i]==$na[0] || $strc[$i]==$na[1] || $strc[$i]==$na[2] || $strc[$i]==$na[3] || $strc[$i]==$na[4]){
					if(in_array($strc[$i],$nt)){
					}else{
						$numb=$numb+1;
					}
				}
			}
			if($numa==1 && $numb>=3){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times,zjnums=1 where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="6" || $mid=="86" || $mid=="166" || $mid=="246" || $mid=="326" || $mid=="676"){//五星组选30 2*2+1
			unset($nt);
			$stra=explode("|",$row['codes']);
			$numa=0;
			$numb=0;
			$strb=explode("&",$stra[0]);
			$nb=pnb($rowz['code']);
			for ($i=0; $i<count($strb); $i++) {
				if(($strb[$i]==$nb[0] && $strb[$i]==$nb[1]) || ($strb[$i]==$nb[1] && $strb[$i]==$nb[2]) || ($strb[$i]==$nb[2] && $strb[$i]==$nb[3]) || ($strb[$i]==$nb[3] && $strb[$i]==$nb[4])){$nt[$numa]=$strb[$i];$numa=$numa+1;}
			}
			$strc=explode("&",$stra[1]);
			for ($i=0; $i<count($strc); $i++) {
				if($strc[$i]==$na[0] || $strc[$i]==$na[1] || $strc[$i]==$na[2] || $strc[$i]==$na[3] || $strc[$i]==$na[4]){
					if(in_array($strc[$i],$nt)){
					}else{
						$numb=$numb+1;
					}
				}
			}
			if($numa>=2 && $numb>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times,zjnums=1 where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="7" || $mid=="87" || $mid=="167" || $mid=="247" || $mid=="327" || $mid=="677"){//五星组选20 3+1*2
			unset($nt);
			$stra=explode("|",$row['codes']);
			$numa=0;
			$numb=0;
			$strb=explode("&",$stra[0]);
			$nb=pnb($rowz['code']);
			for ($i=0; $i<count($strb); $i++) {
				if(($strb[$i]==$nb[0] && $strb[$i]==$nb[1] && $strb[$i]==$nb[2]) || ($strb[$i]==$nb[1] && $strb[$i]==$nb[2] && $strb[$i]==$nb[3]) || ($strb[$i]==$nb[2] && $strb[$i]==$nb[3] && $strb[$i]==$nb[4])){$nt[$numa]=$strb[$i];$numa=$numa+1;}
			}
			$strc=explode("&",$stra[1]);
			for ($i=0; $i<count($strc); $i++) {
				if($strc[$i]==$na[0] || $strc[$i]==$na[1] || $strc[$i]==$na[2] || $strc[$i]==$na[3] || $strc[$i]==$na[4]){
					if(in_array($strc[$i],$nt)){
					}else{
						$numb=$numb+1;
					}
				}
			}
			if($numa>=1 && $numb>=2){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times,zjnums=1 where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="8" || $mid=="88" || $mid=="168" || $mid=="248" || $mid=="328" || $mid=="678"){//五星组选10 3+2
			unset($nt);
			$stra=explode("|",$row['codes']);
			$numa=0;
			$numb=0;
			$strb=explode("&",$stra[0]);
			$nb=pnb($rowz['code']);
			for ($i=0; $i<count($strb); $i++) {
				if(($strb[$i]==$nb[0] && $strb[$i]==$nb[1] && $strb[$i]==$nb[2]) || ($strb[$i]==$nb[1] && $strb[$i]==$nb[2] && $strb[$i]==$nb[3]) || ($strb[$i]==$nb[2] && $strb[$i]==$nb[3] && $strb[$i]==$nb[4])){$nt[$numa]=$strb[$i];$numa=$numa+1;}
			}
			$strc=explode("&",$stra[1]);
			for ($i=0; $i<count($strc); $i++) {
				if(($strc[$i]==$nb[0] && $strc[$i]==$nb[1]) || ($strc[$i]==$nb[1] && $strc[$i]==$nb[2]) || ($strc[$i]==$nb[2] && $strc[$i]==$nb[3]) || ($strc[$i]==$nb[3] && $strc[$i]==$nb[4])){
					if(in_array($strc[$i],$nt)){
					}else{
						$numb=$numb+1;
					}
				}
			}
			if($numa>=1 && $numb>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times,zjnums=1 where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="9" || $mid=="89" || $mid=="169" || $mid=="249" || $mid=="329" || $mid=="679"){//五星组选5 4+1
			unset($nt);
			$stra=explode("|",$row['codes']);
			$numa=0;
			$numb=0;
			$strb=explode("&",$stra[0]);
			$nb=pnb($rowz['code']);
			for ($i=0; $i<count($strb); $i++) {
				if(($strb[$i]==$nb[0] && $strb[$i]==$nb[1] && $strb[$i]==$nb[2] && $strb[$i]==$nb[3]) || ($strb[$i]==$nb[1] && $strb[$i]==$nb[2] && $strb[$i]==$nb[3] && $strb[$i]==$nb[4])){$nt[$numa]=$strb[$i];$numa=$numa+1;}
			}
			$strc=explode("&",$stra[1]);
			for ($i=0; $i<count($strc); $i++) {
				if($strc[$i]==$na[0] || $strc[$i]==$na[1] || $strc[$i]==$na[2] || $strc[$i]==$na[3] || $strc[$i]==$na[4]){
					if(in_array($strc[$i],$nt)){
					}else{
						$numb=$numb+1;
					}
				}
			}
			if($numa>=1 && $numb>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times,zjnums=1 where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="11" || $mid=="91" || $mid=="171" || $mid=="251" || $mid=="331" || $mid=="681"){//任四直选
			if($row['type']=="input"){//单式
				$numa=0;
				$stra=explode("&",$row['codes']);
				$pos=explode(",",$row['pos']);
				for($i=0; $i<2; $i++) {
					if($pos[$i]==1){
						for($ii=$i+1;$ii<3;$ii++) {
							if($pos[$ii]==1){
								for($iii=$ii+1;$iii<4;$iii++) {
									if($pos[$iii]==1){
										for($iiii=$iii+1;$iiii<5;$iiii++) {
											if($pos[$iiii]==1){
												$cs=$na[$i].$na[$ii].$na[$iii].$na[$iiii];
												for ($k=0; $k<count($stra); $k++) {
													if($stra[$k]==$cs){$numa=$numa+1;}
												}
											}
										}
									}
								}
							}
						}
					}
				}
				if($numa>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa.",zjnums='".$numa."' where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}
			}else{		
				$stra=explode("|",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					$strb=explode("&",$stra[$i]);
					for ($ii=0; $ii<count($strb); $ii++) {
						if($strb[$ii]==$na[$i]){$nums=$nums+1;}
					}
				}
				if($nums==4){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times,zjnums=1 where id='".$row['id']."'");						
				}else if($nums==5){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*5,zjnums=5 where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="12" || $mid=="92" || $mid=="172" || $mid=="252" || $mid=="332" || $mid=="682"){//任四组合???
			$stra=explode("|",$row['codes']);
			$rates=explode(";",Get_rate($mid));
			$rate=0;
			$nums=0;
			for($i=0; $i<2; $i++) {
				for($ii=$i+1;$ii<3;$ii++) {
					for($iii=$ii+1;$iii<4;$iii++) {
						for($iiii=$iii+1;$iiii<5;$iiii++) {
							if(strpos($stra[$iiii],$na[$iiii])===false){
							}else{
								$nums=$nums+1;
								$rate=$rate+$rates[3];
								if(strpos($stra[$iii],$na[$iii])===false){
								}else{
									$nums=$nums+1;
									$rate=$rate+$rates[2];
									if(strpos($stra[$ii],$na[$ii])===false){
									}else{
										$nums=$nums+1;
										$rate=$rate+$rates[1];
										if(strpos($stra[$i],$na[$i])===false){
										}else{
											$nums=$nums+1;
											$rate=$rate+$rates[0];
										}
									}
								}
							}
						}
					}
				}
			}

			if($rate>0){
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($rate*$modes)."*times,zjnums='".$nums."' where id='".$row['id']."'");	
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");	
			}

		}else if($mid=="14" || $mid=="94" || $mid=="174" || $mid=="254" || $mid=="334" || $mid=="684"){//任四组选24
			$numa=0;
			$stra=explode("&",$row['codes']);
			$pos=explode(",",$row['pos']);
			for($i=0; $i<2; $i++) {
				if($pos[$i]==1){
					for($ii=$i+1;$ii<3;$ii++) {
						if($pos[$ii]==1){
							for($iii=$ii+1;$iii<4;$iii++) {
								if($pos[$iii]==1){
									for($iiii=$iii+1;$iiii<5;$iiii++) {
										if($pos[$iiii]==1){
											$nums=0;
											for ($j=0; $j<count($stra); $j++) {
												if($stra[$j]==$na[$i] || $stra[$j]==$na[$ii] || $stra[$j]==$na[$iii] || $stra[$j]==$na[$iiii]){$nums=$nums+1;}
											}
											if($nums>=4){$numa=$numa+1;}
										}
									}
								}
							}
						}
					}
				}
			}
			if($numa>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa.",zjnums='".$numa."' where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="15" || $mid=="95" || $mid=="175" || $mid=="255" || $mid=="335" || $mid=="685"){//任四组选12
			unset($nt);
			$nums=0;
			$stra=explode("|",$row['codes']);
			$pos=explode(",",$row['pos']);
			for($i=0; $i<2; $i++) {
				if($pos[$i]==1){
					for($ii=$i+1;$ii<3;$ii++) {
						if($pos[$ii]==1){
							for($iii=$ii+1;$iii<4;$iii++) {
								if($pos[$iii]==1){
									for($iiii=$iii+1;$iiii<5;$iiii++) {
										if($pos[$iiii]==1){
											$numa=0;
											$numb=0;
											$strb=explode("&",$stra[0]);
											$nb=pnb($na[$i].",".$na[$ii].",".$na[$iii].",".$na[$iiii]);
											for ($j=0; $j<count($strb); $j++) {
												if(($strb[$j]==$nb[0] && $strb[$j]==$nb[1]) || ($strb[$j]==$nb[1] && $strb[$j]==$nb[2]) || ($strb[$j]==$nb[2] && $strb[$j]==$nb[3])){$nt[$numa]=$strb[$j];$numa=$numa+1;}
											}
											$strc=explode("&",$stra[1]);
											for ($j=0; $j<count($strc); $j++) {
												if($strc[$j]==$na[$i] || $strc[$j]==$na[$ii] || $strc[$j]==$na[$iii] || $strc[$j]==$na[$iiii]){
													if(in_array($strc[$j],$nt)){
													}else{
														$numb=$numb+1;
													}
												}
											}
//											echo "t".$nb[0].$nb[1].$nb[2].$nb[3];
//											echo $numa.$numb;
											if($numa>=1 && $numb>=2){$nums=$nums+1;}
										}
									}
								}
							}
						}
					}
				}
			}
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums.",zjnums='".$nums."' where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="16" || $mid=="96" || $mid=="176" || $mid=="256" || $mid=="336" || $mid=="686"){//任四组选6
			$nums=0;
			$stra=explode("&",$row['codes']);
			$pos=explode(",",$row['pos']);
			for($i=0; $i<2; $i++) {
				if($pos[$i]==1){
					for($ii=$i+1;$ii<3;$ii++) {
						if($pos[$ii]==1){
							for($iii=$ii+1;$iii<4;$iii++) {
								if($pos[$iii]==1){
									for($iiii=$iii+1;$iiii<5;$iiii++) {
										if($pos[$iiii]==1){
											$numa=0;
											$nb=pnb($na[$i].",".$na[$ii].",".$na[$iii].",".$na[$iiii]);
											for ($j=0; $j<count($stra); $j++) {
												if(($stra[$j]==$nb[0] && $stra[$j]==$nb[1]) || ($stra[$j]==$nb[1] && $stra[$j]==$nb[2]) || ($stra[$j]==$nb[2] && $stra[$j]==$nb[3])){$numa=$numa+1;}
											}

											if($numa>=2){$nums=$nums+1;}
										}
									}
								}
							}
						}
					}
				}
			}
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums.",zjnums='".$nums."' where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="17" || $mid=="97" || $mid=="177" || $mid=="257" || $mid=="337" || $mid=="687"){//任四组选4
			unset($nt);
			$nums=0;
			$stra=explode("|",$row['codes']);
			$pos=explode(",",$row['pos']);
			for($i=0; $i<2; $i++) {
				if($pos[$i]==1){
					for($ii=$i+1;$ii<3;$ii++) {
						if($pos[$ii]==1){
							for($iii=$ii+1;$iii<4;$iii++) {
								if($pos[$iii]==1){
									for($iiii=$iii+1;$iiii<5;$iiii++) {
										if($pos[$iiii]==1){
											$numa=0;
											$numb=0;
											$strb=explode("&",$stra[0]);
											$nb=pnb($na[$i].",".$na[$ii].",".$na[$iii].",".$na[$iiii]);
											for ($j=0; $j<count($strb); $j++) {
												if(($strb[$j]==$nb[0] && $strb[$j]==$nb[1] && $strb[$j]==$nb[2]) || ($strb[$j]==$nb[1] && $strb[$j]==$nb[2] && $strb[$j]==$nb[3])){$nt[$numa]=$strb[$j];$numa=$numa+1;}
											}
											
											$strc=explode("&",$stra[1]);
											for ($j=0; $j<count($strc); $j++) {
												if($strc[$j]==$na[$i] || $strc[$j]==$na[$ii] || $strc[$j]==$na[$iii] || $strc[$j]==$na[$iiii]){
													if(in_array($strc[$j],$nt)){
													}else{
														$numb=$numb+1;
													}
												}
											}
											if($numa>=1 && $numb>=1){$nums=$nums+1;}
										}
									}
								}
							}
						}
					}
				}
			}
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums.",zjnums='".$nums."' where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="19" || $mid=="99" || $mid=="179" || $mid=="259" || $mid=="339" || $mid=="689"){//任三直选
			if($row['type']=="input"){//单式
				$numa=0;
				$stra=explode("&",$row['codes']);
				$pos=explode(",",$row['pos']);
				for($i=0; $i<3; $i++) {
					if($pos[$i]==1){
						for($ii=$i+1;$ii<4;$ii++) {
							if($pos[$ii]==1){
								for($iii=$ii+1;$iii<5;$iii++) {
									if($pos[$iii]==1){
										$cs=$na[$i].$na[$ii].$na[$iii];
										for ($k=0; $k<count($stra); $k++) {
											if($stra[$k]==$cs){$numa=$numa+1;}
										}
									}
								}
							}
						}
					}
				}
				if($numa>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa.",zjnums='".$numa."' where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}
			}else{
				$stra=explode("|",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					$strb=explode("&",$stra[$i]);
					for ($ii=0; $ii<count($strb); $ii++) {
						if($strb[$ii]==$na[$i]){$nums=$nums+1;}
					}
				}
				if($nums==3){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times,zjnums=1 where id='".$row['id']."'");						
				}else if($nums==4){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*4,zjnums=4 where id='".$row['id']."'");
				}else if($nums==5){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*10,zjnums=10 where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="20" || $mid=="100" || $mid=="180" || $mid=="260" || $mid=="340" || $mid=="690"){//任三直选和值
			$numa=0;
			$stra=explode("&",$row['codes']);
			$pos=explode(",",$row['pos']);
			for($i=0; $i<3; $i++) {
				if($pos[$i]==1){
					for($ii=$i+1;$ii<4;$ii++) {
						if($pos[$ii]==1){
							for($iii=$ii+1;$iii<5;$iii++) {
								if($pos[$iii]==1){
									$cs=$na[$i]+$na[$ii]+$na[$iii];
									for ($j=0; $j<count($stra); $j++) {
										if($stra[$j]==$cs){
											$numa=$numa+1;
											break;
										}
									}
								}
							}
						}
					}
				}
			}
			if($numa>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa.",zjnums='".$numa."' where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="21" || $mid=="101" || $mid=="181" || $mid=="261" || $mid=="341" || $mid=="691"){//任三跨度???
			$numa=0;
			$stra=explode("&",$row['codes']);
			$pos=explode(",",$row['pos']);
			for($i=0; $i<3; $i++) {
				if($pos[$i]==1){
					for($ii=$i+1;$ii<4;$ii++) {
						if($pos[$ii]==1){
							for($iii=$ii+1;$iii<5;$iii++) {
								if($pos[$iii]==1){
									$nb=pnb($na[$i].",".$na[$ii].",".$na[$iii]);
									$cs=abs($nb[2]-$nb[0]);
									for ($j=0; $j<count($stra); $j++) {
										if($stra[$j]==$cs){
											$numa=$numa+1;
											break;
										}
									}
								}
							}
						}
					}
				}
			}
			if($numa>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa.",zjnums='".$numa."' where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="22" || $mid=="102" || $mid=="182" || $mid=="262" || $mid=="342" || $mid=="692"){//任三组合
			$stra=explode("|",$row['codes']);
			$rates=explode(";",Get_rate($mid));
			$rate=0;
			$nums=0;
			for($i=0; $i<3; $i++) {
				for($ii=$i+1;$ii<4;$ii++) {
					for($iii=$ii+1;$iii<5;$iii++) {
						if(strpos($stra[$iii],$na[$iii])===false){
						}else{
							$nums=$nums+1;
							$rate=$rate+$rates[2];
							if(strpos($stra[$ii],$na[$ii])===false){
							}else{
								$nums=$nums+1;
								$rate=$rate+$rates[1];
								if(strpos($stra[$i],$na[$i])===false){
								}else{
									$nums=$nums+1;
									$rate=$rate+$rates[0];
								}
							}
						}
					}
				}
			}

			if($rate>0){
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($rate*$modes)."*times,zjnums='".$nums."' where id='".$row['id']."'");	
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");	
			}
		}else if($mid=="24" || $mid=="104" || $mid=="184" || $mid=="264" || $mid=="344" || $mid=="694"){//任三组选组三
			if($row['type']=="input"){//单式
				$numa=0;
				$stra=explode("&",$row['codes']);
				$pos=explode(",",$row['pos']);
				for($i=0; $i<3; $i++) {
					if($pos[$i]==1){
						for($ii=$i+1;$ii<4;$ii++) {
							if($pos[$ii]==1){
								for($iii=$ii+1;$iii<5;$iii++) {
									if($pos[$iii]==1){
										for ($k=0; $k<count($stra); $k++) {
											if($stra[$k]==$na[$i].$na[$ii].$na[$iii] || $stra[$k]==$na[$i].$na[$iii].$na[$ii] || $stra[$k]==$na[$ii].$na[$i].$na[$iii] || $stra[$k]==$na[$ii].$na[$iii].$na[$i] || $stra[$k]==$na[$iii].$na[$i].$na[$ii] || $stra[$k]==$na[$iii].$na[$ii].$na[$i]){$numa=$numa+1;}
										}
									}
								}
							}
						}
					}
				}
				if($numa>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa.",zjnums='".$numa."' where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}
			}else{		
				$numa=0;
				$stra=explode("&",$row['codes']);
				$pos=explode(",",$row['pos']);
				for($i=0; $i<3; $i++) {
					if($pos[$i]==1){
						for($ii=$i+1;$ii<4;$ii++) {
							if($pos[$ii]==1){
								for($iii=$ii+1;$iii<5;$iii++) {
									if($pos[$iii]==1){
										$nums=0;
										if($na[$i]==$na[$ii] || $na[$i]==$na[$iii] || $na[$ii]==$na[$iii]){
											for ($j=0; $j<count($stra); $j++) {
												if($stra[$j]==$na[$i] || $stra[$j]==$na[$ii] || $stra[$j]==$na[$iii]){$nums=$nums+1;}
											}
										}
										if($nums>=2){$numa=$numa+1;}
									}
								}
							}
						}
					}
				}
				if($numa>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa.",zjnums='".$numa."' where id='".$row['id']."'");		
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="25" || $mid=="105" || $mid=="185" || $mid=="265" || $mid=="345" || $mid=="695"){//任三组选组六
			if($row['type']=="input"){//单式
				$numa=0;
				$stra=explode("&",$row['codes']);
				$pos=explode(",",$row['pos']);
				for($i=0; $i<3; $i++) {
					if($pos[$i]==1){
						for($ii=$i+1;$ii<4;$ii++) {
							if($pos[$ii]==1){
								for($iii=$ii+1;$iii<5;$iii++) {
									if($pos[$iii]==1){
										for ($k=0; $k<count($stra); $k++) {
											if($stra[$k]==$na[$i].$na[$ii].$na[$iii] || $stra[$k]==$na[$i].$na[$iii].$na[$ii] || $stra[$k]==$na[$ii].$na[$i].$na[$iii] || $stra[$k]==$na[$ii].$na[$iii].$na[$i] || $stra[$k]==$na[$iii].$na[$i].$na[$ii] || $stra[$k]==$na[$iii].$na[$ii].$na[$i]){$numa=$numa+1;}
										}
									}
								}
							}
						}
					}
				}
				if($numa>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa.",zjnums='".$numa."' where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}
			}else{
				$numa=0;
				$stra=explode("&",$row['codes']);
				$pos=explode(",",$row['pos']);
				for($i=0; $i<3; $i++) {
					if($pos[$i]==1){
						for($ii=$i+1;$ii<4;$ii++) {
							if($pos[$ii]==1){
								for($iii=$ii+1;$iii<5;$iii++) {
									if($pos[$iii]==1){
										$nums=0;
										if($na[$i]!=$na[$ii] && $na[$i]!=$na[$iii] && $na[$ii]!=$na[$iii]){
											for ($j=0; $j<count($stra); $j++) {
												if($stra[$j]==$na[$i] || $stra[$j]==$na[$ii] || $stra[$j]==$na[$iii]){$nums=$nums+1;}
											}
										}
										if($nums>=3){$numa=$numa+1;}
									}
								}
							}
						}
					}
				}
				if($numa>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa.",zjnums='".$numa."' where id='".$row['id']."'");		
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="27" || $mid=="107" || $mid=="187" || $mid=="267" || $mid=="347" || $mid=="697"){//任三组选和值
			$numa=0;
			$nums=0;
			$rates=explode(";",Get_rate($mid));
			$stra=explode("&",$row['codes']);
			$pos=explode(",",$row['pos']);
			for($i=0; $i<3; $i++) {
				if($pos[$i]==1){
					for($ii=$i+1;$ii<4;$ii++) {
						if($pos[$ii]==1){
							for($iii=$ii+1;$iii<5;$iii++) {
								if($pos[$iii]==1){
									$cs=$na[$i]+$na[$ii]+$na[$iii];
									for ($j=0; $j<count($stra); $j++) {
										if($stra[$j]==$cs){
											if($na[$i]==$na[$ii] || $na[$i]==$na[$iii] || $na[$ii]==$na[$iii]){//组三
												$numa=$numa+$rates[0];
											}else{
												$numa=$numa+$rates[1];
											}
											$nums=$nums+1;
											break;
										}
									}
								}
							}
						}
					}
				}
			}
			if($numa>0){
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($numa*$modes)."*times,zjnums='".$nums."' where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="26" || $mid=="106" || $mid=="186" || $mid=="266" || $mid=="346" || $mid=="696"){//任三组选混合
			$numa=0;
			$nums=0;
			$rates=explode(";",Get_rate($mid));
			$stra=explode("&",$row['codes']);
			$pos=explode(",",$row['pos']);
			for($i=0; $i<3; $i++) {
				if($pos[$i]==1){
					for($ii=$i+1;$ii<4;$ii++) {
						if($pos[$ii]==1){
							for($iii=$ii+1;$iii<5;$iii++) {
								if($pos[$iii]==1){
									for ($k=0; $k<count($stra); $k++) {
										if($stra[$k]==$na[$i].$na[$ii].$na[$iii] || $stra[$k]==$na[$i].$na[$iii].$na[$ii] || $stra[$k]==$na[$ii].$na[$i].$na[$iii] || $stra[$k]==$na[$ii].$na[$iii].$na[$i] || $stra[$k]==$na[$iii].$na[$i].$na[$ii] || $stra[$k]==$na[$iii].$na[$ii].$na[$i]){
											if($na[$i]==$na[$ii] || $na[$i]==$na[$iii] || $na[$ii]==$na[$iii]){//组三
												$numa=$numa+$rates[0];
											}else{
												$numa=$numa+$rates[1];
											}
											$nums=$nums+1;
										}
									}
								}
							}
						}
					}
				}
			}
			if($numa>0){
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($numa*$modes)."*times,zjnums='".$nums."' where id='".$row['id']."'");									
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");					
			}
		}else if($mid=="28" || $mid=="108" || $mid=="188" || $mid=="268" || $mid=="348" || $mid=="698"){//任三组选包胆
			$numa=0;
			$nums=0;
			$rates=explode(";",Get_rate($mid));
			$stra=explode("&",$row['codes']);
			$pos=explode(",",$row['pos']);
			for($i=0; $i<3; $i++) {
				if($pos[$i]==1){
					for($ii=$i+1;$ii<4;$ii++) {
						if($pos[$ii]==1){
							for($iii=$ii+1;$iii<5;$iii++) {
								if($pos[$iii]==1){
									for ($j=0; $j<count($stra); $j++) {
										if($stra[$j]==$na[$i] || $stra[$j]==$na[$ii] || $stra[$j]==$na[$iii]){
											if($na[$i]==$na[$ii] || $na[$i]==$na[$iii] || $na[$ii]==$na[$iii]){//组三
												$numa=$numa+$rates[0];
											}else{
												$numa=$numa+$rates[1];
											}
											$nums=$nums+1;
											break;
										}
									}
								}
							}
						}
					}
				}
			}
			if($numa>0){
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($numa*$modes)."*times,zjnums='".$nums."' where id='".$row['id']."'");									
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");					
			}
		}else if($mid=="30" || $mid=="110" || $mid=="190" || $mid=="270" || $mid=="350" || $mid=="700"){//任三和值尾数
			$numa=0;
			$stra=explode("&",$row['codes']);
			$pos=explode(",",$row['pos']);
			for($i=0; $i<3; $i++) {
				if($pos[$i]==1){
					for($ii=$i+1;$ii<4;$ii++) {
						if($pos[$ii]==1){
							for($iii=$ii+1;$iii<5;$iii++) {
								if($pos[$iii]==1){
									$cs=($na[$i]+$na[$ii]+$na[$iii])%10;
									for ($j=0; $j<count($stra); $j++) {
										if($stra[$j]==$cs){
											$numa=$numa+1;
											break;
										}
									}
								}
							}
						}
					}
				}
			}
			if($numa>0){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa.",zjnums='".$numa."' where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="31" || $mid=="111" || $mid=="191" || $mid=="271" || $mid=="351" || $mid=="701"){//任三特殊号
			$numa=0;
			$nums=0;
			$rates=explode(";",Get_rate($mid));
			$stra=explode("&",$row['codes']);
			$pos=explode(",",$row['pos']);
			for($i=0; $i<3; $i++) {
				if($pos[$i]==1){
					for($ii=$i+1;$ii<4;$ii++) {
						if($pos[$ii]==1){
							for($iii=$ii+1;$iii<5;$iii++) {
								if($pos[$iii]==1){
									$na1="";
									$na2="";
									$na3="";
									if($na[$i]==$na[$ii] || $na[$ii]==$na[$iii] || $na[$i]==$na[$iii]){$na3="对子";}
									if($na[$i]==$na[$ii] && $na[$ii]==$na[$iii]){$na1="豹子";}
									$nb=pnb($na[$i].",".$na[$ii].",".$na[$iii]);
									if($nb[1]-$nb[0]==1 && $nb[2]-$nb[1]==1){$na2="顺子";}

									for ($j=0; $j<count($stra); $j++) {
										if($stra[$j]==$na1){
											$numa=$numa+$rates[0];
											$nums=$nums+1;
										}else if($stra[$j]==$na2){
											$numa=$numa+$rates[1];
											$nums=$nums+1;
										}else if($stra[$j]==$na3){
											$numa=$numa+$rates[2];
											$nums=$nums+1;
										}
									}
								}
							}
						}
					}
				}
			}
			if($numa>0){
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($numa*$modes)."*times,zjnums='".$nums."' where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="33" || $mid=="113" || $mid=="193" || $mid=="273" || $mid=="353" || $mid=="703"){//任二直选
			if($row['type']=="input"){//单式
				$numa=0;
				$stra=explode("&",$row['codes']);
				$pos=explode(",",$row['pos']);
				for($i=0; $i<4; $i++) {
					if($pos[$i]==1){
						for($ii=$i+1;$ii<5;$ii++) {
							if($pos[$ii]==1){
								$cs=$na[$i].$na[$ii];
								for ($k=0; $k<count($stra); $k++) {
									if($stra[$k]==$cs){$numa=$numa+1;}
								}
							}
						}
					}
				}
				if($numa>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa.",zjnums='".$numa."' where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}
			}else{
				$stra=explode("|",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					$strb=explode("&",$stra[$i]);
					for ($ii=0; $ii<count($strb); $ii++) {
						if($strb[$ii]==$na[$i]){$nums=$nums+1;}
					}
				}
				if($nums==2){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times,zjnums=1 where id='".$row['id']."'");						
				}else if($nums==3){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*3,zjnums=3 where id='".$row['id']."'");
				}else if($nums==4){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*6,zjnums=6 where id='".$row['id']."'");
				}else if($nums==5){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*10,zjnums=10 where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="34" || $mid=="114" || $mid=="194" || $mid=="274" || $mid=="354" || $mid=="704"){//任二直选和值
			$numa=0;
			$stra=explode("&",$row['codes']);
			$pos=explode(",",$row['pos']);
			for($i=0; $i<4; $i++) {
				if($pos[$i]==1){
					for($ii=$i+1;$ii<5;$ii++) {
						if($pos[$ii]==1){
							$cs=$na[$i]+$na[$ii];
							for ($j=0; $j<count($stra); $j++) {
								if($stra[$j]==$cs){
									$numa=$numa+1;
									break;
								}
							}
						}
					}
				}
			}
			if($numa>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa.",zjnums='".$numa."' where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="35" || $mid=="115" || $mid=="195" || $mid=="275" || $mid=="355" || $mid=="705"){//任二直选跨度
			$numa=0;
			$stra=explode("&",$row['codes']);
			$pos=explode(",",$row['pos']);
			for($i=0; $i<4; $i++) {
				if($pos[$i]==1){
					for($ii=$i+1;$ii<5;$ii++) {
						if($pos[$ii]==1){
							$cs=abs($na[$ii]-$na[$i]);
							for ($j=0; $j<count($stra); $j++) {
								if($stra[$j]==$cs){
									$numa=$numa+1;
									break;
								}
							}
						}
					}
				}
			}
			if($numa>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa.",zjnums='".$numa."' where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="37" || $mid=="117" || $mid=="197" || $mid=="277" || $mid=="357" || $mid=="707"){//任二组选
			if($row['type']=="input"){//单式
				$numa=0;
				$stra=explode("&",$row['codes']);
				$pos=explode(",",$row['pos']);
				for($i=0; $i<4; $i++) {
					if($pos[$i]==1){
						for($ii=$i+1;$ii<5;$ii++) {
							if($pos[$ii]==1){
								for ($k=0; $k<count($stra); $k++) {
									if($stra[$k]==$na[$i].$na[$ii] || $stra[$k]==$na[$ii].$na[$i]){$numa=$numa+1;}
								}
							}
						}
					}
				}
				if($numa>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa.",zjnums='".$numa."' where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}
			}else{
				$numa=0;
				$stra=explode("&",$row['codes']);
				$pos=explode(",",$row['pos']);
				for($i=0; $i<4; $i++) {
					if($pos[$i]==1){
						for($ii=$i+1;$ii<5;$ii++) {
							if($pos[$ii]==1){
								$nums=0;
								for ($j=0; $j<count($stra); $j++) {
									if($stra[$j]==$na[$i] || $stra[$j]==$na[$ii]){$nums=$nums+1;}
								}
								if($nums>=2){$numa=$numa+1;}
							}
						}
					}
				}
				if($numa>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa.",zjnums='".$numa."' where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="38" || $mid=="118" || $mid=="198" || $mid=="278" || $mid=="358" || $mid=="708"){//任二组选和值
			$numa=0;
			$stra=explode("&",$row['codes']);
			$pos=explode(",",$row['pos']);
			for($i=0; $i<4; $i++) {
				if($pos[$i]==1){
					for($ii=$i+1;$ii<5;$ii++) {
						if($pos[$ii]==1){
							$cs=$na[$i]+$na[$ii];
							for ($j=0; $j<count($stra); $j++) {
								if($stra[$j]==$cs){$numa=$numa+1;break;}
							}
						}
					}
				}
			}
			if($numa>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa.",zjnums='".$numa."' where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}		
		}else if($mid=="39" || $mid=="119" || $mid=="199" || $mid=="279" || $mid=="359" || $mid=="709"){//任二组选包胆
			$numa=0;
			$stra=explode("&",$row['codes']);
			$pos=explode(",",$row['pos']);
			for($i=0; $i<4; $i++) {
				if($pos[$i]==1){
					for($ii=$i+1;$ii<5;$ii++) {
						if($pos[$ii]==1){
							for ($j=0; $j<count($stra); $j++) {
								if($stra[$j]==$na[$i] || $stra[$j]==$na[$ii]){$numa=$numa+1;break;}
							}
						}
					}
				}
			}
			if($numa>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa.",zjnums='".$numa."' where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
			
		}else if($mid=="41" || $mid=="121" || $mid=="201" || $mid=="281" || $mid=="361" || $mid=="711"){//定位胆ok 170时时乐 585 3d 612 p3 
			$stra=explode("|",$row['codes']);
			$nums=0;
			for ($i=0; $i<count($stra); $i++) {
				$strb=explode("&",$stra[$i]);
				for ($ii=0; $ii<count($strb); $ii++) {
					if($strb[$ii]==$na[$i]){$nums=$nums+1;}
				}
			}
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums.",zjnums='".$nums."' where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="43" || $mid=="123" || $mid=="203" || $mid=="283" || $mid=="363" || $mid=="713"){//任三一码不定位???
			$numa=0;
			$stra=explode("&",$row['codes']);
			$pos=explode(",",$row['pos']);
			for($i=0; $i<3; $i++) {
				if($pos[$i]==1){
					for($ii=$i+1;$ii<4;$ii++) {
						if($pos[$ii]==1){
							for($iii=$ii+1;$iii<5;$iii++) {
								if($pos[$iii]==1){
									for ($j=0; $j<count($stra); $j++) {
										if($stra[$j]==$na[$i] || $stra[$j]==$na[$ii] || $stra[$j]==$na[$iii]){$numa=$numa+1;}
									}
								}
							}
						}
					}
				}
			}
			if($numa>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa.",zjnums='".$numa."' where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="44" || $mid=="124" || $mid=="204" || $mid=="284" || $mid=="364" || $mid=="714"){//任三二码不定位???
			$numa=0;
			$stra=explode("&",$row['codes']);
			$pos=explode(",",$row['pos']);
			for($i=0; $i<3; $i++) {
				if($pos[$i]==1){
					for($ii=$i+1;$ii<4;$ii++) {
						if($pos[$ii]==1){
							for($iii=$ii+1;$iii<5;$iii++) {
								if($pos[$iii]==1){
									$nums=0;
									for ($j=0; $j<count($stra); $j++) {
										if($stra[$j]==$na[$i] || $stra[$j]==$na[$ii] || $stra[$j]==$na[$iii]){
											$nums=$nums+1;
										}
									}
									if($nums>=2){
										$numa=$numa+$nums*($nums-1)/2;
									}
								}
							}
						}
					}
				}
			}
			if($numa>0){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa.",zjnums='".$numa."' where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="45" || $mid=="125" || $mid=="205" || $mid=="285" || $mid=="365" || $mid=="715"){//任四一码不定位???
			$numa=0;
			$stra=explode("&",$row['codes']);
			$pos=explode(",",$row['pos']);
			for($i=0; $i<2; $i++) {
				if($pos[$i]==1){
					for($ii=$i+1;$ii<3;$ii++) {
						if($pos[$ii]==1){
							for($iii=$ii+1;$iii<4;$iii++) {
								if($pos[$iii]==1){
									for($iiii=$iii+1;$iiii<5;$iiii++) {
										if($pos[$iiii]==1){
											for ($j=0; $j<count($stra); $j++) {
												if($stra[$j]==$na[$i] || $stra[$j]==$na[$ii] || $stra[$j]==$na[$iii] || $stra[$j]==$na[$iiii]){
													$numa=$numa+1;
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}						
										
			if($numa>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa.",zjnums='".$numa."' where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="46" || $mid=="126" || $mid=="206" || $mid=="286" || $mid=="366" || $mid=="716"){//任四二码不定位???
			$numa=0;
			$stra=explode("&",$row['codes']);
			$pos=explode(",",$row['pos']);
			for($i=0; $i<2; $i++) {
				if($pos[$i]==1){
					for($ii=$i+1;$ii<3;$ii++) {
						if($pos[$ii]==1){
							for($iii=$ii+1;$iii<4;$iii++) {
								if($pos[$iii]==1){
									for($iiii=$iii+1;$iiii<5;$iiii++) {
										if($pos[$iiii]==1){
											$nums=0;
											for ($j=0; $j<count($stra); $j++) {
												if($stra[$j]==$na[$i] || $stra[$j]==$na[$ii] || $stra[$j]==$na[$iii] || $stra[$j]==$na[$iiii]){
													$nums=$nums+1;
												}
											}
											if($nums>=2){
												$numa=$numa+$nums*($nums-1)/2;
											}
										}
									}
								}
							}
						}
					}
				}
			}						
			if($numa>0){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa.",zjnums='".$numa."' where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="47" || $mid=="127" || $mid=="207" || $mid=="287" || $mid=="367" || $mid=="717"){//五星二码不定位ok
			$nums=0;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2] || $stra[$i]==$na[3] || $stra[$i]==$na[4]){$nums=$nums+1;}
			}
			if($nums==2){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times,zjnums=1 where id='".$row['id']."'");						
			}else if($nums==3){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*3,zjnums=3 where id='".$row['id']."'");						
			}else if($nums==4){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*6,zjnums=6 where id='".$row['id']."'");						
			}else if($nums==5){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*10,zjnums=10 where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="48" || $mid=="128" || $mid=="208" || $mid=="288" || $mid=="368" || $mid=="718"){//五星三码不定位ok
			$nums=0;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2] || $stra[$i]==$na[3] || $stra[$i]==$na[4]){$nums=$nums+1;}
			}
			if($nums==3){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times,zjnums=1 where id='".$row['id']."'");						
			}else if($nums==4){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*4,zjnums=4 where id='".$row['id']."'");
			}else if($nums==5){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*10,zjnums=10 where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
			}
		}else if($mid=="50" || $mid=="130" || $mid=="210" || $mid=="290" || $mid=="370" || $mid=="720"){//任二大小单双 
			$numa=0;
			$stra=explode("|",$row['codes']);
			$pos=explode(",",$row['pos']);
			for($i=0; $i<4; $i++) {
				if($pos[$i]==1){
					for($ii=$i+1;$ii<5;$ii++) {
						if($pos[$ii]==1){
							$numb=0;
							$numc=0;
							if($na[$i]>4){$na1a="大";}else{$na1a="小";}
							if ($na[$i]%2==1){$na1b="单";}else{$na1b="双";}
							if($na[$ii]>4){$na2a="大";}else{$na2a="小";}
							if ($na[$ii]%2==1){$na2b="单";}else{$na2b="双";}
							$strb=explode("&",$stra[0]);
							for ($j=0; $j<count($strb); $j++) {
								if($strb[$j]==$na1a || $strb[$j]==$na1b){$numb=$numb+1;}
							}
							$strb=explode("&",$stra[1]);
							for ($j=0; $j<count($strb); $j++) {
								if($strb[$j]==$na2a || $strb[$j]==$na2b){$numc=$numc+1;}
							}
							$numa=$numa+$numb*$numc;
						}
					}
				}
			}
			if($numa>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa.",zjnums='".$numa."' where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="51" || $mid=="131" || $mid=="211" || $mid=="291" || $mid=="371" || $mid=="721"){//任三大小单双 179时时乐 309 3d 335 p3
			$numa=0;
			$stra=explode("|",$row['codes']);
			$pos=explode(",",$row['pos']);
			for($i=0; $i<3; $i++) {
				if($pos[$i]==1){
					for($ii=$i+1;$ii<4;$ii++) {
						if($pos[$ii]==1){
							for($iii=$ii+1;$iii<5;$iii++) {
								if($pos[$iii]==1){
									$numb=0;
									$numc=0;
									$numd=0;
									if($na[$i]>4){$na1a="大";}else{$na1a="小";}
									if ($na[$i]%2==1){$na1b="单";}else{$na1b="双";}
									if($na[$ii]>4){$na2a="大";}else{$na2a="小";}
									if ($na[$ii]%2==1){$na2b="单";}else{$na2b="双";}
									if($na[$iii]>4){$na3a="大";}else{$na3a="小";}
									if ($na[$iii]%2==1){$na3b="单";}else{$na3b="双";}
									$strb=explode("&",$stra[0]);
									for ($j=0; $j<count($strb); $j++) {
										if($strb[$j]==$na1a || $strb[$j]==$na1b){$numb=$numb+1;}
									}
									$strb=explode("&",$stra[1]);
									for ($j=0; $j<count($strb); $j++) {
										if($strb[$j]==$na2a || $strb[$j]==$na2b){$numc=$numc+1;}
									}
									$strb=explode("&",$stra[2]);
									for ($j=0; $j<count($strb); $j++) {
										if($strb[$j]==$na3a || $strb[$j]==$na3b){$numd=$numd+1;}
									}
									$numa=$numb*$numc*$numd;
								}
							}
						}
					}
				}
			}
			if($numa>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa.",zjnums='".$numa."' where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="53" || $mid=="133" || $mid=="213" || $mid=="293" || $mid=="373" || $mid=="723"){//五码趣味三星
			$numa=0;
			$numb=0;
			$rates=explode(";",Get_rate($mid));
			if($na[0]>4){$na1a="大(5-9)";}else{$na1a="小(0-4)";}
			if($na[1]>4){$na2a="大(5-9)";}else{$na2a="小(0-4)";}
			$stra=explode("|",$row['codes']);
			$strb=explode("&",$stra[0]);
			for ($j=0; $j<count($strb); $j++) {
				if($strb[$j]==$na1a){$numa=1;}
			}
			$strb=explode("&",$stra[1]);
			for ($j=0; $j<count($strb); $j++) {
				if($strb[$j]==$na2a){$numa=$numa+1;}
			}			
			for ($i=1; $i<count($stra); $i++) {
				$strb=explode("&",$stra[$i]);
				for ($ii=0; $ii<count($strb); $ii++) {
					if($strb[$ii]==$na[$i]){$numb=$numb+1;}
				}
			}
			if($numb==3){
				if($numa==2){
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[0]*$modes)."*times,zjnums=1 where id='".$row['id']."'");	
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[1]*$modes)."*times,zjnums=1 where id='".$row['id']."'");	
				}
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="54" || $mid=="134" || $mid=="214" || $mid=="294" || $mid=="374" || $mid=="724"){//四码趣味三星
			$numa=0;
			$numb=0;
			$rates=explode(";",Get_rate($mid));
			if($na[1]>4){$na1a="大(5-9)";}else{$na1a="小(0-4)";}
			$stra=explode("|",$row['codes']);
			$strb=explode("&",$stra[0]);
			for ($j=0; $j<count($strb); $j++) {
				if($strb[$j]==$na1a){$numa=1;}
			}
			for ($i=1; $i<count($stra); $i++) {
				$strb=explode("&",$stra[$i]);
				for ($ii=0; $ii<count($strb); $ii++) {
					if($strb[$ii]==$na[$i+1]){$numb=$numb+1;}
				}
			}
			if($numb==3){
				if($numa==1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[0]*$modes)."*times,zjnums=1 where id='".$row['id']."'");	
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[1]*$modes)."*times,zjnums=1 where id='".$row['id']."'");	
				}
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="55" || $mid=="135" || $mid=="215" || $mid=="295" || $mid=="375" || $mid=="725"){//前三趣味二星
			$numa=0;
			$numb=0;
			$rates=explode(";",Get_rate($mid));
			if($na[0]>4){$na1a="大(5-9)";}else{$na1a="小(0-4)";}
			$stra=explode("|",$row['codes']);
			$strb=explode("&",$stra[0]);
			for ($j=0; $j<count($strb); $j++) {
				if($strb[$j]==$na1a){$numa=1;}
			}
			for ($i=1; $i<count($stra); $i++) {
				$strb=explode("&",$stra[$i]);
				for ($ii=0; $ii<count($strb); $ii++) {
					if($strb[$ii]==$na[$i]){$numb=$numb+1;}
				}
			}
			if($numb==2){
				if($numa==1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[0]*$modes)."*times,zjnums=1 where id='".$row['id']."'");	
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[1]*$modes)."*times,zjnums=1 where id='".$row['id']."'");	
				}
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="56" || $mid=="136" || $mid=="216" || $mid=="296" || $mid=="376" || $mid=="726"){//中三趣味二星
			$numa=0;
			$numb=0;
			$rates=explode(";",Get_rate($mid));
			if($na[1]>4){$na1a="大(5-9)";}else{$na1a="小(0-4)";}
			$stra=explode("|",$row['codes']);
			$strb=explode("&",$stra[0]);
			for ($j=0; $j<count($strb); $j++) {
				if($strb[$j]==$na1a){$numa=1;}
			}
			for ($i=1; $i<count($stra); $i++) {
				$strb=explode("&",$stra[$i]);
				for ($ii=0; $ii<count($strb); $ii++) {
					if($strb[$ii]==$na[$i+1]){$numb=$numb+1;}
				}
			}
			if($numb==2){
				if($numa==1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[0]*$modes)."*times,zjnums=1 where id='".$row['id']."'");	
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[1]*$modes)."*times,zjnums=1 where id='".$row['id']."'");	
				}
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="57" || $mid=="137" || $mid=="217" || $mid=="297" || $mid=="377" || $mid=="727"){//后三趣味二星
			$numa=0;
			$numb=0;
			$rates=explode(";",Get_rate($mid));
			if($na[2]>4){$na1a="大(5-9)";}else{$na1a="小(0-4)";}
			$stra=explode("|",$row['codes']);
			$strb=explode("&",$stra[0]);
			for ($j=0; $j<count($strb); $j++) {
				if($strb[$j]==$na1a){$numa=1;}
			}
			for ($i=1; $i<count($stra); $i++) {
				$strb=explode("&",$stra[$i]);
				for ($ii=0; $ii<count($strb); $ii++) {
					if($strb[$ii]==$na[$i+2]){$numb=$numb+1;}
				}
			}
			if($numb==2){
				if($numa==1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[0]*$modes)."*times,zjnums=1 where id='".$row['id']."'");	
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[1]*$modes)."*times,zjnums=1 where id='".$row['id']."'");	
				}
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="58" || $mid=="138" || $mid=="218" || $mid=="298" || $mid=="378" || $mid=="728"){//五码区间三星
			$numa=0;
			$numb=0;
			$rates=explode(";",Get_rate($mid));
			if($na[0]>7){$na1a="五区(8,9)";}
			elseif($na[0]>5){$na1a="四区(6,7)";}
			elseif($na[0]>3){$na1a="三区(4,5)";}
			elseif($na[0]>1){$na1a="二区(2,3)";}
			else{$na1a="一区(0,1)";}
			if($na[1]>7){$na2a="五区(8,9)";}
			elseif($na[1]>5){$na2a="四区(6,7)";}
			elseif($na[1]>3){$na2a="三区(4,5)";}
			elseif($na[1]>1){$na2a="二区(2,3)";}
			else{$na2a="一区(0,1)";}
			$stra=explode("|",$row['codes']);
			$strb=explode("&",$stra[0]);
			for ($j=0; $j<count($strb); $j++) {
				if($strb[$j]==$na1a){$numa=1;}
			}
			$strb=explode("&",$stra[1]);
			for ($j=0; $j<count($strb); $j++) {
				if($strb[$j]==$na2a){$numa=$numa+1;}
			}			
			for ($i=1; $i<count($stra); $i++) {
				$strb=explode("&",$stra[$i]);
				for ($ii=0; $ii<count($strb); $ii++) {
					if($strb[$ii]==$na[$i]){$numb=$numb+1;}
				}
			}
			if($numb==3){
				if($numa==2){
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[0]*$modes)."*times,zjnums=1 where id='".$row['id']."'");	
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[1]*$modes)."*times,zjnums=1 where id='".$row['id']."'");	
				}
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="59" || $mid=="139" || $mid=="219" || $mid=="299" || $mid=="379" || $mid=="729"){//四码区间三星
			$numa=0;
			$numb=0;
			$rates=explode(";",Get_rate($mid));
			if($na[1]>7){$na1a="五区(8,9)";}
			elseif($na[1]>5){$na1a="四区(6,7)";}
			elseif($na[1]>3){$na1a="三区(4,5)";}
			elseif($na[1]>1){$na1a="二区(2,3)";}
			else{$na1a="一区(0,1)";}
			$stra=explode("|",$row['codes']);
			$strb=explode("&",$stra[0]);
			for ($j=0; $j<count($strb); $j++) {
				if($strb[$j]==$na1a){$numa=1;}
			}
			for ($i=1; $i<count($stra); $i++) {
				$strb=explode("&",$stra[$i]);
				for ($ii=0; $ii<count($strb); $ii++) {
					if($strb[$ii]==$na[$i+1]){$numb=$numb+1;}
				}
			}
			if($numb==3){
				if($numa==1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[0]*$modes)."*times,zjnums=1 where id='".$row['id']."'");	
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[1]*$modes)."*times,zjnums=1 where id='".$row['id']."'");	
				}
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="60" || $mid=="140" || $mid=="220" || $mid=="300" || $mid=="380" || $mid=="730"){//前三区间二星
			$numa=0;
			$numb=0;
			$rates=explode(";",Get_rate($mid));
			if($na[0]>7){$na1a="五区(8,9)";}
			elseif($na[0]>5){$na1a="四区(6,7)";}
			elseif($na[0]>3){$na1a="三区(4,5)";}
			elseif($na[0]>1){$na1a="二区(2,3)";}
			else{$na1a="一区(0,1)";}
			$stra=explode("|",$row['codes']);
			$strb=explode("&",$stra[0]);
			for ($j=0; $j<count($strb); $j++) {
				if($strb[$j]==$na1a){$numa=1;}
			}
			for ($i=1; $i<count($stra); $i++) {
				$strb=explode("&",$stra[$i]);
				for ($ii=0; $ii<count($strb); $ii++) {
					if($strb[$ii]==$na[$i]){$numb=$numb+1;}
				}
			}
			if($numb==2){
				if($numa==1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[0]*$modes)."*times,zjnums=1 where id='".$row['id']."'");	
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[1]*$modes)."*times,zjnums=1 where id='".$row['id']."'");	
				}
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="61" || $mid=="141" || $mid=="221" || $mid=="301" || $mid=="381" || $mid=="731"){//中三区间二星
			$numa=0;
			$numb=0;
			$rates=explode(";",Get_rate($mid));
			if($na[1]>7){$na1a="五区(8,9)";}
			elseif($na[1]>5){$na1a="四区(6,7)";}
			elseif($na[1]>3){$na1a="三区(4,5)";}
			elseif($na[1]>1){$na1a="二区(2,3)";}
			else{$na1a="一区(0,1)";}
			$stra=explode("|",$row['codes']);
			$strb=explode("&",$stra[0]);
			for ($j=0; $j<count($strb); $j++) {
				if($strb[$j]==$na1a){$numa=1;}
			}
			for ($i=1; $i<count($stra); $i++) {
				$strb=explode("&",$stra[$i]);
				for ($ii=0; $ii<count($strb); $ii++) {
					if($strb[$ii]==$na[$i+1]){$numb=$numb+1;}
				}
			}
			if($numb==2){
				if($numa==1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[0]*$modes)."*times,zjnums=1 where id='".$row['id']."'");	
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[1]*$modes)."*times,zjnums=1 where id='".$row['id']."'");	
				}
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="62" || $mid=="142" || $mid=="222" || $mid=="302" || $mid=="382" || $mid=="732"){//后三区间二星
			$numa=0;
			$numb=0;
			$rates=explode(";",Get_rate($mid));
			if($na[2]>7){$na1a="五区(8,9)";}
			elseif($na[2]>5){$na1a="四区(6,7)";}
			elseif($na[2]>3){$na1a="三区(4,5)";}
			elseif($na[2]>1){$na1a="二区(2,3)";}
			else{$na1a="一区(0,1)";}
			$stra=explode("|",$row['codes']);
			$strb=explode("&",$stra[0]);
			for ($j=0; $j<count($strb); $j++) {
				if($strb[$j]==$na1a){$numa=1;}
			}
			for ($i=1; $i<count($stra); $i++) {
				$strb=explode("&",$stra[$i]);
				for ($ii=0; $ii<count($strb); $ii++) {
					if($strb[$ii]==$na[$i+2]){$numb=$numb+1;}
				}
			}
			if($numb==2){
				if($numa==1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[0]*$modes)."*times,zjnums=1 where id='".$row['id']."'");	
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[1]*$modes)."*times,zjnums=1 where id='".$row['id']."'");	
				}
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="64" || $mid=="144" || $mid=="224" || $mid=="304" || $mid=="384" || $mid=="734"){//一帆风顺
			$stra=explode("&",$row['codes']);
			$numa=0;
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2] || $stra[$i]==$na[3] || $stra[$i]==$na[4]){$numa=$numa+1;}
			}
			if($numa>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa.",zjnums='".$numa."' where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="65" || $mid=="145" || $mid=="225" || $mid=="305" || $mid=="385" || $mid=="735"){//好事成双
			$stra=explode("&",$row['codes']);
			$numa=0;
			$nb=pnb($rowz['code']);
			for ($i=0; $i<count($stra); $i++) {
				if(($stra[$i]==$nb[0] && $stra[$i]==$nb[1]) || ($stra[$i]==$nb[1] && $stra[$i]==$nb[2]) || ($stra[$i]==$nb[2] && $stra[$i]==$nb[3]) || ($stra[$i]==$nb[3] && $stra[$i]==$nb[4])){$numa=$numa+1;}
			}
			if($numa>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa.",zjnums='".$numa."' where id='".$row['id']."'");
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="66" || $mid=="146" || $mid=="226" || $mid=="306" || $mid=="386" || $mid=="736"){//三星报喜
			$stra=explode("&",$row['codes']);
			$numa=0;
			$nb=pnb($rowz['code']);
			for ($i=0; $i<count($stra); $i++) {
				if(($stra[$i]==$nb[0] && $stra[$i]==$nb[1] && $stra[$i]==$nb[2]) || ($stra[$i]==$nb[1] && $stra[$i]==$nb[2] && $stra[$i]==$nb[3]) || ($stra[$i]==$nb[2] && $stra[$i]==$nb[3] && $stra[$i]==$nb[4])){$numa=$numa+1;}
			}
			if($numa>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa.",zjnums='".$numa."' where id='".$row['id']."'");
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="67" || $mid=="147" || $mid=="227" || $mid=="307" || $mid=="387" || $mid=="737"){//四季发财
			$stra=explode("&",$row['codes']);
			$numa=0;
			$nb=pnb($rowz['code']);
			for ($i=0; $i<count($stra); $i++) {
				if(($stra[$i]==$nb[0] && $stra[$i]==$nb[1] && $stra[$i]==$nb[2] && $stra[$i]==$nb[3]) || ($stra[$i]==$nb[1] && $stra[$i]==$nb[2] && $stra[$i]==$nb[3] && $stra[$i]==$nb[4])){$numa=$numa+1;}
			}
			if($numa>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa.",zjnums='".$numa."' where id='".$row['id']."'");
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="69" || $mid=="149" || $mid=="229" || $mid=="309" || $mid=="389" || $mid=="739"){//五星胆码
			$numa=0;
			$numb=0;
			$nb=pnb($rowz['code']);
			$stra=explode("|",$row['codes']);
			$nums=$na[0]+$na[1]+$na[2]+$na[3]+$na[4];
			
			$strb=explode("&",$stra[0]);
			for ($i=0; $i<count($strb); $i++) {
				if($strb[$i]==$na[0] || $strb[$i]==$na[1] || $strb[$i]==$na[2] || $strb[$i]==$na[3] || $strb[$i]==$na[4]){
					$numb=$numb+1;
				}
			}
			if($numb>0){
				if($stra[1]<>""){
					$strb=explode("-",$stra[1]);
					if($numb>=$strb[0] && $numb<=$strb[1]){
						$numa=$numa+1;
					}
				}else{
					$numa=$numa+1;
				}
				if($stra[2]<>"" && $numa==1){//跨度
					$strb=explode("&",$stra[2]);
					for ($i=0; $i<count($strb); $i++) {
						if($strb[$i]==$nb[4]-$nb[0]){
							$numa=$numa+1;
							break;
						}
					}
				}else{
					$numa=$numa+1;
				}
				if($stra[3]<>"" && $numa==2){
					$strb=explode("&",$stra[3]);
					for ($i=0; $i<count($strb); $i++) {
						if($strb[$i]==$nums % 10){
							$numa=$numa+1;
							break;
						}
					}
				}else{
					$numa=$numa+1;
				}
				if($stra[4]<>"" && $numa==3){
					$strb=explode("&",$stra[4]);
					for ($i=0; $i<count($strb); $i++) {
						$strc=explode("-",$strb[$i]);
						if($nums>=$strc[0] && $nums<=$strc[1]){
							$numa=$numa+1;
							break;
						}
					}
				}else{
					$numa=$numa+1;
				}
				if($stra[5]<>"" && $numa==4){
					$strb=explode("&",$stra[5]);
					$nums=0;
					if($na[0]%2==1){$nums++;}
					if($na[1]%2==1){$nums++;}
					if($na[2]%2==1){$nums++;}
					if($na[3]%2==1){$nums++;}
					if($na[4]%2==1){$nums++;}
					for ($i=0; $i<count($strb); $i++) {
						if($strb[$i]==$nums.":".(5-$nums)){
							$numa=$numa+1;
							break;
						}
					}
				}else{
					$numa=$numa+1;
				}
				if($stra[6]<>"" && $numa==5){
					$strb=explode("&",$stra[6]);
					$nums=0;
					if($na[0]>=5){$nums++;}
					if($na[1]>=5){$nums++;}
					if($na[2]>=5){$nums++;}
					if($na[3]>=5){$nums++;}
					if($na[4]>=5){$nums++;}
					for ($i=0; $i<count($strb); $i++) {
						if($strb[$i]==$nums.":".(5-$nums)){
							$numa=$numa+1;
							break;
						}
					}
				}else{
					$numa=$numa+1;
				}
				if($stra[7]<>"" && $numa==6){
					$strb=explode("&",$stra[7]);
					if($nb[0]==$nb[3] || $nb[1]==$nb[4]){
						$strc="组选5";
					}else{
						if(($nb[0]==$nb[2] && $nb[3]==$nb[4]) || ($nb[0]==$nb[1] && $nb[2]==$nb[4])){
							$strc="组选10";
						}else{
							if(($nb[0]==$nb[2] && $nb[3]!=$nb[4]) || ($nb[0]!=$nb[1] && $nb[2]==$nb[4]) || $nb[1]==$nb[3]){
								$strc="组选20";
							}else{
								if(($nb[0]==$nb[1] && $nb[2]==$nb[3]) || ($nb[0]==$nb[1] && $nb[2]==$nb[4]) || ($nb[0]==$nb[1] && $nb[3]==$nb[4]) || ($nb[0]==$nb[2] && $nb[3]==$nb[4]) || ($nb[1]==$nb[2] && $nb[3]==$nb[4])){
									$strc="组选30";
								}else{
								if($nb[0]==$nb[1] || $nb[1]==$nb[2] || $nb[2]==$nb[3] || $nb[3]==$nb[4]){
										$strc="组选60";
									}else{
										$strc="组选120";
									}
								}
							}
						}
					}
					for ($i=0; $i<count($strb); $i++) {
						if($strb[$i]==$strc){
							$numa=$numa+1;
							break;
						}
					}
				}else{
					$numa=$numa+1;
				}
			}
			if($numa>=7){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times,zjnums=1 where id='".$row['id']."'");
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="70" || $mid=="150" || $mid=="230" || $mid=="310" || $mid=="390" || $mid=="740"){//任四胆码
			$numc=0;
			$stra=explode("|",$row['codes']);
			$pos=explode(",",$row['pos']);
			for($i=0; $i<2; $i++) {
				if($pos[$i]==1){
					for($ii=$i+1;$ii<3;$ii++) {
						if($pos[$ii]==1){
							for($iii=$ii+1;$iii<4;$iii++) {
								if($pos[$iii]==1){
									for($iiii=$iii+1;$iiii<5;$iiii++) {
										if($pos[$iiii]==1){
											$numa=0;
											$numb=0;
											$nb=pnb($na[$i].",".$na[$ii].",".$na[$iii].",".$na[$iiii]);
											$nums=$na[$i]+$na[$ii]+$na[$iii]+$na[$iiii];
											
											$strb=explode("&",$stra[0]);
											for ($j=0; $j<count($strb); $j++) {
												if($strb[$j]==$na[$i] || $strb[$j]==$na[$ii] || $strb[$j]==$na[$iii] || $strb[$j]==$na[$iiii]){
													$numb=$numb+1;
												}
											}
											if($numb>0){
												if($stra[1]<>""){
													$strb=explode("-",$stra[1]);
													if($numb>=$strb[0] && $numb<=$strb[1]){
														$numa=$numa+1;
													}
												}else{
													$numa=$numa+1;
												}
												if($stra[2]<>"" && $numa==1){//跨度
													$strb=explode("&",$stra[2]);
													for ($j=0; $j<count($strb); $j++) {
														if($strb[$j]==$nb[3]-$nb[0]){
															$numa=$numa+1;
															break;
														}
													}
												}else{
													$numa=$numa+1;
												}
												if($stra[3]<>"" && $numa==2){
													$strb=explode("&",$stra[3]);
													for ($j=0; $j<count($strb); $j++) {
														if($strb[$j]==$nums % 10){
															$numa=$numa+1;
															break;
														}
													}
												}else{
													$numa=$numa+1;
												}
												if($stra[4]<>"" && $numa==3){
													$strb=explode("&",$stra[4]);
													for ($j=0; $j<count($strb); $j++) {
														$strc=explode("-",$strb[$j]);
														if($nums>=$strc[0] && $nums<=$strc[1]){
															$numa=$numa+1;
															break;
														}
													}
												}else{
													$numa=$numa+1;
												}
												if($stra[5]<>"" && $numa==4){
													$strb=explode("&",$stra[5]);
													$nums=0;
													if($na[$i]%2==1){$nums++;}
													if($na[$ii]%2==1){$nums++;}
													if($na[$iii]%2==1){$nums++;}
													if($na[$iiii]%2==1){$nums++;}
													for ($j=0; $j<count($strb); $j++) {
														if($strb[$j]==$nums.":".(4-$nums)){
															$numa=$numa+1;
															break;
														}
													}
												}else{
													$numa=$numa+1;
												}
												if($stra[6]<>"" && $numa==5){
													$strb=explode("&",$stra[6]);
													$nums=0;
													if($na[$i]>=5){$nums++;}
													if($na[$ii]>=5){$nums++;}
													if($na[$iii]>=5){$nums++;}
													if($na[$iiii]>=5){$nums++;}
													for ($j=0; $j<count($strb); $j++) {
														if($strb[$j]==$nums.":".(4-$nums)){
															$numa=$numa+1;
															break;
														}
													}
												}else{
													$numa=$numa+1;
												}
												if($stra[7]<>"" && $numa==6){
													$strb=explode("&",$stra[7]);
													if($nb[0]==$nb[2] || $nb[1]==$nb[3]){
														$strc="组选4";
													}else{
														if($nb[0]==$nb[1] && $nb[2]==$nb[3]){
															$strc="组选6";
														}else{
															if($nb[0]==$nb[1] || $nb[1]==$nb[2] || $nb[2]==$nb[3]){
																$strc="组选12";
															}else{
																$strc="组选24";
															}
														}
													}

													for ($j=0; $j<count($strb); $j++) {
														if($strb[$j]==$strc){
															$numa=$numa+1;
															break;
														}
													}
												}else{
													$numa=$numa+1;
												}
											}
											if($numa>=7){$numc=$numc+1;}
										}
									}
								}
							}
						}
					}
				}
			}
			if($numc>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numc.",zjnums='".$numc."' where id='".$row['id']."'");
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="71" || $mid=="151" || $mid=="231" || $mid=="311" || $mid=="391" || $mid=="741"){//任三胆码
			$numc=0;
			$stra=explode("|",$row['codes']);
			$pos=explode(",",$row['pos']);
			for($i=0; $i<3; $i++) {
				if($pos[$i]==1){
					for($ii=$i+1;$ii<4;$ii++) {
						if($pos[$ii]==1){
							for($iii=$ii+1;$iii<5;$iii++) {
								if($pos[$iii]==1){
									$numa=0;
									$numb=0;
									$nb=pnb($na[$i].",".$na[$ii].",".$na[$iii]);
									$nums=$na[$i]+$na[$ii]+$na[$iii];
											
									$strb=explode("&",$stra[0]);
									for ($j=0; $j<count($strb); $j++) {
										if($strb[$j]==$na[$i] || $strb[$j]==$na[$ii] || $strb[$j]==$na[$iii]){
											$numb=$numb+1;
										}
									}
									if($numb>0){
										if($stra[1]<>""){
											$strb=explode("-",$stra[1]);
											if($numb>=$strb[0] && $numb<=$strb[1]){
												$numa=$numa+1;
											}
										}else{
											$numa=$numa+1;
										}
										if($stra[2]<>"" && $numa==1){//跨度
											$strb=explode("&",$stra[2]);
											for ($j=0; $j<count($strb); $j++) {
												if($strb[$j]==$nb[2]-$nb[0]){
													$numa=$numa+1;
													break;
												}
											}
										}else{
											$numa=$numa+1;
										}
										if($stra[3]<>"" && $numa==2){
											$strb=explode("&",$stra[3]);
											for ($j=0; $j<count($strb); $j++) {
												if($strb[$j]==$nums % 10){
													$numa=$numa+1;
													break;
												}
											}
										}else{
											$numa=$numa+1;
										}
										if($stra[4]<>"" && $numa==3){
											$strb=explode("&",$stra[4]);
											for ($j=0; $j<count($strb); $j++) {
												$strc=explode("-",$strb[$j]);
												if($nums>=$strc[0] && $nums<=$strc[1]){
													$numa=$numa+1;
													break;
												}
											}
										}else{
											$numa=$numa+1;
										}
										if($stra[5]<>"" && $numa==4){
											$strb=explode("&",$stra[5]);
											$nums=0;
											if($na[$i]%2==1){$nums++;}
											if($na[$ii]%2==1){$nums++;}
											if($na[$iii]%2==1){$nums++;}
											for ($j=0; $j<count($strb); $j++) {
												if($strb[$j]==$nums.":".(3-$nums)){
													$numa=$numa+1;
													break;
												}
											}
										}else{
											$numa=$numa+1;
										}
										if($stra[6]<>"" && $numa==5){
											$strb=explode("&",$stra[6]);
											$nums=0;
											if($na[$i]>=5){$nums++;}
											if($na[$ii]>=5){$nums++;}
											if($na[$iii]>=5){$nums++;}
											for ($j=0; $j<count($strb); $j++) {
												if($strb[$j]==$nums.":".(3-$nums)){
													$numa=$numa+1;
													break;
												}
											}
										}else{
											$numa=$numa+1;
										}
										if($stra[7]<>"" && $numa==6){
											$strb=explode("&",$stra[7]);
											if($nb[0]==$nb[1] || $nb[1]==$nb[2]){
												$strc="组选三";
											}else{
												$strc="组选六";
											}

											for ($j=0; $j<count($strb); $j++) {
												if($strb[$j]==$strc){
													$numa=$numa+1;
													break;
												}
											}
										}else{
											$numa=$numa+1;
										}
									}
									if($numa>=7){$numc=$numc+1;}
								}
							}
						}
					}
				}
			}
			if($numc>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numc.",zjnums='".$numc."' where id='".$row['id']."'");
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="72" || $mid=="152" || $mid=="232" || $mid=="312" || $mid=="392" || $mid=="742"){//任二胆码
			$numc=0;
			$stra=explode("|",$row['codes']);
			$pos=explode(",",$row['pos']);
			for($i=0; $i<4; $i++) {
				if($pos[$i]==1){
					for($ii=$i+1;$ii<5;$ii++) {
						if($pos[$ii]==1){
							$numa=0;
							$numb=0;
							$nb=pnb($na[$i].",".$na[$ii]);
							$nums=$na[$i]+$na[$ii];
							$strb=explode("&",$stra[0]);
							for ($j=0; $j<count($strb); $j++) {
								if($strb[$j]==$na[$i] || $strb[$j]==$na[$ii]){
									$numb=$numb+1;
								}
							}
							if($numb>0){
								if($stra[1]<>""){
									$strb=explode("-",$stra[1]);
									if($numb>=$strb[0] && $numb<=$strb[1]){
										$numa=$numa+1;
									}
								}else{
									$numa=$numa+1;
								}
								if($stra[2]<>"" && $numa==1){//跨度
									$strb=explode("&",$stra[2]);
									for ($j=0; $j<count($strb); $j++) {
										if($strb[$j]==$nb[1]-$nb[0]){
											$numa=$numa+1;
											break;
										}
									}
								}else{
									$numa=$numa+1;
								}
								if($stra[3]<>"" && $numa==2){
									$strb=explode("&",$stra[3]);
									for ($j=0; $j<count($strb); $j++) {
										if($strb[$j]==$nums % 10){
											$numa=$numa+1;
											break;
										}
									}
								}else{
									$numa=$numa+1;
								}
								if($stra[4]<>"" && $numa==3){
									$strb=explode("&",$stra[4]);
									for ($j=0; $j<count($strb); $j++) {
										$strc=explode("-",$strb[$j]);
										if($nums>=$strc[0] && $nums<=$strc[1]){
											$numa=$numa+1;
											break;
										}
									}
								}else{
									$numa=$numa+1;
								}
								if($stra[5]<>"" && $numa==4){
									$strb=explode("&",$stra[5]);
									$nums=0;
									if($na[$i]%2==1){$nums++;}
									if($na[$ii]%2==1){$nums++;}
									for ($j=0; $j<count($strb); $j++) {
										if($strb[$j]==$nums.":".(2-$nums)){
											$numa=$numa+1;
											break;
										}
									}
								}else{
									$numa=$numa+1;
								}
								if($stra[6]<>"" && $numa==5){
									$strb=explode("&",$stra[6]);
									$nums=0;
									if($na[$i]>=5){$nums++;}
									if($na[$ii]>=5){$nums++;}
									for ($j=0; $j<count($strb); $j++) {
										if($strb[$j]==$nums.":".(2-$nums)){
											$numa=$numa+1;
											break;
										}
									}
								}else{
									$numa=$numa+1;
								}
							}
							if($numa>=6){$numc=$numc+1;}
						}
					}
				}
			}
			if($numc>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numc.",zjnums='".$numc."' where id='".$row['id']."'");
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}


		}

		mysql_query("update ssc_bills set prize='".$maxprize."' where id='".$row['id']."' and prize>'".$maxprize."'");

		if($sign==1){
			$sqls="update ssc_bills set kjcode='".$kjcode."' where id ='".$row['id']."'";
			$rss=mysql_query($sqls) or  die("数据库修改出错1");
			
			$sqls="select * from ssc_bills where id ='".$row['id']."'";
			$rss=mysql_query($sqls) or  die("数据库修改出错1");
			$rows = mysql_fetch_array($rss);
			
			if($rows['regfrom']!=""){
				$sqla = "select * from ssc_class where mid='".$mid."'";
				$rsa = mysql_query($sqla);
				$rowa = mysql_fetch_array($rsa);
				$sstri=$rowa['sid'];
				
				$sqlb = "select * from ssc_member where username='" . $rows['username'] . "'";
				$rsb = mysql_query($sqlb);
				$rowb = mysql_fetch_array($rsb);
		
				$sstrp=$rowb['flevel'];
				
				$regfrom=explode("&&",$rows['regfrom']);
				for ($ia=0; $ia<count($regfrom); $ia++) {
											
					$susername=str_replace("&","",$regfrom[$ia]);
					$sqlu = "select * from ssc_member where username='".$susername."'";
					$rsu = mysql_query($sqlu);
					$rowu = mysql_fetch_array($rsu);
											
					$sstrb=$rowu['flevel'];
					if(($sstrb-$sstrp)>0){
						$sqla = "select id from ssc_record order by id desc limit 1";
						$rsa = mysql_query($sqla);
						$rowa = mysql_fetch_array($rsa);
						$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));
						$sqla="insert into ssc_record set lotteryid='".$rows['lotteryid']."', lottery='".$rows['lottery']."', dan='".$dan1."', dan1='".$dan."', uid='".Get_memid($susername)."', username='".$susername."', issue='".$rows['issue']."', types='11', mid='".$rows['mid']."', mode='".$rows['mode']."', smoney=".($rows['money']*($sstrb-$sstrp)/100).",leftmoney=".(Get_mmoneys($susername)+$rows['money']*($sstrb-$sstrp)/100).", cont='".$rows['cont']."', regtop='".$rowu['regtop']."', regup='".$rowu['regup']."', regfrom='".$rowu['regfrom']."', adddate='".date("Y-m-d H:i:s")."',virtual='" .$rowu['virtual']. "'";
		//								echo $smoney."___".($sstrb[1]-$sstrp);
						$exe=mysql_query($sqla) or  die("数据库修改出错4!!!");
					
						$sqla="update ssc_member set leftmoney=leftmoney+".($rows['money']*($sstrb-$sstrp)/100)." where username='".$susername."'"; 
						$exe=mysql_query($sqla) or  die("数据库修改出错12!!!");
						$sstrp=$sstrb;
					}
				}
			}	
			
			
			
			if($rows['zt']==1){	
				$sqla = "select id from ssc_record order by id desc limit 1";
				$rsa = mysql_query($sqla);
				$rowa = mysql_fetch_array($rsa);
				$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));
				$lmoney = Get_mmoney($rows['uid'])+$rows['prize'];
				$sqla="insert into ssc_record set lotteryid='".$rows['lotteryid']."', lottery='".$rows['lottery']."', dan='".$dan1."', dan1='".$rows['dan']."', dan2='".$rows['dan1']."', uid='".$rows['uid']."', username='".$rows['username']."', issue='".$rows['issue']."', types='12', mid='".$rows['mid']."', mode='".$rows['mode']."', smoney=".$rows['prize'].",leftmoney=".$lmoney.", cont='".$rows['cont']."', regtop='".$rows['regtop']."', regup='".$rows['regup']."', regfrom='".$rows['regfrom']."', adddate='".date("Y-m-d H:i:s")."',virtual='" .$rows['virtual']. "'";
				$exe=mysql_query($sqla) or  die("数据库修改出错!!!1");
				
				$sqla="update ssc_member set leftmoney=".$lmoney." where id='".$rows['uid']."'"; 
				$exe=mysql_query($sqla) or  die("数据库修改出错!!!2");
				
				if($rows['dan1']!=""){
					$sqla = "update ssc_zbills set prize=prize+".$rows['prize'].", zjnums=zjnums+1 where dan='".$rows['dan1']."'";
					$rsa = mysql_query($sqla);
				}
				
				if($rows['autostop']=="yes"){//多余转结
					//
					$sqla="select sum(money) as tmoney,count(*) as cnums from ssc_zdetail where zt=0 and dan='".$rows['dan1']."'";
					$rsa = mysql_query($sqla);
					$rowa = mysql_fetch_array($rsa);
					$ttm=$rowa['tmoney'];
					if($ttm>0){
						$sqla = "update ssc_zbills set cnums=cnums+".$rowa['cnums'].", cmoney=cmoney+".$ttm." where dan='".$rows['dan1']."'";
						$rsa = mysql_query($sqla);

						$sqla = "select id from ssc_record order by id desc limit 1";
						$rsa = mysql_query($sqla);
						$rowa = mysql_fetch_array($rsa);
						$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));//追号返款
						$sqla="insert into ssc_record set lotteryid='".$rows['lotteryid']."', lottery='".$rows['lottery']."', dan='".$dan1."', dan2='".$rows['dan1']."', uid='".$rows['uid']."', username='".$rows['username']."', issue='".$rows['issue']."', types='10', mid='".$rows['mid']."', mode='".$rows['mode']."', smoney=".$ttm.",leftmoney=".($lmoney+$ttm).", cont='".$rows['cont']."', regtop='".$rows['regtop']."', regup='".$rows['regup']."', regfrom='".$rows['regfrom']."', adddate='".date("Y-m-d H:i:s")."',virtual='" .$rows['virtual']. "'";
						$exe=mysql_query($sqla) or  die("数据库修改出错9!!!");

						$sqla="update ssc_member set leftmoney=".($lmoney+$ttm)." where id='".$rows['uid']."'"; 
						$exe=mysql_query($sqla) or  die("数据库修改出错!!!3");
						
					}
					
					$sqla="update ssc_zdetail set zt=2 where dan='".$rows['dan1']."' and zt=0"; 
					$exe=mysql_query($sqla) or  die("数据库修改出错!!!4");
				}
			}
		}
	}
	mysql_free_result($rs);
//	echo "zzz";
	if($sign==1){
//		$sqlb="update ssc_data set zt=2 where id ='".$rowz['id']."'";
//		$rsb=mysql_query($sqlb) or  die("数据库修改出错1");
	
		$sqlb="select SUM(IF(types = 1, smoney, 0)) as t1,SUM(IF(types = 2, zmoney, 0)) as t2,SUM(IF(types = 3, smoney, 0)) as t3,SUM(IF(types = 7, zmoney, 0)) as t7,SUM(IF(types = 11, smoney, 0)) as t11,SUM(IF(types = 12, smoney, 0)) as t12,SUM(IF(types = 13, smoney, 0)) as t13,SUM(IF(types = 15, zmoney, 0)) as t15,SUM(IF(types = 16, zmoney, 0)) as t16,SUM(IF(types = 32, smoney, 0)) as t32,SUM(IF(types = 40, smoney, 0)) as t40 from ssc_record where lotteryid='".$lid."' and issue='".$issue."'";
		$rsb = mysql_query($sqlb);
		$rowb = mysql_fetch_array($rsb);

		$sqlc="select SUM(prize) as zj from ssc_bills where lotteryid='".$lid."' and issue='".$issue."'";
		$rsc = mysql_query($sqlc);
		$rowc = mysql_fetch_array($rsc);

		$sqld="update ssc_info set issue='".$issue."', tz='".($rowb['t7']-$rowb['t13'])."', fd='".($rowb['t11']-$rowb['t15'])."', zj='".floatval($rowc['zj'])."', adddate='".date("Y-m-d H:i:s")."' where lotteryid='".$lid."'";
//		echo $sqld;
		$exe=mysql_query($sqld) or  die("数据库修改出错!!!5");
		
//	}else if($sign==1){//计分红 zh
		$sqlb="update ssc_data2 set zt=1 where id ='".$rowz['id']."'";
		$rsb=mysql_query($sqlb) or  die("数据库修改出错1");

		//转zh
		$issueb=intval($issue)+1;
		$sqlb="select * from ssc_zdetail where lotteryid='".$lid."' and issue='".$issueb."' and zt=0";
		$rsb = mysql_query($sqlb);
		while ($rowb = mysql_fetch_array($rsb)){
			$sqla = "update ssc_zbills set fnums=fnums+1, fmoney=fmoney+".$rowb['money']." where dan='".$rowb['dan']."'";
			$rsa = mysql_query($sqla);
		
			$sql = "select * from ssc_member where username='" . $rowb['username'] . "'";
			$rs = mysql_query($sql);
			$row = mysql_fetch_array($rs);
			$lmoney=$row['leftmoney'];

			$sstrb=$row['flevel'];
			$spoints=$sstrb/100;
		
//			if($rowb['mid']=="20" || $rowb['mid']=="21" || $rowb['mid']=="24" || $rowb['mid']=="25" || $rowb['mid']=="58" || $rowb['mid']=="59" || $rowb['mid']=="62" || $rowb['mid']=="63" || $rowb['mid']=="96" || $rowb['mid']=="97" || $rowb['mid']=="100" || $rowb['mid']=="101" || $rowb['mid']=="134" || $rowb['mid']=="135" || $rowb['mid']=="138" || $rowb['mid']=="139" || $rowb['mid']=="168" || $rowb['mid']=="169" || $rowb['mid']=="205" || $rowb['mid']=="206" || $rowb['mid']=="239" || $rowb['mid']=="240" || $rowb['mid']=="273" || $rowb['mid']=="274" || $rowb['mid']=="298" || $rowb['mid']=="299" || $rowb['mid']=="326" || $rowb['mid']=="327" || $rowb['mid']=="366" || $rowb['mid']=="367"){//point处理
//				$spoint=$spoints;
//			}else{
				$spoint=$rowb['point'];
//			}

			$sqla = "select id from ssc_record order by id desc limit 1";
			$rsa = mysql_query($sqla);
			$rowa = mysql_fetch_array($rsa);
			$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));//追号返款
			$sqla="insert into ssc_record set lotteryid='".$rowb['lotteryid']."', lottery='".$rowb['lottery']."', dan='".$dan1."', dan2='".$rowb['dan']."', uid='".$rowb['uid']."', username='".$rowb['username']."', issue='".$rowb['issue']."', types='10', mid='".$rowb['mid']."', mode='".$rowb['mode']."', smoney=".$rowb['money'].",leftmoney=".($lmoney+$rowb['money']).", cont='".$rowb['cont']."', regtop='".$rowb['regtop']."', regup='".$rowb['regup']."', regfrom='".$rowb['regfrom']."', adddate='".date("Y-m-d H:i:s")."',virtual='" .$rowb['virtual']. "'";
			$exe=mysql_query($sqla) or  die("数据库修改出错9!!!");

			$sqla = "select id from ssc_bills order by id desc limit 1";
			$rsa = mysql_query($sqla);
			$rowa = mysql_fetch_array($rsa);
			$dan2 = sprintf("%06s",strtoupper(base_convert($rowa['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));//转注单
						
			$sqla="INSERT INTO ssc_bills set lotteryid='".$rowb['lotteryid']."', lottery='".$rowb['lottery']."', dan='".$dan2."', dan1='".$rowb['dan']."', uid='".$rowb['uid']."', username='".$rowb['username']."', issue='".$rowb['issue']."', type='".$rowb['type']."', mid='".$rowb['mid']."',mname='".$rowb['mname']."', codes='".$rowb['codes']."', pos='".$rowb['pos']."', nums='".$rowb['nums']."', times='".$rowb['times']."', money='".$rowb['money']."', mode='".$rowb['mode']."', rates='".$rowb['rates']."', point='".$rowb['point']."', cont='".$rowb['cont']."', regtop='".$rowb['regtop']."', regup='".$rowb['regup']."', regfrom='".$rowb['regfrom']."', userip='".$rowb['userip']."', adddate='".date("Y-m-d H:i:s")."', canceldead='".$rowb['canceldead']."', autostop='".$rowb['autostop']."',virtual='" .$rowb['virtual']. "'";
			$exe=mysql_query($sqla) or  die("数据库修改出错10!!!!");
			
			$sqla = "update ssc_zdetail set danb='".$dan2."', zt=1 where id='".$rowb['id']."'";
			$rsa = mysql_query($sqla);
			
			$sqla = "select id from ssc_record order by id desc limit 1";
			$rsa = mysql_query($sqla);
			$rowa = mysql_fetch_array($rsa);
			$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));//投注扣款
			$sqla="insert into ssc_record set lotteryid='".$rowb['lotteryid']."', lottery='".$rowb['lottery']."', dan='".$dan1."', dan1='".$dan2."', dan2='".$rowb['dan']."', uid='".$rowb['uid']."', username='".$rowb['username']."', issue='".$rowb['issue']."', types='7', mid='".$rowb['mid']."', mode='".$rowb['mode']."', zmoney=".$rowb['money'].",leftmoney=".$lmoney.", cont='".$rowb['cont']."', regtop='".$rowb['regtop']."', regup='".$rowb['regup']."', regfrom='".$rowb['regfrom']."', adddate='".date("Y-m-d H:i:s")."',virtual='" .$rowb['virtual']. "'";
			$exe=mysql_query($sqla) or  die("数据库修改出错11!!!");
			
			if($spoint>0){
				$sqla = "select id from ssc_record order by id desc limit 1";
				$rsa = mysql_query($sqla);
				$rowa = mysql_fetch_array($rsa);
				$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));
				$sqla="insert into ssc_record set lotteryid='".$rowb['lotteryid']."', lottery='".$rowb['lottery']."', dan='".$dan1."', dan1='".$dan2."', dan2='".$rowb['dan']."', uid='".$rowb['uid']."', username='".$rowb['username']."', issue='".$rowb['issue']."', types='11', mid='".$rowb['mid']."', mode='".$rowb['mode']."', smoney=".$rowb['money']*$spoint.",leftmoney=".($lmoney+$rowb['money']*$spoint).", cont='".$rowb['cont']."', regtop='".$rowb['regtop']."', regup='".$rowb['regup']."', regfrom='".$rowb['regfrom']."', adddate='".date("Y-m-d H:i:s")."',virtual='" .$rowb['virtual']. "'";
				$exe=mysql_query($sqla) or  die("数据库修改出错4!!!");

				$sqla="update ssc_member set leftmoney=".($lmoney+$rowb['money']*$spoint)." where username='".$rowb['username']."'"; 
				$exe=mysql_query($sqla) or  die("数据库修改出错12!!!");
			}
		}
		mysql_free_result($rsb);
		$sqla="select * from ssc_zbills where lotteryid='".$lid."' and zt='0'";
		$rsa = mysql_query($sqla) or  die("数据库修改出错!!!6");
		while ($rowa = mysql_fetch_array($rsa)){
			$sqlb="select * from ssc_zdetail where dan='".$rowa['dan']."' and zt='0'";
			$rsb = mysql_query($sqlb) or  die("数据库修改出错!!!7");
			$total = mysql_num_rows($rsb);
			if($total==0){
				$sqlb="update ssc_zbills set zt='1' where dan='".$rowa['dan']."'"; 
				$exe=mysql_query($sqlb) or  die("数据库修改出错!!!");
			}
		}
		mysql_free_result($rsa);
	}
}
function pnb($nbs){
	$nb=explode(",",$nbs);
	for($i=0; $i<count($nb); $i++) {
		for($j=count($nb)-1;$j>$i;$j--) {
			if ($nb[$j]<$nb[$j-1]) {
				$temp0=$nb[$j];
				$nb[$j]=$nb[$j-1];
				$nb[$j-1] =$temp0;
			}
		}
	}
	return $nb;
}
?>