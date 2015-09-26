<?php 
session_start();
error_reporting(0); ;
require_once 'conn.php';
require_once 'check.php';
$_SESSION["mainframe"] = '"./help_security.php"';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<head>
    <title>娱乐平台  - 系统公告</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
        <link href="./css/v1/all.css?modidate=20130201001" rel="stylesheet" type="text/css" />
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
</div>
<script type="text/javascript">
//        alert("重要提示：\r\n充值卡号会频繁更换，请一定要复制最新卡号信息\r\n切不可直接用上次充值的卡号信息。\r\n否则充到错误的卡号而产生的损失平台一律不负责！\r\n","重要提示","",650);

//    $(function(){
//    });
</script>
<div id="rightcon">
    <div class="rc_con">
        <div class="rc_con_lt"></div>
        <div class="rc_con_rt"></div>
        <div class="rc_con_lb"></div>
        <div class="rc_con_rb"></div>
        <h5><div class="rc_con_title">系统公告</div></h5>
        <div class="rc_con_to">
            <div class="rc_con_ti">
                <div class="news_l" align="center">
                	<table class='st' border="0" cellspacing="0" cellpadding="0" width="90%">
        	<?php
			$id=$_GET['id'];
			if($id==""){
            $sql = "select id,lev,adddate,topic from ssc_news order by id desc";
			$rsnews = mysql_query($sql);
			$ii=0;
			while ($rownews = mysql_fetch_array($rsnews)){
				if($rownews['lev']==1){
			?>
                    	<tr><td width=30 height=30><img src="/images/dot.gif"></td><td><a href="?id=<?=$rownews['id']?>" class="act"><?=$rownews['topic']?></a></td><td width="150"><a href="?id=<?=$rownews['id']?>" class="act"><?=$rownews['adddate']?></a></td></tr>
              	<?php }else{?>
                    	<tr><td width=30 height=30><img src="/images/dot.gif"></td><td><a href="?id=<?=$rownews['id']?>"><?=$rownews['topic']?></a></td><td width="150"><a href="?id=<?=$rownews['id']?>"><?=$rownews['adddate']?></a></td>
                   	  </tr>
            <?php }
				$ii++;
				if($ii%5==0){echo "<tr><td  colspan=3 height=1  background='images/dott.png'></td></tr><tr><td  colspan=3 height=8></td></tr>";}
			}}else{
            $sql = "select * from ssc_news where id='".$id."'";
			$rsnews = mysql_query($sql);
			$rownews = mysql_fetch_array($rsnews)?>
						<tr><td align="center"><h3><?=$rownews['topic']?></h3></td></tr>
						<tr><td align="center"><?=$rownews['adddate']?></td></tr>
                        <tr><td height=10 style='border-bottom:1px dotted #555555;'></td></tr>
                        <tr><td height=10></td></tr>
                        <tr><td><?=$rownews['cont']?></td></tr>
                        <tr><td height=60 align="center"><a href="?"><img src="/images/fh.png"></a></td></tr>
			<?php }?>
                    </table>
 
                </div>
 
                <div class="clear"></div>
            </div>
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