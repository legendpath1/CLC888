<?php
session_start();
error_reporting(0);
require_once 'conn.php';
//require_once 'check.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=utf-8" />
<TITLE>系统消息</TITLE>
<link href="./css/v1/all.css?modidate=20130201001" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="rightcon">
<div class="rc_con system">
    <div class="rc_con_lt"></div>
    <div class="rc_con_rt"></div>
    <div class="rc_con_lb"></div>
    <div class="rc_con_rb"></div>
    <h5><div class="rc_con_title">系统提示</div></h5>
    <div class="rc_con_to">
        <div class="rc_con_ti">
                            <div class="system_title_<?php if($_SESSION["backzt"]=="failed"){echo "w";}else{echo "y";}?>"><span></span><?=$_SESSION["backtitle"]?></div>
                        <div class="sy_txt">
                <div class="s_tit">如果您不做出选择，将在 <span id="spanSeconds">9</span> 秒后跳转到第一个链接地址</div>
                <ul>
                <?php if($_SESSION["backurl"]=="users_list.php"){?><li><a href="users_add.php" target="_self">增加用户</a></li><?php }?><li><a href="<?=$_SESSION["backurl"]?>" target="_self"><?=$_SESSION["backname"]?></a></li>
                </ul>
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
<div class="clear"></div>
</div>
<SCRIPT language="JavaScript">
<!--
var seconds = document.getElementById('spanSeconds').innerHTML;
var defaultUrl = "<?=$_SESSION["backurl"]?>";
var timeInterval = null;


onload = function()
{
 timeInterval = window.setInterval(redirection, 1000);
    document.getElementById('spanSeconds').innerHTML = seconds;
}

function redirection()
{
  seconds--;

  if (seconds <= 0)
  {
   clearInterval(timeInterval);
      window.location.href= defaultUrl;
  }
  else
  {
      document.getElementById('spanSeconds').innerHTML = seconds;
  }
}
//-->
</SCRIPT>
</BODY>
</HTML>