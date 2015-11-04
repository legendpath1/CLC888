<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

if(Get_member(virtual)==1){
	$_SESSION["backtitle"]="虚拟用户，禁止充值。";
	$_SESSION["backurl"]="help_security.php";
	$_SESSION["backzt"]="failed";
	$_SESSION["backname"]="系统公告";
	echo "<script language=javascript>window.location='sysmessage.php';</script>";
	exit;
}

$sqla = "select * from ssc_banks WHERE tid=7";
$rsa = mysql_query($sqla);
$rowa = mysql_fetch_array($rsa);
$loadmin = $rowa["cmin"];
$loadmax = $rowa["cmax"];

$tcbank=Get_member(banks);
if($tcbank==""){
	$tcbank=0;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>娱乐平台 - 在线充值</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Pragma" content="no-cache" />
<link href="./css/v1/all.css?modidate=20150902016" rel="stylesheet"
	type="text/css" />
<link
	href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css"
	rel="stylesheet" />
<script>var pri_imgserver = '';</script>
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script language="javascript" type="text/javascript"
	src="./js/jquery.js?modidate=20130415002"></script>
<script language="javascript" type="text/javascript"
	src="./js/common.js?modidate=20130415002"></script>
<script language="javascript" f type="text/javascript"
	src="./js/lottery/min/message.js?modidate=20130415002"></script>
<script language='JavaScript'>function ResumeError() {return true;} window.onerror = ResumeError; </script>
</head>
<body>
<div id="rightcon">
<div id="msgbox" class="win_bot" style="display: none;">
<h5 id="msgtitle"></h5>
<div class="wb_close" onclick="javascript:msgclose();"></div>
<div class="clear"></div>
<div class="wb_con">
<p id="msgcontent"></p>
</div>
<div class="clear"></div>
<a class="wb_p" href="#" onclick="javascript:prenotice();" id="msgpre">上一条</a><a
	class="wb_n" href="#" onclick="javascript:nextnotice();">下一条</a></div>
<script type="text/javascript">
    function checkForm(obj)
    {
        s = obj.bankinfo.length;
        ischecked = false;
        for( i=0; i<s; i++ ){
            if( obj.bankinfo[i].checked == true ){
                ischecked = true;
            }
        }
        if( ischecked == false ){
            alert("请选择充值银行");
            return false;
        }
        var loadmin = $("#loadmin").html();
        var loadmax = $("#loadmax").html();
        loadmin = Number(loadmin);
        loadmax = Number(loadmax);
        if(obj.real_money.value < loadmin)
        {
            alert("充值金额不能低于最低充值限额 ");
            $("#real_money").val(loadmin);
            showPaymentFee();
            return false;
        }
        if(obj.real_money.value > loadmax)
        {
            alert("充值金额不能高于最高充值限额 ");
            $("#real_money").val(loadmax);
            showPaymentFee();
            return false;
        }
	
    }
    function showPaymentFee(){
        document.saveform.real_money.value = document.saveform.real_money.value.replace(/\D+/g,'');
        jQuery("#chineseMoney").html( changeMoneyToChinese(document.saveform.real_money.value) );
    }
    function changbank(obj){
        var id = $(obj).attr("id");
        var $banklist={
<?php

$sqla = "select * from ssc_banks WHERE zt='1' and tc='".$tcbank."' order by id asc";
$rsa = mysql_query($sqla);
$total = mysql_num_rows($rsa);
$i=0;
while ($rowa = mysql_fetch_array($rsa)){
?>"bank_<?=$rowa['tid']?>":{"minload":"<?=$rowa['cmin']?>","maxload":"<?=$rowa['cmax']?>"}
<?php 
		if($i!=$total-1){echo ",";}
		$i=$i+1;
}?>};
        $("#loadmin").html($banklist[id]['minload']);
        $("#loadmax").html($banklist[id]['maxload']);
        id = parseInt(id.replace("bank_",""),10);
        if( id == 3 ){
<?php 
if($cardnums=="0"){
?>
		alert("请先绑定您的建行银行卡");
		self.location = "account_banks.php";
		return false;
<?php }?>
        }
        $("tr[id^=msg_]").hide();
        $("#msg_bank_"+id).show();
    }
</script>
<div class="top_menu">
<div class="tm_left"></div>
<div class="tm_title"></div>
<div class="tm_right"></div>
<div class="tm_menu">
<a href="/account_drawlist.php?check=914">提现记录</a>
<a href="/account_draw.php?check=914">平台提现</a> <a
	href="/account_savelist.php?check=914">充值记录</a> <a class="act"
	href="/account_autosavea.php?check=">在线充值</a>
	<a href="/ws_money_in.php">网站间转账</a></div>
</div>
<div class="rc_con pay">
<div class="rc_con_lt"></div>
<div class="rc_con_rt"></div>
<div class="rc_con_lb"></div>
<div class="rc_con_rb"></div>
<h5>
<div class="rc_con_title">在线充值</div>
</h5>
<div class="rc_con_to">
<div class="rc_con_ti">

<form method="post" action="./account_autopay.php" name="saveform"
	id="saveform" onsubmit="return checkForm(this)">
<table width="100%" class="ct" border="0" cellspacing="0"
	cellpadding="0">
	<tr>
		<td class="nl"><font color="#FF3300">自动充值使用需知:</font></td>
		<td style='line-height: 23px; padding: 5px 0px'>每天的充值处理时间为：<font
			style="font-size: 16px; color: #F30; font-weight: bold;">早上 8:30 至
		次日凌晨1:55</font><br />
		请在下方选择充值银行, 填写充值金额, 点击 <font color=#0000FF>[下一步]</font> 后，根据你的银行卡选择对应的网银进行充值<br />
		充值后, <font color='#ff0000'>请手动刷新您的余额</font>及查看相关帐变信息,若超过1分钟未上分,请与客服联系
		</td>
	</tr>
	<tr>
		<td class="nl">充值银行:</td>
		<td style='height: 60px;'><?php
		$dd=date("H:i:s");
		$sqla = "select * from ssc_banks WHERE zt='1' and tc='".$tcbank."' and ((cztimemin<cztimemax and cztimemin<'".$dd."' and cztimemax>'".$dd."') or (cztimemin>cztimemax and (cztimemin<'".$dd."' or cztimemax>'".$dd."'))) order by id asc";
		$rsa = mysql_query($sqla);
		while ($rowa = mysql_fetch_array($rsa)){?> 
			<input type="radio" id='bank_<?=$rowa['tid']?>' name="bankinfo"
			value="<?=$rowa['tid']?>" onclick="changbank(this)" />&nbsp;
			<label for='bank_<?=$rowa['tid']?>'>
			     <img style='cursor: pointer;'
			     src="images/banks/<?=$rowa['tid']?>.jpg" />
			</label>&nbsp;&nbsp;&nbsp;
		<?php }?> &nbsp;&nbsp;
			<span style="color: red; display: none"><input
			type="radio" name="bankinfo" value="" /></span></td>
	</tr>
	<tr>
		<td class="nl">充值金额:</td>
		<td style='height: 66px;'><input type="text" name="real_money"
			id="real_money" maxlength="10" onkeyup="showPaymentFee();" />
		&nbsp;&nbsp;<span style="color: red;"></span> ( 单笔充值限额：最低：&nbsp;<font
			style="color: #FF3300" id="loadmin"><?php echo $loadmin?>&nbsp;</font>&nbsp;元，最高：&nbsp;<font
			style="color: #FF3300" id="loadmax"><?php echo $loadmax?>&nbsp;</font>&nbsp;元
		)</td>
	</tr>
	<tr>
		<td class="nl">充值金额(大写):</td>
		<td style='height: 60px;'>&nbsp;<span id="chineseMoney"></span><input
			type="hidden" id="hiddenchinese" /></td>
	</tr>
	<tr>
		<td class="nl"></td>
		<td height="30"><br />
		<input name="submit" type="submit" value="下一步" width='69' height='26'
			class="btn_next" /> &nbsp;&nbsp;&nbsp;&nbsp;<br />
		<br />
		</td>
	</tr>
</table>
</form>
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
	<tr>
		<td height="25" align="center">浏览器建议：首选IE
		8.0,Chrome浏览器，其次为火狐浏览器,尽量不要使用IE6。</td>
	</tr>
	<tr>
		<td height="25" align="center">资金安全建议：为了您的资金安全请定期更换资金密码。</td>
	</tr>
</table>
</div>
</div>

</div>

</body>
</html>
