<?php 
session_start();
error_reporting(0);
require_once 'conn.php';
$id=$_POST['id'];
	$sql="select * from ssc_bills where dan='".$id."'";
	$rs=mysql_query($sql) or  die("数据库修改出错!!!!");
	$row = mysql_fetch_array($rs);
	if(empty($row)){
		echo "{\"stats\":\"error\",\"data\":\"读取数据出错啦\"}";
	}else{
		if(date("Y-m-d H:i:s")<$row['canceldead'] && $row['zt']==0){
			$can=1;
		}else{
			$can=0;
		}
		$modes=$row['mode'];
		if($row['mode']=="元"){
			$modes2=1;
		}else{
			$modes2=0.1;
		}
		
		if($row['dan1']!=""){
			$taskid=$row['dan1'];
		}else{
			$taskid=0;
		}
				
		$iscancel=0;
		$isgetprize=0;
		$prizestatus=1;//派奖
		if($row['zt']==4){
			$iscancel=2;
		}else if($row['zt']==5){
			$iscancel=1;
		}else if($row['zt']==6){
			$iscancel=3;
		}else{
			$isgetprize=$row['zt'];
		}
		
		$poss="";
		if($row['mid']==755 || $row['mid']==664 || $row['mid']==765 || $row['mid']==708 || $row['mid']==686 || $row['mid']==696 || $row['mid']==718 || $row['mid']==775 || $row['mid']==730 || $row['mid']==735 || $row['mid']==740 || $row['mid']==745 || (($row['mid']==654 || $row['mid']==676 || $row['mid']==725) && $row['type']=="input")){
			$poss=" ";
			$pos=explode(",",$row['pos']);
			if($pos[0]==1){$poss=$poss."万位";}
			if($pos[1]==1){$poss=$poss."千位";}
			if($pos[2]==1){$poss=$poss."百位";}
			if($pos[3]==1){$poss=$poss."十位";}
			if($pos[4]==1){$poss=$poss."个位";}
		}
		
		$sqla = "select * from ssc_class where mid='".$row['mid']."'";
		$rsa = mysql_query($sqla);
		$rowa = mysql_fetch_array($rsa);
		$rates=explode(";",$rowa['rates']);
		if(count($rates)>1){
			$sstrd=explode(";",$rowa['rates']);
			$sstre=explode(";",$rowa['jname']);
			$dypointdec="";
		}else{
			$dypointdec=($row['rates']/$modes2)."-".($row['point']*100)."%";
			$sstrd=explode(";",$row['rates']/$modes2);
		}

		echo "{\"stats\":\"ok\",\"data\":{\"need\":0,\"money\":0,\"can\":".$can.",\"project\":{\"projectid\":\"".$row['dan']."\",\"userid\":\"".$row['uid']."\",\"packageid\":\"10\",\"taskid\":\"".$taskid."\",\"lotteryid\":\"".$row['lotteryid']."\",\"methodid\":\"".$row['mid']."\",\"issue\":\"".$row['issue']."\",\"nocode\":\"\",\"bonus\":\"".$row['prize']."\",\"code\":\"".dcode($row['codes'],$row['lotteryid'])."\",\"codetype\":\"".$row['type']."\",\"singleprice\":\"".($row['money']/$row['times'])."\",\"multiple\":\"".$row['times']."\",\"totalprice\":\"".$row['money']."\",\"maxbouns\":\"".number_format($sstrd[0]*modes2,2)."\",\"lvtopid\":\"9\",\"lvtoppoint\":\"0.075\",\"lvproxyid\":\"27545\",\"userdefaultpoint\":\"0.050\",\"userpoint\":\"".$row['point']."\",\"dypointdec\":\"".$dypointdec."\",\"writetime\":\"".$row['adddate']."\",\"updatetime\":\"2012-03-12 12:42:03\",\"deducttime\":\"2012-03-12 12:42:03\",\"bonustime\":\"0000-00-00 00:00:00\",\"canceltime\":\"".$row['canceldate']."\",\"isdeduct\":\"1\",\"iscancel\":\"".$iscancel."\",\"isgetprize\":\"".$isgetprize."\",\"prizestatus\":\"".$prizestatus."\",\"userip\":\"".$row['userip']."\",\"cdnip\":\"127.0.0.1\",\"modes\":\"".$modes."\",\"sqlnum\":\"0\",\"hashvar\":\"a\",\"cnname\":\"".$row['lottery']."\",\"methodname\":\"".$row['mname'].$poss."\",\"username\":\"".$row['username']."\",\"nocode\":\"".$row['kjcode']."\",\"canneldeadline\":\"".$row['canceldead']."\",\"statuscode\":\"2\"},\"prizelevel\":[";
		for($i=0;$i<count($sstrd);$i=$i+1){
			$prize=number_format(floatval($sstrd[$i])*$modes2*$row['times'],2);
			if(count($sstrd)==1){
				$mname=$row['mname'];
			}else{
				$mname=$sstre[$i];
			}
			echo "{\"entry\":\"17679965\",\"projectid\":\"17015274\",\"isspecial\":\"0\",\"level\":\"".($i+1)."\",\"codetimes\":\"".$row['times']."\",\"prize\":\"".$prize."\",\"expandcode\":\"".dcode($row['codes'],$row['lotteryid'])."\",\"updatetime\":\"".$row['adddate']."\",\"hashvar\":\"a\",\"leveldesc\":\"".$mname."\",\"levelcodedesc\":\" \",\"singleprize\":60}";
			if($i!=count($sstrd)-1){echo ",";}
		}
		echo "]}}";
	}

//{"stats":"ok","data":{"need":0,"money":0,"can":1,"project":{"projectid":"L53PUD","userid":"111133","packageid":"26682574","taskid":"0","lotteryid":"1","methodid":"20","issue":"130718024","nocode":"","bonus":"0.0000","code":"1,2","expandcode":"","codetype":"digital","singleprice":"0.6000","multiple":"1","totalprice":"0.6000","maxbouns":"60.0000","lvtopid":"10","lvtoppoint":"0.075","lvproxyid":"42","istester":"0","userdefaultpoint":"0.065","userpoint":"1.000","dypointdec":"","writetime":"2013-07-18 09:24:30","updatetime":"2013-07-18 09:24:30","deducttime":"0000-00-00 00:00:00","bonustime":"0000-00-00 00:00:00","canceltime":"0000-00-00 00:00:00","isdeduct":"0","iscancel":"0","isgetprize":"0","prizestatus":"0","userip":"124.89.77.156","cdnip":"218.213.233.100","modes":"角","sqlnum":"2","hashvar":"5efc525c3f4552e6694cc323626304ab","cnname":"重庆时时彩","lotterytype":"0","methodname":"后三组选_和值","nocount":"a:4:{i:1;a:3:{s:5:%"count%";s:1:%"3%";s:4:%"name%";s:123:%"组三:所选和值与开奖号码的后三位数字和值全部相同(不含豹子号)，且号码为组三，顺序不限%";s:3:%"use%";i:1;}i:2;a:3:{s:5:%"count%";s:1:%"6%";s:4:%"name%";s:123:%"组六:所选和值与开奖号码的后三位数字和值全部相同(不含豹子号)，且号码为组六，顺序不限%";s:3:%"use%";i:1;}s:4:%"type%";i:0;s:6:%"isdesc%";i:0;}","username":"tianxiaxing002","canneldeadline":"2013-07-18 09:59:00","statuscode":"0"},
//"prizelevel":[{"entry":"51862681","projectid":"49949518","isspecial":"0","level":"1","codetimes":"1","prize":"60.0000","expandcode":"1,2","updatetime":"2013-07-18 09:24:30","hashvar":"2db7ccdf9e3377a50a9386ff2d4307c9","leveldesc":"组三","levelcodedesc":"所选和值与开奖号码的后三位数字和值全部相同(不含豹子号)，且号码为组三，顺序不限","singleprize":60},{"entry":"51862682","projectid":"49949518","isspecial":"0","level":"2","codetimes":"1","prize":"30.0000","expandcode":"1,2","updatetime":"2013-07-18 09:24:30","hashvar":"326afdd307023285344b270c7e0e0389","leveldesc":"组六","levelcodedesc":"所选和值与开奖号码的后三位数字和值全部相同(不含豹子号)，且号码为组六，顺序不限","singleprize":30}]}}


