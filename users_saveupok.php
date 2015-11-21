<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';


$sql = "SELECT * FROM ssc_member WHERE id='" . $_REQUEST['uid'] . "'";
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs);
if(empty($row)){
	$_SESSION["backtitle"]="操作失败，无此用户";
	$_SESSION["backurl"]="users_list.php";
	$_SESSION["backzt"]="failed";
	$_SESSION["backname"]="用户列表";
	echo "<script language=javascript>window.location='sysmessage.php';</script>";
	exit;
}

if($row['virtual']==1 || Get_member(virtual)==1){
	$_SESSION["backtitle"]="虚拟用户，禁止充值。";
	$_SESSION["backurl"]="users_list.php";
	$_SESSION["backzt"]="failed";
	$_SESSION["backname"]="用户列表";
	echo "<script language=javascript>window.location='sysmessage.php';</script>";
	exit;
}


$sqla = "SELECT * FROM ssc_member WHERE username='" . $_SESSION["username"] . "'";
$rsa = mysql_query($sqla);
$rowa = mysql_fetch_array($rsa);


$cmoney=floatval($_POST['money']);
	if($cmoney==0){
		$_SESSION["backtitle"]="操作失败，请输入正确充值金额";
		$_SESSION["backurl"]="users_saveup.php?uid=".$_REQUEST['uid'];
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="用户充值";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}

$flag = trim($_POST['flag']);
if($flag=="confirm"){	
		
	if($rowa['czzt']!="1" || $rowa['zt']!="0"){
		$_SESSION["backtitle"]="操作失败，您无此权限";
		$_SESSION["backurl"]="users_list.php";
		$_SESSION["backzt"]="failed";				
		$_SESSION["backname"]="用户列表";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}
	
	if(md5(trim($_POST['spwd']))!=$rowa['cwpwd']){
		$_SESSION["backtitle"]="操作失败，资金密码错误";
		$_SESSION["backurl"]="users_list.php";
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="用户列表";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}
	
	if(floatval($rowa['czxg'])<$cmoney){
		$_SESSION["backtitle"]="操作失败，充值金额超过限额";
		$_SESSION["backurl"]="users_list.php";
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="用户列表";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}

	if(floatval($rowa['leftmoney'])<$cmoney){
		$_SESSION["backtitle"]="操作失败，您的余额不足";
		$_SESSION["backurl"]="users_saveup.php?uid=".$_REQUEST['uid'];
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="用户充值";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}


	$lmoney=$rowa['leftmoney']-$cmoney;
	
	$sqlc = "select * from ssc_record order by id desc limit 1";		//帐变
	$rsc = mysql_query($sqlc);
	$rowc = mysql_fetch_array($rsc);
	$dan1 = sprintf("%07s",strtoupper(base_convert($rowc['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));
	
	$sqlb="insert into ssc_record set dan='".$dan1."', uid='".$rowa['id']."', username='".$rowa['username']."', types='30', zmoney=".$cmoney.",leftmoney=".$lmoney.", regtop='".$rowa['regtop']."', regup='".$rowa['regup']."', regfrom='".$rowa['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
	$exe=mysql_query($sqlb) or  die("数据库修改出错6!!!");

	$sql="update ssc_member set leftmoney ='".$lmoney."',cztotal=cztotal+".$cmoney." where username ='".$_SESSION["username"]."'";
	if (!mysql_query($sql)){
		die('Error: ' );
	}

	if(floatval($rowa['cztotal'])>=1000 && floatval($rowa['czxg'])<1000){
		$sql="update ssc_member set czxg ='1000' where username ='".$_SESSION["username"]."'";
		if (!mysql_query($sql)){
			die('Error: ' );
		}
	}
	if(floatval($rowa['cztotal'])>=10000 && floatval($rowa['czxg'])<5000){
		$sql="update ssc_member set czxg ='5000' where username ='".$_SESSION["username"]."'";
		if (!mysql_query($sql)){
			die('Error: ' );
		}
	}	
	
	$lmoney=$row['leftmoney']+$cmoney;

	$sqlc = "select * from ssc_record order by id desc limit 1";		//帐变
	$rsc = mysql_query($sqlc);
	$rowc = mysql_fetch_array($rsc);
	$dan1 = sprintf("%07s",strtoupper(base_convert($rowc['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));

	$sqlb="insert into ssc_record set dan='".$dan1."', uid='".$row['id']."', username='".$row['username']."', types='31', smoney=".$cmoney.",leftmoney=".$lmoney.", regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
	$exe=mysql_query($sqlb) or  die("数据库修改出错6!!!");


//	$sqlb="insert into ssc_savelist set uid='".$row['id']."', username='".$row['username']."', bank='上级充值', bankid='0', cardno='', money=".$cmoney.", sxmoney='0', rmoney=".$cmoney.", adddate='".date("Y-m-d H:i:s")."',zt='1',types='2'";
//	$exe=mysql_query($sqlb) or  die("数据库修改出错6!!!");
	
	$sql="update ssc_member set leftmoney ='".$lmoney."',totalmoney=totalmoney+ '".$cmoney."' where id ='".$row['id']."'";
	if (!mysql_query($sql)){
		die('Error: ' );
	}
	

	
	$_SESSION["backtitle"]="充值成功";
	$_SESSION["backurl"]="users_list.php";
	$_SESSION["backzt"]="successed";
	$_SESSION["backname"]="用户列表";
	echo "<script language=javascript>window.location='sysmessage.php';</script>";
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<head>
    <title>娱乐平台  - 账户充值 (确认页)</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
        <link href="./css/v1/all.css?modidate=20130201001" rel="stylesheet" type="text/css" />
    <script>var pri_imgserver = '';</script>
        <script language="javascript" type="text/javascript" src="./js/jquery.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/common.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/lottery/min/message.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/keyboard/keyboard.js?modidate=20130415002"></script>
        <script language="javascript">
        function ResumeError() {return true;} window.onerror = ResumeError; 
        document.onselectstart = function(event){
            if(window.event) {
                event =    window.event;
            }
            try {
                var the = event.srcElement ;
                if( !( ( the.tagName== "INPUT" && the.type.toLowerCase() == "text" ) || the.tagName== "TEXTAREA" || the.tagName.toLowerCase()=="p" || the.tagName.toLowerCase()=="span") )
                {
                    return false;
                }
                return true ;
            } catch(e) {
                return false;
            }
        } 
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
</div><script> 
    $(function(){
        getKeyBoard($('#spwd'));
        var top = $("#spwd").offset().top+$("#spwd").height()-4;
        $(".spwd").css("top",top+"px");
        $("#copyright").css("margin-bottom","100px");
    });
</script>
<script type="text/javascript"> 
    jQuery("document").ready( function(){
        jQuery("#chineseMoney").html(changeMoneyToChinese(<?=$cmoney?>));
    });
</script>
<div class="rc_con system">
    <div class="rc_con_lt"></div>
    <div class="rc_con_rt"></div>
    <div class="rc_con_lb"></div>
    <div class="rc_con_rb"></div>
    <h5><div class="rc_con_title">账户充值 (确认页)</div></h5>
    <div class="rc_con_to">
        <div class="rc_con_ti">
            <table width="100%" class="ct" border="0" cellspacing="0" cellpadding="0">
                <form action="" method="post" onsubmit="this.submit.disabled=true;">
                    <input type="hidden" name="uid" value="<?=$_REQUEST['uid']?>" />
                    <input type="hidden" name="money" id="money" value="<?=$cmoney?>" />
                    <input type="hidden" name="flag" value="confirm" />
                    <tr>
                        <td class="nl" width="20%">目标账户: </td>
                        <td><?=$row['username']?></td>
                    </tr>
                    <tr>
                        <td class="nl">充值金额: </td>
                        <td><?=$cmoney?></td>
                    </tr>
                    <tr>
                        <td class="nl">充值金额(大写): </td>
                        <td><span id="chineseMoney"></span></td>
                    </tr>
                    <tr>
                        <td class="nl">资金密码: </td>
                        <td><input type="password" id="spwd" name="spwd" maxlength="20" style='width:160px;'/></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="submit" value="确认充值"  class="btn_next" /></td>
                    </tr>
                </form>
            </table>
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
