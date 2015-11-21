<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';
$_SESSION["mainframe"] = '"./users_info.php"';

$uid=$_REQUEST['uid'];
if($uid!=""){
	$sql = "select * from ssc_member WHERE id='" . $uid . "'";
}else{
	$sql = "select * from ssc_member WHERE username='" . $_SESSION["username"] . "'";
}
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs);
$flevel=$row['flevel'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<head>
    <title>娱乐平台  - 奖金详情</title>
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
</div><script language="javascipt" type="text/javascript">
    ;(function($){
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
            $("span[id^='general_tab_']:first","#tabbar-div-s2").click();
        });
    })(jQuery);
</script>
<div class="top_menu">
    <div class="tm_left"></div>
    <div class="tm_title"></div>
    <div class="tm_right"></div>
    <div class="tm_menu">
        <a class="act" href="/users_info.php?check=">奖金详情</a>
        <a href="/users_message.php">我的消息</a>
        <a href="/account_banks.php?check=">我的银行卡</a>
        <a href="/account_update.php?check=">修改密码</a>
    </div>
</div>
<div class="rc_con betting">
    <div class="rc_con_lt"></div>
    <div class="rc_con_rt"></div>
    <div class="rc_con_lb userpoint"></div>
    <div class="rc_con_rb userpoint"></div>
    <h5><div class="rc_con_title">奖金详情</div></h5>
    <div class="rc_con_to">
        <div class="rc_con_ti">
            <div class="rc_m_til">用户基本信息</div>
            <div class="betting_input">
                <table class="user_infc" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="100" align="right" class="n1">账号：</td>
                        <td class="c_bl"><?=$row['username']?></td>
                        <td width="100" align="right" class="n1">昵称：</td>
                        <td class="c_bl"><?=$row['nickname']?></td>
                        <td width="100" align="right" class="n1">奖金限额：</th>
                        <td class="c_bl"><font color="#FF3300">高频彩：</font>300000元&nbsp;&nbsp;&nbsp;&nbsp;<font color="#8e3736">低频彩：</font>100000元</td>
                    </tr>
                </table>
            </div>
            <div class="clear"></div>
            <div class="rc_list">
                <div class="rl_list">
                    <table width='100%' cellspacing="0" cellpadding="0" class="tab_title">
                        <tr>
                            <td id="tabbar-div-s2">
   	<?php 
		$sqle = "select * from ssc_set where zt=1 order by id asc";
		$rse = mysql_query($sqle);
		while ($rowe = mysql_fetch_array($rse)){
	?>
                                <span class="tab-back"  id="general_tab_<?=$rowe['id']?>" TITLE='<?=$rowe['name']?>' ALT='<?=$rowe['name']?>'>
                                    <span class="tabbar-left"></span>
                                    <span class="content"><?=$rowe['jname']?></span>
                                    <span class="tabbar-right"></span>
                                </span>
    <?php }?>
                            </td>
                        </tr>
                    </table>
   	<?php 
		$sqle = "select * from ssc_set where zt=1 order by id asc";
		$rse = mysql_query($sqle);
		while ($rowe = mysql_fetch_array($rse)){
	?>
                    <div class='bd'>
                        <div class='bd2' id="general_txt_<?=$rowe['id']?>">
                        	<div class="ld">
                            	<table class="lt" id="tabbar_txt_<?=$rowe['id']?>_10" border="0" cellspacing="0" cellpadding="0" width="100%">
                                    <tr>
                                        <th>彩种</th>
                                        <th>玩法组</th>
                                        <th><div class='line'>奖级</div></th>
                                        <th><div class='line'>奖金</div></th>
                                        <?php if($flevel>0){?>
                                        <th><div class='line'>返点</div></th>
                                        <?php }?>
                                        <th><div class='line'>状态</div></th>
                                    </tr>
		<?php 
            $sqlf = "select * from ssc_class where cid='".$rowe['id']."' and sign=1 order by id asc";
            $rsf = mysql_query($sqlf);
            while ($rowf = mysql_fetch_array($rsf)){
				$stra=str_replace(";","<br>",$rowf['jname']);
				$strb=str_replace(";","<br>",$rowf['rates']);
				
//				$strc=explode(";",$rowf['rates']);
//				$ratesa="";
//				for ($i=0; $i<count($strc); $i++) {
//					$ratesa=$ratesa.$strc[$i];
//					if($i!=count($strc)){
//						$ratesa=$ratesa."<br>";	
//					}
//				}
				$rebate=cflevel($flevel,$rowf['cid']);
				if($rowf['mid']>=133 && $rowf['mid']<=145){
					$rebate=$rebate+5;
				}

        ?>
                                    <tr>
                                        <td align="center"><?=$rowf['cname']?></td>
                                        <td align="center"><?=$rowf['name']?></td>
                                        <td align="center"><?=$stra?></td>
                                        <td align="center"><?=$strb?></td>
                                        <?php if($flevel>0){?>
                                        <td align="center"><?=$rebate?></td>
                                        <?php }?>
                                        <td align="center">使用中</td>
                                    </tr>
<?php }?>
                                </table>
                            </div>
                        </div>
                    </div>
<?php }?>

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