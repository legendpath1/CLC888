<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$tcbank=Get_member(banks);
if($tcbank==""){
	$tcbank=0;
}

if(Get_member(virtual)==1){
	$_SESSION["backtitle"]="虚拟用户，禁止充值。";
	$_SESSION["backurl"]="help_security.php";
	$_SESSION["backzt"]="failed";
	$_SESSION["backname"]="系统公告";
	echo "<script language=javascript>window.location='sysmessage.php';</script>";
	exit;
}

$bid=$_POST["bankinfo"];
$sqla = "SELECT * FROM ssc_banks WHERE tid='" . $bid . "' and tc='".$tcbank."'";
$rsa = mysql_query($sqla);
$rowa = mysql_fetch_array($rsa);

$cmoney=round($_POST['real_money'],2);
if ($cmoney<1) {

}
if ($cmoney>=$rowa['climit']){
	$sxmoney=$cmoney*$rowa['crates']/100;
	$rmoney=$cmoney+$sxmoney;
}else{
	$sxmoney=0;
	$rmoney=$cmoney;
}

$sqla="insert into ssc_savepending set uid='".$_SESSION["uid"]."', username='".$_SESSION["username"]."', bank='".$rowa['name']."', bankid='".$rowa['tid']."',  cardno='', money=".$cmoney.", sxmoney=".$sxmoney.", rmoney=".$rmoney.", adddate='".date("Y-m-d H:i:s")."',zt='0',types='1'";
$exe=mysql_query($sqla) or  die("数据库修改出错6!!!");

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
</div><div class="top_menu">
    <div class="tm_left"></div>
    <div class="tm_title"></div>
    <div class="tm_right"></div>
    <div class="tm_menu">
<a href="/account_drawlist.php?check=914">提现记录</a>
<a href="/account_draw.php?check=914">平台提现</a> <a
	href="/account_savelist.php?check=914">充值记录</a> <a class="act"
	href="/account_autosavea.php?check=914">在线充值</a>
	<a href="/ws_money_in.php">网站间转账</a></div>
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
            <div id="demobox"><img src="./images/help/zdcz<?=$rowa['tid']?>.png" style="border:2px solid #333333;" /></div>
          
		  
		  
	
<?php if($bid==11){?><table width="766" border="0" cellpadding="0" cellspacing="0" class="ct">
  <form action="/dinpay/req.php" method="post" name="form1" target="_blank" id="form1">
  <input name="username" type="hidden" value="<? echo $_SESSION['username'];?>" />
  <input name="price" type="hidden" value="<? echo $_POST['real_money'];?>" />
  <tr>
	<td width="126" class="nl"><div align="right">充值银行：</div></td>
	<td width="540"> <table  border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
              <tbody>
                <tr>
                  <td height="35" bgcolor="#ffffff"><input type="radio" name="issuerId" value="ICBC" class="banking" id="bank_icbc" 
                                            checked="checked">
                      <img src="/dinpay/bank/bank_icbc.gif" alt="icbc" width="107" height="20" /> </td>
                  <td height="35" bgcolor="#ffffff"><input type="radio" name="issuerId" value="ABC" class="banking" id="bank_abc">
                      <img src="/dinpay/bank/bank_abc.gif" alt="abc" width="107" height="20" /> </td>
                  <td bgcolor="#ffffff"><input type="radio" name="issuerId" value="CCB" class="banking" id="bank_ccb" />
                    <img src="/dinpay/bank/bank_ccb.gif" alt="ccb" width="107" height="20" /></td>
                  <td height="35" bgcolor="#ffffff"><input type="radio" name="issuerId" value="BOC" class="banking" id="bank_boc">
                      <img src="/dinpay/bank/bank_boc.gif" alt="boc" width="107" height="20" /> </td>
                </tr>
                <tr>
                  <td height="35" bgcolor="#ffffff"><input type="radio" name="issuerId" value="BCOM" class="banking" id="bank_comm">
                      <img src="/dinpay/bank/bank_comm.gif" alt="comm" width="107" height="20" /> </td>
                  <td height="35" bgcolor="#ffffff"><input type="radio" name="issuerId" value="CMB" class="banking" id="bank_cmb">
                      <img src="/dinpay/bank/bank_cmb.gif" alt="cmb" width="107" height="20" /> </td>
                  <td height="35"><input type="radio" name="issuerId" value="CMBC" class="banking" id="bank_cmbc" />
                      <img src="/dinpay/bank/bank_cmbc.gif" alt="cmbc" width="107" height="20" /></td>
                  <td height="35" bgcolor="#ffffff"><input type="radio" name="issuerId" value="SPDB" class="banking" id="bank_spdb">
                      <img src="/dinpay/bank/bank_spdb.gif" alt="spdb" width="107" height="20" /> </td>
                </tr>
                <tr>
                  <td height="35" bgcolor="#ffffff"><input type="radio" name="issuerId" value="CIB" class="banking" id="bank_cib">
                      <img src="/dinpay/bank/bank_cib.gif" alt="cib" width="107" height="20" /> </td>
                  <td height="35" bgcolor="#ffffff"><input type="radio" name="issuerId" value="CEB" class="banking" id="bank_ceb">
                      <img src="/dinpay/bank/bank_ceb.gif" alt="ceb" width="107" height="20" /> </td>
                  <td height="35"><input type="radio" name="issuerId" value="PSBC" class="banking" id="radio2" />
                      <img src="/dinpay/bank/bank_psbc.gif" alt="psbc" width="107" height="20" /></td>
                  <td height="35" bgcolor="#ffffff"><input type="radio" name="issuerId" value="GDB" class="banking" id="bank_cgb" />
                      <img src="/dinpay/bank/bank_cgb.gif" alt="cgb" width="107" height="20" /> </td>
                </tr>
                <tr>
                  <td height="35" bgcolor="#ffffff"><input type="radio" name="issuerId" value="ECITIC" class="banking" id="bank_citic" />
                      <img src="/dinpay/bank/bank_citic.gif" alt="citic" width="107" height="20" /> </td>
                  <td height="35" bgcolor="#ffffff"><input type="radio" name="issuerId" value="SHB" class="banking" id="bank_psbc" />
                      <img src="/dinpay/bank/bank_bos.gif" alt="psbc" width="107" height="20" /></td>
                  <td bgcolor="#ffffff"><input type="radio" name="issuerId" value="BJRCB" class="banking" id="radio4" />
                    <img src="/dinpay/bank/BJRCB_OUT.gif" alt="psbc" width="100" height="20" /></td>
                  <td height="35" bgcolor="#ffffff"><input type="radio" name="issuerId" value="SPABANK" class="banking" id="radio" />
                      <img src="/dinpay/bank/bank_pingan.gif" alt="psbc" width="107" height="20" /></td>
                </tr>
                <tr>
                  <td height="35" bgcolor="#ffffff"><input type="radio" name="issuerId" value="BOB" class="banking" id="bank_citic" />
                      <img src="/dinpay/bank/beijing.gif" alt="citic" width="107" height="21" /> </td>
                  <td height="35" bgcolor="#ffffff"><input type="radio" name="issuerId" value="NJCB" class="banking" id="bank_psbc" />
                      <img src="/dinpay/bank/nanjing.gif" alt="psbc" width="95" height="24" /></td>
                  <td bgcolor="#ffffff"><input type="radio" name="issuerId" value="NBCB" class="banking" id="radio5" />
                    <img src="/dinpay/bank/NBBANK_OUT.gif" alt="citic" width="100" height="20" /> </td>
                  <td height="35" bgcolor="#ffffff"><input type="radio" name="issuerId" value="CBHB" class="banking" id="radio" />
                      <img src="/dinpay/bank/bank_bh.gif" alt="psbc" width="107" height="20" /></td>
                </tr>
                <tr>
                  <td height="35" bgcolor="#ffffff"><input type="radio" name="issuerId" value="SPABANK" class="banking" id="bank_hxb" />
                      <img src="/dinpay/bank/bank_sdb.gif" alt="hxb" width="121" height="21" /></td>
                  <td height="35"><input type="radio" name="issuerId" value="BEA" class="banking" id="radio3" />
                      <img src="/dinpay/bank/bank_dy.gif" alt="psbc" width="107" height="20" /></td>
                  <td bgcolor="#ffffff">&nbsp;</td>
                  <td height="35" bgcolor="#ffffff">&nbsp;</td>
                </tr>
              </tbody>
            </table> </td>
</tr>
 
<tr>
	<td height="1" class="nl"><div align="right">充值金额：</div></td>
    <td height="1" style="color:#333333;"><? echo $_POST['real_money'];?>元    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="image" src="/dinpay/bank/buy1.gif" name="a"   value="马上提交充值"  style="width:100px;height:30px" /></td>
</tr>
 
  </form>
</table>





<? } else { ?>   	  
		  
		  
		    <table class="ct" border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td class="nl">充值银行：</td>
                                            <td><a href="<?=$rowa['url']?>" target="_blank"><img src="./images/banks/<?=$rowa['tid']?>.jpg" border="0" /></a>&nbsp;&nbsp;&nbsp;<a href="<?=$rowa['url']?>" style="color:#009900; font-size:14px; font-weight:bold;" target="_blank">←点此进入网上银行</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;页面有效期倒计时：<span id="expire_time" style="color:#006699; font-size:14px; font-weight:bold;">00:00</span></td>
                </tr>
<?php if($bid==19){?>
                <tr>
                    <td class="nl">财付通付款方式：</td>
                    <td>向亲朋好友付款</td>
                </tr>
<?php }?>
<?php if($bid==2){?>
                <tr>
                    <td class="nl">支行名称：</td>
                    <td><span id="copy_branch_txt" style="padding-right:10px;"><?=$rowa['branch']?></span> <a href='#' TITLE='复制' onClick="javascript:copyToClipboard( 'copy_branch_txt','【支行名称】' )" ><img src="./images/comm/copy.gif" border="0" />复制</a></td>
                </tr>
<?php }?>
<?php if($bid==8){?>
                <tr>
                    <td class="nl">开户省份：</td>
                    <td><span id="copy_province_txt" style="padding-right:10px;"><?=$rowa['province']?></span> <a href='#' TITLE='复制' onClick="javascript:copyToClipboard( 'copy_province_txt','【收款省份】' )" ><img src="./images/comm/copy.gif" border="0" />复制</a></td>
                </tr>
                <tr>
                	<td class="nl">开户支行：</td>
                    <td><span id="copy_branch_txt" style="padding-right:10px;"><?=$rowa['branch']?></span> <a href='#' TITLE='复制' onClick="javascript:copyToClipboard( 'copy_branch_txt','【收款支行】' )" ><img src="./images/comm/copy.gif" border="0" />复制</a></td>
                </tr>
<?php }?>
                <tr>
                    <td class="nl">收款账户名：</td>
                    <td><span id="copy_name_txt" style="padding-right:10px;"><?=$rowa['uname']?></span> <a href='#' TITLE='复制' onClick="javascript:copyToClipboard( 'copy_name_txt','【收款账户名】' )" ><img src="./images/comm/copy.gif" border="0" />复制</a></td>
                </tr>
                <tr>
                    <td class="nl">收款账号：</td>
                    <td><span id="copy_account_txt" style="padding-right:10px;"><?=$rowa['account']?></span> <a href='#' TITLE='复制' onClick="javascript:copyToClipboard( 'copy_account_txt','【收款账号】' )" ><img src="./images/comm/copy.gif" border="0" />复制</a></td>
                </tr>
                <tr>
                    <td class="nl">充值金额：</td>
                    <td><span id="copy_monye_txt" style="padding-right:10px;"><?=number_format($_POST['real_money'],2)?></span> <a href='#' TITLE='复制' onClick="javascript:copyToClipboard( 'copy_monye_txt','【充值金额】' )" ><img src="./images/comm/copy.gif" border="0" />复制</a></td>
                </tr>
<?php if($bid==1){?>
                <tr>
                    <td class="nl">温馨提示：</td>
                    <td style="color:#080;">在工商银行的网银界面中，使用“E-mail 汇款”功能。</td>
                </tr>
<?php }?>
<?php if($bid==3){?>
<tr>
	<td class="nl">您的汇款银行卡：</td>
    <td style="line-height:23px;color:#FF0000;">请使用您在平台绑定的<font color="#006699">【尾号为<?=substr($rowc['cardno'],-4)?>】</font>的建行卡进行汇款，否则不能到账！<br/>
	注意: 建行每天会在 <b style='color:#069'>22:30-00:00</b> 维护,请避开维护时段！</td>
</tr>
<?php }?>
<?php if($bid==1 || $bid==2 || $bid==4 || $bid==8 || $bid==19 || $bid==20){?>
                <tr>
                    <td class="nl">附言(充值编号)：</td>
                    <td style="color:#FF0000;"><span id="copy_msg_txt" style="padding-right:10px; font-family:fixedsys;"><?=$_SESSION["uid"]?></span> <a href='#' TITLE='复制' onClick="javascript:copyToClipboard( 'copy_msg_txt','【附言(充值编号)】' )" ><img src="./images/comm/copy.gif" border="0" />复制</a>&nbsp;&nbsp;&nbsp;&nbsp;<font color="#FF0000">←务必将此充值编号正确填写到汇款附言里</font></td>
                </tr>
<?php }?>
                <tr>
                    <td class="nl" style="color:#FF0000;width:20%;">充值说明：</td>
                    <td style="line-height:25px; padding:5px 0; color:#333333;">
<?php if($bid==8){?>
                        1、请务必复制“</font><font style="font-size:12px;color:blue;font-weight:bold;">充值编号</font>”准确填写到“</font><font style="font-size:12px;color:blue;font-weight:bold;">工行</font>”汇款页面“</font><font style="font-size:12px;color:blue;font-weight:bold;">附言</font>”栏、“</font><font style="font-size:12px;color:blue;font-weight:bold;">招行</font>”汇款页面的“</font><font style="font-size:12px;color:blue;font-weight:bold;">备注</font>”栏、“</font><font style="font-size:12px;color:blue;font-weight:bold;">建行</font>”汇款页面的“</font><font style="font-size:12px;color:blue;font-weight:bold;">附言</font>”栏、“</font><font style="font-size:12px;color:blue;font-weight:bold;">农行</font>”汇款页面的“</font><font style="font-size:12px;color:blue;font-weight:bold;">转账用途</font>”栏、“</font><font style="font-size:12px;color:blue;font-weight:bold;">交行</font>”汇款页面的“</font><font style="font-size:12px;color:blue;font-weight:bold;">汇款附言</font>”栏中，否则充值将无法到账。<br />
                        2、充值金额低于 <font style="font-size:12px;color:#F30;font-weight:bold;">100</font> 不享受“</font><font style="font-size:12px;color:blue;font-weight:bold;">充值即返手续费</font>”的优惠政策。<br />
                        3、工行跨行转民生银行：务必选择“</font><font style="font-size:12px;color:blue;font-weight:bold;">转账汇款</font>”中的“</font><font style="font-size:12px;color:blue;font-weight:bold;">跨行快汇</font>”。<br />
                        4、招行跨行转民生银行：务必选择“</font><font style="font-size:12px;color:blue;font-weight:bold;">转账汇款</font>”中的“</font><font style="font-size:12px;color:blue;font-weight:bold;">跨行异地汇款</font>”。<br />
                        5、建行跨行转民生银行：务必选择“</font><font style="font-size:12px;color:blue;font-weight:bold;">转账汇款</font>”中的“</font><font style="font-size:12px;color:blue;font-weight:bold;">跨行转账</font>”，选择汇款方式为“</font><font style="font-size:12px;color:blue;font-weight:bold;">建行转他行（加急）</font>”。<br />
                        6、农行跨行转民生银行：务必选择“</font><font style="font-size:12px;color:blue;font-weight:bold;">转账汇款</font>”中的“</font><font style="font-size:12px;color:blue;font-weight:bold;">单笔转账</font>”，在“</font><font style="font-size:12px;color:blue;font-weight:bold;">增加收款方</font>”中选择“</font><font style="font-size:12px;color:blue;font-weight:bold;">账户开户行行别</font>”为“</font><font style="font-size:12px;color:blue;font-weight:bold;">民生银行</font>”。<br />
                        7、交行跨行转民生银行：务必选择“</font><font style="font-size:12px;color:blue;font-weight:bold;">转账</font>”->“</font><font style="font-size:12px;color:blue;font-weight:bold;">汇款</font>”->“</font><font style="font-size:12px;color:blue;font-weight:bold;">汇款方式</font>”中的“</font><font style="font-size:12px;color:blue;font-weight:bold;">快速汇款</font>”。<br />
                        8、充值编号为随机生成，一个充值编号</font><font style="font-size:12px;color:red;font-weight:bold;">只能充值一次，过期或重复使用</font>充值将无法到账。<br />
                        9、“</font><font style="font-size:12px;color:blue;font-weight:bold;">收款账户名</font>”和“</font><font style="font-size:12px;color:blue;font-weight:bold;">收款账号</font>”会不定期更换，请在获取最新信息后充值，否则充值将无法到账。<br />
                        10、此汇款方式接受：工行跨行转民生、招行跨行转民生、建行跨行转民生、农行跨行转民生，交行跨行转民生，</font><font style="font-size:12px;color:blue;font-weight:bold;">其他跨行汇款</font>一律在48小时内退回。<br />
<?php
}else{
 if($bid==3){?>
    					1、务必使用您在平台绑定的建设银行卡进行充值，否则充值将无法到账。<br />
<?php }else{?>
                        1、<font style="font-size:12px;color:red;">务必复制“充值编号”到汇款页面的“附言”栏中进行粘贴(键盘[CTRL+V])，否则充值将无法到账。</font><br />
<?php }?> 
                        2、充值金额低于<font style="font-size:12px;color:#F30;font-weight:bold;"><?=$rowa['climit']?></font>&nbsp;不享受“充值即返手续费”的优惠政策<br />
                        3、充值编号为随机生成，一个充值编号只能充值一次，<font style="font-size:12px;color:red;">过期或重复使用</font>充值将无法到账。<br />
                        4、收款账户名和收款帐号会不定期更换，<font style="font-size:12px;color:red;">请在获取最新信息后充值</font>，否则充值将无法到账。<br />
                        5、“充值金额”与网银转账金额不符，充值将无法准确到账。<br />
<?php if($bid==1){?>
                        6、登陆工行网银，点击“转账汇款”后选择“E-mail汇款”。<br />
                        7、<font style="font-size:12px;color:red;">只支持同行转账，使用跨行转账充值将无法到账。</font>
<?php }}?> 
                </tr>
                <tr>
                    <td class="nl">&nbsp;</td>
                    <td>
                        <input type="button" name="showdemo" id="showdemo" value="充值演示" class="button" />&nbsp;&nbsp;&nbsp;
                                                <div class="pay_info"></div>
                    </td>
                </tr>
            </table>
			
			
	<? }?>			
			
			
			
            <div class="clear"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){
        TimeCountDown('expire_time',600,function(){window.location.href="./help_security.php";;});
<?php if($bid==3333){?>setTimeout(function(){alert('<?php if($bid==3){?>请使用您在平台绑定的【尾号为<?=substr($rowc['cardno'],-4)?>】的建行卡进行汇款\n否则充值无法到账！\n\n注意: 建行每天会在 22:30-00:00 维护,请避开维护时段！<?php }else{?>务必将“充值编号”正确填写到银行汇款页面的汇款附言栏中(复制→ 粘帖[CTRL+V])，否则充值将无法到账。<?php }?>');},1000);
<?php 


}?>
                var demoleft = $("#showdemo").offset();
        demoleft = demoleft.left +120;
        $("#demobox").css({"left":demoleft+"px"});
        $("#showdemo").click(function(){
            if($(this).val()=='充值演示'){
                $("#demobox").show();
                $(this).val("关闭演示");
            }else{
                $("#demobox").hide();
                $(this).val("充值演示");
            }
        });
    });
</script>
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