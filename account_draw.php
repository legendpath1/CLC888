<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';
$_SESSION["mainframe"] = '"./account_draw.php"';

$sqla = "select * from ssc_bankcard WHERE  username='" . $_SESSION["username"] . "'";
$rsa = mysql_query($sqla);
$cardnums=mysql_num_rows($rsa);
if($cardnums==0){
	$_SESSION["backtitle"]="非常抱歉，你需要在平台绑定银行卡之后才能提现，如有任何疑问请联系在线客服。";
	$_SESSION["backurl"]="account_banks.php?check=114";
	$_SESSION["backzt"]="failed";
	$_SESSION["backname"]="我的银行卡";
	echo "<script language=javascript>window.location='sysmessage.php';</script>";
	exit;
}

$result=mysql_query("Select * from ssc_config"); 
$raa=mysql_fetch_array($result); 
$txmin = $raa[txmin];
$txmax = $raa[txmax];
$txtnums = $raa[txnums];
$txhours = $raa[txhours];
$timemin = $raa[timemin];
$timemax = $raa[timemax];

$sqla = "select * from ssc_member WHERE username='" . $_SESSION["username"] . "'";
$rsa = mysql_query($sqla);
$rowa = mysql_fetch_array($rsa);
$leftmoney=$rowa['leftmoney'];

if($rowa['virtual']==1){
	$_SESSION["backtitle"]="虚拟用户，禁止提现。";
	$_SESSION["backurl"]="help_security.php";
	$_SESSION["backzt"]="failed";
	$_SESSION["backname"]="系统公告";
	echo "<script language=javascript>window.location='sysmessage.php';</script>";
	exit;
}

$sql = "select * from ssc_drawlist WHERE username='" . $_SESSION["username"] . "' and DATE_FORMAT( adddate, '%Y-%m-%d' )='".date("Y-m-d")."'";
$rs = mysql_query($sql);
$txnums=mysql_num_rows($rs);

if($rowa['cwpwd']==""){
	$_SESSION["cwurl"]="account_draw.php";
	echo "<script language=javascript>window.location='account_setpwd.php';</script>";
	exit;
}
if($_GET['check']!="914"){
	if($_SESSION["cwflag"]!="ok"){
		$_SESSION["cwurl"]="account_draw.php";
		echo "<script language=javascript>window.location='account_check.php';</script>";
		exit;
	}
}
$_SESSION["cwflag"]="";


$flag=$_REQUEST['flag'];
if($flag=="confirm"){
	$ntime=date("Y-m-d H:i:s",strtotime("-".$txhours." hour"));
	$sqlb = "select * from ssc_bankcard WHERE id='".$_REQUEST['bankinfo']."'";
	$rsb = mysql_query($sqlb);
	$rowb = mysql_fetch_array($rsb);
	if($ntime<$rowb['adddate']){
		$_SESSION["backtitle"]="操作失败，新卡绑定".$txhours."小时后才能提现";
		$_SESSION["backurl"]="account_draw.php?check=914";
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="提现申请";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;	
	}

	if($txnums>=$txtnums){
		$_SESSION["backtitle"]="操作失败，您今天已提现了".$txnums."次";
		$_SESSION["backurl"]="account_draw.php?check=914";
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="提现申请";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}
	$sql = "select * from ssc_member where username='" . $_SESSION["username"] . "'";
	$rs = mysql_query($sql);
	$row = mysql_fetch_array($rs);
	$zt=$row['zt'];
	if($zt==1){//
		$_SESSION["backtitle"]="操作失败，您的帐户被冻结";
		$_SESSION["backurl"]="account_draw.php?check=914";
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="提现申请";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}
	if($zt==2){//
		$_SESSION["backtitle"]="操作失败，您的帐户被锁定";
		$_SESSION["backurl"]="account_draw.php?check=914";
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="提现申请";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}
	
	if($_POST['real_money']!="" && $_POST['bankinfo']!=""){
		if($leftmoney>=$_REQUEST['real_money']){
			$lmoney=$leftmoney-$_REQUEST['real_money'];

			$sqlc = "select * from ssc_drawlist order by id desc limit 1";		//帐变
			$rsc = mysql_query($sqlc);
			$rowc = mysql_fetch_array($rsc);
			$dan = sprintf("%07s",strtoupper(base_convert($rowc['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));
			
			$sql = "insert into ssc_drawlist set dan='".$dan."', money='".$_REQUEST['real_money']."', sxmoney='0', rmoney='".$_REQUEST['real_money']."', bank='".$rowb['bankname']."', realname='".$rowb['realname']."', cardno='".$rowb['cardno']."', branch='".$rowb['bankbranch']."', province='".Get_province($rowb['province'])."', city='".Get_city($rowb['city'])."', uid='".$_SESSION["uid"]."', username='".$_SESSION["username"]."', adddate='".date("Y-m-d H:i:s")."'";
	//		echo $sql;
			$exe = mysql_query($sql);
	
	
			$sqlc = "select * from ssc_record order by id desc limit 1";		//帐变zh扣款
			$rsc = mysql_query($sqlc);

			$rowc = mysql_fetch_array($rsc);
			$dan1 = sprintf("%07s",strtoupper(base_convert($rowc['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));
			$sqla="insert into ssc_record set dan='".$dan1."', uid='".$_SESSION["uid"]."', username='".$_SESSION["username"]."', types='2', zmoney=".$_REQUEST['real_money'].",leftmoney=".$lmoney.", regtop='".$rowa['regtop']."', regup='".$rowa['regup']."', regfrom='".$rowa['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
			$exe=mysql_query($sqla) or  die("数据库修改出错6!!!");
			
			$sqla="update ssc_member set leftmoney=".$lmoney." where username='".$_SESSION["username"]."'"; 
			$exe=mysql_query($sqla) or  die("数据库修改出错7!!!");
	
			$_SESSION["backtitle"]="操作成功";
			$_SESSION["backurl"]="account_drawlist.php?check=914";
			$_SESSION["backzt"]="successed";
			$_SESSION["backname"]="提现记录";
			echo "<script language=javascript>window.location='sysmessage.php';</script>";
			exit;
		}else{
			$_SESSION["backtitle"]="操作失败，余额不足";
			$_SESSION["backurl"]="account_draw.php?check=914";
			$_SESSION["backzt"]="failed";
			$_SESSION["backname"]="提现申请";
			echo "<script language=javascript>window.location='sysmessage.php';</script>";
			exit;		
		}
	}
	
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<head>
    <title>娱乐平台  - 提现申请</title>
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
        function checkForm(obj)
    {
                if (obj.real_money.value == ""){
            alert("请填写 '提现金额'");
            obj.real_money.focus();
            return false;
        }
        var mind = $("#min_money").html();
        var maxd = $("#max_money").html();
        mind = Number(mind);
        maxd = Number(maxd);
        if(obj.real_money.value < <?=$txmin?>)
        {
            alert("提现金额不能低于最低提现限额 ");
            $("#real_money").val(<?=$txmin?>);
            showPaymentFee(<?=$txmin?>);
            return false;
        }
        if(obj.real_money.value > <?=$rowa['leftmoney']?>)
        {
            alert("提现金额不能高于您的账户余额 ");
            $("#real_money").val(<?=$rowa['leftmoney']?>);
            showPaymentFee(<?=$rowa['leftmoney']?>);
            return false;
        }
		if(obj.real_money.value > <?=$txmax?>)
		{
			alert("提现金额不能高于最大提现限额 ");
			$("#real_money").val(<?=$txmax?>);
			showPaymentFee(<?=$txmax?>);
			return false;
		}
        if( obj.bankinfo.value == "" )
        {
            alert("请选择收款银行卡");
            return false;
        }
    }
    function showPaymentFee(i){
        document.drawform.real_money.value = formatFloat(""+i);
        document.drawform.money.value = FormatNumber( i ,2);
        jQuery("#chineseMoney").html( changeMoneyToChinese(document.drawform.money.value) );
    }

    /* format number 0.00 */
    function FormatNumber(srcStr, nAfterDot){
        var srcStr,nAfterDot;
        var resultStr,nTen;
        srcStr = ""+srcStr+"";
        strLen = srcStr.length;
        dotPos = srcStr.indexOf(".",0);
        if (dotPos == -1){
            resultStr = srcStr+".";
            for (i=0; i<nAfterDot; i++){
                resultStr = resultStr+"0";
            }
	   
        }
        else{
            if ((strLen - dotPos - 1) >= nAfterDot){
		   
                nAfter = dotPos + nAfterDot + 1;
                nTen =1;
                for(j=0;j<nAfterDot;j++){
                    nTen = nTen*10;
                }
                resultStr = Math.round(parseFloat(srcStr)*nTen)/nTen;
            }
            else{
                resultStr = srcStr;
	    
                for (i=0;i<(nAfterDot - strLen + dotPos + 1);i++){
                    resultStr = resultStr+"0";
                }
	    
            }
        }
        return resultStr;
    }
</script>
<div class="top_menu">
    <div class="tm_left"></div>
    <div class="tm_title"></div>
    <div class="tm_right"></div>
    <div class="tm_menu">
        <a href="/account_drawlist.php?check=914">提现记录</a>
        <a  class="act" href="/account_draw.php?check=914">平台提现</a>
        <a href="/account_savelist.php?check=914">充值记录</a>
        <a href="/account_autosavea.php?check=">在线充值</a>
        <a href="/ws_money_in.php">网站间转账</a>
    </div>
</div>
<div class="rc_con pay">
    <div class="rc_con_lt"></div>
    <div class="rc_con_rt"></div>
    <div class="rc_con_lb"></div>
    <div class="rc_con_rb"></div>
    <h5><div class="rc_con_title">提现申请</div></h5>
    <div class="rc_con_to">
        <div class="rc_con_ti">
            <table width="100%" class="ct" border="0" cellspacing="0" cellpadding="0">
                <form action="account_draws.php?check=914" method="post" name="drawform" id="drawform" onsubmit="return checkForm(this)">
                    <input type="hidden" name="flag" value="confirm" />
                    <input type="hidden" name="money" value="" />
                    <input type="hidden" name='transferfee' id='transferfee' value=''/>
                    <tr>
                        <td class="nl"><font color="#FF3300">提示信息：</font></td>
                        <td STYLE='line-height:20px;padding:5px 0px'>每天限提&nbsp;<font style="font-size:16px;color:#F30;font-weight:bold;"><?=$txtnums?></font>&nbsp;次，今天您已经成功发起了&nbsp;<font style="font-size:16px;color:#690;font-weight:bold;"><?=$txnums?></font>&nbsp;次提现申请。<br/>
                            每天的提现处理时间为：<font style="font-size:16px;color:#F30;font-weight:bold;"><?=$timemin?> 至  <?=$timemax?></font><br/>
                            <font color="#0066FF">新绑定的提款银行卡需要绑定时间超过&nbsp;<font style="font-size:16px;color:#F30;font-weight:bold;"><?=$txhours?></font>&nbsp;小时才能正常提款。</font><font color="#FF0000">（新）</font>
                        </td>
                    </tr>
                    <tr>
                        <td class="nl">可提现金额：</td>
                        <td><?=$rowa['leftmoney']?></td>
                    </tr>
                    <tr>
                        <td class="nl">收款银行卡信息：</td>
                        <td>
                            <select name="bankinfo" id="bankinfo">
                                <option value="">请选择银行卡...</option>
<?php 
$tcbank=Get_member(banks);
if($tcbank==""){
	$tcbank=0;
}

$sqlb = "select ssc_bankcard.* from ssc_bankcard left join ssc_banks on ssc_bankcard.bankid=ssc_banks.tid WHERE ssc_bankcard.username='" . $_SESSION["username"] . "' and ssc_banks.zt3='1' and ssc_banks.tc='".$tcbank."'";
$rsb = mysql_query($sqlb);
while ($rowb = mysql_fetch_array($rsb)){
?>
                                <option value="<?=$rowb['id']?>"><?=$rowb['bankname']?> | 银行卡尾号: <?=substr($rowb['cardno'],-4)?> </option>
<?php }?>
                            </select>&nbsp;&nbsp;<span style="color:red;"></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="nl">提现金额：</td>
                        <td><input type="text" name="real_money" id="real_money" onkeyup="showPaymentFee(this.value);" />&nbsp;&nbsp;<span style="color:red;"></span> ( 单笔提现限额：最低：&nbsp;<font style="color:#FF3300" id="min_money"><?=$txmin?></font>&nbsp;元，最高：&nbsp;<font style="color:#FF3300" id="max_money"><?=$txmax?></font>&nbsp;元 ) </td>
                    </tr>
                    <tr>
                        <td class="nl">提现金额(大写)：</td>
                        <td>&nbsp;<span id="chineseMoney"></span><input type="hidden" id="hiddenchinese" /></td>
                    </tr>
                    <tr>
                        <td class="nl"></td>
                        <td height="30"><br/><input value="下一步" name="submit" type="submit" width='69' height='26' class="btn_next" /></button><br/><br/></td>
                    </tr>
                </form>
            </table>
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