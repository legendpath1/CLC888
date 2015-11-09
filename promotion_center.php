<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

if($_POST['flag']=="getgift"){
	$id=$_POST['id'];
	$sql="select * from ssc_activity where id= ".$id;
	$query = mysql_query($sql);
	$rs = mysql_fetch_array($query);
	if($id==1){//开户有礼
			$smoney=floatval($rs['tjz']);
			if($smoney>0){
				$sqlc = "select id from ssc_record order by id desc limit 1";		//帐变
				$rsc = mysql_query($sqlc);
				$rowc = mysql_fetch_array($rsc);
				$dan1 = sprintf("%07s",strtoupper(base_convert($rowc['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));
				
				$sqlc = "select * from ssc_member where username ='".$_SESSION["username"]."'";	
				$rsc = mysql_query($sqlc);
				$rowc = mysql_fetch_array($rsc);

				if($rowc['tag1']=="1"){		
						$_SESSION["backtitle"]="您已参加了开户有礼活动";
						$_SESSION["backurl"]="promotion_center.php?id=".$_REQUEST['id'];
						$_SESSION["backzt"]="failed";
						$_SESSION["backname"]="开户有礼";
						echo "<script language=javascript>window.location='sysmessage.php';</script>";
						exit;
				}

				$sqlb = "select * from ssc_bankcard WHERE  username='" . $_SESSION["username"] . "'";
				$rsb = mysql_query($sqlb);
				$rowb = mysql_fetch_array($rsb);
				$cardnum=mysql_num_rows($rsb);

				if($cardnum>0){
					if($rowc['cardlock']==1){
						$sqld="select * from ssc_savelist where username= '".$_SESSION["username"]."' and zt='1'  order by id asc limit 1";
						$queryd = mysql_query($sqld);
						$rsd = mysql_fetch_array($queryd);
//						if(empty($rsd)){
//							echo "<script language=javascript>alert('对不起，您不符合领取红包条件，请充值！');window.location.href='?id=".$id."';</script>";
//							exit;
//						}
					
						$lmoney=$rowc['leftmoney']+$smoney;
						$sqlb="insert into ssc_record set dan='".$dan1."', uid='".$rowc['id']."', username='".$rowc['username']."', types='32', smoney=".$smoney.",leftmoney=".$lmoney.", regtop='" .$rowc['regtop']. "', regup='" .$rowc['regup']. "', regfrom='".$rowc['regfrom']."', adddate='".date("Y-m-d H:i:s")."',tag='开户有礼',virtual='" .$rowc['virtual']. "'";
						$exe=mysql_query($sqlb) or  die("数据库修改出错6!!!");
						
						$sql="update ssc_member set leftmoney ='".$lmoney."',tag1='1' where username ='".$_SESSION["username"]."'";
						$exe=mysql_query($sql) or  die("数据库修改出错6!!!");

						$_SESSION["backtitle"]="祝贺您领取了".$smoney."元红包！";
						$_SESSION["backurl"]="promotion_center.php?id=".$_REQUEST['id'];
						$_SESSION["backzt"]="successed";
						$_SESSION["backname"]="开户有礼";
						echo "<script language=javascript>window.location='sysmessage.php';</script>";
						exit;
					}else{
						$_SESSION["backtitle"]="请先锁定您的银行卡！";
						$_SESSION["backurl"]="promotion_center.php?id=".$_REQUEST['id'];
						$_SESSION["backzt"]="failed";
						$_SESSION["backname"]="开户有礼";

						echo "<script language=javascript>window.location='sysmessage.php';</script>";
						exit;		
					}
				}else{
						$_SESSION["backtitle"]="请先绑定您的银行卡！";
						$_SESSION["backurl"]="promotion_center.php?id=".$_REQUEST['id'];
						$_SESSION["backzt"]="failed";
						$_SESSION["backname"]="开户有礼";
						echo "<script language=javascript>window.location='sysmessage.php';</script>";
						exit;	
				}
			}
	}elseif($id==3){
		if(date("H:i:s")<"08:00:00" || date("H:i:s")>"23:30:00"){
			$_SESSION["backtitle"]="领奖失败! 原因:请于08:00-23:30期间领奖！";
			$_SESSION["backurl"]="promotion_center.php?id=".$_REQUEST['id'];
			$_SESSION["backzt"]="failed";
			$_SESSION["backname"]="领奖活动";
			echo "<script language=javascript>window.location='sysmessage.php';</script>";
			exit;	
		}
		$sqld="select * from ssc_record where adddate>='".date("Y-m-d")." 03:00:00"."' and username= '".$_SESSION["username"]."' and types='32' and tag='开市有礼'";
		$queryd = mysql_query($sqld);
		$rsd = mysql_fetch_array($queryd);
		if(empty($rsd)){
			$sqla="select SUM(IF(types = 7, zmoney, 0)) as t7,SUM(IF(types = 13, smoney, 0)) as t13 from ssc_record where adddate>='".date("Y-m-d",strtotime("-1 day"))." 03:00:00"."' and adddate<'".date("Y-m-d")." 03:00:00"."' and username= '".$_SESSION["username"]."' and (types='7' or types='13')";
			$querya = mysql_query($sqla);
			$rsa = mysql_fetch_array($querya);
			$txf=$rsa['t7']-$rsa['t13'];
			
//			echo $txf;
			$smoney=$txf/1000*5;
			$umoney=$smoney;

			$sqlc = "select * from ssc_member where username ='".$_SESSION["username"]."'";	
			$rsc = mysql_query($sqlc);
			$rowc = mysql_fetch_array($rsc);
			$lmoney=$rowc['leftmoney'];
			
			if($smoney>0){
				$sqle = "select * from ssc_record order by id desc limit 1";		//帐变
				$rse = mysql_query($sqle);
				$rowe = mysql_fetch_array($rse);
				$dan1 = sprintf("%07s",strtoupper(base_convert($rowe['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));
				
				$lmoney=$rowc['leftmoney']+$smoney;
				
				$sqlb="insert into ssc_record set dan='".$dan1."', uid='".$rowc['id']."', username='".$rowc['username']."', types='32', smoney=".$smoney.",leftmoney=".$lmoney.", regtop='" .$rowc['regtop']. "', regup='" .$rowc['regup']. "', regfrom='".$rowc['regfrom']."', adddate='".date("Y-m-d H:i:s")."',tag='开市有礼',virtual='" .$rowc['virtual']. "'";
				$exe=mysql_query($sqlb) or  die("数据库修改出错6!!!");
				
				$sql="update ssc_member set leftmoney ='".$lmoney."' where username ='".$_SESSION["username"]."'";
				$exe=mysql_query($sql) or  die("数据库修改出错6!!!");

				$sqlc = "select * from ssc_member where username ='".$rowc['regup']."'";	
				$rsc = mysql_query($sqlc);
				$rowc = mysql_fetch_array($rsc);
				if(empty($rowc)){
				}else{
					$lmoney=$rowc['leftmoney'];
		
					$sqle = "select * from ssc_record order by id desc limit 1";		//帐变
					$rse = mysql_query($sqle);
					$rowe = mysql_fetch_array($rse);
					$dan1 = sprintf("%07s",strtoupper(base_convert($rowe['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));
						
					$lmoney=$rowc['leftmoney']+$umoney;
						
					$sqlb="insert into ssc_record set dan='".$dan1."', uid='".$rowc['id']."', username='".$rowc['username']."', types='32', smoney=".$umoney.",leftmoney=".$lmoney.", regtop='" .$rowc['regtop']. "', regup='" .$rowc['regup']. "', regfrom='".$rowc['regfrom']."', adddate='".date("Y-m-d H:i:s")."',tag='上级开市有礼',virtual='" .$rowc['virtual']. "'";
					$exe=mysql_query($sqlb) or  die("数据库修改出错6!!!");
						
					$sql="update ssc_member set leftmoney ='".$lmoney."' where username ='".$rowc['username']."'";
					$exe=mysql_query($sql) or  die("数据库修改出错6!!!");
				}
					
				echo "<script language=javascript>alert('祝贺您领取了".$smoney."元红包！');window.location.href='?id=".$id."';</script>";
				exit;
			}else{
				echo "<script language=javascript>alert('对不起，您不符合领取红包条件！');window.location.href='?id=".$id."';</script>";
				exit;
			}
		}else{
			echo "<script language=javascript>alert('今天您已参加了领奖活动！');window.location.href='?id=".$id."';</script>";
			exit;
		}
	}elseif($id==5){
		if(date("H:i:s")<"08:00:00" || date("H:i:s")>"23:30:00"){
			$_SESSION["backtitle"]="领奖失败! 原因:请于08:00-23:30期间领奖！";
			$_SESSION["backurl"]="promotion_center.php?id=".$_REQUEST['id'];
			$_SESSION["backzt"]="failed";
			$_SESSION["backname"]="领奖活动";
			echo "<script language=javascript>window.location='sysmessage.php';</script>";
			exit;	
		}
		$sqld="select * from ssc_record where adddate>='".date("Y-m-d")." 03:00:00"."' and username= '".$_SESSION["username"]."' and types='32' and tag='胆码送礼'";
		$queryd = mysql_query($sqld);
		$rsd = mysql_fetch_array($queryd);
		if(empty($rsd)){
			$sqla="select SUM(IF(types = 7, zmoney, 0)) as t7,SUM(IF(types = 13, smoney, 0)) as t13 from ssc_record where adddate>='".date("Y-m-d",strtotime("-1 day"))." 03:00:00"."' and adddate<'".date("Y-m-d")." 03:00:00"."' and username= '".$_SESSION["username"]."' and (types='7' or types='13') and (mid=69 || mid=70 || mid=71 || mid=72 || mid=149 || mid=150 || mid=151 || mid=152 || mid=229 || mid=230 || mid=231 || mid=232 || mid=309 || mid=310 || mid=311 || mid=312 || mid=389 || mid=390 || mid=391 || mid=392 || mid=739 || mid=740 || mid=741 || mid=742)";
			$querya = mysql_query($sqla);
			$rsa = mysql_fetch_array($querya);
			$txf=$rsa['t7']-$rsa['t13'];
			
//			echo $txf;
			$smoney=$txf/1000*5;
			$umoney=$smoney;
			
			$sqlc = "select * from ssc_member where username ='".$_SESSION["username"]."'";	
			$rsc = mysql_query($sqlc);
			$rowc = mysql_fetch_array($rsc);
			$lmoney=$rowc['leftmoney'];
			
			if($smoney>0){
				$sqle = "select * from ssc_record order by id desc limit 1";		//帐变
				$rse = mysql_query($sqle);
				$rowe = mysql_fetch_array($rse);
				$dan1 = sprintf("%07s",strtoupper(base_convert($rowe['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));
				
				$lmoney=$rowc['leftmoney']+$smoney;
				
				$sqlb="insert into ssc_record set dan='".$dan1."', uid='".$rowc['id']."', username='".$rowc['username']."', types='32', smoney=".$smoney.",leftmoney=".$lmoney.", regtop='" .$rowc['regtop']. "', regup='" .$rowc['regup']. "', regfrom='".$rowc['regfrom']."', adddate='".date("Y-m-d H:i:s")."',tag='胆码送礼',virtual='" .$rowc['virtual']. "'";
				$exe=mysql_query($sqlb) or  die("数据库修改出错6!!!");
				
				$sql="update ssc_member set leftmoney ='".$lmoney."' where username ='".$_SESSION["username"]."'";
				$exe=mysql_query($sql) or  die("数据库修改出错6!!!");

				$sqlc = "select * from ssc_member where username ='".$rowc['regup']."'";	
				$rsc = mysql_query($sqlc);
				$rowc = mysql_fetch_array($rsc);
				if(empty($rowc)){
				}else{
					$lmoney=$rowc['leftmoney'];
		
					$sqle = "select * from ssc_record order by id desc limit 1";		//帐变
					$rse = mysql_query($sqle);
					$rowe = mysql_fetch_array($rse);
					$dan1 = sprintf("%07s",strtoupper(base_convert($rowe['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));
						
					$lmoney=$rowc['leftmoney']+$umoney;
						
					$sqlb="insert into ssc_record set dan='".$dan1."', uid='".$rowc['id']."', username='".$rowc['username']."', types='32', smoney=".$umoney.",leftmoney=".$lmoney.", regtop='" .$rowc['regtop']. "', regup='" .$rowc['regup']. "', regfrom='".$rowc['regfrom']."', adddate='".date("Y-m-d H:i:s")."',tag='上级胆码送礼',virtual='" .$rowc['virtual']. "'";
					$exe=mysql_query($sqlb) or  die("数据库修改出错6!!!");
						
					$sql="update ssc_member set leftmoney ='".$lmoney."' where username ='".$rowc['username']."'";
					$exe=mysql_query($sql) or  die("数据库修改出错6!!!");
				}
				
				echo "<script language=javascript>alert('祝贺您领取了".$smoney."元红包！');window.location.href='?id=".$id."';</script>";
				exit;
			}else{
				echo "<script language=javascript>alert('对不起，您不符合领取红包条件！');window.location.href='?id=".$id."';</script>";
				exit;
			}
		}else{
			echo "<script language=javascript>alert('今天您已参加了领奖活动！');window.location.href='?id=".$id."';</script>";
			exit;
		}
	}elseif($id==2){//0.5%
		$sqld="select * from ssc_savelist where adddate>='".date("Y-m-d")." 00:00:00"."' and username= '".$_SESSION["username"]."' and zt='1'  order by id asc limit 1";
		$queryd = mysql_query($sqld);
		$rsd = mysql_fetch_array($queryd);
		if(empty($rsd)){
					echo "<script language=javascript>alert('对不起，您不符合领取红包条件！');window.location.href='?id=".$id."';</script>";
					exit;
		}else{
			if($rsd['hd']==1){
				echo "<script language=javascript>alert('今天您已参加了领奖活动！');window.location.href='?id=".$id."';</script>";
				exit;
			}else{
				$tmoney=5;
				$txf=$rsd['rmoney'];
				
				$sqlc = "select * from ssc_member where username ='".$_SESSION["username"]."'";	
				$rsc = mysql_query($sqlc);
				$rowc = mysql_fetch_array($rsc);
				$lmoney=$rowc['leftmoney'];
				$smoney=$txf/1000*$tmoney;
				
				if($smoney>0){
					$sql="update ssc_savelist set hd ='1' where id ='".$rsd['id']."'";
					$exe=mysql_query($sql) or  die("数据库修改出错6!!!");

					$sqle = "select * from ssc_record order by id desc limit 1";		//帐变
					$rse = mysql_query($sqle);
					$rowe = mysql_fetch_array($rse);
					$dan1 = sprintf("%07s",strtoupper(base_convert($rowe['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));
					
					$lmoney=$rowc['leftmoney']+$smoney;
					
					$sqlb="insert into ssc_record set dan='".$dan1."', uid='".$rowc['id']."', username='".$rowc['username']."', types='32', smoney=".$smoney.",leftmoney=".$lmoney.", regtop='" .$rowc['regtop']. "', regup='" .$rowc['regup']. "', regfrom='".$rowc['regfrom']."', adddate='".date("Y-m-d H:i:s")."',tag='充值返利',virtual='" .$rowc['virtual']. "'";
					$exe=mysql_query($sqlb) or  die("数据库修改出错6!!!");
					
					$sql="update ssc_member set leftmoney ='".$lmoney."' where username ='".$_SESSION["username"]."'";
					$exe=mysql_query($sql) or  die("数据库修改出错6!!!");

					$sqlc = "select * from ssc_member where username ='".$rowc['regup']."'";	
					$rsc = mysql_query($sqlc);
					$rowc = mysql_fetch_array($rsc);
					if(empty($rowc)){
					}else{
						$lmoney=$rowc['leftmoney'];
		
						$sqle = "select * from ssc_record order by id desc limit 1";		//帐变
						$rse = mysql_query($sqle);
						$rowe = mysql_fetch_array($rse);
						$dan1 = sprintf("%07s",strtoupper(base_convert($rowe['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));
						
						$lmoney=$rowc['leftmoney']+$smoney;
						
						$sqlb="insert into ssc_record set dan='".$dan1."', uid='".$rowc['id']."', username='".$rowc['username']."', types='32', smoney=".$smoney.",leftmoney=".$lmoney.", regtop='" .$rowc['regtop']. "', regup='" .$rowc['regup']. "', regfrom='".$rowc['regfrom']."', adddate='".date("Y-m-d H:i:s")."',tag='上级充值返利',virtual='" .$rowc['virtual']. "'";
						$exe=mysql_query($sqlb) or  die("数据库修改出错6!!!");
						
						$sql="update ssc_member set leftmoney ='".$lmoney."' where username ='".$rowc['username']."'";
						$exe=mysql_query($sql) or  die("数据库修改出错6!!!");
					}

					echo "<script language=javascript>alert('祝贺您领取了".$smoney."元红包！');window.location.href='?id=".$id."';</script>";
					exit;
				}else{
					echo "<script language=javascript>alert('对不起，您不符合领取红包条件！');window.location.href='?id=".$id."';</script>";
					exit;
				}
			}
		}
	}
}
	$sql="select * from ssc_activity where zt=1 and starttime< '".date("Y-m-d H:i:s")."' and endtime >'".date("Y-m-d H:i:s")."'";//.$_GET['id']
	$query = mysql_query($sql);
	$nums=mysql_num_rows($query);
	if($nums==0){
		$_SESSION["backtitle"]="暂无活动！";
		$_SESSION["backurl"]="help_security.php";
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="暂无活动";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<head>
    <title>娱乐平台  - 活动</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
        <link href="./css/v1/all.css?modidate=20130201001" rel="stylesheet" type="text/css" />
    <script>var pri_imgserver = '';</script>
        <script language="javascript" type="text/javascript" src="./js/jquery.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/common.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/lottery/min/message.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/keyboard/keyboard.js?modidate=20130415002"></script>
<script language="javascipt" type="text/javascript">
(function($){
        $(document).ready(function(){
            $("span[id^='general_tab_']","#tabbar-div-s2").click(function(){
                $k = $(this).attr("id").replace("general_tab_","");
                $k = parseInt($k,10);
                $("span[id^='general_tab_']","#tabbar-div-s2").attr("class","tab-back");
                $("div[id^='general_txt_']").hide();
                $(this).attr("class","tab-front");
                $("#general_txt_"+$k).show();
                $("span[id^='tabbar_tab_"+$k+"_']:first").click();
            });
            $("span[id^='tabbar_tab_']").click(function(){
                $z = $(this).attr("id").replace("tabbar_tab_","");
                $("span[id^='tabbar_tab_']").attr("class","tab-back");
                $("table[id^='tabbar_txt_']").hide();
                $(this).attr("class","tab-front");
                $("#tabbar_txt_"+$z).show();
            });
			<?php if($_REQUEST['id']==""){;?>
            $("span[id^='general_tab_']:first","#tabbar-div-s2").click();
			<?php }else{?>
            $("span[id^='general_tab_<?=$_REQUEST['id']?>']","#tabbar-div-s2").click();			
			<?php }?>
        });
    })(jQuery);
</script>
    <style type="text/css">
        .keyboard{-moz-user-select: -moz-none;}
    </style>
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
</div>

<div class="rc_con binding">
    <div class="rc_con_lt"></div>
    <div class="rc_con_rt"></div>
    <div class="rc_con_lb"></div>
    <div class="rc_con_rb"></div>
    <h5><div class="rc_con_title">活动</div></h5>
    <div class="rc_con_to">
        <div class="rc_con_ti">
            <div class="clear"></div>
            <div class="binding_input">
                <table class="ct" border="0" cellspacing="0" cellpadding="0" width="100%">
                    <tr>
                        <td id="tabbar-div-s2">
   	<?php 
		$rse = mysql_query($sql);
		while ($rowe = mysql_fetch_array($rse)){
	?>
                            <span class="tab-back"  id="general_tab_<?=$rowe['id']?>" TITLE='<?=$rowe['topic']?>' ALT='<?=$rowe['topic']?>'>
                                <span class="tabbar-left"></span>
                                <span class="content"><?=$rowe['topic']?></span>
                                <span class="tabbar-right"></span>
                            </span>
    <?php }?>
                        </td>
                    </tr>
                </table>
   	<?php 
		$rowe = mysql_query($sql);
		while ($row = mysql_fetch_array($rowe)){?>
				<div id="general_txt_<?=$row['id']?>">
					<table class="ct" border="0" cellspacing="0" cellpadding="0" width="100%">
					<form action="" method="post" name="drawform" id="drawform">
						<input type="hidden" name="flag" value="getgift" />
						<input type="hidden" name="id" value="<?=$row['id']?>" />
						<tr>
							<td class="nl" style="color:#FF6633;">活动主题</td>
							<td STYLE='line-height:20px;padding:5px 0px'><font style="font-size:16px;color:#F30;font-weight:bold;"><?=$row['topic']?></font>	</td>
						</tr>
						<tr>
							<td class="nl">活动内容</td>
							<td class='info' style="font-size:14px;">
						<?=$row['content']?></td>
						</tr>
						<tr>
							<td class="nl">活动规则</td>
							<td class='info' style="font-size:12px;line-height:25px;">
						<?=$row['intro']?></td>
						</tr>
						<tr>
							<td style="border-left:1px solid #E5E5E5;">&nbsp;</td>
							<td height="35">
							<input name="Submit" style='width:126px;height:29px;' type="image" id="Submit" src="<?=$ftp?>/images/lqhb.gif" title="下一步" width="104" height="35"/>
						
							</td>
						</tr>

					</form>
					</table>
				</div>
<?php }?>
			</div>
            <div class="clear"></div>
        </div>
    </div>
</div>
<div class="clear"></div>
<div id="copyright">
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