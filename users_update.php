<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$ztt=array("停用","使用中"); 
$uid=$_REQUEST['uid'];
$sql = "select * from ssc_member WHERE username='" . $_SESSION["username"] . "'";
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs);
$flevel=$row['flevel'];
$level=$row['level'];
$pes=$row['pe'];

$sql = "select * from ssc_member WHERE id='" . $uid . "'";
$rs = mysql_query($sql);
$total=mysql_num_rows($rs);
if($total==0){
	$_SESSION["backtitle"]="该用户不存在";
	$_SESSION["backurl"]="users_list.php";
	$_SESSION["backzt"]="failed";
	$_SESSION["backname"]="用户列表";
	echo "<script language=javascript>window.location='sysmessage.php';</script>";
	exit;
}
$row = mysql_fetch_array($rs);
$flevel1=$row['flevel'];

$sqls = "select flevel from ssc_member WHERE regup='" . $row['username'] . "' order by flevel desc limit 1";
$rss = mysql_query($sqls);
$total=mysql_num_rows($rss);
if($total==0){
	$flevels=0;
}else{
	$rows = mysql_fetch_array($rss);
	$flevels=$rows['flevel']+0.1;
}

if($flevel>7.0){
	$pe=explode(";",$pes);
	$pe0=$pe[0];
	$pe1=$pe[1];
	$pe2=$pe[2];
	$pe3=$pe[3];
	$pe4=$pe[4];
	$pe5=$pe[5];
	$pe6=$pe[6];
	$pe7=$pe[7];
}else{
	$pe0=0;
	$pe1=0;
	$pe2=0;
	$pe3=0;
	$pe4=0;
	$pe5=0;
	$pe6=0;
	$pe7=0;
}
//if($level==2){
//	$flevel2=$flevel;
//}else{
	$flevel2=$flevel-0.1;
	if($flevel2<0){
		$flevel2=0;
	}
//}

$flag=$_REQUEST['flag'];

if($flag=="insert"){

	if($_REQUEST['keeppoint']!=""){
		$fflevel = round($_REQUEST['keeppoint'],1);
		if($fflevel>$flevel2 || $fflevel<$flevels){
			$_SESSION["backtitle"]="用户返点设置错误";
			$_SESSION["backurl"]="users_list.php";
			$_SESSION["backzt"]="failed";
			$_SESSION["backname"]="用户列表";
			echo "<script language=javascript>window.location='sysmessage.php';</script>";
			exit;
		}

		$sqla = "select flevel from ssc_member WHERE username='" . $row['regup'] . "'";
		$rsa = mysql_query($sqla);
		$rowa = mysql_fetch_array($rsa);
		if($fflevel>$rowa['flevel']-0.1){
			$_SESSION["backtitle"]="用户返点设置错误。不符合上级点差";
			$_SESSION["backurl"]="users_list.php";
			$_SESSION["backzt"]="failed";
			$_SESSION["backname"]="用户列表";
			echo "<script language=javascript>window.location='sysmessage.php';</script>";
			exit;
		}


		if($flevel1>=7.7){
			$pe[7]=$pe[7]+1;
		}elseif($flevel1==7.6){
			$pe[6]=$pe[6]+1;
		}elseif($flevel1==7.5){
			$pe[5]=$pe[5]+1;
		}elseif($flevel1==7.4){
			$pe[4]=$pe[4]+1;
		}elseif($flevel1==7.3){
			$pe[3]=$pe[3]+1;
		}elseif($flevel1==7.2){
			$pe[2]=$pe[2]+1;
		}elseif($flevel1==7.1){
			$pe[1]=$pe[1]+1;
		}elseif($flevel1==7.0){
			$pe[0]=$pe[0]+1;
		}
		
		if($fflevel>=7.7){
			if($pe[7]>0){
				$pe[7]=$pe[7]-1;
			}else{
				$prerr=1;
			}
		}elseif($fflevel==7.6){
			if($pe[6]>0){
				$pe[6]=$pe[6]-1;
			}else{
				$prerr=1;
			}
		}elseif($fflevel==7.5){
			if($pe[5]>0){
				$pe[5]=$pe[5]-1;
			}else{
				$prerr=1;
			}
		}elseif($fflevel==7.4){
			if($pe[4]>0){
				$pe[4]=$pe[4]-1;
			}else{
				$prerr=1;
			}
		}elseif($fflevel==7.3){
			if($pe[3]>0){
				$pe[3]=$pe[3]-1;
			}else{
				$prerr=1;
			}
		}elseif($fflevel==7.2){
			if($pe[2]>0){
				$pe[2]=$pe[2]-1;
			}else{
				$prerr=1;
			}
		}elseif($fflevel==7.1){
			if($pe[1]>0){
				$pe[1]=$pe[1]-1;
			}else{
				$prerr=1;
			}
		}elseif($fflevel==7.0){
			if($pe[0]>0){
				$pe[0]=$pe[0]-1;
			}else{
				$prerr=1;
			}
		}

		if($prerr==1){
			$_SESSION["backtitle"]="配额不足，请与上级联系！";
			$_SESSION["backurl"]="users_list.php";
			$_SESSION["backzt"]="failed";
			$_SESSION["backname"]="用户列表";
			echo "<script language=javascript>window.location='sysmessage.php';</script>";
			exit;
		}

		if($flevel>7){
			$pes=implode(";",$pe);
			$sql = "update ssc_member set pe='" . $pes . "' where username='" . $_SESSION["username"] . "'";
			$exe = mysql_query($sql);
		}

		$sql = "update ssc_member set flevel='".$fflevel."' where id='" . $uid . "'";
//		echo $sql;
		$exe = mysql_query($sql);
		
		$_SESSION["backtitle"]="操作成功";
		$_SESSION["backurl"]="users_list.php";
		$_SESSION["backzt"]="successed";
		$_SESSION["backname"]="用户列表";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<head>
    <title>娱乐平台  - 修改用户</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
        <link href="./css/v1/all.css?modidate=20130201001" rel="stylesheet" type="text/css" />
    <script>var pri_imgserver = '';</script>
        <script language="javascript" type="text/javascript" src="./js/jquery.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/common.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/lottery/min/message.js?modidate=20130415002"></script>
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
</div><script type="text/javascript"> 
 
    function checkform(obj)
    {
            minp = Number($("#keepmin").val());
            maxp = Number($("#keepmax").val());
            point= Number($("#keeppoint").val());
            if( point > maxp || point < minp ){
                alert("保留返点设置错误，请检查");
                return false;
            }
        obj.submit.disabled=true;
        return true;
    }
    //返点输入框输入过滤
    function filterPercent(num){
        num = num.replace(/^[^\d]/g,'');
        num = num.replace(/[^\d.]/g,'');
        num = num.replace(/\.{2,}/g,'.');
        num = num.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
        if( num.indexOf(".") != -1 ){
            var data = num.split('.');
            num = (data[0].substr(0,3))+'.'+(data[1].substr(0,1));
        }else{
            num = num.substr(0,3);
        }
        num = num > 100 ? 100 : num;
        return num;
    }
</script>
<form method="post" name="updateform" onsubmit="return checkform(this)">
<input type="hidden" name="currentlotteryid" value="0" id="currentlotteryid">
<div class="rc_con betting">
    <div class="rc_con_lt"></div>
    <div class="rc_con_rt"></div>
    <div class="rc_con_lb"></div>
    <div class="rc_con_rb"></div>
    <h5><div class="rc_con_title">修改用户</div></h5>
    <div class="rc_con_to">
        <div class="rc_con_ti">
            <div class="rc_m_til">用户基本信息</div>
            <div class="betting_input">
                <input type="hidden" name="addtype" id="addtype" value="ks" />
                <input type="hidden" name="uid" value="<?=$uid?>" />
                <input type="hidden" name="flag" value="insert" />
                <table class="user_infc" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="100" align="right" class="n1">账号：</td>
                        <td class="c_bl"><?=$row['username']?></td>
                        <td width="100" align="right" class="n1">昵称：</td>
                        <td class="c_bl"><?=$row['nickname']?></td>
                        <td width="100" align="right" class="n1">返点级别：</th>
                        <td class="c_bl"><?=$row['flevel']?></td>
                    </tr>
                </table>
            </div>
            <div class="clear"></div>
            <div class="rc_list">
                <div class="rl_list">
                    <div class="tab_userset">
                        <table width='100%' border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td id="tabbar-div-s2">
                                    <span class="tab-front"  id="general_tab_0">
                                        <span class="tabbar-left"></span>
                                        <span class="content">返点设置</span>
                                        <span class="tabbar-right"></span>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class='bd'>
                        <div class='bd2' id="general_txt_0">
                            <div class="user_ts">
                                <span class="user_ts_title">剩余开户额：<br></span>
                                <span class="c_bl">
                                    	<?php if($flevel>=7.8){?>
                                        [7.7]:<font color="#F00"> <?=$pe7?> </font>个&nbsp;&nbsp;&nbsp;
                                        <?php }?>
                                    	<?php if($flevel>=7.7){?>
                                        [7.6]:<font color="#F00"> <?=$pe6?> </font>个&nbsp;&nbsp;&nbsp;
                                        <?php }?>
                                    	<?php if($flevel>=7.6){?>
                                        [7.5]:<font color="#F00"> <?=$pe5?> </font>个&nbsp;&nbsp;&nbsp;
                                        <?php }?>
                                    	<?php if($flevel>=7.5){?>
                                        [7.4]:<font color="#F00"> <?=$pe4?> </font>个&nbsp;&nbsp;&nbsp;
                                        <?php }?>
                                    	<?php if($flevel>=7.4){?>
                                        [7.3]:<font color="#F00"> <?=$pe3?> </font>个&nbsp;&nbsp;&nbsp;
                                        <?php }?>
                                    	<?php if($flevel>=7.3){?>
                                        [7.2]:<font color="#F00"> <?=$pe2?> </font>个&nbsp;&nbsp;&nbsp;
                                        <?php }?>
                                    	<?php if($flevel>=7.2){?>
                                        [7.1]:<font color="#F00"> <?=$pe1?> </font>个&nbsp;&nbsp;&nbsp;
                                        <?php }?>
                                    	<?php if($flevel>=7.1){?>
                                        [7.0]:<font color="#F00"> <?=$pe0?> </font>个&nbsp;&nbsp;&nbsp;
                                        <?php }?>
										<br>
                                </span>
                                <b>备注:</b><font color="red">开通返点级别为<b>【7.0】</b>以下的用户不需要开户配额</font>
                            </div>
                                                        <div class="user_ts">
                                <span class="user_ts_title">您的返点级别：</span>
                                <font color="red"><b><?=$flevel?></b></font>
                                <span class="user_ts_title">用户返点: </span>
                                <input type="text" name="keeppoint" id="keeppoint" style='width:45px;' value="<?=$flevel1?>"/>
                                <input type="hidden" name="keepmin" id="keepmin" value="<?=$flevels?>" />
                                <input type="hidden" name="keepmax" id="keepmax" value="<?=$flevel2?>" /> % 
                                <span class='helpinfo'>( 可填范围: <?=$flevels?>～<?=$flevel2?> )</span>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input name='submit1' type="submit" value="修改用户" class="btn_next">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
</form> 
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
