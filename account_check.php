<?php
session_start();
error_reporting(0);
require_once 'conn.php';
$flag = trim($_POST['flag']);
if($flag=="check"){
	$sql = "select * from ssc_member WHERE username='" . $_SESSION["username"] . "'";
	$rs = mysql_query($sql);
	$row = mysql_fetch_array($rs);
	
	if(md5(trim($_POST['secpass']))==$row['cwpwd']){
		$_SESSION["cwflag"]="ok";
		echo "<script language=javascript>window.location='".$_SESSION["cwurl"]."';</script>";
		exit;
	}else{
		$_SESSION["cwflag"]="failed";
		$_SESSION["backtitle"]="资金密码错误";
		$_SESSION["backurl"]="account_check.php";
		$_SESSION["backzt"]="failed";		
		$_SESSION["backname"]="返回上一页";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<head>
    <title>娱乐平台  - 资金密码检查</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
        <link href="./css/v1/all.css?modidate=20130201001" rel="stylesheet" type="text/css" />
    <script>var pri_imgserver = '';</script>
        <script language="javascript" type="text/javascript" src="./js/jquery.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/common.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/lottery/min/message.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/keyboard/keyboard.js?modidate=20130415002"></script>
        <script language="javascript">
        function ResumeError() {return true;} window.onerror = ResumeError; 
        document.onselectstart = function(event){
            if(window.event) {
                event =    window.event;
            }
            try {
                var the = event.srcElement ;
                if( !( ( the.tagName== "INPUT" && the.type.toLowerCase() == "text" ) || the.tagName== "TEXTAREA" || the.tagName.toLowerCase()=="p" || the.tagName.toLowerCase()=="span") )
                {
                    return false;
                }
                return true ;
            } catch(e) {
                return false;
            }
        } 
    </script>
    <style type="text/css">
        .keyboard{-moz-user-select: -moz-none;}
    </style>
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
</div><script>
    $(function(){
        getKeyBoard($('#secpass'));
        var top = $("#secpass").offset().top+$("#secpass").height()-4;
        $(".secpass").css("top",top+"px");
        $("#copyright").css("margin-bottom","100px");
    });
</script>
<div class="clear"></div>
<div class="rc_con system">
    <div class="rc_con_lt"></div>
    <div class="rc_con_rt"></div>
    <div class="rc_con_lb"></div>
    <div class="rc_con_rb"></div>
    <h5><div class="rc_con_title">资金密码检查</div></h5>
    <div class="rc_con_to">
        <div class="rc_con_ti">
            <table class="ct" border="0" cellspacing="0" cellpadding="0">
                <form action="" method="post" name="updateform">
                    <input type="hidden" name="flag" value="check" />
                    <input type="hidden" name="nextcon" value="account" />
                    <input type="hidden" name="nextact" value="<?=$_SESSION["cwurl"]?>" />
                    <tr>
                        <td class="nl">输入资金密码: </td>
                        <td>
                            <input id='secpass' type="password" name="secpass" value="" />
                            <input name="submit" type="submit" value="提交" class="btn_submit" />
                        </td>
                    </tr>
                </form>
            </table>
            <div class="clear"></div>
        </div>
    </div>
</div>

<div class="clear"></div>
<div id="copyright">
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