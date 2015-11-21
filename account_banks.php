<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$sqla = "select * from ssc_member WHERE username='" . $_SESSION["username"] . "'";
$rsa = mysql_query($sqla);
$rowa = mysql_fetch_array($rsa);
if($rowa['cwpwd']==""){
	$_SESSION["cwurl"]="account_banks.php";
	echo "<script language=javascript>window.location='account_setpwd.php';</script>";
	exit;
}
if($_GET['check']!="114"){
	if($_SESSION["cwflag"]!="ok"){
		$_SESSION["cwurl"]="account_banks.php";
		echo "<script language=javascript>window.location='account_check.php';</script>";
		exit;
	}
}
$_SESSION["cwflag"]="";
$sql = "select * from ssc_bankcard WHERE username='" . $_SESSION["username"] . "'";
$rs = mysql_query($sql);
$banknums=mysql_num_rows($rs);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<head>
    <title>娱乐平台  - 我的银行卡</title>
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
    window.onload = function(){
        var t = window.top;
        $.each(t.$("#leftframe").contents().find("a"),function(){
            if($(this).html() == "我的银行卡"){
                t.$("#leftframe").contents().find("a").removeClass();
                $(this).attr("class", "active");
            }
        });
    }
</script>
<div class="top_menu">
    <div class="tm_left"></div>
    <div class="tm_title"></div>
    <div class="tm_right"></div>
    <div class="tm_menu">
        <a href="/users_info.php?check=416">奖金详情</a>
        <a href="/users_message.php">我的消息</a>
        <a class="act" href="/account_banks.php?check=416">我的银行卡</a>
        <a href="/account_update.php?check=416">修改密码</a>
    </div>
</div>
<div class="rc_con binding">
    <div class="rc_con_lt"></div>
    <div class="rc_con_rt"></div>
    <div class="rc_con_lb"></div>
    <div class="rc_con_rb"></div>
    <div><a class="title_menu" href="/account_cardadd.php?check=416">绑定银行卡</a></div>
    <h5><div class="rc_con_title">我的银行卡</div></h5>
    <div class="rc_con_to">
        <div class="rc_con_ti">
            <div class="binding_ts">
                <div class="binding_tsn">
                    <h4>使用提示：</h4>
                    <p>1, 银行卡绑定成功后, 平台任何区域都 <strong>不会</strong> 出现您的完整银行账号, 开户姓名等信息。</p>
                    <p>2, 每个游戏账号最多绑定 <strong>5</strong> 张银行卡, 您已成功绑定 <strong><?=$banknums?></strong> 张。</p>
                    <p>3, 新绑定的提款银行卡需要绑定时间超过 <strong>6</strong> 小时才能正常提款。</p>
                    <p>4, 一个账户只能绑定同一个开户人姓名的银行卡。</p>
                </div>
            </div>
            <div class="clear"></div>
            <div class="rl_list">
                <table width="100%" class="lt" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <th><div>银行名称</div></th>
                        <th><div class='line'>卡号</div></th>
                        <th><div class='line'>绑定时间</div></th>
<?php
  if($rowa['cardlock']!=1){
?>
                        <th><div class='line'>操作</div></th>
<?php }?>
                    </tr>
<?php
  if($banknums==0){
?>
                    <tr align="center">
                        <td colspan="6" class='no-records'><span>您还没有绑定任何银行卡</span></td>
                    </tr>
<?php
  }else{
	while ($row = mysql_fetch_array($rs)){
?>
                    <tr align="center">
                        <td><?=$row['bankname']?></td>
                        <td>***************<?=substr($row['cardno'],-4)?></td>
                        <td><?=$row['adddate']?></td>
<?php
  if($rowa['cardlock']!=1){
?>
                        <td><a href="./account_carddel.php?id=<?=$row['id']?>">解绑</a></td>
<?php }?>
                    </tr>
  <?php
    }
  }
  ?>
                </table><br />
 <?php
  if($rowa['cardlock']!=1){
?>
                <input name="addcard" type="button" style="font-weight:bold;" value="绑定银行卡" onclick="window.location.href='./account_cardadd.php?check=416'" class="btn_normal">
                &nbsp;&nbsp;<input name="addcard" type="button" value="&nbsp;锁定银行卡" onclick="window.location.href='./account_cardlock.php?check=416'" class="btn_normal">
<?php }else{?>
&nbsp;&nbsp;&nbsp;<font color="#FF0000"  style="font-weight:bold;">您的银行卡资料已锁定</font>
<?php }?>
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