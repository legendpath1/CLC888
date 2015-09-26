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

$sqlz = "select * from ssc_data where zt=0 order by issue asc limit 3";// or zt=2
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
	if($rowz['zt']==2 and $rowz['sign']<2){
		$sqlb="update ssc_data set sign=sign+1 where id ='".$rowz['id']."'";
		$rsb=mysql_query($sqlb) or  die("数据库修改出错1");
		exit;
	}
	
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

		if($mid=="870"){//5星
			if($row['type']=="input"){//单式
				$cs=$na[0].$na[1].$na[2].$na[3].$na[4];
				$stra=explode("&",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$cs){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
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
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");	
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");	
				}
			}
		}else if($mid=="872"){//五星组合
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
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($rate*$modes)."*times where id='".$row['id']."'");	
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");	
			}
		}else if($mid=="874"){//五星组选120
			$nums=0;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2] || $stra[$i]==$na[3] || $stra[$i]==$na[4]){$nums=$nums+1;}
			}
			if($nums>=5){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="875"){//五星组选60 2+1*3
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
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="876"){//五星组选30 2*2+1
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
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="877"){//五星组选20 3+1*2
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
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="878"){//五星组选10 3+2
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
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="879"){//五星组选5 4+1
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
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="2" || $mid=="176" || $mid=="264" || $mid=="352" || $mid=="777"){//后四 
			if($row['type']=="input"){//单式
				$cs=$na[1].$na[2].$na[3].$na[4];
				$stra=explode("&",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$cs){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}
			}else if($row['type']=="digital"){//复式
				$stra=explode("|",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					$strb=explode("&",$stra[$i]);
					for ($ii=0; $ii<count($strb); $ii++) {
						if($strb[$ii]==$na[$i+1]){$nums=$nums+1;}
					}
				}
				if($nums==4){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="4" || $mid=="178" || $mid=="266" || $mid=="354" || $mid=="779"){//四星组合
			$stra=explode("|",$row['codes']);
			$numa=0;
			$nums=0;
			for ($i=0; $i<count($stra); $i++) {
				$strb=explode("&",$stra[3-$i]);
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
				$rate=$rates[3];
			}elseif($nums==2){
				$rate=$rates[3]+$rates[2];
			}elseif($nums==3){
				$rate=$rates[3]+$rates[2]+$rates[1];
			}elseif($nums==4){
				$rate=$rates[3]+$rates[2]+$rates[1]+$rates[0];
			}
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($rate*$modes)."*times where id='".$row['id']."'");	
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");	
			}
		}else if($mid=="6" || $mid=="180" || $mid=="268" || $mid=="356" || $mid=="781"){//四星组选24
			$nums=0;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[1] || $stra[$i]==$na[2] || $stra[$i]==$na[3] || $stra[$i]==$na[4]){$nums=$nums+1;}
			}
			if($nums>=4){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="7" || $mid=="181" || $mid=="269" || $mid=="357" || $mid=="782"){//四星组选12
			unset($nt);
			$stra=explode("|",$row['codes']);
			$numa=0;
			$numb=0;
			$strb=explode("&",$stra[0]);
			$nb=pnb($na[1].",".$na[2].",".$na[3].",".$na[4]);
			for ($i=0; $i<count($strb); $i++) {
				if(($strb[$i]==$nb[0] && $strb[$i]==$nb[1]) || ($strb[$i]==$nb[1] && $strb[$i]==$nb[2]) || ($strb[$i]==$nb[2] && $strb[$i]==$nb[3])){$nt[$numa]=$strb[$i];$numa=$numa+1;}
			}
			$strc=explode("&",$stra[1]);
			for ($i=0; $i<count($strc); $i++) {
				if($strc[$i]==$na[1] || $strc[$i]==$na[2] || $strc[$i]==$na[3] || $strc[$i]==$na[4]){
					if(in_array($strc[$i],$nt)){
					}else{
						$numb=$numb+1;
					}
				}
			}
//			echo "t".$nb[0].$nb[1].$nb[2].$nb[3];
//			echo $numa.$numb;
			if($numa>=1 && $numb>=2){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="8" || $mid=="182" || $mid=="270" || $mid=="358" || $mid=="783"){//四星组选6 2*2
			$numa=0;
			$strb=explode("&",$row['codes']);
			$nb=pnb($na[1].",".$na[2].",".$na[3].",".$na[4]);
			for ($i=0; $i<count($strb); $i++) {
				if(($strb[$i]==$nb[0] && $strb[$i]==$nb[1]) || ($strb[$i]==$nb[1] && $strb[$i]==$nb[2]) || ($strb[$i]==$nb[2] && $strb[$i]==$nb[3])){$numa=$numa+1;}
			}
			if($numa>=2){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="9" || $mid=="183" || $mid=="271" || $mid=="359" || $mid=="784"){//四星组选4 3+1
			unset($nt);
			$stra=explode("|",$row['codes']);
			$numa=0;
			$numb=0;
			$strb=explode("&",$stra[0]);
			$nb=pnb($na[1].",".$na[2].",".$na[3].",".$na[4]);
			for ($i=0; $i<count($strb); $i++) {
				if(($strb[$i]==$nb[0] && $strb[$i]==$nb[1] && $strb[$i]==$nb[2]) || ($strb[$i]==$nb[1] && $strb[$i]==$nb[2] && $strb[$i]==$nb[3])){$nt[$numa]=$strb[$i];$numa=$numa+1;}
			}
			$strc=explode("&",$stra[1]);
			for ($i=0; $i<count($strc); $i++) {
				if($strc[$i]==$na[1] || $strc[$i]==$na[2] || $strc[$i]==$na[3] || $strc[$i]==$na[4]){
					if(in_array($strc[$i],$nt)){
					}else{
						$numb=$numb+1;
					}
				}
			}
			if($numa>=1 && $numb>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="11" || $mid=="185" || $mid=="273" || $mid=="361" || $mid=="786"){//后三直选
			if($row['type']=="input"){//单式
				$cs=$na[2].$na[3].$na[4];
				$stra=explode("&",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$cs){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}

			}else if($row['type']=="digital"){//复式
				$stra=explode("|",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					$strb=explode("&",$stra[$i]);
					for ($ii=0; $ii<count($strb); $ii++) {
						if($strb[$ii]==$na[$i+2]){$nums=$nums+1;}
					}
				}
				if($nums==3){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="12" || $mid=="186" || $mid=="274" || $mid=="362" || $mid=="787"){//后三和ok
			$zt=2;
			$cs=$na[2]+$na[3]+$na[4];
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$cs){
					$zt=1;
					break;
				}
			}
			if($zt=="1"){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="13" || $mid=="187" || $mid=="275" || $mid=="363" || $mid=="788"){//后三跨度
			$zt=2;
			$nb=pnb($na[2].",".$na[3].",".$na[4]);
			$cs=abs($nb[2]-$nb[0]);
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$cs){
					$zt=1;
					break;
				}
			}
			if($zt=="1"){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}

		}else if($mid=="15" || $mid=="189" || $mid=="277" || $mid=="365" || $mid=="790"){//后三组合
			$stra=explode("|",$row['codes']);
			$numa=0;
			$nums=0;
			for ($i=0; $i<count($stra); $i++) {
				$strb=explode("&",$stra[2-$i]);
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
				$rate=$rates[2];
			}elseif($nums==2){
				$rate=$rates[2]+$rates[1];
			}elseif($nums==3){
				$rate=$rates[2]+$rates[1]+$rates[0];
			}
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($rate*$modes)."*times where id='".$row['id']."'");	
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");	
			}
		}else if($mid=="17" || $mid=="191" || $mid=="279" || $mid=="367" || $mid=="792"){//后三组三
			if($row['type']=="input"){//单式
				$stra=explode("&",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$na[2].$na[3].$na[4] || $stra[$i]==$na[2].$na[4].$na[3] || $stra[$i]==$na[3].$na[2].$na[4] || $stra[$i]==$na[3].$na[4].$na[2] || $stra[$i]==$na[4].$na[2].$na[3] || $stra[$i]==$na[4].$na[3].$na[2]){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}
			}else if($row['type']=="digital"){//复式
				$nums=0;
				if($na[2]==$na[3] || $na[2]==$na[4] || $na[3]==$na[4]){
					$stra=explode("&",$row['codes']);
					for ($i=0; $i<count($stra); $i++) {
						if($stra[$i]==$na[2] || $stra[$i]==$na[3] || $stra[$i]==$na[4]){$nums=$nums+1;}
					}
				}
				if($nums>=2){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="18" || $mid=="192" || $mid=="280" || $mid=="368" || $mid=="793"){//后三组6
			if($row['type']=="input"){//单式
				$stra=explode("&",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$na[2].$na[3].$na[4] || $stra[$i]==$na[2].$na[4].$na[3] || $stra[$i]==$na[3].$na[2].$na[4] || $stra[$i]==$na[3].$na[4].$na[2] || $stra[$i]==$na[4].$na[2].$na[3] || $stra[$i]==$na[4].$na[3].$na[2]){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}
			}else if($row['type']=="digital"){//复式	
				$nums=0;
				if($na[2]!=$na[3] && $na[2]!=$na[4] && $na[3]!=$na[4]){
					$stra=explode("&",$row['codes']);
					for ($i=0; $i<count($stra); $i++) {
						if($stra[$i]==$na[2] || $stra[$i]==$na[3] || $stra[$i]==$na[4]){$nums=$nums+1;}
					}
				}
				if($nums>=3){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="19" || $mid=="193" || $mid=="281" || $mid=="369" || $mid=="794"){//后三组混合
			$stra=explode("&",$row['codes']);
			$nums=0;
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[2].$na[3].$na[4] || $stra[$i]==$na[2].$na[4].$na[3] || $stra[$i]==$na[3].$na[2].$na[4] || $stra[$i]==$na[3].$na[4].$na[2] || $stra[$i]==$na[4].$na[2].$na[3] || $stra[$i]==$na[4].$na[3].$na[2]){$nums=$nums+1;}
			}
			if($nums>=1){
				$rates=explode(";",Get_rate($mid));
				if($na[2]==$na[3] || $na[2]==$na[4] || $na[3]==$na[4]){//组三
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[0]*$modes*$nums)."*times where id='".$row['id']."'");										
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[1]*$modes*$nums)."*times where id='".$row['id']."'");										
				}
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
			}
		}else if($mid=="20" || $mid=="194" || $mid=="282" || $mid=="370" || $mid=="795"){//后三组合值
			$zt=2;
			$cs=$na[2]+$na[3]+$na[4];
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$cs){
					$zt=1;
					break;
				}
			}
			if($zt=="1"){
				$rates=explode(";",Get_rate($mid));			
				if($na[2]==$na[3] || $na[2]==$na[4] || $na[3]==$na[4]){//组3
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[0]*$modes)."*times where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[1]*$modes)."*times where id='".$row['id']."'");				
				}		
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}			
		}else if($mid=="21" || $mid=="195" || $mid=="283" || $mid=="371" || $mid=="796"){//包胆
			$zt=2;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[2] || $stra[$i]==$na[3] || $stra[$i]==$na[4]){
					$zt=1;
					break;
				}
			}
			if($zt=="1"){
				$rates=explode(";",Get_rate($mid));			
				if($na[2]==$na[3] || $na[2]==$na[4] || $na[3]==$na[4]){//组3
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[0]*$modes)."*times where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[1]*$modes)."*times where id='".$row['id']."'");				
				}
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="23" || $mid=="197" || $mid=="285" || $mid=="373" || $mid=="798"){//后三和值尾数
			$zt=2;
			$cs=($na[2]+$na[3]+$na[4])%10;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$cs){
					$zt=1;
					break;
				}
			}
			if($zt=="1"){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="25" || $mid=="199" || $mid=="287" || $mid=="375" || $mid=="800"){//后三特殊号
			$na1="";
			$na2="";
			$na3="";
			if($na[2]==$na[3] || $na[3]==$na[4] || $na[2]==$na[4]){$na3="对子";}
			if($na[2]==$na[3] && $na[3]==$na[4]){$na1="豹子";}

			$nb=pnb($na[2].",".$na[3].",".$na[4]);
			if($nb[1]-$nb[0]==1 && $nb[2]-$nb[1]==1){$na2="顺子";}

			$stra=explode("&",$row['codes']);
			$numa=0;			
			$rates=explode(";",Get_rate($mid));
			
			for ($ii=0; $ii<count($stra); $ii++) {
				if($stra[$ii]==$na1){
					$numa=$numa+$rates[0];
				}else if($stra[$ii]==$na2){
					$numa=$numa+$rates[1];
				}else if($stra[$ii]==$na3){
					$numa=$numa+$rates[2];
				}
			}
			if($numa>0){
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($numa*$modes)."*times where id='".$row['id']."'");
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="27" || $mid=="201" || $mid=="289" || $mid=="377" || $mid=="802" || $mid=="154" || $mid=="569" || $mid=="596"){//前三直选ok154时时乐5693d 596p3
			if($row['type']=="input"){//单式
				$cs=$na[0].$na[1].$na[2];
				$stra=explode("&",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$cs){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
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
				if($nums==3){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="28" || $mid=="202" || $mid=="290" || $mid=="378" || $mid=="803" || $mid=="155" || $mid=="570" || $mid=="597"){//前三和值ok155时时乐直选合值 570 3d 597p3
			$zt=2;
			$cs=$na[0]+$na[1]+$na[2];
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$cs){
					$zt=1;
					break;
				}
			}
			if($zt=="1"){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="29" || $mid=="203" || $mid=="291" || $mid=="379" || $mid=="804"){//前三跨度
			$zt=2;
			$nb=pnb($na[0].",".$na[1].",".$na[2]);
			$cs=abs($nb[2]-$nb[0]);
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$cs){
					$zt=1;
					break;
				}
			}
			if($zt=="1"){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}

		}else if($mid=="31" || $mid=="205" || $mid=="293" || $mid=="381" || $mid=="806"){//前三组合
			$stra=explode("|",$row['codes']);
			$numa=0;
			$nums=0;
			for ($i=0; $i<count($stra); $i++) {
				$strb=explode("&",$stra[2-$i]);
				for ($ii=0; $ii<count($strb); $ii++) {
					if($strb[$ii]==$na[2-$i]){$numa=1;}
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
				$rate=$rates[2];
			}elseif($nums==2){
				$rate=$rates[2]+$rates[1];
			}elseif($nums==3){
				$rate=$rates[2]+$rates[1]+$rates[0];
			}
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($rate*$modes)."*times where id='".$row['id']."'");	
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");	
			}

		}else if($mid=="33" || $mid=="207" || $mid=="295" || $mid=="383" || $mid=="808" || $mid=="157" || $mid=="572" || $mid=="599"){//前组三ok 157时时乐组3 572 3d 599 p3
			if($row['type']=="input"){//单式
				$stra=explode("&",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$na[0].$na[1].$na[2] || $stra[$i]==$na[0].$na[2].$na[1] || $stra[$i]==$na[1].$na[0].$na[2] || $stra[$i]==$na[1].$na[2].$na[0] || $stra[$i]==$na[2].$na[0].$na[1] || $stra[$i]==$na[2].$na[1].$na[0]){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}
			}else if($row['type']=="digital"){//复式
				$nums=0;
				if($na[0]==$na[1] || $na[0]==$na[2] || $na[1]==$na[2]){
					$stra=explode("&",$row['codes']);
					for ($i=0; $i<count($stra); $i++) {
						if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2]){$nums=$nums+1;}
					}
				}
				if($nums>=2){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="34" || $mid=="208" || $mid=="296" || $mid=="384" || $mid=="809" || $mid=="158" || $mid=="573" || $mid=="600"){//前组六ok 158时时乐组6 573 3d 600 p3
			if($row['type']=="input"){//单式
				$stra=explode("&",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$na[0].$na[1].$na[2] || $stra[$i]==$na[0].$na[2].$na[1] || $stra[$i]==$na[1].$na[0].$na[2] || $stra[$i]==$na[1].$na[2].$na[0] || $stra[$i]==$na[2].$na[0].$na[1] || $stra[$i]==$na[2].$na[1].$na[0]){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}
			}else if($row['type']=="digital"){//复式
				$nums=0;
				if($na[0]!=$na[1] && $na[0]!=$na[2] && $na[1]!=$na[2]){
					$stra=explode("&",$row['codes']);
					for ($i=0; $i<count($stra); $i++) {
						if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2]){$nums=$nums+1;}
					}
				}
				if($nums>=3){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="35" || $mid=="209" || $mid=="297" || $mid=="385" || $mid=="810" || $mid=="159" || $mid=="574" || $mid=="601"){//前三组选，混合 inputok 159时时乐混合组选 574 3d 601p3
			$stra=explode("&",$row['codes']);
			$nums=0;
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[0].$na[1].$na[2] || $stra[$i]==$na[0].$na[2].$na[1] || $stra[$i]==$na[1].$na[0].$na[2] || $stra[$i]==$na[1].$na[2].$na[0] || $stra[$i]==$na[2].$na[0].$na[1] || $stra[$i]==$na[2].$na[1].$na[0]){$nums=$nums+1;}
			}
			if($nums>=1){
				$rates=explode(";",Get_rate($mid));
				if($na[0]==$na[1] || $na[0]==$na[2] || $na[1]==$na[2]){//组三
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[0]*$modes*$nums)."*times where id='".$row['id']."'");										
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[1]*$modes*$nums)."*times where id='".$row['id']."'");										
				}
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
			}
		}else if($mid=="36" || $mid=="210" || $mid=="298" || $mid=="386" || $mid=="811" || $mid=="160" || $mid=="575" || $mid=="602"){//前三组合值ok 160时时乐组合值 575 3d 602 p3
			$zt=2;
			$cs=$na[0]+$na[1]+$na[2];
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$cs){
					$zt=1;
					break;
				}
			}
			if($zt=="1"){
				$rates=explode(";",Get_rate($mid));			
				if($na[0]==$na[1] || $na[0]==$na[2] || $na[1]==$na[2]){//组3
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[0]*$modes)."*times where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[1]*$modes)."*times where id='".$row['id']."'");				
				}
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}			
		}else if($mid=="37" || $mid=="211" || $mid=="299" || $mid=="387" || $mid=="812"){//前三包胆
			$zt=2;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2]){
					$zt=1;
					break;
				}
			}
			if($zt=="1"){
				$rates=explode(";",Get_rate($mid));			
				if($na[0]==$na[1] || $na[0]==$na[2] || $na[1]==$na[2]){//组3
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[0]*$modes)."*times where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[1]*$modes)."*times where id='".$row['id']."'");				
				}
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="39" || $mid=="213" || $mid=="301" || $mid=="389" || $mid=="814"){//前三和值尾数
			$zt=2;
			$cs=($na[0]+$na[1]+$na[2])%10;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$cs){
					$zt=1;
					break;
				}
			}
			if($zt=="1"){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="41" || $mid=="215" || $mid=="303" || $mid=="391" || $mid=="816"){//前三特殊号
			$na1="";
			$na2="";
			$na3="";
			if($na[0]==$na[1] || $na[1]==$na[2] || $na[0]==$na[2]){$na3="对子";}
			if($na[0]==$na[1] && $na[1]==$na[2]){$na1="豹子";}

			$nb=pnb($na[0].",".$na[1].",".$na[2]);
			if($nb[1]-$nb[0]==1 && $nb[2]-$nb[1]==1){$na2="顺子";}

			$stra=explode("&",$row['codes']);
			$numa=0;			
			$rates=explode(";",Get_rate($mid));
			
			for ($ii=0; $ii<count($stra); $ii++) {
				if($stra[$ii]==$na1){
					$numa=$numa+$rates[0];
				}else if($stra[$ii]==$na2){
					$numa=$numa+$rates[1];
				}else if($stra[$ii]==$na3){
					$numa=$numa+$rates[2];
				}
			}
			if($numa>0){
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($numa*$modes)."*times where id='".$row['id']."'");
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}			
		}else if($mid=="43" || $mid=="217" || $mid=="305" || $mid=="393" || $mid=="818" || $mid=="162" || $mid=="577" || $mid=="604"){//前二直选 162时时乐前2直 577 3d 604p3
			if($row['type']=="input"){//单式
				$cs=$na[0].$na[1];
				$stra=explode("&",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$cs){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
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
				if($nums==2){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}					
		}else if($mid=="44" || $mid=="218" || $mid=="306" || $mid=="394" || $mid=="819"){//前二和值ok165时时乐直选合值 295 3d 323p3
			$zt=2;
			$cs=$na[0]+$na[1];
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$cs){
					$zt=1;
					break;
				}
			}
			if($zt=="1"){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="45" || $mid=="219" || $mid=="307" || $mid=="395" || $mid=="820"){//前二跨度
			$zt=2;
			$cs=abs($na[1]-$na[0]);
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$cs){
					$zt=1;
					break;
				}
			}
			if($zt=="1"){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="47" || $mid=="221" || $mid=="309" || $mid=="397" || $mid=="822" || $mid=="608"){//后二直选 608p3
			if($row['type']=="input"){//单式
				$cs=$na[3].$na[4];
				$stra=explode("&",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$cs){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}

			}else if($row['type']=="digital"){//复式
				$stra=explode("|",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					$strb=explode("&",$stra[$i]);
					for ($ii=0; $ii<count($strb); $ii++) {
						if($strb[$ii]==$na[$i+3]){$nums=$nums+1;}
					}
				}
				if($nums==2){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}		
		}else if($mid=="48" || $mid=="222" || $mid=="310" || $mid=="398" || $mid=="823"){//后二和值ok165时时乐直选合值 295 3d 323p3
			$zt=2;
			$cs=$na[3]+$na[4];
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$cs){
					$zt=1;
					break;
				}
			}
			if($zt=="1"){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="49" || $mid=="223" || $mid=="311" || $mid=="399" || $mid=="824"){//后二跨度
			$zt=2;
			$cs=abs($na[4]-$na[3]);
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$cs){
					$zt=1;
					break;
				}
			}
			if($zt=="1"){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}			
		}else if($mid=="51" || $mid=="225" || $mid=="313" || $mid=="401" || $mid=="826" || $mid=="164" || $mid=="579" || $mid=="606"){//前二组选 164时时乐前二组 579 3d 606p3
			if($row['type']=="input"){//单式
				$stra=explode("&",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$na[0].$na[1] || $stra[$i]==$na[1].$na[0]){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$na[0] || $stra[$i]==$na[1]){$nums=$nums+1;}
				}
				if($nums>=2){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="52" || $mid=="226" || $mid=="314" || $mid=="402" || $mid=="827"){//前二组合值ok 169时时乐组合值 299 3d 327 p3
			$zt=2;
			$cs=$na[0]+$na[1];
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$cs){
					$zt=1;
					break;
				}
			}
			if($zt=="1"){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}			
		}else if($mid=="53" || $mid=="227" || $mid=="315" || $mid=="403" || $mid=="828"){//前二包胆
			$zt=2;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[0] || $stra[$i]==$na[1]){
					$zt=1;
					break;
				}
			}
			if($zt=="1"){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}			
		}else if($mid=="55" || $mid=="229" || $mid=="317" || $mid=="405" || $mid=="830" || $mid=="610"){//后二组选 610p3
			if($row['type']=="input"){//单式
				$stra=explode("&",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$na[3].$na[4] || $stra[$i]==$na[4].$na[3]){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$na[3] || $stra[$i]==$na[4]){$nums=$nums+1;}
				}
				if($nums>=2){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}			
		}else if($mid=="56" || $mid=="230" || $mid=="318" || $mid=="406" || $mid=="831"){//后二组合值ok 169时时乐组合值 299 3d 327 p3
			$zt=2;
			$cs=$na[3]+$na[4];
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$cs){
					$zt=1;
					break;
				}
			}
			if($zt=="1"){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}			
		}else if($mid=="57" || $mid=="231" || $mid=="319" || $mid=="407" || $mid=="832"){//后二包胆
			$zt=2;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[3] || $stra[$i]==$na[4]){
					$zt=1;
					break;
				}
			}
			if($zt=="1"){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}					
		}else if($mid=="59" || $mid=="233" || $mid=="321" || $mid=="409" || $mid=="834" || $mid=="170" || $mid=="585" || $mid=="612"){//定位胆ok 170时时乐 585 3d 612 p3 
			$stra=explode("|",$row['codes']);
			$nums=0;
			for ($i=0; $i<count($stra); $i++) {
				$strb=explode("&",$stra[$i]);
				for ($ii=0; $ii<count($strb); $ii++) {
					if($strb[$ii]==$na[$i]){$nums=$nums+1;}
				}
			}
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="65" || $mid=="239" || $mid=="327" || $mid=="415" || $mid=="840"){//后三一码不定位ok
			$nums=0;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[2] || $stra[$i]==$na[3] || $stra[$i]==$na[4]){$nums=$nums+1;}
			}
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="66" || $mid=="240" || $mid=="328" || $mid=="416" || $mid=="841"){//前三一码不定位ok
			$nums=0;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2]){$nums=$nums+1;}
			}
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="68" || $mid=="242" || $mid=="330" || $mid=="418" || $mid=="843"){//后三二码不定位ok
			$nums=0;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[2] || $stra[$i]==$na[3] || $stra[$i]==$na[4]){$nums=$nums+1;}
			}
			if($nums==2){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else if($nums==3){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*3 where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="69" || $mid=="243" || $mid=="331" || $mid=="419" || $mid=="844"){//前三二码不定位ok
			$nums=0;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2]){$nums=$nums+1;}
			}
			if($nums==2){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else if($nums==3){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*3 where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="71" || $mid=="245" || $mid=="333" || $mid=="421" || $mid=="846"){//四星一码不定位ok
			$nums=0;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[1] || $stra[$i]==$na[2] || $stra[$i]==$na[3] || $stra[$i]==$na[4]){$nums=$nums+1;}
			}
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="73" || $mid=="247" || $mid=="335" || $mid=="423" || $mid=="848"){//四星二码不定位ok
			$nums=0;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[1] || $stra[$i]==$na[2] || $stra[$i]==$na[3] || $stra[$i]==$na[4]){$nums=$nums+1;}
			}
			if($nums==2){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else if($nums==3){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*3 where id='".$row['id']."'");						
			}else if($nums==4){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*6 where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="75" || $mid=="249" || $mid=="337" || $mid=="425" || $mid=="850"){//五星二码不定位ok
			$nums=0;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2] || $stra[$i]==$na[3] || $stra[$i]==$na[4]){$nums=$nums+1;}
			}
			if($nums==2){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else if($nums==3){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*3 where id='".$row['id']."'");						
			}else if($nums==4){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*6 where id='".$row['id']."'");						
			}else if($nums==5){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*10 where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="77" || $mid=="251" || $mid=="339" || $mid=="427" || $mid=="852"){//五星三码不定位ok
			$nums=0;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2] || $stra[$i]==$na[3] || $stra[$i]==$na[4]){$nums=$nums+1;}
			}
			if($nums==3){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else if($nums==4){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*4 where id='".$row['id']."'");						
			}else if($nums==5){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*10 where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="79" || $mid=="253" || $mid=="341" || $mid=="429" || $mid=="854" || $mid=="593" || $mid=="622"){//前二大小单双 时时乐 593 3d 622 p3
			if($na[0]>4){$na1a="大";}else{$na1a="小";}
			if ($na[0]%2==1){$na1b="单";}else{$na1b="双";}
			if($na[1]>4){$na2a="大";}else{$na2a="小";}
			if ($na[1]%2==1){$na2b="单";}else{$na2b="双";}
			$stra=explode("|",$row['codes']);
			$numa=0;
			$numb=0;
			$strb=explode("&",$stra[0]);
			for ($ii=0; $ii<count($strb); $ii++) {
				if($strb[$ii]==$na1a || $strb[$ii]==$na1b){$numa=$numa+1;}
			}
			$strb=explode("&",$stra[1]);
			for ($ii=0; $ii<count($strb); $ii++) {
				if($strb[$ii]==$na2a || $strb[$ii]==$na2b){$numb=$numb+1;}
			}
			$nums=$numa*$numb;
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="80" || $mid=="254" || $mid=="342" || $mid=="430" || $mid=="855" || $mid=="623"){//后二大小单双ok 623 p3
			if($na[3]>4){$na1a="大";}else{$na1a="小";}
			if ($na[3]%2==1){$na1b="单";}else{$na1b="双";}
			if($na[4]>4){$na2a="大";}else{$na2a="小";}
			if ($na[4]%2==1){$na2b="单";}else{$na2b="双";}
			$stra=explode("|",$row['codes']);
			$numa=0;
			$numb=0;
			$strb=explode("&",$stra[0]);
			for ($ii=0; $ii<count($strb); $ii++) {
				if($strb[$ii]==$na1a || $strb[$ii]==$na1b){$numa=$numa+1;}
			}
			$strb=explode("&",$stra[1]);
			for ($ii=0; $ii<count($strb); $ii++) {
				if($strb[$ii]==$na2a || $strb[$ii]==$na2b){$numb=$numb+1;}
			}
			
			$nums=$numa*$numb;
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="82" || $mid=="256" || $mid=="344" || $mid=="432" || $mid=="857"){//前三大小单双 179时时乐 309 3d 335 p3
			if($na[0]>4){$na1a="大";}else{$na1a="小";}
			if ($na[0]%2==1){$na1b="单";}else{$na1b="双";}
			if($na[1]>4){$na2a="大";}else{$na2a="小";}
			if ($na[1]%2==1){$na2b="单";}else{$na2b="双";}
			if($na[2]>4){$na3a="大";}else{$na3a="小";}
			if ($na[2]%2==1){$na3b="单";}else{$na3b="双";}
			$stra=explode("|",$row['codes']);
			$numa=0;
			$numb=0;
			$numc=0;
			$strb=explode("&",$stra[0]);
			for ($ii=0; $ii<count($strb); $ii++) {
				if($strb[$ii]==$na1a || $strb[$ii]==$na1b){$numa=$numa+1;}
			}
			$strb=explode("&",$stra[1]);
			for ($ii=0; $ii<count($strb); $ii++) {
				if($strb[$ii]==$na2a || $strb[$ii]==$na2b){$numb=$numb+1;}
			}
			$strb=explode("&",$stra[2]);
			for ($ii=0; $ii<count($strb); $ii++) {
				if($strb[$ii]==$na3a || $strb[$ii]==$na3b){$numc=$numc+1;}
			}

			$nums=$numa*$numb*$numc;
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="83" || $mid=="257" || $mid=="345" || $mid=="433" || $mid=="858"){//后三大小单双ok 336 p3
			if($na[2]>4){$na1a="大";}else{$na1a="小";}
			if ($na[2]%2==1){$na1b="单";}else{$na1b="双";}
			if($na[3]>4){$na2a="大";}else{$na2a="小";}
			if ($na[3]%2==1){$na2b="单";}else{$na2b="双";}
			if($na[4]>4){$na3a="大";}else{$na3a="小";}
			if ($na[4]%2==1){$na3b="单";}else{$na3b="双";}
			$stra=explode("|",$row['codes']);
			$numa=0;
			$numb=0;
			$numc=0;
			$strb=explode("&",$stra[0]);
			for ($ii=0; $ii<count($strb); $ii++) {
				if($strb[$ii]==$na1a || $strb[$ii]==$na1b){$numa=$numa+1;}
			}
			$strb=explode("&",$stra[1]);
			for ($ii=0; $ii<count($strb); $ii++) {
				if($strb[$ii]==$na2a || $strb[$ii]==$na2b){$numb=$numb+1;}
			}
			$strb=explode("&",$stra[2]);
			for ($ii=0; $ii<count($strb); $ii++) {
				if($strb[$ii]==$na3a || $strb[$ii]==$na3b){$numc=$numc+1;}
			}
			
			$nums=$numa*$numb*$numc;
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="85" || $mid=="259" || $mid=="347" || $mid=="435" || $mid=="860"){//一帆风顺
			$stra=explode("&",$row['codes']);
			$numa=0;
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2] || $stra[$i]==$na[3] || $stra[$i]==$na[4]){$numa=$numa+1;}
			}
			if($numa>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="86" || $mid=="260" || $mid=="348" || $mid=="436" || $mid=="861"){//好事成双
			$stra=explode("&",$row['codes']);
			$numa=0;
			$nb=pnb($rowz['code']);
			for ($i=0; $i<count($stra); $i++) {
				if(($stra[$i]==$nb[0] && $stra[$i]==$nb[1]) || ($stra[$i]==$nb[1] && $stra[$i]==$nb[2]) || ($stra[$i]==$nb[2] && $stra[$i]==$nb[3]) || ($stra[$i]==$nb[3] && $stra[$i]==$nb[4])){$numa=$numa+1;}
			}
			if($numa>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa." where id='".$row['id']."'");
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="87" || $mid=="261" || $mid=="349" || $mid=="437" || $mid=="862"){//三星报喜
			$stra=explode("&",$row['codes']);
			$numa=0;
			$nb=pnb($rowz['code']);
			for ($i=0; $i<count($stra); $i++) {
				if(($stra[$i]==$nb[0] && $stra[$i]==$nb[1] && $stra[$i]==$nb[2]) || ($stra[$i]==$nb[1] && $stra[$i]==$nb[2] && $stra[$i]==$nb[3]) || ($stra[$i]==$nb[2] && $stra[$i]==$nb[3] && $stra[$i]==$nb[4])){$numa=$numa+1;}
			}
			if($numa>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa." where id='".$row['id']."'");
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="88" || $mid=="262" || $mid=="350" || $mid=="438" || $mid=="863"){//四季发财
			$stra=explode("&",$row['codes']);
			$numa=0;
			$nb=pnb($rowz['code']);
			for ($i=0; $i<count($stra); $i++) {
				if(($stra[$i]==$nb[0] && $stra[$i]==$nb[1] && $stra[$i]==$nb[2] && $stra[$i]==$nb[3]) || ($stra[$i]==$nb[1] && $stra[$i]==$nb[2] && $stra[$i]==$nb[3] && $stra[$i]==$nb[4])){$numa=$numa+1;}
			}
			if($numa>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa." where id='".$row['id']."'");
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="654"){//任二直选
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
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa." where id='".$row['id']."'");
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
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else if($nums==3){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*3 where id='".$row['id']."'");
				}else if($nums==4){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*6 where id='".$row['id']."'");
				}else if($nums==5){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*10 where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="755"){//任二直选和值
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
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa." where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="664"){//任二组选
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
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa." where id='".$row['id']."'");
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
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="765"){//任二组选和值
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
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}		
		}else if($mid=="676"){//任三直选
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
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa." where id='".$row['id']."'");
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
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else if($nums==4){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*4 where id='".$row['id']."'");
				}else if($nums==5){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*10 where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="708"){//任三直选和值
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
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa." where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="686"){//任三组选组三
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
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa." where id='".$row['id']."'");
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
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa." where id='".$row['id']."'");		
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="696"){//任三组选组六
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
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa." where id='".$row['id']."'");
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
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa." where id='".$row['id']."'");		
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="718"){//任三组选和值
			$numa=0;
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
											break;
										}
									}
								}
							}
						}
					}
				}
			}
			if($numa>=0){
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($numa*$modes)."*times where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="775"){//任三组选混合
			$numa=0;
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
										}
									}
								}
							}
						}
					}
				}
			}
			if($numa>0){
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($numa*$modes)."*times where id='".$row['id']."'");									
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");					
			}	
		}else if($mid=="725"){//任四直选
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
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa." where id='".$row['id']."'");
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
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else if($nums==5){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*5 where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="730"){//任四组选24
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
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$numa." where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="735"){//任四组选12
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
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="740"){//任四组选6
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
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="745"){//任四组选4
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
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	
		}else if($mid=="90" || $mid=="440" || $mid=="483" || $mid=="526"){//115前三直选
			if($row['type']=="input"){//单式
				$cs=$na[0]." ".$na[1]." ".$na[2];
				$stra=explode("&",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$cs){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
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
				if($nums==3){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="92" || $mid=="442" || $mid=="485" || $mid=="528"){//115前三组选
			if($row['type']=="input"){//单式
				$stra=explode("&",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$na[0]." ".$na[1]." ".$na[2] || $stra[$i]==$na[0]." ".$na[2]." ".$na[1] || $stra[$i]==$na[1]." ".$na[0]." ".$na[2] || $stra[$i]==$na[1]." ".$na[2]." ".$na[0] || $stra[$i]==$na[2]." ".$na[0]." ".$na[1] || $stra[$i]==$na[2]." ".$na[1]." ".$na[0]){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2]){$nums=$nums+1;}
				}
				if($nums>=3){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="123" || $mid=="443" || $mid=="486" || $mid=="529"){//115前三组选胆拖
			$numa=0;
			$numb=0;
			$stra=explode("|",$row['codes']);
			$strb=explode("&",$stra[0]);
			for ($i=0; $i<count($strb); $i++) {
				if($strb[$i]==$na[0] || $strb[$i]==$na[1] || $strb[$i]==$na[2]){$numa=$numa+1;}
			}
			$strc=explode("&",$stra[1]);
			for ($i=0; $i<count($strc); $i++) {
				if($strc[$i]==$na[0] || $strc[$i]==$na[1] || $strc[$i]==$na[2]){$numb=$numb+1;}
			}
			if($numa==count($strb) && $numb + $numa>=3){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="94" || $mid=="445" || $mid=="488" || $mid=="531"){//115前二直选
			if($row['type']=="input"){//单式
				$cs=$na[0]." ".$na[1];
				$stra=explode("&",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$cs){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
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
				if($nums==2){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="96" || $mid=="447" || $mid=="490" || $mid=="533"){//115前二组选
			if($row['type']=="input"){//单式
				$stra=explode("&",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$na[0]." ".$na[1] || $stra[$i]==$na[1]." ".$na[0]){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$na[0] || $stra[$i]==$na[1]){$nums=$nums+1;}
				}
				if($nums>=2){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="124" || $mid=="448" || $mid=="491" || $mid=="534"){//115前二组选胆拖
			$numa=0;
			$numb=0;
			$stra=explode("|",$row['codes']);
			$strb=explode("&",$stra[0]);
			for ($i=0; $i<count($strb); $i++) {
				if($strb[$i]==$na[0] || $strb[$i]==$na[1]){$numa=$numa+1;}
			}
			$strc=explode("&",$stra[1]);
			for ($i=0; $i<count($strc); $i++) {
				if($strc[$i]==$na[0] || $strc[$i]==$na[1]){$numb=$numb+1;}
			}
			if($numb>=1 && $numa>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="98" || $mid=="450" || $mid=="493" || $mid=="536"){//115前三不定位ok
			$nums=0;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2]){$nums=$nums+1;}
			}
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="100" || $mid=="452" || $mid=="495" || $mid=="538"){//定位胆ok 
			$stra=explode("|",$row['codes']);
			$nums=0;
			for ($i=0; $i<count($stra); $i++) {
				$strb=explode("&",$stra[$i]);
				for ($ii=0; $ii<count($strb); $ii++) {
					if($strb[$ii]==$na[$i]){$nums=$nums+1;}
				}
			}
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="104" || $mid=="456" || $mid=="499" || $mid=="542"){//定单双
			$numa=0;
			if (intval($na[0])%2==0){$numa=$numa+1;}
			if (intval($na[1])%2==0){$numa=$numa+1;}
			if (intval($na[2])%2==0){$numa=$numa+1;}
			if (intval($na[3])%2==0){$numa=$numa+1;}
			if (intval($na[4])%2==0){$numa=$numa+1;}
			$numstr=(5-$numa)."单".$numa."双";
			$rates=explode(";",Get_rate($mid));
			if($numa==0){
				$rate=$rates[1];
			}elseif($numa==1){
				$rate=$rates[3];
			}elseif($numa==2){
				$rate=$rates[5];
			}elseif($numa==3){
				$rate=$rates[4];
			}elseif($numa==4){
				$rate=$rates[2];
			}elseif($numa==5){
				$rate=$rates[0];
			}
			if(strpos($row['codes'],$numstr)===false){
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
			}else{
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($rate*$modes)."*times where id='".$row['id']."'");
			}
		}else if($mid=="106" || $mid=="458" || $mid=="501" || $mid=="544"){//猜中位
			$rates=explode(";",Get_rate($mid));
			$nb=pnb($rowz['code']);
			$nums=intval($nb[2]);
			if(strpos($row['codes'],strval($nums))===false){//字符类型转换
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
			}else{
				if($nums>6){
					$nums=12-$nums;
				}
//			echo $nums;
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[$nums-3]*$modes)."*times where id='".$row['id']."'");
			}
		}else if($mid=="108" || $mid=="460" || $mid=="503" || $mid=="546"){//任选1中1
			$nums=0;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2] || $stra[$i]==$na[3] || $stra[$i]==$na[4]){$nums=$nums+1;}
			}
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="110" || $mid=="462" || $mid=="505" || $mid=="548"){//任选2中2
			if($row['type']=="input"){//单式
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					$numa=0;
					$strb=explode(" ",$stra[$i]);
					for ($ii=0; $ii<count($strb); $ii++) {
						if($strb[$ii]==$na[0] || $strb[$ii]==$na[1] || $strb[$ii]==$na[2] || $strb[$ii]==$na[3] || $strb[$ii]==$na[4]){$numa=$numa+1;}
					}
					if($numa>=2){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2] || $stra[$i]==$na[3] || $stra[$i]==$na[4]){$nums=$nums+1;}
				}
				if($nums>=2){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".($nums*($nums-1)/2)." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="112" || $mid=="465" || $mid=="508" || $mid=="551"){//任选3中3
			if($row['type']=="input"){//单式
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					$numa=0;
					$strb=explode(" ",$stra[$i]);
					for ($ii=0; $ii<count($strb); $ii++) {
						if($strb[$ii]==$na[0] || $strb[$ii]==$na[1] || $strb[$ii]==$na[2] || $strb[$ii]==$na[3] || $strb[$ii]==$na[4]){$numa=$numa+1;}
					}
					if($numa>=3){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2] || $stra[$i]==$na[3] || $stra[$i]==$na[4]){$nums=$nums+1;}
				}
				if($nums>=3){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".($nums*($nums-1)*($nums-2)/6)." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="114" || $mid=="468" || $mid=="511" || $mid=="554"){//任选4中4
			if($row['type']=="input"){//单式
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					$numa=0;
					$strb=explode(" ",$stra[$i]);
					for ($ii=0; $ii<count($strb); $ii++) {
						if($strb[$ii]==$na[0] || $strb[$ii]==$na[1] || $strb[$ii]==$na[2] || $strb[$ii]==$na[3] || $strb[$ii]==$na[4]){$numa=$numa+1;}
					}
					if($numa>=4){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2] || $stra[$i]==$na[3] || $stra[$i]==$na[4]){$nums=$nums+1;}
				}
				if($nums>=4){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".($nums*($nums-1)*($nums-2)*($nums-3)/24)." where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="116" || $mid=="471" || $mid=="514" || $mid=="557"){//任选5中5
			if($row['type']=="input"){//单式
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					$numa=0;
					$strb=explode(" ",$stra[$i]);
					for ($ii=0; $ii<count($strb); $ii++) {
						if($strb[$ii]==$na[0] || $strb[$ii]==$na[1] || $strb[$ii]==$na[2] || $strb[$ii]==$na[3] || $strb[$ii]==$na[4]){$numa=$numa+1;}
					}
					if($numa>=5){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2] || $stra[$i]==$na[3] || $stra[$i]==$na[4]){$nums=$nums+1;}
				}
				if($nums>=5){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="118" || $mid=="474" || $mid=="517" || $mid=="560"){//任选6中5 75 85
			if($row['type']=="input"){//单式
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					$numa=0;
					$strb=explode(" ",$stra[$i]);
					for ($ii=0; $ii<count($strb); $ii++) {
						if($strb[$ii]==$na[0] || $strb[$ii]==$na[1] || $strb[$ii]==$na[2] || $strb[$ii]==$na[3] || $strb[$ii]==$na[4]){$numa=$numa+1;}
					}
					if($numa>=5){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2] || $stra[$i]==$na[3] || $stra[$i]==$na[4]){$nums=$nums+1;}
				}
				if($nums>=5){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".(count($stra)-5)." where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");	
				}
			}

		}else if($mid=="120" || $mid=="477" || $mid=="520" || $mid=="563"){//任选7中5
			if($row['type']=="input"){//单式
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					$numa=0;
					$strb=explode(" ",$stra[$i]);
					for ($ii=0; $ii<count($strb); $ii++) {
						if($strb[$ii]==$na[0] || $strb[$ii]==$na[1] || $strb[$ii]==$na[2] || $strb[$ii]==$na[3] || $strb[$ii]==$na[4]){$numa=$numa+1;}
					}
					if($numa>=5){$nums=$nums+1;}

				}
				if($nums>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2] || $stra[$i]==$na[3] || $stra[$i]==$na[4]){$nums=$nums+1;}
				}
				if($nums>=5){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".((count($stra)-5)*(count($stra)-6)/2)." where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");	
				}
			}
		}else if($mid=="122" || $mid=="480" || $mid=="523" || $mid=="566"){//任选8中5
			if($row['type']=="input"){//单式
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					$numa=0;
					$strb=explode(" ",$stra[$i]);
					for ($ii=0; $ii<count($strb); $ii++) {
						if($strb[$ii]==$na[0] || $strb[$ii]==$na[1] || $strb[$ii]==$na[2] || $strb[$ii]==$na[3] || $strb[$ii]==$na[4]){$numa=$numa+1;}
					}
					if($numa>=5){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2] || $stra[$i]==$na[3] || $stra[$i]==$na[4]){$nums=$nums+1;}
				}
				if($nums>=5){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".((count($stra)-5)*(count($stra)-6)*(count($stra)-7)/6)." where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");	
				}
			}
		}else if($mid=="125" || $mid=="463" || $mid=="506" || $mid=="549"){//任选2中2胆拖
			$numa=0;
			$numb=0;
			$stra=explode("|",$row['codes']);
			$strb=explode("&",$stra[0]);
			for ($i=0; $i<count($strb); $i++) {
				if($strb[$i]==$na[0] || $strb[$i]==$na[1] || $strb[$i]==$na[2] || $strb[$i]==$na[3] || $strb[$i]==$na[4]){$numa=$numa+1;}
			}
			$strc=explode("&",$stra[1]);
			for ($i=0; $i<count($strc); $i++) {
				if($strc[$i]==$na[0] || $strc[$i]==$na[1] || $strc[$i]==$na[2] || $strc[$i]==$na[3] || $strc[$i]==$na[4]){$numb=$numb+1;}
			}
			if($numa>=1 && $numb>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".($numa*$numb)." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="126" || $mid=="466" || $mid=="509" || $mid=="552"){//任选3中3胆拖
			$numa=0;
			$numb=0;
			$nums=0;
			$stra=explode("|",$row['codes']);
			$strb=explode("&",$stra[0]);
			for ($i=0; $i<count($strb); $i++) {
				if($strb[$i]==$na[0] || $strb[$i]==$na[1] || $strb[$i]==$na[2] || $strb[$i]==$na[3] || $strb[$i]==$na[4]){$numa=$numa+1;}
			}
			$strc=explode("&",$stra[1]);
			for ($i=0; $i<count($strc); $i++) {
				if($strc[$i]==$na[0] || $strc[$i]==$na[1] || $strc[$i]==$na[2] || $strc[$i]==$na[3] || $strc[$i]==$na[4]){$numb=$numb+1;}
			}
			if($numa==count($strb) && $numa+$numb>=3){
				if($numa==1){
					$nums=$numb*($numb-1)/2;
				}
				if($numa==2){
					$nums=$numb;
				}
			}
//			echo "t".$numa.$numb;
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="127" || $mid=="469" || $mid=="512" || $mid=="555"){//任选4中4胆拖
			$numa=0;
			$numb=0;
			$nums=0;
			$stra=explode("|",$row['codes']);
			$strb=explode("&",$stra[0]);
			for ($i=0; $i<count($strb); $i++) {
				if($strb[$i]==$na[0] || $strb[$i]==$na[1] || $strb[$i]==$na[2] || $strb[$i]==$na[3] || $strb[$i]==$na[4]){$numa=$numa+1;}
			}
			$strc=explode("&",$stra[1]);
			for ($i=0; $i<count($strc); $i++) {
				if($strc[$i]==$na[0] || $strc[$i]==$na[1] || $strc[$i]==$na[2] || $strc[$i]==$na[3] || $strc[$i]==$na[4]){$numb=$numb+1;}
			}
			if($numa==count($strb) && $numa+$numb>=4){
				if($numa==1){
					$nums=$numb*($numb-1)*($numb-2)/6;
				}
				if($numa==2){
					$nums=$numb*($numb-1)/2;
				}
				if($numa==3){
					$nums=$numb;
				}
			}
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="128" || $mid=="472" || $mid=="515" || $mid=="558"){//任选5中5胆拖
			$numa=0;
			$numb=0;
			$stra=explode("|",$row['codes']);
			$strb=explode("&",$stra[0]);
			for ($i=0; $i<count($strb); $i++) {
				if($strb[$i]==$na[0] || $strb[$i]==$na[1] || $strb[$i]==$na[2] || $strb[$i]==$na[3] || $strb[$i]==$na[4]){$numa=$numa+1;}
			}
			$strc=explode("&",$stra[1]);
			for ($i=0; $i<count($strc); $i++) {
				if($strc[$i]==$na[0] || $strc[$i]==$na[1] || $strc[$i]==$na[2] || $strc[$i]==$na[3] || $strc[$i]==$na[4]){$numb=$numb+1;}
			}
			if($numa==count($strb) && $numa+$numb>=5){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="129" || $mid=="475" || $mid=="518" || $mid=="561"){//任选6中5胆拖 75 85
			$numa=0;
			$numb=0;
			$nums=0;
			$stra=explode("|",$row['codes']);
			$strb=explode("&",$stra[0]);
			for ($i=0; $i<count($strb); $i++) {
				if($strb[$i]==$na[0] || $strb[$i]==$na[1] || $strb[$i]==$na[2] || $strb[$i]==$na[3] || $strb[$i]==$na[4]){$numa=$numa+1;}
			}
			$strc=explode("&",$stra[1]);
			for ($i=0; $i<count($strc); $i++) {
				if($strc[$i]==$na[0] || $strc[$i]==$na[1] || $strc[$i]==$na[2] || $strc[$i]==$na[3] || $strc[$i]==$na[4]){$numb=$numb+1;}
			}
			
			if($numa + $numb==5 ){
				if(count($strb)==$numa){
					$nums=count($strc)-$numb;
				}
				if(count($strb)-$numa==1){
					$nums=1;
				}
			}
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="130" || $mid=="478" || $mid=="521" || $mid=="564"){//任选7中5胆拖
			$numa=0;
			$numb=0;
			$nums=0;
			$stra=explode("|",$row['codes']);
			$strb=explode("&",$stra[0]);
			for ($i=0; $i<count($strb); $i++) {
				if($strb[$i]==$na[0] || $strb[$i]==$na[1] || $strb[$i]==$na[2] || $strb[$i]==$na[3] || $strb[$i]==$na[4]){$numa=$numa+1;}
			}
			$strc=explode("&",$stra[1]);
			for ($i=0; $i<count($strc); $i++) {
				if($strc[$i]==$na[0] || $strc[$i]==$na[1] || $strc[$i]==$na[2] || $strc[$i]==$na[3] || $strc[$i]==$na[4]){$numb=$numb+1;}
			}
			if($numa + $numb==5 ){
				if(count($strb)==$numa){
					$nums=(count($strc)-$numb)*(count($strc)-$numb-1)/2;
				}
				if(count($strb)-$numa==1){
					$nums=count($strc)-$numb;
				}
				if(count($strb)-$numa==2){
					$nums=1;
				}
			}
			
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="131" || $mid=="481" || $mid=="524" || $mid=="567"){//任选8中5胆拖
			$numa=0;
			$numb=0;
			$nums=0;
			$stra=explode("|",$row['codes']);
			$strb=explode("&",$stra[0]);
			for ($i=0; $i<count($strb); $i++) {
				if($strb[$i]==$na[0] || $strb[$i]==$na[1] || $strb[$i]==$na[2] || $strb[$i]==$na[3] || $strb[$i]==$na[4]){$numa=$numa+1;}
			}
			$strc=explode("&",$stra[1]);
			for ($i=0; $i<count($strc); $i++) {
				if($strc[$i]==$na[0] || $strc[$i]==$na[1] || $strc[$i]==$na[2] || $strc[$i]==$na[3] || $strc[$i]==$na[4]){$numb=$numb+1;}
			}
			if($numa + $numb==5 ){
				if(count($strb)==$numa){
					$nums=(count($strc)-$numb)*(count($strc)-$numb-1)*(count($strc)-$numb-2)/6;
				}
				if(count($strb)-$numa==1){
					$nums=(count($strc)-$numb)*(count($strc)-$numb-1)/2;
				}
				if(count($strb)-$numa==2){
					$nums=count($strc)-$numb;
				}
				if(count($strb)-$numa==3){
					$nums=1;
				}
			}
			
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}

		}else if($mid=="133"){//北京任选一
			$nums=0;
			$stra=explode("&",$row['codes']);
			$rates=Get_rate($mid);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2] || $stra[$i]==$na[3] || $stra[$i]==$na[4] || $stra[$i]==$na[5] || $stra[$i]==$na[6] || $stra[$i]==$na[7] || $stra[$i]==$na[8] || $stra[$i]==$na[9] || $stra[$i]==$na[10] || $stra[$i]==$na[11] || $stra[$i]==$na[12] || $stra[$i]==$na[13] || $stra[$i]==$na[14] || $stra[$i]==$na[15] || $stra[$i]==$na[16] || $stra[$i]==$na[17] || $stra[$i]==$na[18] || $stra[$i]==$na[19]){$nums=$nums+1;}
			}
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=times*".($rates*$modes*$nums)." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");	
			}
		}else if($mid=="135"){//北京任选二
			$nums=0;
			$stra=explode("&",$row['codes']);
			$rates=Get_rate($mid);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2] || $stra[$i]==$na[3] || $stra[$i]==$na[4] || $stra[$i]==$na[5] || $stra[$i]==$na[6] || $stra[$i]==$na[7] || $stra[$i]==$na[8] || $stra[$i]==$na[9] || $stra[$i]==$na[10] || $stra[$i]==$na[11] || $stra[$i]==$na[12] || $stra[$i]==$na[13] || $stra[$i]==$na[14] || $stra[$i]==$na[15] || $stra[$i]==$na[16] || $stra[$i]==$na[17] || $stra[$i]==$na[18] || $stra[$i]==$na[19]){$nums=$nums+1;}
			}
			if($nums>=2){
				mysql_query("update ssc_bills set zt=".$signa.",prize=times*".($rates*$modes*$nums*($nums-1)/2)." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="137"){//北京任选三 3中3中2
			$nums=0;
			$stra=explode("&",$row['codes']);
			$cnum=count($stra);
			$rates=explode(";",Get_rate($mid));
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2] || $stra[$i]==$na[3] || $stra[$i]==$na[4] || $stra[$i]==$na[5] || $stra[$i]==$na[6] || $stra[$i]==$na[7] || $stra[$i]==$na[8] || $stra[$i]==$na[9] || $stra[$i]==$na[10] || $stra[$i]==$na[11] || $stra[$i]==$na[12] || $stra[$i]==$na[13] || $stra[$i]==$na[14] || $stra[$i]==$na[15] || $stra[$i]==$na[16] || $stra[$i]==$na[17] || $stra[$i]==$na[18] || $stra[$i]==$na[19]){$nums=$nums+1;}
			}
			if($nums>=2){
				$numa=($cnum-$nums)*$nums*($nums-1)/2;
				$numb=$nums*($nums-1)*($nums-2)/6;
				$rate=$numa*$rates[1]+$numb*$rates[0];
				
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($rate*$modes)."*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="139"){//北京任选四 4中432
			$nums=0;
			$stra=explode("&",$row['codes']);
			$cnum=count($stra);
			$rates=explode(";",Get_rate($mid));
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2] || $stra[$i]==$na[3] || $stra[$i]==$na[4] || $stra[$i]==$na[5] || $stra[$i]==$na[6] || $stra[$i]==$na[7] || $stra[$i]==$na[8] || $stra[$i]==$na[9] || $stra[$i]==$na[10] || $stra[$i]==$na[11] || $stra[$i]==$na[12] || $stra[$i]==$na[13] || $stra[$i]==$na[14] || $stra[$i]==$na[15] || $stra[$i]==$na[16] || $stra[$i]==$na[17] || $stra[$i]==$na[18] || $stra[$i]==$na[19]){$nums=$nums+1;}
			}
			if($nums>=2){
				$numa=($cnum-$nums)*($cnum-$nums-1)*$nums*($nums-1)/4;
				$numb=($cnum-$nums)*$nums*($nums-1)*($nums-2)/6;
				$numc=$nums*($nums-1)*($nums-2)*($nums-3)/24;
				$rate=$numa*$rates[2]+$numb*$rates[1]+$numc*$rates[0];
				
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($rate*$modes)."*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="141"){//北京任选五 5中543
			$nums=0;
			$stra=explode("&",$row['codes']);
			$cnum=count($stra);
			$rates=explode(";",Get_rate($mid));
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2] || $stra[$i]==$na[3] || $stra[$i]==$na[4] || $stra[$i]==$na[5] || $stra[$i]==$na[6] || $stra[$i]==$na[7] || $stra[$i]==$na[8] || $stra[$i]==$na[9] || $stra[$i]==$na[10] || $stra[$i]==$na[11] || $stra[$i]==$na[12] || $stra[$i]==$na[13] || $stra[$i]==$na[14] || $stra[$i]==$na[15] || $stra[$i]==$na[16] || $stra[$i]==$na[17] || $stra[$i]==$na[18] || $stra[$i]==$na[19]){$nums=$nums+1;}
			}
			if($nums>=3){
				$numa=($cnum-$nums)*($cnum-$nums-1)*$nums*($nums-1)*($nums-2)/12;
				$numb=($cnum-$nums)*$nums*($nums-1)*($nums-2)*($nums-3)/24;
				$numc=$nums*($nums-1)*($nums-2)*($nums-3)*($nums-4)/120;
				$rate=$numa*$rates[2]+$numb*$rates[1]+$numc*$rates[0];
//				echo "t".$numa." ".$numb." ".$numc." ".$rate." ".$rates[0]." ".$rates[1]." ".$rates[2]."s";
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($rate*$modes)."*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="143"){//北京任选六 6中6543
			$nums=0;
			$stra=explode("&",$row['codes']);
			$cnum=count($stra);
			$rates=explode(";",Get_rate($mid));
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2] || $stra[$i]==$na[3] || $stra[$i]==$na[4] || $stra[$i]==$na[5] || $stra[$i]==$na[6] || $stra[$i]==$na[7] || $stra[$i]==$na[8] || $stra[$i]==$na[9] || $stra[$i]==$na[10] || $stra[$i]==$na[11] || $stra[$i]==$na[12] || $stra[$i]==$na[13] || $stra[$i]==$na[14] || $stra[$i]==$na[15] || $stra[$i]==$na[16] || $stra[$i]==$na[17] || $stra[$i]==$na[18] || $stra[$i]==$na[19]){$nums=$nums+1;}
			}
			if($nums>=3){
				$numa=($cnum-$nums)*($cnum-$nums-1)*($cnum-$nums-2)*$nums*($nums-1)*($nums-2)/36;
				$numb=($cnum-$nums)*($cnum-$nums-1)*$nums*($nums-1)*($nums-2)*($nums-3)/48;
				$numc=($cnum-$nums)*$nums*($nums-1)*($nums-2)*($nums-3)*($nums-4)/120;
				$numd=$nums*($nums-1)*($nums-2)*($nums-3)*($nums-4)*($nums-5)/720;
				$rate=$numa*$rates[3]+$numb*$rates[2]+$numc*$rates[1]+$numd*$rates[0];
//				echo "t".$numa." ".$numb." ".$numc." ".$numd." ".$rate." ".$rates[0]." ".$rates[1]." ".$rates[2]." ".$rates[3]."s";
			
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($rate*$modes)."*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="145"){//北京任选七 7中76540
			$nums=0;
			$stra=explode("&",$row['codes']);
			$cnum=count($stra);
			$rates=explode(";",Get_rate($mid));
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2] || $stra[$i]==$na[3] || $stra[$i]==$na[4] || $stra[$i]==$na[5] || $stra[$i]==$na[6] || $stra[$i]==$na[7] || $stra[$i]==$na[8] || $stra[$i]==$na[9] || $stra[$i]==$na[10] || $stra[$i]==$na[11] || $stra[$i]==$na[12] || $stra[$i]==$na[13] || $stra[$i]==$na[14] || $stra[$i]==$na[15] || $stra[$i]==$na[16] || $stra[$i]==$na[17] || $stra[$i]==$na[18] || $stra[$i]==$na[19]){$nums=$nums+1;}
			}
			if($nums>=4){
				$numa=($cnum-$nums)*($cnum-$nums-1)*($cnum-$nums-2)*$nums*($nums-1)*($nums-2)*($nums-3)/144;
				$numb=($cnum-$nums)*($cnum-$nums-1)*$nums*($nums-1)*($nums-2)*($nums-3)*($nums-4)/240;
				$numc=($cnum-$nums)*$nums*($nums-1)*($nums-2)*($nums-3)*($nums-4)*($nums-5)/620;
				$numd=$nums*($nums-1)*($nums-2)*($nums-3)*($nums-4)*($nums-5)*($nums-6)/5040;
				$nume=($cnum-$nums)*($cnum-$nums-1)*($cnum-$nums-2)*($cnum-$nums-3)*($cnum-$nums-4)*($cnum-$nums-5)*($cnum-$nums-6)/5040;
				$rate=$nume*$rates[4]+$numa*$rates[3]+$numb*$rates[2]+$numc*$rates[1]+$numd*$rates[0];
			}else{
				$nume=($cnum-$nums)*($cnum-$nums-1)*($cnum-$nums-2)*($cnum-$nums-3)*($cnum-$nums-4)*($cnum-$nums-5)*($cnum-$nums-6)/5040;
				$rate=$nume*$rates[4];
			}
			if($rate>0){
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($rate*$modes)."*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="147"){//北京上下盘
			$numa=0;
			$numb=0;
			$numt="";
			for($i=0;$i<20;$i++){
				if($na[$i]<=40){
					$numa=$numa+1;
				}else{
					$numb=$numb+1;
				}
			}
			$rates=explode(";",Get_rate($mid));
			if($numa==$numb){
				$rate=$rates[2];
				$numt="中";
			}
			if($numa>$numb){
				$rate=$rates[1];
				$numt="上";
			}
			if($numa<$numb){
				$rate=$rates[0];
				$numt="下";
			}
			if(strpos($row['codes'],$numt)===false){//字符类型转换
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($rate*$modes)."*times where id='".$row['id']."'");						
			}
		}else if($mid=="149"){//北京奇偶
			$numa=0;
			$numb=0;
			for($i=0;$i<20;$i++){
				if($na[$i] % 2 ==1){
					$numa=$numa+1;
				}else{
					$numb=$numb+1;
				}
			}
			$rates=explode(";",Get_rate($mid));
			if($numa==$numb){
				$rate=$rates[2];
				$numt="和";
			}
			if($numa>$numb){
				$rate=$rates[1];
				$numt="奇";
			}
			if($numa<$numb){
				$rate=$rates[0];
				$numt="偶";
			}
			if(strpos($row['codes'],$numt)===false){//字符类型转换
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($rate*$modes)."*times where id='".$row['id']."'");						
			}
		}else if($mid=="152"){//北京和大小单双
			$nums=0;
			$numt="";
			for($i=0;$i<20;$i++){
				$nums=$nums+$na[$i];
			}
			$rates=explode(";",Get_rate($mid));
			if($nums>810){
				if($nums % 2 ==1){
					$rate=$rates[3];
					$numt="大.单";
				}else{
					$rate=$rates[2];
					$numt="大.双";
				}
			}else{
				if($nums % 2 ==1){
					$rate=$rates[1];
					$numt="小.单";
				}else{
					$rate=$rates[0];
					$numt="小.双";
				}
			}
			if(strpos($row['codes'],$numt)===false){//字符类型转换
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($rate*$modes)."*times where id='".$row['id']."'");						
			}
///////////////////////////////////////////////////////
		}else if($mid=="625"){//江苏和值
			$nums=$na[0]+$na[1]+$na[2];
			$rates=explode(";",Get_rate($mid));
			$zt=2;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$nums){
					$zt=1;
					break;
				}
			}
			if($nums>11){
				$nums=21-$nums;
			}
			$rate=$rates[$nums-3];
			if($zt==1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($rate*$modes)."*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="627"){//江苏三同号通选
			$rates=Get_rate($mid);
			$nums=0;
			if($na[0]==$na[1] && $na[1]==$na[2]){
				$nums=1;
			}
			if($nums==1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates*$modes)."*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="629"){//江苏三同号单选
			$rates=Get_rate($mid);
			$nums=0;
			if($na[0]==$na[1] && $na[1]==$na[2]){
				$nums=$na[0];
			}
			if(strpos($row['codes'],strval($nums))===false){//字符类型转换
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates*$modes)."*times where id='".$row['id']."'");						
			}		
		}else if($mid=="631"){//江苏二同号复选
			$rates=Get_rate($mid);
			$nums=0;
			if($na[0]==$na[1] || $na[0]==$na[2]){
				$nums=$na[0];
			}
			if($na[1]==$na[2]){
				$nums=$na[1];
			}
			if(strpos($row['codes'],strval($nums))===false){//字符类型转换
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates*$modes)."*times where id='".$row['id']."'");						
			}		
		}else if($mid=="633"){//江苏二同号单选
			$rates=Get_rate($mid);
			if($row['type']=="input"){//单式
				$stra=explode("&",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$na[0].$na[1].$na[2] || $stra[$i]==$na[0].$na[2].$na[1] || $stra[$i]==$na[1].$na[0].$na[2] || $stra[$i]==$na[1].$na[2].$na[0] || $stra[$i]==$na[2].$na[0].$na[1] || $stra[$i]==$na[2].$na[1].$na[0]){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=times*".$rates*$modes*$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}
			}else{
				$numa=0;
				$numb=0;
				if($na[0]==$na[1]){
					$numa=$na[0];
					$numb=$na[2];
				}
				if($na[0]==$na[2]){
					$numa=$na[0];
					$numb=$na[1];
				}
				if($na[1]==$na[2]){
					$numa=$na[1];
					$numb=$na[0];
				}
				if($numa>0){
					$stra=explode("|",$row['codes']);
					$strb=explode("&",$stra[0]);
					for ($i=0; $i<count($strb); $i++) {
						if($strb[$i]==$numa){$numa=7;}
					}
					$strc=explode("&",$stra[1]);
					for ($i=0; $i<count($strc); $i++) {
						if($strc[$i]==$numb){$numb=7;}
					}
				}
				if($numa==7 && $numb==7){//字符类型转换
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates*$modes)."*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="635"){//江苏三不同号
			$rates=Get_rate($mid);
			if($row['type']=="input"){//单式
				$stra=explode("&",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$na[0].$na[1].$na[2] || $stra[$i]==$na[0].$na[2].$na[1] || $stra[$i]==$na[1].$na[0].$na[2] || $stra[$i]==$na[1].$na[2].$na[0] || $stra[$i]==$na[2].$na[0].$na[1] || $stra[$i]==$na[2].$na[1].$na[0]){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=times*".$rates*$modes*$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}
			}else if($row['type']=="digital"){//复式
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++){
					if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2]){$nums=$nums+1;}
				}
				if($nums>=3){//字符类型转换
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates*$modes)."*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="641"){//江苏三不同号胆拖
			$rates=Get_rate($mid);
			$nums=0;
			$stra=explode("&",str_replace("|","&",$row['codes']));
			for ($i=0; $i<count($stra); $i++){
				if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2]){$nums=$nums+1;}
			}
			if($nums>=3){
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates*$modes)."*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="642"){//江苏三不同号和值
			$rates=Get_rate($mid);
			$nums=0;
			$zt=2;
			if($na[0]!=$na[1] && $na[0]!=$na[2] && $na[1]!=$na[2]){
				$nums=$na[0]+$na[1]+$na[2];
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$nums){
						$zt=1;
						break;
					}
				}
			}
			if($zt==1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates*$modes)."*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="637"){//江苏二不同号
			$rates=Get_rate($mid);
			if($row['type']=="input"){//单式
				$nums=0;
				$stra=explode("&",$row['codes']);
				for($i=0; $i<2; $i++) {
					for($ii=$i+1;$ii<3;$ii++) {
						for ($k=0; $k<count($stra); $k++) {
							if($stra[$k]==$na[$i].$na[$ii] || $stra[$k]==$na[$ii].$na[$i]){$nums=$nums+1;}
						}
					}
				}
				if($nums>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=times*".($rates*$modes*$nums)." where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}
			}else if($row['type']=="digital"){//复式
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++){
					if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2]){$nums=$nums+1;}
				}
				if($nums>=2){
					mysql_query("update ssc_bills set zt=".$signa.",prize=times*".($rates*$modes*$nums*($nums-1)/2)." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="638"){//江苏二不同号胆拖
			$rates=Get_rate($mid);
			$nums=0;
			$stra=explode("&",str_replace("|","&",$row['codes']));
			for ($i=0; $i<count($stra); $i++){
				if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2]){$nums=$nums+1;}
			}
			if($nums==3){
				$rates=$rates*2;
			}
			if($nums>=2){
				mysql_query("update ssc_bills set zt=".$signa.",prize=times*".($rates*$modes)." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}		
		}else if($mid=="640"){//三连号通选
			$rates=Get_rate($mid);
			$nb=pnb($rowz['code']);
			if($nb[1]-$nb[0]==1 && $nb[2]-$nb[1]==1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates*$modes)."*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}

		}else if($mid=="166" || $mid=="581"){//166时时乐后二直选 581 3d
			if($row['type']=="input"){//单式
				$cs=$na[1].$na[2];
				$stra=explode("&",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$cs){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}
			}else if($row['type']=="digital"){//复式
				$stra=explode("|",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					$strb=explode("&",$stra[$i]);
					for ($ii=0; $ii<count($strb); $ii++) {
						if($strb[$ii]==$na[$i+1]){$nums=$nums+1;}
					}
				}
				if($nums==2){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}				
		}else if($mid=="168" || $mid=="583"){//168时时乐后二组选 583 3d
			if($row['type']=="input"){//单式
				$stra=explode("&",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$na[1].$na[2] || $stra[$i]==$na[2].$na[1]){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}	
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$na[1] || $stra[$i]==$na[2]){$nums=$nums+1;}
				}
				if($nums>=2){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="174" || $mid=="589" || $mid=="618"){//174时时乐一码不定位ok 589 3d 618 p3
			$nums=0;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2]){$nums=$nums+1;}
			}
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}

		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
		}else if($mid=="591" || $mid=="620"){//时时乐二码不定位ok 591 3d 329 p3
			$nums=0;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$na[0] || $stra[$i]==$na[1] || $stra[$i]==$na[2]){$nums=$nums+1;}
			}
			if($nums==2){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else if($nums==3){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*3 where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}

		}else if($mid=="594"){//时时乐后二大小单双ok	594 3d
			if($na[1]>4){$na1a="大";}else{$na1a="小";}
			if ($na[1]%2==1){$na1b="单";}else{$na1b="双";}
			if($na[2]>4){$na2a="大";}else{$na2a="小";}
			if ($na[2]%2==1){$na2b="单";}else{$na2b="双";}
			$stra=explode("|",$row['codes']);
			$numa=0;
			$numb=0;
			$strb=explode("&",$stra[0]);
			for ($ii=0; $ii<count($strb); $ii++) {
				if($strb[$ii]==$na1a || $strb[$ii]==$na1b){$numa=$numa+1;}
			}
			$strb=explode("&",$stra[1]);
			for ($ii=0; $ii<count($strb); $ii++) {
				if($strb[$ii]==$na2a || $strb[$ii]==$na2b){$numb=$numb+1;}
			}
			
			$nums=$numa*$numb;
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
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
						$sqla = "select * from ssc_record order by id desc limit 1";
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
				$sqla = "select * from ssc_record order by id desc limit 1";
				$rsa = mysql_query($sqla);
				$rowa = mysql_fetch_array($rsa);
				$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));
				$lmoney = Get_mmoney($rows['uid'])+$rows['prize'];
				$sqla="insert into ssc_record set lotteryid='".$rows['lotteryid']."', lottery='".$rows['lottery']."', dan='".$dan1."', dan1='".$rows['dan']."', dan2='".$rows['dan1']."', uid='".$rows['uid']."', username='".$rows['username']."', issue='".$rows['issue']."', types='12', mid='".$rows['mid']."', mode='".$rows['mode']."', smoney=".$rows['prize'].",leftmoney=".$lmoney.", cont='".$rows['cont']."', regtop='".$rows['regtop']."', regup='".$rows['regup']."', regfrom='".$rows['regfrom']."', adddate='".date("Y-m-d H:i:s")."',virtual='" .$rows['virtual']. "'";
				$exe=mysql_query($sqla) or  die("数据库修改出错!!!");
				
				$sqla="update ssc_member set leftmoney=".$lmoney." where id='".$rows['uid']."'"; 
				$exe=mysql_query($sqla) or  die("数据库修改出错!!!");
				
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

						$sqla = "select * from ssc_record order by id desc limit 1";
						$rsa = mysql_query($sqla);
						$rowa = mysql_fetch_array($rsa);
						$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));//追号返款
						$sqla="insert into ssc_record set lotteryid='".$rows['lotteryid']."', lottery='".$rows['lottery']."', dan='".$dan1."', dan2='".$rows['dan1']."', uid='".$rows['uid']."', username='".$rows['username']."', issue='".$rows['issue']."', types='10', mid='".$rows['mid']."', mode='".$rows['mode']."', smoney=".$ttm.",leftmoney=".($lmoney+$ttm).", cont='".$rows['cont']."', regtop='".$rows['regtop']."', regup='".$rows['regup']."', regfrom='".$rows['regfrom']."', adddate='".date("Y-m-d H:i:s")."',virtual='" .$rows['virtual']. "'";
						$exe=mysql_query($sqla) or  die("数据库修改出错9!!!");

						$sqla="update ssc_member set leftmoney=".($lmoney+$ttm)." where id='".$rows['uid']."'"; 
						$exe=mysql_query($sqla) or  die("数据库修改出错!!!");
						
					}
					
					$sqla="update ssc_zdetail set zt=2 where dan='".$rows['dan1']."' and zt=0"; 
					$exe=mysql_query($sqla) or  die("数据库修改出错!!!");
				}
			}
		}
	}
	//
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

		$sqld="update ssc_info set lottery='".Get_lottery($lid)."', issue='".$issue."', tz='".($rowb['t7']-$rowb['t13'])."', fd='".($rowb['t11']-$rowb['t15'])."', zj='".$rowc['zj']."', adddate='".date("Y-m-d H:i:s")."' where lotteryid='".$lid."'";
//		echo $sqld;
		$exe=mysql_query($sqld) or  die("数据库修改出错!!!");
		
//	}else if($sign==1){//计分红 zh
		$sqlb="update ssc_data set zt=1 where id ='".$rowz['id']."'";
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

			$sqla = "select * from ssc_record order by id desc limit 1";
			$rsa = mysql_query($sqla);
			$rowa = mysql_fetch_array($rsa);
			$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));//追号返款
			$sqla="insert into ssc_record set lotteryid='".$rowb['lotteryid']."', lottery='".$rowb['lottery']."', dan='".$dan1."', dan2='".$rowb['dan']."', uid='".$rowb['uid']."', username='".$rowb['username']."', issue='".$rowb['issue']."', types='10', mid='".$rowb['mid']."', mode='".$rowb['mode']."', smoney=".$rowb['money'].",leftmoney=".($lmoney+$rowb['money']).", cont='".$rowb['cont']."', regtop='".$rowb['regtop']."', regup='".$rowb['regup']."', regfrom='".$rowb['regfrom']."', adddate='".date("Y-m-d H:i:s")."',virtual='" .$rowb['virtual']. "'";
			$exe=mysql_query($sqla) or  die("数据库修改出错9!!!");

			$sqla = "select * from ssc_bills order by id desc limit 1";
			$rsa = mysql_query($sqla);
			$rowa = mysql_fetch_array($rsa);
			$dan2 = sprintf("%06s",strtoupper(base_convert($rowa['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));//转注单
						
			$sqla="INSERT INTO ssc_bills set lotteryid='".$rowb['lotteryid']."', lottery='".$rowb['lottery']."', dan='".$dan2."', dan1='".$rowb['dan']."', uid='".$rowb['uid']."', username='".$rowb['username']."', issue='".$rowb['issue']."', type='".$rowb['type']."', mid='".$rowb['mid']."',mname='".$rowb['mname']."', codes='".$rowb['codes']."', pos='".$rowb['pos']."', nums='".$rowb['nums']."', times='".$rowb['times']."', money='".$rowb['money']."', mode='".$rowb['mode']."', rates='".$rowb['rates']."', point='".$rowb['point']."', cont='".$rowb['cont']."', regtop='".$rowb['regtop']."', regup='".$rowb['regup']."', regfrom='".$rowb['regfrom']."', userip='".$rowb['userip']."', adddate='".date("Y-m-d H:i:s")."', canceldead='".$rowb['canceldead']."', autostop='".$rowb['autostop']."',virtual='" .$rowb['virtual']. "'";
			$exe=mysql_query($sqla) or  die("数据库修改出错10!!!!");
			
			$sqla = "update ssc_zdetail set danb='".$dan2."', zt=1 where id='".$rowb['id']."'";
			$rsa = mysql_query($sqla);
			
			$sqla = "select * from ssc_record order by id desc limit 1";
			$rsa = mysql_query($sqla);
			$rowa = mysql_fetch_array($rsa);
			$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));//投注扣款
			$sqla="insert into ssc_record set lotteryid='".$rowb['lotteryid']."', lottery='".$rowb['lottery']."', dan='".$dan1."', dan1='".$dan2."', dan2='".$rowb['dan']."', uid='".$rowb['uid']."', username='".$rowb['username']."', issue='".$rowb['issue']."', types='7', mid='".$rowb['mid']."', mode='".$rowb['mode']."', zmoney=".$rowb['money'].",leftmoney=".$lmoney.", cont='".$rowb['cont']."', regtop='".$rowb['regtop']."', regup='".$rowb['regup']."', regfrom='".$rowb['regfrom']."', adddate='".date("Y-m-d H:i:s")."',virtual='" .$rowb['virtual']. "'";
			$exe=mysql_query($sqla) or  die("数据库修改出错11!!!");
			
			if($spoint>0){
				$sqla = "select * from ssc_record order by id desc limit 1";
				$rsa = mysql_query($sqla);
				$rowa = mysql_fetch_array($rsa);
				$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));
				$sqla="insert into ssc_record set lotteryid='".$rowb['lotteryid']."', lottery='".$rowb['lottery']."', dan='".$dan1."', dan1='".$dan2."', dan2='".$rowb['dan']."', uid='".$rowb['uid']."', username='".$rowb['username']."', issue='".$rowb['issue']."', types='11', mid='".$rowb['mid']."', mode='".$rowb['mode']."', smoney=".$rowb['money']*$spoint.",leftmoney=".($lmoney+$rowb['money']*$spoint).", cont='".$rowb['cont']."', regtop='".$rowb['regtop']."', regup='".$rowb['regup']."', regfrom='".$rowb['regfrom']."', adddate='".date("Y-m-d H:i:s")."',virtual='" .$rowb['virtual']. "'";
				$exe=mysql_query($sqla) or  die("数据库修改出错4!!!");

				$sqla="update ssc_member set leftmoney=".($lmoney+$rowb['money']*$spoint)." where username='".$rowb['username']."'"; 
				$exe=mysql_query($sqla) or  die("数据库修改出错12!!!");
			}
		}
		
		$sqla="select * from ssc_zbills where lotteryid='".$lid."' and zt='0'";
		$rsa = mysql_query($sqla) or  die("数据库修改出错!!!");
		while ($rowa = mysql_fetch_array($rsa)){
			$sqlb="select * from ssc_zdetail where dan='".$rowa['dan']."' and zt='0'";
			$rsb = mysql_query($sqlb) or  die("数据库修改出错!!!");
			$total = mysql_num_rows($rsb);
			if($total==0){
				$sqlb="update ssc_zbills set zt='1' where dan='".$rowa['dan']."'"; 
				$exe=mysql_query($sqlb) or  die("数据库修改出错!!!");
			}
		}
		//分红
//		$sqlb="select regtop, SUM(IF(types = 1, smoney, 0)) as t1,SUM(IF(types = 2, zmoney, 0)) as t2,SUM(IF(types = 3, smoney, 0)) as t3,SUM(IF(types = 7, zmoney, 0)) as t7,SUM(IF(types = 11, smoney, 0)) as t11,SUM(IF(types = 12, smoney, 0)) as t12,SUM(IF(types = 13, smoney, 0)) as t13,SUM(IF(types = 15, zmoney, 0)) as t15,SUM(IF(types = 16, zmoney, 0)) as t16,SUM(IF(types = 32, smoney, 0)) as t32,SUM(IF(types = 40, smoney, 0)) as t40 from ssc_record where lotteryid='".$lid."' and issue='".$issue."' group by regtop";
//		$rsb = mysql_query($sqlb);
//		while ($rowb = mysql_fetch_array($rsb)){
//			if($rowb['regtop']!=""){
//				$sqls="select * from ssc_member where username ='".$rowb['regtop']."'";
//				$rss=mysql_query($sqls) or  die("数据库修改出错1");
//				$rows = mysql_fetch_array($rss);
//				if($rows['zc']>0){
//					$sqlc="select SUM(money) as smoney from ssc_bills where zt='1' and lotteryid='".$lid."' and issue='".$issue."' and regtop='".$rowb['regtop']."'";
//					$rsc = mysql_query($sqlc);
//					$rowc = mysql_fetch_array($rsc);
					
//					$zmoney = $rows['zc']*($rowb['t7']-$rowb['t11']-$rowb['t13']+$rowb['t15']-$rowc['smoney'])/100;
//					if($zmoney>0){
//						$lmoney = $rows['leftmoney']+$zmoney;
					
//						$sqla = "select * from ssc_record order by id desc limit 1";
//						$rsa = mysql_query($sqla);
//						$rowa = mysql_fetch_array($rsa);
//						$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));
					
//						$sqla="insert into ssc_record set lotteryid='".$lid."', lottery='".Get_lottery($lid)."', dan='".$dan1."', uid='".$rows['id']."', username='".$rowb['regtop']."', issue='".$issue."', types='40', smoney=".$zmoney.",leftmoney=".$lmoney.", adddate='".date("Y-m-d H:i:s")."'";
//						$exe=mysql_query($sqla) or  die("数据库修改出错!!!");
						
//						$sqla="update ssc_member set leftmoney=".$lmoney." where username='".$rowb['regtop']."'"; 
//						$exe=mysql_query($sqla) or  die("数据库修改出错!!!");
//					}
//				}
//			}
//		}		
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