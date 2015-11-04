<?php
@set_magic_quotes_runtime(0);
@header("content-Type: text/html; charset=utf-8");
define('PHPYOU','v1.0');
//此软件仅供学习测试使用，不得用于非法用途！
if(function_exists('date_default_timezone_set')) {

	@date_default_timezone_set('Etc/GMT-8');

}

if(!get_magic_quotes_gpc()){
	Add_S($_POST);
	Add_S($_GET);
	Add_S($_COOKIE);
}
Add_S($_FILES);

function Add_S(&$array){
	foreach($array as $key=>$value){
		if(!is_array($value)){
			$array[$key]=addslashes($value);
		}else{
			Add_S($array[$key]);
		}
	}
}

//如果要修改数据库连接信息，请在web.config.php中修改
require_once($_SERVER['DOCUMENT_ROOT'].'/web.config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/SAPI/appfun.php');
$conn = mysql_pconnect($con_db_host, $con_db_id, $con_db_pass);
//$conn = mysql_pconnect( "180.150.226.18:3306", "root", "hellocy666" );
//$conn = mysql_pconnect( "175.41.26.18:7395", "root", "k4v_sel" );
if (!$conn)
  {
  die('系统繁忙，请稍候再试！');// 
  }

mysql_select_db($con_db_name);
mysql_query( "SET NAMES 'utf8'" );

$sqlzz = "select zt from ssc_config";
$rszz = mysql_query($sqlzz);
$rowzz = mysql_fetch_array($rszz);
$webzt=$rowzz['zt'];
mysql_free_result($rszz); 

function amend($rrr){   
	require_once 'ip.php';
	$ip1 = get_ip();
	$iplocation = new iplocate();
	$address=$iplocation->getaddress($ip1);
	$iparea = $address['area1'].$address['area2'];

	$exe = mysql_query( "insert into ssc_memberamend set uid = '".$_SESSION["uid"]."',username = '".$_SESSION["username"]."',level = '".$_SESSION["level"]."', cont='".$rrr."', ip='".$ip1."', area='".$iparea."', adddate='".date("Y-m-d H:i:s")."'");
	mysql_free_result($exe); 

//return $rrr;
}

function judgez($rrr){   
if($rrr<0){
	$rrr=0;
}
return $rrr;
}

function dcode($rrr,$lid,$mid){
if($mid==69 || $mid==70 || $mid==71 || $mid==72 || $mid==149 || $mid==150 || $mid==151 || $mid==152 || $mid==229 || $mid==230 || $mid==231 || $mid==232 || $mid==309 || $mid==310 || $mid==311 || $mid==312 || $mid==389 || $mid==390 || $mid==391 || $mid==392 || $mid==432 || $mid==433 || $mid==434 || $mid==435 || $mid==472 || $mid==473 || $mid==474 || $mid==475 || $mid==512 || $mid==513 || $mid==514 || $mid==515 || $mid==552 || $mid==553 || $mid==554 || $mid==555){
	$rrs=explode("|",$rrr);
	if($rrs[0]!=""){$rrt=$rrt."胆码".$rrs[0].";";}
	if($rrs[1]!=""){$rrt=$rrt."胆中".$rrs[1].";";}
	if($rrs[2]!=""){$rrt=$rrt."跨度".$rrs[2].";";}
	if($rrs[3]!=""){$rrt=$rrt."和尾".$rrs[3].";";}
	if($rrs[4]!=""){$rrt=$rrt."和值".$rrs[4].";";}
	if($rrs[5]!=""){$rrt=$rrt."奇偶".$rrs[5].";";}
	if($rrs[6]!=""){$rrt=$rrt."大小".$rrs[6].";";}
	if(count($rrs)>7){
		if($rrs[7]!=""){$rrt=$rrt."组选".$rrs[7];}
	}
	$rrr=str_replace("&",",",$rrt);
}else{

	if(strpos($rrr,"|")===false){
		$rrr=str_replace("&",",",$rrr);
	}else{
		$rrr=str_replace("|",",",$rrr);
		if($lid=="2" || $lid=="3" || $lid=="8" || $lid=="9" || $lid=="10"){
			$rrr=str_replace("&"," ",$rrr);	
		}else{
			$rrr=str_replace("&","",$rrr);
		}
	}
}
return $rrr;
}

function Get_member($rrr){
$result=mysql_query("Select * from ssc_member where username='".$_SESSION["username"]."'"); 
$raa=mysql_fetch_array($result); 
mysql_free_result($result); 
return $raa[$rrr];
}

function Get_canceldate($rrr,$sss){
if($rrr==1 || $rrr==5 ||$rrr==7 || $rrr==13 || $rrr==14 || $rrr==16 || $rrr==17){
	$sss1=substr($sss,-3);
}else if($rrr==11 || $rrr==12){
	$sss1=1;
	if(date("H:i:s")>"20:30:00"){
		$sss=date("ymd",strtotime("+1 day"));
	}else{
		$sss=date("ymd");
	}
}else if($rrr==3){
	$snum=575051;
	$sday=strtotime("2013-06-29");
	$sss2=($sss+77) % 179;
	if($sss2==0){$sss2=179;}
	$sss1=sprintf("%03d",$sss2);
	$sjc=($sss+1-$snum-$sss1)/179;
	$sss=date("ymd",$sjc*24*3600+$sday);
}else if($rrr==6){
	$sday=strtotime("2013-07-14");
	$snum=119569;
	$sss2=($sss+48) % 84;
	if($sss2==0){$sss2=84;}
	$sss1=sprintf("%03d",$sss2);
	$sjc=($sss+1-$snum-$sss1)/84;
	$sss=date("ymd",$sjc*24*3600+$sday);
}else{
	$sss1=substr($sss,-2);
}
$result=mysql_query("Select * from ssc_nums where cid='".$rrr."' and nums='".$sss1."'"); 
$raa=mysql_fetch_array($result);
mysql_free_result($result); 

//$sss2="20".substr($sss,0,2)."-".substr($sss,2,2)."-".substr($sss,4,2);
if($rrr==15 || $rrr==15 || $rrr==15){
$sss2=date("Y-m-d H:i:s",mktime(substr($raa['endtimes'],0,2),substr($raa['endtimes'],3,2),substr($raa['endtimes'],6,2),substr($sss,4,2),substr($sss,6,2),"20".substr($sss,2,2)));
}else{
$sss2=date("Y-m-d H:i:s",mktime(substr($raa['endtimes'],0,2),substr($raa['endtimes'],3,2),substr($raa['endtimes'],6,2),substr($sss,2,2),substr($sss,4,2),"20".substr($sss,0,2)));
}
//$rrr=$raa['endtime'];
return $sss2;
}

function Get_rate($rrr){
$result=mysql_query("Select * from ssc_class where mid='".$rrr."'"); 
$raa=mysql_fetch_array($result);
mysql_free_result($result); 
return $raa['rates'];
}

function Get_mname($rrr){
$result=mysql_query("Select * from ssc_member where id='".$rrr."'"); 
$raa=mysql_fetch_array($result); 
mysql_free_result($result); 
return $raa['username'];
}

function Get_mrebate($rrr){
$result=mysql_query("Select * from ssc_member where id='".$rrr."'"); 
$raa=mysql_fetch_array($result); 
mysql_free_result($result); 
return $raa['rebate'];
}

function Get_memid($rrr){
$result=mysql_query("Select * from ssc_member where username='".$rrr."'"); 
$raa=mysql_fetch_array($result); 
mysql_free_result($result); 
return $raa['id'];
}

function Get_mmoney($rrr){
$result=mysql_query("Select * from ssc_member where id='".$rrr."'"); 
$raa=mysql_fetch_array($result);
mysql_free_result($result);  
return $raa['leftmoney'];
}

function Get_mmoneys($rrr){
$result=mysql_query("Select * from ssc_member where username='".$rrr."'"); 
$raa=mysql_fetch_array($result); 
mysql_free_result($result); 
return $raa['leftmoney'];
}

function Get_online($rrr){   
$result=mysql_query("Select count(*) as nums from ssc_online where username='".$rrr."'"); 
$raa=mysql_fetch_array($result); 
mysql_free_result($result); 
return $raa['nums'];
}

function Get_xj($rrr){   //下级
$result=mysql_query("Select count(*) as nums from ssc_member where regup='".$rrr."'"); 
$raa=mysql_fetch_array($result); 
mysql_free_result($result); 
return $raa['nums'];
}

function Get_mid($rrr){   
$result=mysql_query("Select * from ssc_class where mid='".$rrr."'"); 
$raa=mysql_fetch_array($result); 
mysql_free_result($result); 
return $raa['name'];
}

function Get_lottery($rrr){   
$result=mysql_query("Select * from ssc_set where id='".$rrr."'"); 
$raa=mysql_fetch_array($result); 
mysql_free_result($result); 
return $raa['name'];
}

function Get_province($rrr){   
$result=mysql_query("Select * from ssc_province where pid='".$rrr."'"); 
$raa=mysql_fetch_array($result); 
mysql_free_result($result); 
return $raa['name'];
}

function Get_bank($rrr){   
$result=mysql_query("Select * from ssc_banks where tid='".$rrr."'"); 
$raa=mysql_fetch_array($result); 
mysql_free_result($result); 
return $raa['name'];
}

function Get_city($rrr){   
$result=mysql_query("Select * from ssc_city where cid='".$rrr."'"); 
$raa=mysql_fetch_array($result); 
mysql_free_result($result); 
return $raa['name'];
}

function Get_card($rrr){
$result=mysql_query("Select count(*) as nums from ssc_bankcard where username='".$rrr."'"); 
$raa=mysql_fetch_array($result); 
mysql_free_result($result); 
if($raa['nums']>1){
return 1;
}else{
return $raa['nums'];
}
}

function rep_str($rrr){   
$repa=str_replace(":","",$rrr);
$repa=str_replace(",","",$repa);
return $repa;
}

function cflevel($rrr,$lid){   
	if($lid=="2" || $lid=="4" || $lid=="8" || $lid=="9" || $lid=="10" || $lid=="11" || $lid=="12"){
		$rrr=$rrr-1.5;
		if($rrr<0){
			$rrr=0;
		}
	}elseif($lid==3){
		$rrr=$rrr+2.5;
	}elseif($lid==13){
		$rrr=$rrr+7.5;
	}
return $rrr;
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

function pxt($nbs,$lid){
	if($lid==1 || $lid==5 || $lid==6 || $lid==7 || $lid==14 || $lid==16){
		$ntn=5;
	}else{
		$ntn=6;
	}
	$nb=pnb($nbs);
	$xt="五星: 跨度".($nb[4]-$nb[0])."&nbsp;&nbsp;";
	$hz=$nb[0]+$nb[1]+$nb[2]+$nb[3]+$nb[4];
	$jo=0;
	$dx=0;
	$xt=$xt."和值".$hz."&nbsp;&nbsp;";
	$xt=$xt."和尾".($hz % 10)."&nbsp;&nbsp;";
	for($it=0;$it<5;$it++){
		if($nb[$it]%2==1){$jo++;}
		if($nb[$it]>=$ntn){$dx++;}
	}
	$xt=$xt."大小".($dx.":".(5-$dx))."&nbsp;&nbsp;";
	$xt=$xt."奇偶".($jo.":".(5-$jo))."&nbsp;&nbsp;";
	if($ntn==5){
		if($nb[0]==$nb[3] || $nb[1]==$nb[4]){
			$xt=$xt."组选5";
		}else{
			if(($nb[0]==$nb[2] && $nb[3]==$nb[4]) || ($nb[0]==$nb[1] && $nb[2]==$nb[4])){
				$xt=$xt."组选10";
			}else{
				if(($nb[0]==$nb[2] && $nb[3]!=$nb[4]) || ($nb[0]!=$nb[1] && $nb[2]==$nb[4]) || $nb[1]==$nb[3]){
					$xt=$xt."组选20";
				}else{
					if(($nb[0]==$nb[1] && $nb[2]==$nb[3]) || ($nb[0]==$nb[1] && $nb[2]==$nb[4]) || ($nb[0]==$nb[1] && $nb[3]==$nb[4]) || ($nb[0]==$nb[2] && $nb[3]==$nb[4]) || ($nb[1]==$nb[2] && $nb[3]==$nb[4])){
						$xt=$xt."组选30";
					}else{
					if($nb[0]==$nb[1] || $nb[1]==$nb[2] || $nb[2]==$nb[3] || $nb[3]==$nb[4]){
							$xt=$xt."组选60";
						}else{
							$xt=$xt."组选120";
						}
					}
				}
			}
		}
	}else{
		$xt=$xt."中位".$nb[2];
	}
	return $xt;
}

function get_ip(){
	if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}else{
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

?>