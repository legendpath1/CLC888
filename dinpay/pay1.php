<?
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
session_start();
header("Content-type: text/html; charset=utf-8");
include_once("../include/config.php");
include_once("../include/mysqli.php");

$username=$_POST['username'];
$uid=intval($_POST['uid']);
$sql="select uid,username,mobile,money from k_user where username='$username' and uid='$uid'";
$query	=	$mysqli->query($sql);
$cou	=	$query->num_rows;
if($cou<=0){
	echo "<script>alert(\"请登录后再进行存款和提款操作\");location.href='http://".$conf_www."/zhuce.php';</script>";
	exit();
}
$rows	=	$query->fetch_array();


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title>History</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../css/css_1.css" rel="stylesheet" type="text/css" />
	<style type="text/css">
	.dv{ line-height:25px;}
	.body2{
		width: 737px;
		height: auto;
		padding: 10px 0 0 12px;
		margin-left:10px;
		margin-right:10px;
		float:left;
		font-size:12px;
	}
	.tds {
		line-height:25px;
	}
	.STYLE1 {font-weight: bold}
    .STYLE2 {color: #0000FF}
	.STYLE12{ color:#F00}
    </style>
<script language="JAVAScript">
		var $ = function(Id){
            return document.getElementById(Id);
        }
    
       
        //数字验证 过滤非法字符
        function clearNoNum(obj){
	        //先把非数字的都替换掉，除了数字和.
	        obj.value = obj.value.replace(/[^\d.]/g,"");
	        //必须保证第一个为数字而不是.
	        obj.value = obj.value.replace(/^\./g,"");
	        //保证只有出现一个.而没有多个.
	        obj.value = obj.value.replace(/\.{2,}/g,".");
	        //保证.只出现一次，而不能出现两次以上
	        obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
	        if(obj.value != ''){

	        var re=/^\d+\.{0,1}\d{0,2}$/;
                  if(!re.test(obj.value))   
                  {   
			          obj.value = obj.value.substring(0,obj.value.length-1);
			          return false;
                  } 
	        }
        }
<!--
//去掉空格
function check_null(string) { 
var i=string.length;
var j = 0; 
var k = 0; 
var flag = true;
while (k<i){ 
if (string.charAt(k)!= " ") 
j = j+1; 
k = k+1; 
} 
if (j==0){ 
flag = false;
} 
return flag; 
}
function VerifyData() {
if (document.form1.MOAmount.value == "") {
			alert("请输入存款金额！")
			document.form1.MOAmount.focus();
			return false;
}
if (document.form1.MOAmount.value <100 {
			alert("最低冲值100元！")
			document.form1.MOAmount.focus();
			return false;
}
}
-->
</script>
<script language="JavaScript">
<!--
function url(r){
    window.open(r,"mainFrame");  
}
-->
</script>
</HEAD>
<body id="zhuce_body">
<div class="body2">
<div style="margin-top:10px;margin:10px 0 10px 0;"><span class="STYLE1"><strong>在线冲值</strong></span>>&nbsp;&nbsp;&nbsp;<a class="len" onclick="url('../user/cha_ckonline.php?s_time=<?=date("Y-m-d",time()-1123200)?>&e_time=<?=date("Y-m-d",time())?>')" style="color:#00F;text-decoration: underline;">冲值记录查看</a></div>

<form id="form1" name="form1" action="MerToDinpay.php" method="post" onsubmit="return VerifyData();" target="_blank">
    <table width="720" style="border-collapse:collapse;border:1px solid #CCC;" border="0" cellpadding="1" cellspacing="1" >
                    <tr>
                        <td height="30" align="right"> 用户帐号:</td>
                        <td align="left"><span class="STYLE5">
                        &nbsp;&nbsp;&nbsp;<?=$username;?>
                        </span></td>
                    </tr>
                  <tr>
                    <td height="30" align="right"> 手机号码:</td>
                    <td align="left"><span class="STYLE5">&nbsp;&nbsp;&nbsp;<?=$rows['mobile']?></span></td>
                  </tr>
                  <tr>
                    <td height="30" align="right"> 目前额度:</td>
                    <td align="left"><span class="STYLE5">&nbsp;&nbsp;&nbsp;<?=$rows['money']?></span></td>
                  </tr>                    
                    <tr>
                        <td height="30" align="right"><span class="STYLE12">*</span> 充值金额:</td>
                        <td align="left">&nbsp;&nbsp;&nbsp;<input name="MOAmount" type="text" id="MOAmount" style="border:1px solid #CCCCCC;height:18px;line-height:20px; width:118px;" onkeyup="clearNoNum(this);" size="15"/>&nbsp;&nbsp;最少冲值100元</td>
                    </tr>
					<tr>
                            <td height="30" align="right">选择银行:</td>
                            <td align="elft">
                            	<input type="radio" name="bank_name" value="ICBC" /><img src="img/bank_3.gif" alt="工商银行" width="130" height="52" align="middle" />&nbsp;
                            	<input type="radio" name="bank_name" value="CCB" /><img src="img/bank_2.gif" alt="建设银行" width="130" height="52" align="middle" />&nbsp;
                            	<input type="radio" name="bank_name" value="ABC" /><img src="img/bank_4.gif" alt="农业银行" width="130" height="52" align="middle" />&nbsp;
								<input type="radio" name="bank_name" value="SDB" /><img src="img/bank_9.gif" alt="深圳发展银行" width="130" height="52" align="middle" />&nbsp;<br />
                            	<input type="radio" name="bank_name" value="CNCB" /><img src="img/bank_12_01.gif" alt="中信银行" width="130" height="52" align="middle" />&nbsp;
                            	<input type="radio" name="bank_name" value="CMD" /><img src="img/bank_5.gif" alt="招商银行" width="130" height="52" align="middle" />&nbsp;
                            	<input type="radio" name="bank_name" value="BCOM" /><img src="img/bank_12_02.gif" alt="交通银行" width="130" height="52" align="middle" />&nbsp;
                            	<input type="radio" name="bank_name" value="CMSB" /><img src="img/bank_11.gif" alt="民生银行" width="130" height="52" align="middle" />&nbsp;<br />
                            	<input type="radio" name="bank_name" value="CEBB" /><img src="img/bank_7.gif" alt="光大银行" width="130" height="52" align="middle" />&nbsp;
                            	<input type="radio" name="bank_name" value="BEA" /><img src="img/bank_12_06.gif" alt="东亚银行" width="130" height="52" align="middle" />&nbsp;
                            	<input type="radio" name="bank_name" value="SPABANK" /><img src="img/pab.png" alt="平安银行" width="130" height="52" align="middle" />&nbsp;
                            	<input type="radio" name="bank_name" value="BOC" /><img src="img/bank_1.gif" alt="中国银行" width="130" height="52" align="middle" />&nbsp;<br />
                            	<input type="radio" name="bank_name" value="PSBC" /><img src="img/bank_12_09.gif" alt="中国邮政" width="130" height="52" align="middle" />&nbsp;
                            	<input type="radio" name="bank_name" value="CIB" /><img src="img/bank_8.gif" alt="兴业银行" width="130" height="52" align="middle" />&nbsp;
                            	<input type="radio" name="bank_name" value="GDB" /><img src="img/bank_6.gif" alt="广东发展银行" width="130" height="52" align="middle" />&nbsp;
                            	<input type="radio" name="bank_name" value="HXB" /><img src="img/bank_10.gif" alt="华夏银行" width="130" height="52" align="middle" />&nbsp;<br />
                            	<input type="radio" name="bank_name" value="SPDB" /><img src="img/shpf.png" alt="浦发银行" width="130" height="52" align="middle" />&nbsp;
                            	<input type="radio" name="bank_name" value="CMBC" /><img src="img/bank_11_01.gif" alt="中国民生银行信用卡支付" width="130" height="52" align="middle" />&nbsp;
                            	<input type="radio" name="bank_name" value="ECITIC" /><img src="img/bank_11_02.gif" alt="中信银行信用卡支付" width="130" height="52" align="middle" />&nbsp;
                            	</td> 
                        </tr>
                    <tr><td height="35" align="right">&nbsp;</td>
					<td height="40" align="left" valign="middle">
                      &nbsp;&nbsp;<table><tr><td> <input name="SubTran" id="SubTran"  type="image" src="/images/btn-recharge.jpg" /></td><td> <input type="reset" style="height:39px;border:none;width:85px;background:url(/images/btn-reset.jpg)" value="" border="0">	</td></tr></table>			</td>
					</tr>
                </table>
                <div style="display:none">
    <br>
		<br>时间字段：<input Type="text" Name="MODate" value="2010-08-16 12:20:10">
	<br>币      种：<input Type="text" Name="MOCurrency" value="1">
	<br>语言选择：<input Type="text" Name="M_Language" value="1">
	<br>消费者姓名：<input Type="text" Name="S_Name" value="<?=$username;?>">
	<br>消费者住址：<input Type="text" Name="S_Address" value="2308">
	<br>消费者邮码：<input Type="text" Name="S_PostCode" value="518000">
	<br>消费者电话：<input Type="text" Name="S_Telephone" value="0755-88833166">
	<br>消费者邮件：<input Type="text" Name="S_Email" value="service@dinpay.com">
	<br>收货人姓名：<input Type="text" Name="R_Name" value="wangl">
	<br>收货人住址：<input Type="text" Name="R_Address" value="2308">
	<br>收货人邮码：<input Type="text" Name="R_PostCode" value="100080">
	<br>收货人电话：<input Type="text" Name="R_Telephone" value="0755-82384511">
	<br>收货人邮件：<input Type="text" Name="R_Email" value="service@dinpay.com">
	<br>商品名称：<input Type="text" Name="G_Name" value="aaa">
	<br>商品编号：<input Type="text" Name="G_Number" value="B001">
	<br>商品数量：<input Type="text" Name="G_Count" value="1">
	<br>商品描述：<input Type="text" Name="G_Info" value="bbb">
	<br>商品展示地址：<input Type="text" Name="G_Url" value="http://www.a.com">
	<br>备     注：<input Type="text" name="MOComment" value="w">
	<br>交易状态：<input Type="text" Name="State" value="0">

	<br>
</div>              
              </form>
<table width="96%" border="0" cellpadding="0" cellspacing="5">
                <tr >
                </tr>
                <tr>

                  <td align="left">
                  <span class="font-hblack"><span >
                  <div style=" line-height:22px;font-size:12px;">
                  如充值未及时到账、或有其他任何问题,您可以联系在线客服,爱发娱乐场为您提供365天×24小时不间断的友善和专业客户咨询服务!                 </div>
                  </span>                   </span>                  </td>
   
                </tr>
              </table>              
</div>              
</BODY>
</HTML>
