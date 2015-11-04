<?php	//
	$serr="";
	$ssuccess=0;
	$sfail=0;

	if($_SERVER['HTTP_REFERER']!="http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']){//
		echo "{\"stats\":\"error\",\"data\":\"注单严重异常！！！\"}";
		exit;
	}
	
	$sissue=$_REQUEST['lt_issue_start'];
	if($sissue<$issue){//已停止投注
		echo "{\"stats\":\"error\",\"data\":\"\u7b2c[".$sissue."]\u671f\u5df2\u505c\u6b62\u9500\u552e\"}";
		exit;
	}
	if($_SESSION["username"]==""){//
		echo "{\"stats\":\"error\",\"data\":\"请重新登录\"}";
		exit;
	}
	$sql = "select * from ssc_member where username='" . $_SESSION["username"] . "'";
	$rs = mysql_query($sql);
	$row = mysql_fetch_array($rs);
	$zt=$row['zt'];
	if($zt==1){//
		echo "{\"stats\":\"error\",\"data\":\"你的帐户被冻结\"}";
		exit;
	}
	if($zt==2){//
		echo "{\"stats\":\"error\",\"data\":\"你的帐户被锁定\"}";
		exit;
	}
	if($row['flevel']>7.5){//
		echo "{\"stats\":\"error\",\"data\":\"你的帐户不能投注\"}";
		exit;
	}
	
	
	if($_REQUEST['lt_trace_if']=="yes"){		//追号次数
		$ztimes=0;
		$zcount=count($_REQUEST['lt_trace_issues']);
		for ($ii=0; $ii<$zcount; $ii++) {
			$ztimes=$ztimes+$_REQUEST['lt_trace_times_'.$_REQUEST['lt_trace_issues'][$ii]];
		}
	}

	for ($i=0; $i<count($_REQUEST['lt_project']); $i++) {
		if( $_REQUEST['lt_jm'][$i]!= md5(stripslashes($_REQUEST['lt_project'][$i])."zcy")){
			echo "{\"stats\":\"error\",\"data\":\"注单错误！！\"}";
			exit;
		}
	}

	$ip=get_ip();

	for ($i=0; $i<count($_REQUEST['lt_project']); $i++) {
//		echo $_REQUEST['lt_project'][$i];
//		$stra=str_replace("\'","\"",$_REQUEST['lt_project'][$i]);//localhost
		$stra=str_replace("'","\"",$_REQUEST['lt_project'][$i]);
		$strb=json_decode($stra);
		$sql = "select * from ssc_member where username='" . $_SESSION["username"] . "'";
		$rs = mysql_query($sql);
		$row = mysql_fetch_array($rs);
		$leftmoney=$row['leftmoney'];
		//session ？
		//玩法是否关闭
		//限注 限倍 限额
		if($strb->mode==2){
			$modes=0.1;
			$mode="角";
		}elseif($strb->mode==1){
			$modes=1;
			$mode="元";
		}else{
			$modes=0.01;
			$mode="分";
		}
		

		$poss=explode("&",$strb->position);
		$pos0="";
		$pos1="";
		$pos2="";
		$pos3="";
		$pos4="";
		
		for($ti=0;$ti<count($poss);$ti++){
			if($poss[$ti]==0){
				$pos0=1;
			}elseif($poss[$ti]==1){
				$pos1=1;
			}elseif($poss[$ti]==2){
				$pos2=1;
			}elseif($poss[$ti]==3){
				$pos3=1;
			}elseif($poss[$ti]==4){
				$pos4=1;
			}
		}
		$pos=$pos0.",".$pos1.",".$pos2.",".$pos3.",".$pos4;
		
		$sqla = "select * from ssc_class where mid='".$strb->methodid."'";
//		echo $sqla;
		$rsa = mysql_query($sqla);
		$rowa = mysql_fetch_array($rsa);
		$sstri=$rowa['sid'];
		$maxzhu=$rowa['maxzhu'];
		$mname=$rowa['name'];
		
		$spoints=cflevel($row['flevel'],$lotteryid)/100;//
		if($strb->methodid>=133 && $strb->methodid<=145){
			$spoints=$spoints+0.05;
		}
		if($strb->point==1){
			$spoint=$spoints;
			$prize=0;
		}else{
			$spoint=$strb->point;
			if(floatval($spoint)==0){
//				if($rowa['rates']>100){
//					$prize=$rowa['rates']+floor($rowa['rates']*$spoints*100/90);
//				}else{
					$prize=$rowa['rates']+round($rowa['rates']*$spoints*100/90,4);
//				}
			}else{
				$prize=$rowa['rates'];
			}
			$prize=$prize*$modes;
		}

//		echo $strb->point." ".$spoint." ".round($spoint,3);
		$eerr="";
		if(strlen($strb->codes)>12000){//$rowa['maxzhu'] < $strb->nums || 
			$sfail=$sfail+1;
			$eerr=1;
			if($sfail>1){
				$serr=$serr.",";
			}
			$serr=$serr."{\"desc\":\"[".$strb->desc."\",\"errmsg\":\"超过最大投注注数\"}";
		}

		if($rowa['maxbei'] < $strb->times && $eerr==""){
			$sfail=$sfail+1;
			$eerr=1;
			if($sfail>1){
				$serr=$serr.",";
			}
			$serr=$serr."{\"desc\":\"[".$strb->desc."\",\"errmsg\":\"超过最大投注倍数\"}";
		}

		if($rowa['zt'] !="1" && $eerr==""){
			$sfail=$sfail+1;
			$eerr=1;
			if($sfail>1){
				$serr=$serr.",";
			}
			$serr=$serr."{\"desc\":\"[".$strb->desc."\",\"errmsg\":\"该玩法已被关闭\"}";
		}
		

		if($_REQUEST['lt_trace_if']!="yes"){		//不追号
			
			if($leftmoney<$strb->money && $eerr==""){
				$sfail=$sfail+1;
				$eerr=1;
				if($sfail>1){
					$serr=$serr.",";
				}
				$serr=$serr."{\"desc\":\"[".$strb->desc."\",\"errmsg\":\"余额不足\"}";
			}
			

			if(round($strb->nums*$strb->times*$modes * 2,1) != round($strb->money,1) && $eerr==""){
//				alert();
				$sfail=$sfail+1;
				$eerr=1;
				if($sfail>1){
					$serr=$serr.",";
				}
				$serr=$serr."{\"desc\":\"[".$strb->desc."\",\"errmsg\":\"该注单异常\"}";
			}
			
			if($eerr==""){
				$ssuccess=$ssuccess+1;

					$sqla = "select id from ssc_bills order by id desc limit 1";
					$rsa = mysql_query($sqla);
					$rowa = mysql_fetch_array($rsa);
					$dan = sprintf("%06s",strtoupper(base_convert($rowa['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));//注单
					$sqla="INSERT INTO ssc_bills set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan."', uid='".$_SESSION["uid"]."', username='".$_SESSION["username"]."', issue='".$sissue."', type='".$strb->type."', mid='".$strb->methodid."',mname='".$mname."', codes='".$strb->codes."', pos='".$pos."', nums='".$strb->nums."', times='".$strb->times."', money='".$strb->money."', mode='".$mode."', rates='".$prize."', point='".$spoint."', cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', userip='".$ip."', adddate='".date("Y-m-d H:i:s")."', canceldead='".Get_canceldate($lotteryid,$sissue)."',virtual='" .$row['virtual']. "'";
					$exe=mysql_query($sqla) or  die("数据库修改出错1!!");
	
					$lmoney=$leftmoney - $strb->money;
					$lmoney2=$lmoney + $strb->money * $spoint;
					
					$sqla="update ssc_member set leftmoney=".$lmoney2.", usedmoney=usedmoney+".$strb->money.", tempmoney=tempmoney+".$strb->money." where username='".$_SESSION["username"]."'"; 
					$exe=mysql_query($sqla) or  die("数据库修改出错2!!!");
					
//					$sqla = "select * from ssc_savelist where username='" . $_SESSION["username"] . "' order by id desc limit 1";
//					$rsa = mysql_query($sqla);
//					$rowa = mysql_fetch_array($rsa);
					
//					$sqla="update ssc_savelist set xf=xf+".$strb->money." where id='".$rowa['id']."'"; 
//					$exe=mysql_query($sqla) or  die("数据库修改出错2!!!");
					
					$sqla = "select * from ssc_record order by id desc limit 1";
					$rsa = mysql_query($sqla);
					$rowa = mysql_fetch_array($rsa);
					$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));
					
					$sqla="insert into ssc_record set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan1."', dan1='".$dan."', uid='".$_SESSION["uid"]."', username='".$_SESSION["username"]."', issue='".$sissue."', types='7', mid='".$strb->methodid."',mname='".$mname."', mode='".$mode."', zmoney=".$strb->money.",leftmoney=".$lmoney.", cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', adddate='".date("Y-m-d H:i:s")."',virtual='" .$row['virtual']. "'";
					$exe=mysql_query($sqla) or  die("数据库修改出错3!!!");
					if($spoint!="0"){
						$sqla = "select * from ssc_record order by id desc limit 1";
						$rsa = mysql_query($sqla);
						$rowa = mysql_fetch_array($rsa);
						$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));
						$sqla="insert into ssc_record set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan1."', dan1='".$dan."', uid='".$_SESSION["uid"]."', username='".$_SESSION["username"]."', issue='".$sissue."', types='11', mid='".$strb->methodid."',mname='".$mname."', mode='".$mode."', smoney=".$strb->money*$spoint.",leftmoney=".$lmoney2.", cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', adddate='".date("Y-m-d H:i:s")."',virtual='" .$row['virtual']. "'";
						$exe=mysql_query($sqla) or  die("数据库修改出错4!!!");
					}
					
			}
		}else{//zh
			if($eerr==""){
				$zmoney=($strb->money/$strb->times)*$ztimes;
				if($leftmoney<$zmoney){
					$sfail=$sfail+1;
					if($sfail>1){
						$serr=$serr.",";
					}
					$serr=$serr."{\"desc\":\"[".$strb->desc."\",\"errmsg\":\"余额不足\"}";
				}else{
					$ssuccess=$ssuccess+1;
						$sqla = "select id from ssc_zbills order by id desc limit 1";
						$rsa = mysql_query($sqla);
						$rowa = mysql_fetch_array($rsa);
						$dan = sprintf("%06s",strtoupper(base_convert($rowa['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));
						$sissue=$_REQUEST['lt_trace_issues'][0];//2013-9-11 ADD
						$sqla="INSERT INTO ssc_zbills set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan."', uid='".$_SESSION["uid"]."', username='".$_SESSION["username"]."', issue='".$sissue."', type='".$strb->type."', mid='".$strb->methodid."',mname='".$mname."', codes='".$strb->codes."', pos='".$pos."', nums='".$strb->nums."', znums='".$zcount."', money='".$zmoney."', mode='".$mode."', rates='".$prize."', point='".$spoint."', cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', userip='".$ip."', autostop='".$_REQUEST['lt_trace_stop']."', adddate='".date("Y-m-d H:i:s")."',virtual='" .$row['virtual']. "'";
						$exe=mysql_query($sqla) or  die("数据库修改出错5!!!!");
		
						$lmoney=$leftmoney - $zmoney;
		
						$sqla = "select id from ssc_record order by id desc limit 1";		//帐变zh扣款
						$rsa = mysql_query($sqla);
						$rowa = mysql_fetch_array($rsa);
						$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));
						$sqla="insert into ssc_record set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan1."', dan2='".$dan."', uid='".$_SESSION["uid"]."', username='".$_SESSION["username"]."', issue='".$sissue."', types='9', mid='".$strb->methodid."',mname='".$mname."', mode='".$mode."', zmoney=".$zmoney.",leftmoney=".$lmoney.", cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', adddate='".date("Y-m-d H:i:s")."',virtual='" .$row['virtual']. "'";
						$exe=mysql_query($sqla) or  die("数据库修改出错6!!!");
						
						$sqla="update ssc_member set leftmoney=".$lmoney.", usedmoney=usedmoney+".$zmoney.", tempmoney=tempmoney+".$zmoney." where username='".$_SESSION["username"]."'"; 
						$exe=mysql_query($sqla) or  die("数据库修改出错7!!!");
						
						$sqla = "select * from ssc_savelist where username='" . $_SESSION["username"] . "' order by id desc limit 1";
						$rsa = mysql_query($sqla);
						$rowa = mysql_fetch_array($rsa);
						
						$sqla="update ssc_savelist set xf=xf+".$zmoney." where id='".$rowa['id']."'"; 
						$exe=mysql_query($sqla) or  die("数据库修改出错2!!!");
						
						for ($ii=0; $ii<$zcount; $ii++) {
		//					$ztimes=$ztimes+$_REQUEST['lt_trace_times_'.$_REQUEST['lt_trace_issues'][$ii]];
							$dmoney=($strb->money/$strb->times)*$_REQUEST['lt_trace_times_'.$_REQUEST['lt_trace_issues'][$ii]];
							$sqla="INSERT INTO ssc_zdetail set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan."', uid='".$_SESSION["uid"]."', username='".$_SESSION["username"]."', issue='".$_REQUEST['lt_trace_issues'][$ii]."', type='".$strb->type."', mid='".$strb->methodid."', codes='".$strb->codes."', pos='".$pos."', nums='".$strb->nums."', times='".$_REQUEST['lt_trace_times_'.$_REQUEST['lt_trace_issues'][$ii]]."', money='".$dmoney."', mode='".$mode."',mname='".$mname."', rates='".$prize."', point='".$spoint."', cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', userip='".$ip."', autostop='".$_REQUEST['lt_trace_stop']."', adddate='".date("Y-m-d H:i:s")."', canceldead='".Get_canceldate($lotteryid,$_REQUEST['lt_trace_issues'][$ii])."',virtual='" .$row['virtual']. "'";
							$exe=mysql_query($sqla) or  die("数据库修改出错8!!!!");
		
							if($_REQUEST['lt_trace_issues'][$ii]==$issue){
								$sqla = "update ssc_zbills set fnums=fnums+1, fmoney=fmoney+".$dmoney." where dan='".$dan."'";
								$rsa = mysql_query($sqla);
		
								$sqla = "select * from ssc_record order by id desc limit 1";
								$rsa = mysql_query($sqla);
								$rowa = mysql_fetch_array($rsa);
								$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));//追号返款
								$sqla="insert into ssc_record set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan1."', dan2='".$dan."', uid='".$_SESSION["uid"]."', username='".$_SESSION["username"]."', issue='".$_REQUEST['lt_trace_issues'][$ii]."', types='10', mid='".$strb->methodid."', mode='".$mode."',mname='".$mname."', smoney=".$dmoney.",leftmoney=".($lmoney+$dmoney).", cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', adddate='".date("Y-m-d H:i:s")."',virtual='" .$row['virtual']. "'";
								$exe=mysql_query($sqla) or  die("数据库修改出错9!!!");
		
								$sqla = "select id from ssc_bills order by id desc limit 1";
								$rsa = mysql_query($sqla);
								$rowa = mysql_fetch_array($rsa);
								$dan2 = sprintf("%06s",strtoupper(base_convert($rowa['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));//转注单
								
								$sqla="INSERT INTO ssc_bills set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan2."', dan1='".$dan."', uid='".$_SESSION["uid"]."', username='".$_SESSION["username"]."', issue='".$_REQUEST['lt_trace_issues'][$ii]."', type='".$strb->type."', mid='".$strb->methodid."',mname='".$mname."', codes='".$strb->codes."', pos='".$pos."', nums='".$strb->nums."', times='".$_REQUEST['lt_trace_times_'.$_REQUEST['lt_trace_issues'][$ii]]."', money='".$dmoney."', mode='".$mode."', rates='".$prize."', point='".$spoint."', cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', userip='".$ip."', adddate='".date("Y-m-d H:i:s")."', canceldead='".Get_canceldate($lotteryid,$_REQUEST['lt_trace_issues'][$ii])."', autostop='".$_REQUEST['lt_trace_stop']."',virtual='" .$row['virtual']. "'";
								$exe=mysql_query($sqla) or  die("数据库修改出错10!!!!");
								
								$sqla = "update ssc_zdetail set danb='".$dan2."', zt=1 where dan='".$dan."' and issue='".$_REQUEST['lt_trace_issues'][$ii]."'";
								$rsa = mysql_query($sqla);

								$sqla = "select id from ssc_record order by id desc limit 1";
								$rsa = mysql_query($sqla);
								$rowa = mysql_fetch_array($rsa);
								$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));//投注扣款
								$sqla="insert into ssc_record set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan1."', dan1='".$dan2."', dan2='".$dan."', uid='".$_SESSION["uid"]."', username='".$_SESSION["username"]."', issue='".$_REQUEST['lt_trace_issues'][$ii]."', types='7', mid='".$strb->methodid."',mname='".$mname."', mode='".$mode."', zmoney=".$dmoney.",leftmoney=".$lmoney.", cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', adddate='".date("Y-m-d H:i:s")."',virtual='" .$row['virtual']. "'";
								$exe=mysql_query($sqla) or  die("数据库修改出错11!!!");
								
														
								if($spoint!="0"){
									$sqla = "select id from ssc_record order by id desc limit 1";
									$rsa = mysql_query($sqla);
									$rowa = mysql_fetch_array($rsa);
									$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));
									$sqla="insert into ssc_record set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan1."', dan1='".$dan2."', dan2='".$dan."', uid='".$_SESSION["uid"]."', username='".$_SESSION["username"]."', issue='".$_REQUEST['lt_trace_issues'][$ii]."', types='11', mid='".$strb->methodid."',mname='".$mname."', mode='".$mode."', smoney=".$dmoney*$spoint.",leftmoney=".($lmoney+$dmoney*$spoint).", cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', adddate='".date("Y-m-d H:i:s")."',virtual='" .$row['virtual']. "'";
									$exe=mysql_query($sqla) or  die("数据库修改出错4!!!");
		
									$sqla="update ssc_member set leftmoney=".($lmoney+$dmoney*$spoint)." where username='".$_SESSION["username"]."'"; 
									$exe=mysql_query($sqla) or  die("数据库修改出错12!!!");
								}

							
							}
						}
				}
			}
		}
	}
	if($sfail>0){
		echo "{\"stats\":\"fail\",\"data\":{\"success\":".$ssuccess.",\"fail\":".$sfail.",\"content\":[".$serr."]}}";
	}else{
		echo "success";
	}	
?>