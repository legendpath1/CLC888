<?php
//error_reporting(0);
require_once 'conn.php';

$sqls="select * from ssc_nums where cid='16' and DATE_FORMAT(opentime, '%H:%i:%s')<='".date("H:i:s")."' order by id desc limit 1";
//echo $sqls."<br>";
$rss=mysql_query($sqls) or  die("数据库修改出错1".mysql_error());
$nums=mysql_num_rows($rss);
$rows = mysql_fetch_array($rss);
$dymd=date("ymd");
$tissue=$dymd.$rows['nums'];
//echo $nums;
if($nums==0){
	$tissue=date("ymd",strtotime("-1 day"))."540";
}
//echo $tissue;
$sqla="select * from ssc_data2 where cid='16' and issue='".$tissue."'";
$rsa=mysql_query($sqla) or  die("数据库修改出错3".mysql_error());
$rowa = mysql_fetch_array($rsa);
if(empty($rowa)){
//	echo "a";
	$tn1=rand(0,9);
	$tn2=rand(0,9);
	if($tn1==$tn2){
		$tn2=rand(0,9);
	}
	$tn3=rand(0,9);
	
	$tn4=rand(0,9);
	if($tn4==$tn1 || $tn4==$tn2){
		$tn4=rand(0,9);
	}
	$tn5=rand(0,9);
	if($tn5==$tn1 || $tn5==$tn2 || $tn5==$tn4){
		$tn5=rand(0,9);
	}
//	for($i=0; $i<10; $i++) {
//		echo $tissue."_".$tn1.$tn2.$i.$tn4.$tn5."|";
//		$cals[$i]=ckj($tissue,$tn1,$tn2,$i,$tn4,$tn5);
//		echo $cals[$i]."<br>";
//	}
//	echo "b";

//	$tmax=$cals[0];
//	$tn3=0;
//	for($i=1; $i<10; $i++) {
//		if($cals[$i]>$tmax){
//			$tmax=$cals[$i];
//			$tn3=$i;
//		}
//	}
//	$tlist="";
//	for($i=0; $i<10; $i++) {
//		if($cals[$i]==$cals[$tn3]){
//			$tlist=$tlist.",".$i;
//		}
//	}
//	$tta=explode(",",$tlist);
//	//echo $tlist."|".count($tta);
//	$tn3=$tta[rand(1,count($tta)-1)];
//	echo "c";

	$codes=$tn1.",".$tn2.",".$tn3.",".$tn4.",".$tn5;
	$sql="INSERT INTO ssc_data2 set cid='16', name='如意分分彩', issue='".$tissue."', code='".$codes."', opentime='".date("Y-m-d H:i:s")."', addtime='".date("Y-m-d H:i:s")."'";
//				echo $row['name']."第".$t1."期:".$t2."<br>";
	$exe=mysql_query($sql) or  die("数据库修改出错!!!!".mysql_error());

//	echo "vvv".$cals[$tn3];
	echo "如意分分彩 第".$tissue."期 开奖号码：".$codes;
}else{
echo "kkk".$tissue;
}

function ckj($issue,$n1,$n2,$n3,$n4,$n5){   

//$sqly = "select gplimit from ssc_config";
//$rsy = mysql_query($sqly);
//$rowy = mysql_fetch_array($rsy);
//$maxprize=$rowy['gplimit'];
	$lid=16;
//	echo $issue."_".$lid;
	
	$signa=0;
	$signb=0;
	
//	$n1=1;
//	$n2=2;
//	$n3=3;
//	$n4=4;
//	$n5=5;

	$na[0]=$n1;
	$na[1]=$n2;
	$na[2]=$n3;
	$na[3]=$n4;
	$na[4]=$n5;

	$nb[0]=$n1;
	$nb[1]=$n2;
	$nb[2]=$n3;
	$nb[3]=$n4;
	$nb[4]=$n5;

	for($i=0; $i<5; $i++) {
		for($j=4;$j>$i;$j--) {
			if ($nb[$j]<$nb[$j-1]) {
				$temp0=$nb[$j];
				$nb[$j]=$nb[$j-1];
				$nb[$j-1] =$temp0;
			}
		}
	}
	
	
//	$sql="select * from ssc_bills where zt=0 order by id asc";
	$sql="select * from ssc_bills where lotteryid='16' and issue='".$issue."' order by id asc";
	$rs=mysql_query($sql) or  die("数据库修改出错1".mysql_error());
	while ($row = mysql_fetch_array($rs)){
		$mid=$row['mid'];
		if($row['mode']=="元"){
			$modes=1;
		}else if($row['mode']=="角"){
			$modes=0.1;
		}else if($row['mode']=="分"){
			$modes=0.01;
		}

		if($mid=="671"){//5星
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
		}else if($mid=="672"){//五星组合
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
		}else if($mid=="674"){//五星组选120
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
		}else if($mid=="675"){//五星组选60 2+1*3
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
		}else if($mid=="676"){//五星组选30 2*2+1
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
		}else if($mid=="677"){//五星组选20 3+1*2
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
		}else if($mid=="678"){//五星组选10 3+2
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
		}else if($mid=="679"){//五星组选5 4+1
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
		}else if($mid=="681"){//任四直选
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
		}else if($mid=="682"){//任四组合???
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

		}else if($mid=="684"){//任四组选24
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
		}else if($mid=="685"){//任四组选12
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
		}else if($mid=="686"){//任四组选6
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
		}else if($mid=="687"){//任四组选4
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
		}else if($mid=="689"){//任三直选
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
		}else if($mid=="690"){//任三直选和值
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
		}else if($mid=="691"){//任三跨度???
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
		}else if($mid=="692"){//任三组合
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
		}else if($mid=="694"){//任三组选组三
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
		}else if($mid=="695"){//任三组选组六
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
		}else if($mid=="697"){//任三组选和值
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
		}else if($mid=="696"){//任三组选混合
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
		}else if($mid=="698"){//任三组选包胆
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
		}else if($mid=="700"){//任三和值尾数
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
		}else if($mid=="701"){//任三特殊号
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
		}else if($mid=="703"){//任二直选
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
		}else if($mid=="704"){//任二直选和值
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
		}else if($mid=="705"){//任二直选跨度
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
		}else if($mid=="707"){//任二组选
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
		}else if($mid=="708"){//任二组选和值
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
		}else if($mid=="709"){//任二组选包胆
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
			
		}else if($mid=="711"){//定位胆ok 170时时乐 585 3d 612 p3 
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
		}else if($mid=="713"){//任三一码不定位???
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
		}else if($mid=="714"){//任三二码不定位???
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
		}else if($mid=="715"){//任四一码不定位???
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
		}else if($mid=="716"){//任四二码不定位???
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
		}else if($mid=="717"){//五星二码不定位ok
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
		}else if($mid=="718"){//五星三码不定位ok
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
		}else if($mid=="720"){//任二大小单双 
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
		}else if($mid=="721"){//任三大小单双 179时时乐 309 3d 335 p3
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
		}else if($mid=="723"){//五码趣味三星
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
		}else if($mid=="724"){//四码趣味三星
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
		}else if($mid=="725"){//前三趣味二星
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
		}else if($mid=="726"){//中三趣味二星
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
		}else if($mid=="727"){//后三趣味二星
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
		}else if($mid=="728"){//五码区间三星
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
		}else if($mid=="729"){//四码区间三星
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
		}else if($mid=="730"){//前三区间二星
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
		}else if($mid=="731"){//中三区间二星
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
		}else if($mid=="732"){//后三区间二星
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
		}else if($mid=="734"){//一帆风顺
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
		}else if($mid=="735"){//好事成双
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
		}else if($mid=="736"){//三星报喜
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
		}else if($mid=="737"){//四季发财
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
		}else if($mid=="739"){//五星胆码
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
		}else if($mid=="740"){//任四胆码
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
		}else if($mid=="741"){//任三胆码
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
		}else if($mid=="742"){//任二胆码
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

		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
		
		}
		
//		mysql_query("update ssc_bills set prize='".$maxprize."' where id='".$row['id']."' and prize>'".$maxprize."'");

	}
	//
//	echo "zzz";
	mysql_free_result($rs); 	
		$sqlc="select SUM(prize) as zj,sum(money) as tz from ssc_bills where lotteryid='".$lid."' and issue='".$issue."'";
		$rsc = mysql_query($sqlc);
		$rowc = mysql_fetch_array($rsc);
		$yk= intval($rowc['tz'])-intval($rowc['zj']);
		echo $rowc['tz']."_".$rowc['zj']."_"."<br>";
		mysql_free_result($rsc); 
		return $yk;
}

//	echo $n1.$n2.$n4.$n5;	
		 
?>
