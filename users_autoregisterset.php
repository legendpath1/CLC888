<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$sql = "select * from ssc_member WHERE username='" . $_SESSION["username"] . "'";
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs);
$flevel=$row['flevel'];
$level=$row['level'];
$xjlevel=$row['xjlevel'];

	$flevel2=$flevel-0.1;
	if($flevel2<0){
		$flevel2=0;
	}

if($flevel2>6.9){
	$flevel2=6.9;
}
$flag=$_REQUEST['flag'];

if($flag=="insert"){
	
		

		$fflevel = round($_REQUEST['keeppoint'],1);
		if($fflevel>$flevel2){
			$_SESSION["backtitle"]="自动注册返点设置错误";
			$_SESSION["backurl"]="users_autoregisterset.php";
			$_SESSION["backzt"]="failed";
			$_SESSION["backname"]="自动注册设置";
			echo "<script language=javascript>window.location='sysmessage.php';</script>";
			exit;
		}


		$sql = "update ssc_member set xjlevel='" . $fflevel . "'  WHERE username='" . $_SESSION["username"] . "'";
		$exe = mysql_query($sql);
		
		amend("修改自动注册返点为".$fflevel);	
		
		$_SESSION["backtitle"]="操作成功";
		$_SESSION["backurl"]="users_autoregisterset.php";
		$_SESSION["backzt"]="successed";
		$_SESSION["backname"]="自动注册设置";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<head>
    <title>娱乐平台  - 自动注册设置</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
        <link href="./css/v1/all.css?modidate=20130201001" rel="stylesheet" type="text/css" />
    <script>var pri_imgserver = '';</script>
    <script language="javascript" type="text/javascript" src="./js/jquery.js?modidate=20130726001"></script>
    <script language="javascript" type="text/javascript" src="./js/common.js?modidate=20130726001"></script>
    <script language="javascript" type="text/javascript" src="./js/lottery/min/message.js?modidate=20130726001"></script>
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
</div><form method="post" name="updateform" action="/users_autoregisterset.php">
<input type="hidden" name="flag" value="insert" />
    <div class="rc_con betting">
        <div class="rc_con_lt"></div>
        <div class="rc_con_rt"></div>
        <div class="rc_con_lb"></div>
        <div class="rc_con_rb"></div>
        <div><a class="title_menu act" href="/users_list.php?frame=show">用户列表</a></div>
        <h5><div class="rc_con_title">自动注册设置</div></h5>
        <div class="rc_con_to">
            <div class="rc_con_ti">
                <div class="rc_list">
                    <div class="rl_list">
                        <div class='bd2' id="general_txt_0">
                            <div class="user_ts">
                                <span class="user_ts_title">&nbsp;&nbsp;一、自动注册设置说明:</span><BR/>
                                &nbsp;&nbsp;<span class="c_bl">1.请选择自动注册用户时,用户的返点值。</span><BR/>
                                <span class="user_ts_title">&nbsp;&nbsp;二、您的返点级别：</span>
                                <font color="#F00"><b><?=$flevel?></b></font><BR/>
                                <span class="user_ts_title">&nbsp;&nbsp;三、请选择以下相关的设置信息：</span>
                            </div>
                                <div class="user_ts">
                                <span class="user_ts_title">&nbsp;&nbsp;请选择返点: </span>
                                <input type="text" name="keeppoint" id="keeppoint" style='width:45px;' value="<?=$xjlevel?>"/>
                                <input type="hidden" name="keepmin" id="keepmin" value="0" />
                                <input type="hidden" name="keepmax" id="keepmax" value="<?=$flevel2?>" /> % 
                                <span class='helpinfo'>( 可填范围: 0～<?=$flevel2?> )</span>
                            </div>
                            <div class="user_ts">
                                <span class="user_ts_title">&nbsp;&nbsp;自动注册地址： </span>
                                <a href="http://www.clc888.com/register.php?id=<?=$_SESSION["uid"]?>" target="_blank" style="text-decoration: underline;"><font color="blue">http://www.clc888.com/register.php?id=<?=$_SESSION["uid"]?></font></a>
                            </div>
                            <div class="user_ts">
                                <input name='submit1' type="submit" value="确认生成" class="btn_next">
                            </div>


                                                    </div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</form>
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
