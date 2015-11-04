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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<head>
    <title>娱乐平台  - 自动充值</title>
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
        document.drawform.real_money.value = document.drawform.real_money.value.replace(/\D+/g,'');
        jQuery("#chineseMoney").html( changeMoneyToChinese(document.drawform.real_money.value) );
    }
    function changbank(obj){
    }
</script>
<div class="top_menu">
    <div class="tm_left"></div>
    <div class="tm_title"></div>
    <div class="tm_right"></div>
    <div class="tm_menu">
        <a href="/account_drawlist.php?check=">提现记录</a>
        <a href="/account_draw.php?check=">平台提现</a>
        <a class="act" href="/account_autosavea.php?check=">在线充值</a>
        <a href="/account_autosave.php?check=">自动充值</a>
    </div>
</div>
<div class="rc_con pay">
    <div class="rc_con_lt"></div>
    <div class="rc_con_rt"></div>
    <div class="rc_con_lb"></div>
    <div class="rc_con_rb"></div>
    <h5><div class="rc_con_title">在线充值</div></h5>
    <div class="rc_con_to">
        <div class="rc_con_ti">
            <table width="100%" class="ct" border="0" cellspacing="0" cellpadding="0">
                <form action="http://www.ruyi901.com/mobao/mobaopay.php" target="_blank " method="post" name="drawform" id="drawform" onsubmit="return checkForm(this)">
                    <input type="hidden" name="flag" value="confirm" />
					<input type="hidden" name="uid" value="t1000<?=$_SESSION["uid"]?>" />
                    <tr>
                        <td class="nl"><font color="#FF3300">在线充值使用需知:</font></td>
                        <td STYLE='line-height:23px;padding:5px 0px'>
                            每天的充值处理时间为：<font style="font-size:16px;color:#F30;font-weight:bold;">早上 8:40 至 次日凌晨2:00</font><br/>
                            充值后, <font color='#ff0000'>请手动刷新您的余额</font>及查看相关帐变信息,若超过1分钟未上分,请与客服联系<br/>
                            选择充值银行, 填写充值金额, 点击 <font color=#0000FF>[下一步]</font> 后, 将有详细文字说明及<font color=red>充值演示</font>
                        </td>
                    </tr>
                    <tr>
                        <td class="nl">充值银行: </td>
                        <td style='height:60px;'>
						<select name="banks" style="width:120px;">
							<option value="ICBC">工商银行</option>
							<option value="CMB">招商银行</option>
							<option value="ABC">中国农业银行</option>
							<option value="CCB">建设银行</option>
							<option value="COMM">交通银行</option>
							<option value="CIB">兴业银行</option>
							<option value="CMBC">中国民生银行</option>
							<option value="CEB">光大银行</option>
							<option value="BOC">中国银行</option>
							<option value="CNCB">中信银行</option>
							<option value="GDB">广发银行</option>
							<option value="SPDB">上海浦东发展银行</option>
							<option value="PSBC">中国邮政</option>
							<option value="HXB">华夏银行</option>
							<option value="PAB">平安银行</option>
						</select>&nbsp;&nbsp;<span style="color:red; display:none"><input type="radio" name="bankinfo" value="" /></span>

                        </td>
                    </tr>
                    <tr>
                        <td class="nl">充值金额: </td>
                        <td style='height:66px;'><input type="text" name="real_money" id="real_money" maxlength="10" onkeyup="showPaymentFee();" />
                            &nbsp;&nbsp;<span style="color:red;"></span> ( 单笔充值限额：最低：&nbsp;<font style="color:#FF3300" id="loadmin">10</font>&nbsp;元，最高：&nbsp;<font style="color:#FF3300" id="loadmax">50000</font>&nbsp;元 ) </td>
                    </tr>
                    <tr>
                        <td class="nl">充值金额(大写): </td>
                        <td style='height:60px;'>&nbsp;<span id="chineseMoney"></span><input type="hidden" id="hiddenchinese" /></td>
                    </tr>
                    <tr>
                        <td class="nl"></td>
                        <td height="30"><br/><input name="submit" type="submit" value="下一步" width='69' height='26' class="btn_next" />
                            &nbsp;&nbsp;&nbsp;&nbsp;<br/><br/></td>
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