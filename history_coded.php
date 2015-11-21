<?php 
session_start();
error_reporting(0);
require_once 'conn.php';
//require_once 'check.php';

$id=$_REQUEST['id'];
$issuecount=$_REQUEST['issuecount'];
$wday=$_REQUEST['wday'];
$starttime=$_REQUEST['starttime'];
$endtime=$_REQUEST['endtime'];

if($id==""){
	$id=1;
}

$ww=$_REQUEST['ww'];
$qw=$_REQUEST['qw'];
$bw=$_REQUEST['bw'];
$sw=$_REQUEST['sw'];
$gw=$_REQUEST['gw'];
$ns=0;
if($ww==1){$ns++;}
if($qw==1){$ns++;}
if($bw==1){$ns++;}
if($sw==1){$ns++;}
if($gw==1){$ns++;}
if($ns<2){
	$ns=3;
	$bw=1;
	$sw=1;
	$gw=1;
}

if($issuecount==""){
	$issuecount=30;
}
if($wday=="b"){
	$starttime=date("Y-m-d",strtotime("-2 day"));
	$endtime=date("Y-m-d",strtotime("-2 day"));
}
if($wday=="y"){
	$starttime=date("Y-m-d",strtotime("-1 day"));
	$endtime=date("Y-m-d",strtotime("-1 day"));
}
if($wday=="t"){
	$starttime=date("Y-m-d");
	$endtime=date("Y-m-d");
}

$ss="";
if($starttime!="" && $endtime!=""){
	$sql="select * from ssc_data where cid='".$id."' and (addtime >='".$starttime." 00:00:00' and addtime <='".$endtime." 23:59:59') order by issue asc";
}else{
	$sql="select id from ssc_data where cid='".$id."'";
	$rs=mysql_query($sql) or  die("数据库修改出错!!!!");
	$totala= mysql_num_rows($rs);
	if($totala-$issuecount<0){
		$tts=0;
	}else{
		$tts=$totala-$issuecount;
	}
	$sql="select * from ssc_data where cid='".$id."' order by issue asc limit ".$tts.",".$issuecount."";
}


	$rs=mysql_query($sql) or  die("数据库修改出错!!!!");
	$total= mysql_num_rows($rs);


if($id==1 || $id==5 || $id==6 || $id==7 || $id==12 || $id==14 || $id==16 || $id==17){
	$ntn=5;
	$tn1="万位";
	$tn2="千位";
	$tn3="百位";
	$tn4="十位";
	$tn5="个位";
}else if($id==2 || $id==8 || $id==9 || $id==10){
	$ntn=6;
	$tn1="第一位";
	$tn2="第二位";
	$tn3="第三位";
	$tn4="第四位";
	$tn5="第五位";
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<head>
    <title>娱乐平台  - 胆码走势图</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
        <script>var pri_imgserver = 'http://commonuploader.b0.upaiyun.com';</script>
        <link href="./css/v1/all.css?modidate=20130201001" rel="stylesheet" type="text/css" />
    <link href="./js/calendar/css/calendar-blue2.css?modidate=20130201001" rel="stylesheet" type="text/css" />
    <script language="javascript" type="text/javascript" src="./js/jquery.js?modidate=20130820001"></script>
    <script language="javascript" type="text/javascript" src="./js/common.js?modidate=20130820001"></script>
    <script language="javascript" type="text/javascript" src="./js/lottery/min/message.js?modidate=20130820001"></script>
    <script language="javascript" type="text/javascript" src="./js/calendar/jquery.dyndatetime.js?modidate=20130820001"></script>
    <script language="javascript" type="text/javascript" src="./js/calendar/lang/calendar-utf8.js?modidate=20130820001"></script>
    <script language="javascript" type="text/javascript" src="./js/common/line.js?modidate=20130820001"></script>
        <script LANGUAGE='JavaScript'>function ResumeError() {return true;} window.onerror = ResumeError; </script> 
</head>
<body>
<div id="rightcon">
<div id="msgbox" class="win_bot" style="display:none;">
    <h5 id="msgtitle"></h5> <div class="wb_close" onclick="javascript:msgclose();"></div>
    <div class="clear"></div>
    <div class="wb_con">
            <p id="msgcontent"></p>
    </div>
    <div class="clear"></div>
    <a class="wb_p" href="#" onclick="javascript:prenotice();" id="msgpre">上一条</a><a class="wb_n" href="#" onclick="javascript:nextnotice();">下一条</a>
</div><script language="javascript"> 

</script>
<style> 
    esun\:*{behavior:url(#default#VML)}
</style>
<div class="rc_con history">
    <div class="rc_con_lt"></div>
    <div class="rc_con_rt"></div>
    <div class="rc_con_lb"></div>
    <div class="rc_con_rb"></div>
    <h5><div class="rc_con_title">胆码走势图</div></h5>
    <div class="rc_con_to">
        <div class="rc_con_ti">
            <div class="history_code">
                <table width=100% id=tm border=0 cellpadding=0 cellspacing=0>
                    <tr>
                        <td align=left width=200>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>
                                <font color="#FF0000"><?=Get_lottery($id)?>：</font>
                                胆码走势图
                            </strong>
                        </td>
                        <td align=left>
                            <form method="POST" action="?id=<?=$id?>">
                                <span>
                                    <!--<label for="has_line">
                                        <input type="checkbox" name="checkbox2" value="checkbox" id="has_line" />显示折线
                                    </label>-->
                                </span>&nbsp;
                                <span>
                                    <label>
                                        <input type="checkbox" name="ww" value="1" id="ww"  <?php if($ww==1){?>checked="checked"<?php }?>/>万位
                                    </label>
                                </span>&nbsp;
                                <span>
                                    <label>
                                        <input type="checkbox" name="qw" value="1" id="qw" <?php if($qw==1){?>checked="checked"<?php }?>/>千位
                                    </label>
                                </span>&nbsp;
                                <span>
                                    <label>
                                        <input type="checkbox" name="bw" value="1" id="bw" <?php if($bw==1){?>checked="checked"<?php }?>/>百位
                                    </label>
                                </span>&nbsp;
                                <span>
                                    <label>
                                        <input name="sw" type="checkbox" id="sw" value="1" <?php if($sw==1){?>checked="checked"<?php }?>/>
                                        十位
                                    </label>
                                </span>&nbsp;
                                <span>
                                    <label>
                                        <input type="checkbox" name="gw" value="1" id="gw" <?php if($gw==1){?>checked="checked"<?php }?>/>个位
                                    </label>
                                </span>&nbsp;
                                <input type="submit" value="搜索" class="button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="?id=<?=$id?>&ww=<?=$ww?>&qw=<?=$qw?>&bw=<?=$bw?>&sw=<?=$sw?>&gw=<?=$gw?>&issuecount=30&frequencytype=0">最近30期</a>&nbsp;
                                <a href="?id=<?=$id?>&ww=<?=$ww?>&qw=<?=$qw?>&bw=<?=$bw?>&sw=<?=$sw?>&gw=<?=$gw?>&issuecount=50&frequencytype=0">最近50期</a>&nbsp;
                                <a href="?id=<?=$id?>&ww=<?=$ww?>&qw=<?=$qw?>&bw=<?=$bw?>&sw=<?=$sw?>&gw=<?=$gw?>&issuecount=50&frequencytype=0">最近100期</a>&nbsp;
                                <a href="?id=<?=$id?>&ww=<?=$ww?>&qw=<?=$qw?>&bw=<?=$bw?>&sw=<?=$sw?>&gw=<?=$gw?>&wday=b&frequencytype=0">前天</a>&nbsp;
                                <a href="?id=<?=$id?>&ww=<?=$ww?>&qw=<?=$qw?>&bw=<?=$bw?>&sw=<?=$sw?>&gw=<?=$gw?>&wday=y&frequencytype=0">昨天</a>&nbsp;
                                <a href="?id=<?=$id?>&ww=<?=$ww?>&qw=<?=$qw?>&bw=<?=$bw?>&sw=<?=$sw?>&gw=<?=$gw?>&wday=t&frequencytype=0">今天</a>&nbsp;
                                &nbsp;&nbsp;
                            </form>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="hrc_list">
                <div class="hrl_list">
                    <table id="chartsTable" width="100%" border="0" cellpadding="0" cellspacing="1">
                        <tr class="th">
                            <td>期号</td>
                            <td>开奖号码</td>
                            <td>跨度</td>
                            <td>和尾</td>
                            <td>和值</td>
                            <td>奇偶</td>
                            <td>大小</td>
<?php if($ns>2){ ?>
                            <td>组选</td>
<?php }?>
                        </tr>
<?php
	while ($rowa = mysql_fetch_array($rs)){
//		echo $rowa['issue'];
		$na=explode(",",$rowa['code']);
		$nt="";
		$nts="";
		$hz=0;
		$jo=0;
		$dx=0;
		$strc="";
		if($ww==1){
			$nt=$nt.$na[0];
			$nts=$nts."<font color='red'>".$na[0]."</font>";
			$hz=$hz+$na[0];
			if($na[0]%2==1){$jo++;}
			if($na[0]>=$ntn){$dx++;}
		}else{
			$nts=$nts.$na[0];
		}
		if($qw==1){
			if($nt!=""){$nt=$nt.",";}
			$nt=$nt.$na[1];
			$nts=$nts."<font color='red'>".$na[1]."</font>";
			$hz=$hz+$na[1];
			if($na[1]%2==1){$jo++;}
			if($na[1]>=$ntn){$dx++;}
		}else{
			$nts=$nts.$na[1];
		}
		if($bw==1){
			if($nt!=""){$nt=$nt.",";}
			$nt=$nt.$na[2];
			$nts=$nts."<font color='red'>".$na[2]."</font>";
			$hz=$hz+$na[2];
			if($na[2]%2==1){$jo++;}
			if($na[2]>=$ntn){$dx++;}
		}else{
			$nts=$nts.$na[2];
		}
		if($sw==1){
			if($nt!=""){$nt=$nt.",";}
			$nt=$nt.$na[3];
			$nts=$nts."<font color='red'>".$na[3]."</font>";
			$hz=$hz+$na[3];
			if($na[3]%2==1){$jo++;}
			if($na[3]>=$ntn){$dx++;}
		}else{
			$nts=$nts.$na[3];
		}
		if($gw==1){
			if($nt!=""){$nt=$nt.",";}
			$nt=$nt.$na[4];
			$nts=$nts."<font color='red'>".$na[4]."</font>";
			$hz=$hz+$na[4];
			if($na[4]%2==1){$jo++;}
			if($na[4]>=$ntn){$dx++;}
		}else{
			$nts=$nts.$na[4];
		}
		
		$nb=pnb($nt);
		$kd=$nb[count($nb)-1]-$nb[0];
		if($ns==5){
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
		}elseif($ns==4){
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
		}elseif($ns==3){
			if($nb[0]==$nb[1] || $nb[1]==$nb[2]){
				$strc="组选三";
			}else{
				$strc="组选六";
			}
		}

?>			
            <tr>
				<td align="center"><?=$rowa['issue']?></td>
				<td align="center"><?=$nts?></td>
				<td align="center"><?=$kd?></td>
				<td align="center"><?=($hz % 10)?></td>
				<td align="center"><?=$hz?></td>
				<td align="center"><?=($jo.":".($ns-$jo))?></td>
				<td align="center"><?=($dx.":".($ns-$dx))?></td>
<?php if($ns>2){ ?>
                <td align="center"><?=$strc?></td>
<?php }?>

<?php }?>
			</tr>

                    </table>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
<div class="clear"></div>
<div class="rc_con">
    <div class="rc_con_lt"></div>
    <div class="rc_con_rt"></div>
    <div class="rc_con_lb"></div>
    <div class="rc_con_rb"></div>
    <div class="rc_con_to">
    	<table width=100% border="0" cellspacing="0" cellpadding="0">
            <tr><td height="25" align="center">浏览器建议：首选IE 8.0,Chrome浏览器，其次为火狐浏览器,尽量不要使用IE6。</td></tr>
            <tr><td height="25" align="center">资金安全建议：为了您的资金安全请定期更换资金密码。</td></tr>
        </table>
    </div>
</div>

</div>
</body>
</html>
