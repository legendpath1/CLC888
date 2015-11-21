<?php
session_start();
error_reporting(0);
require_once 'conn.php';

	$sqla="select * from ssc_member where username='".$_SESSION["username"]."'";
	$rsa=mysql_query($sqla) or  die("数据库修改出错!!!!");
	$rowa = mysql_fetch_array($rsa);
	if(empty($rowa)){
		//退出
//		$lmoney="0.00";
	}else{
		$lmoney=$rowa['leftmoney'];
		$nickname=$rowa['nickname'];
		$vip=$rowa['vip'];
	}
	
	$sqla="select id from ssc_message where username='".$_SESSION["username"]."' and zt=0";
	$rsa=mysql_query($sqla) or  die("数据库修改出错!!!!");
	$cmessage=mysql_num_rows($rsa);

$flag=$_REQUEST['flag'];
if($flag=="getmoney"){
	echo " {\"money\":\"".$lmoney."\"}";
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>左侧菜单</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <script language="javascript" type="text/javascript" src="./js/jquery.js?modidate=20130415002"></script>
        <script language="javascript" type="text/javascript" src="./js/common.js?modidate=20130415002"></script>
                <script language='javascript'>function ResumeError() {return true;} window.onerror = ResumeError; </script>
        <link href="./css/v1/left.css" rel="stylesheet" type="text/css" />
        <script language="javascript" type="text/javascript">
            $(function(){
                $(".menu_con").find("a").click(function(){
                    $(this).siblings().removeClass("active");
                    $(this).addClass("active");
                });

                $("#refreshimg").click(function(){
                    $("#leftusermoney").html("<font color='#CCFF00'>载入中</font>");
                    fastData();
                });
            });
        </script>
    </head>
    <body>
        <div id="leftcon">
            <div class="user_inf">
                <h4 class="menu_head"><a class="vip<?=$vip?>" href="./help_security.php?id=46" target="mainframe"></a></h4>
                <div class="clear"></div>
                <div class="ui_con">
                    <table width="177" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="75" rowspan="3" valign="middle" class="user_img"><a href="#" id="userswitch"></a></td>
                            <td valign="middle" height="5" width="102"></td>
                        </tr>
                        <tr>
                            <td valign="middle" height="25">您好&nbsp;&nbsp;&nbsp;<a href="./default_logout.php" onclick="javascript:return confirm('您确定要退出平台吗?');" target="_top"><img src="images/left/exit2.gif"></a></td>
                        </tr>
                        <tr>
                          <td valign="middle" id="nickname"><?=$nickname?></td>
                        </tr>
                        <tr>
                          <td valign="middle" height="25" colspan="2"><strong id="refreshimg">余额：<span class="jg" id="leftusermoney"><?=number_format($lmoney,2)?></span> 元</strong></td>
                        </tr>
                        <tr>
                          <td valign="middle" height="21" colspan="2" class="cmessage" align="center"><a target="mainframe" href="users_message.php"><img src='./images/left/email<?php if($cmessage==0){echo "None";}?>.gif' border="0" />&nbsp;<?php if($cmessage==0){echo "我的站内信&nbsp;&nbsp;&nbsp;";}else{echo $cmessage."封未读站内信&nbsp;&nbsp;&nbsp;";}?></a></td>
                        </tr>
                    </table>
                    <div class="clear"></div>
                    <div class="cztx">
                        <div class="cz"><a title="充值操作" href="./account_autosavea.php" target="mainframe"></a></div>
                        <div class="tx"><a title="提现申请" href="./account_draw.php" target="mainframe"></a></div>
                        <div class="clear"></div>
                    </div>
                    <div class="downclient" style="margin-top:10px;">
                        <a href="./soft/game.rar" target="_blank"><img src='./images/left/down.gif' border="0" /></a>
                    </div>
                </div>

            </div>
           
            <div class="clear"></div>

            <div class="my_menu">
                <h4 class="menu_head"></h4>
                <div class="menu_con">
			<?php 
			$sql="select * from ssc_set where zt=1 order by lid asc";
			$rsnewslist = mysql_query($sql);
			while ($row = mysql_fetch_array($rsnewslist)){
			?>
					<a target="mainframe" href="./<?=$row['urls']?>" title="<?=$row['name']?> (<?=$row['cname']?>)"><?=$row['name']?>
            <?php if($row['sign']==1){?> <span class="new">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <?php }elseif($row['sign']==2){?> <span class="hot">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><?php }?></a>
            <?php }?>
                                                        </div>
            </div>
            <div class="clear"></div>

        </div>
    </body>
</html>
