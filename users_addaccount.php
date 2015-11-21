<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$ztt=array("停用","使用中"); 
$uid=$_REQUEST['uid'];
$sql = "select * from ssc_member WHERE username='" . $_SESSION["username"] . "'";
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs);
$pe=$row['pe'];

$sql = "select * from ssc_member WHERE id='" . $uid . "'";
$rs = mysql_query($sql);
$total=mysql_num_rows($rs);
if($total==0){
	$_SESSION["backtitle"]="该用户不存在";
	$_SESSION["backurl"]="users_list.php";
	$_SESSION["backzt"]="failed";
	$_SESSION["backname"]="用户列表";
	echo "<script language=javascript>window.location='sysmessage.php';</script>";
	exit;
}
$row = mysql_fetch_array($rs);
$pes=$row['pe'];
$username=$row['username'];
$flevel=$row['flevel'];


$pe1=explode(";",$pe);
$pe2=explode(";",$pes);

$flag=$_REQUEST['flag'];

if($flag=="save"){
	$addnum0=intval($_REQUEST['addnum0']);
	$addnum1=intval($_REQUEST['addnum1']);
	$addnum2=intval($_REQUEST['addnum2']);
	$addnum3=intval($_REQUEST['addnum3']);
	$addnum4=intval($_REQUEST['addnum4']);
	$addnum5=intval($_REQUEST['addnum5']);
	$addnum6=intval($_REQUEST['addnum6']);
	$addnum7=intval($_REQUEST['addnum7']);
	if($addnum0>$pe1[0] || $addnum1>$pe1[1] || $addnum2>$pe1[2] || $addnum3>$pe1[3] || $addnum4>$pe1[4] || $addnum5>$pe1[5] || $addnum6>$pe1[6] || $addnum7>$pe1[7]){
		$_SESSION["backtitle"]="配额不足，请与上级联系！";
		$_SESSION["backurl"]="users_list.php";
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="用户列表";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}
	
	$pe1[0]=$pe1[0]-$addnum0;
	$pe2[0]=$pe2[0]+$addnum0;
	$pe1[1]=$pe1[1]-$addnum1;
	$pe2[1]=$pe2[1]+$addnum1;
	$pe1[2]=$pe1[2]-$addnum2;
	$pe2[2]=$pe2[2]+$addnum2;
	$pe1[3]=$pe1[3]-$addnum3;
	$pe2[3]=$pe2[3]+$addnum3;
	$pe1[4]=$pe1[4]-$addnum4;
	$pe2[4]=$pe2[4]+$addnum4;
	$pe1[5]=$pe1[5]-$addnum5;
	$pe2[5]=$pe2[5]+$addnum5;
	$pe1[6]=$pe1[6]-$addnum6;
	$pe2[6]=$pe2[6]+$addnum6;
	$pe1[7]=$pe1[7]-$addnum7;
	$pe2[7]=$pe2[7]+$addnum7;
	
	$pe=implode(";",$pe1);
	$pes=implode(";",$pe2);
	$sql = "update ssc_member set pe='" . $pe . "' where username='" . $_SESSION["username"] . "'";
	$exe = mysql_query($sql);

	$sql = "update ssc_member set pe='" . $pes . "' where id='" . $uid . "'";
//	echo $sql;
	$exe = mysql_query($sql);
		
	$_SESSION["backtitle"]="操作成功";
	$_SESSION["backurl"]="users_list.php";
	$_SESSION["backzt"]="successed";
	$_SESSION["backname"]="用户列表";
	echo "<script language=javascript>window.location='sysmessage.php';</script>";
	exit;

}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<head>
    <title>娱乐平台  - 开户配额</title>
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
    function checkform(obj)
    {
        bb = true;
            if (obj.addnum2.value > <?=$pe1[2]?>){
                $("input[name='addnum2']").nextAll("span").html('&nbsp;&nbsp;<font color="red">X</font>').show();
                bb = false;
            }else{
                $("input[name='addnum2']").nextAll("span").html('&nbsp;&nbsp;');
            }
            if (obj.addnum3.value > <?=$pe1[3]?>){
                $("input[name='addnum3']").nextAll("span").html('&nbsp;&nbsp;<font color="red">X</font>').show();
                bb = false;
            }else{
                $("input[name='addnum3']").nextAll("span").html('&nbsp;&nbsp;');
            }
            if( bb == false ){
                alert("增加的配额不能大于当前自己的剩余开户额");
                return false;
            }
            obj.submit.disabled=true;
            return true;
            }
</script>
<div class="rc_con user_list">
    <div class="rc_con_lt"></div>
    <div class="rc_con_rt"></div>
    <div class="rc_con_lb"></div>
    <div class="rc_con_rb"></div>
    <h5><div class="rc_con_title">开户配额</div></h5>
    <div class="rc_con_to">
        <div class="rc_con_ti">
            <form method="post" name="updateform"><!--onsubmit="return checkform(this)"-->
                <input type="hidden" name="uid" value="<?=$uid?>" />
                <input type="hidden" name="flag" value="save" />
                <div class="rc_list">
                    <div class="rl_list">
                        <div class="user_ts">
                            <span class="user_ts_title">账号:</span> <?=$username?> &nbsp;&nbsp;&nbsp;
                            <span class="user_ts_title">返点级别:</span><?=$flevel?>                        </div>
                        <table class="lt" border="0" cellspacing="0" cellpadding="0" width="100%">
                            <tr>
                                <th><div>开户级别</div></th>
                                <th><div class='line'>我的剩余开户额</div></th>
                                <th><div class='line'>下级剩余开户额</div></th>
                                <th><div class='line'>为下级增加开户额</div></th>
                            </tr>
                            <?PHP if($flevel>=7.8){?>
                            <tr>
                                <td align="center" style="font-size:14px; color:#FF0000; font-weight:bold;">7.7</td>
                                <td align="center"><?=$pe1[7]?></td>
                                <td align="center"><?=$pe2[7]?></td>
                                <td align="center"><input type="text" name="addnum7" size="5" onkeyup="value=value.replace(/[^\d]/g,'') "  onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"  /><span>&nbsp;&nbsp;</span></td>
                            </tr>
                            <?php }?>
                            <?PHP if($flevel>=7.7){?>
                            <tr>
                                <td align="center" style="font-size:14px; color:#FF0000; font-weight:bold;">7.6</td>
                                <td align="center"><?=$pe1[6]?></td>
                                <td align="center"><?=$pe2[6]?></td>
                                <td align="center"><input type="text" name="addnum6" size="5" onkeyup="value=value.replace(/[^\d]/g,'') "  onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"  /><span>&nbsp;&nbsp;</span></td>
                            </tr>
                            <?php }?>
                            <?PHP if($flevel>=7.6){?>
                            <tr>
                                <td align="center" style="font-size:14px; color:#FF0000; font-weight:bold;">7.5</td>
                                <td align="center"><?=$pe1[5]?></td>
                                <td align="center"><?=$pe2[5]?></td>
                                <td align="center"><input type="text" name="addnum5" size="5" onkeyup="value=value.replace(/[^\d]/g,'') "  onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"  /><span>&nbsp;&nbsp;</span></td>
                            </tr>
                            <?php }?>
                            <?PHP if($flevel>=7.5){?>
                            <tr>
                                <td align="center" style="font-size:14px; color:#FF0000; font-weight:bold;">7.4</td>
                                <td align="center"><?=$pe1[4]?></td>
                                <td align="center"><?=$pe2[4]?></td>
                                <td align="center"><input type="text" name="addnum4" size="5" onkeyup="value=value.replace(/[^\d]/g,'') "  onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"  /><span>&nbsp;&nbsp;</span></td>
                            </tr>
                            <?php }?>
                            <?PHP if($flevel>=7.4){?>
                            <tr>
                                <td align="center" style="font-size:14px; color:#FF0000; font-weight:bold;">7.3</td>
                                <td align="center"><?=$pe1[3]?></td>
                                <td align="center"><?=$pe2[3]?></td>
                                <td align="center"><input type="text" name="addnum3" size="5" onkeyup="value=value.replace(/[^\d]/g,'') "  onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"  /><span>&nbsp;&nbsp;</span></td>
                            </tr>
                            <?php }?>
                            <?PHP if($flevel>=7.3){?>
                            <tr>
                                <td align="center" style="font-size:14px; color:#FF0000; font-weight:bold;">7.2</td>
                                <td align="center"><?=$pe1[2]?></td>
                                <td align="center"><?=$pe2[2]?></td>
                                <td align="center"><input type="text" name="addnum2" size="5" onkeyup="value=value.replace(/[^\d]/g,'') "  onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"  /><span>&nbsp;&nbsp;</span></td>
                            </tr>
                            <?php }?>
                            <?PHP if($flevel>=7.2){?>
                            <tr>
                                <td align="center" style="font-size:14px; color:#FF0000; font-weight:bold;">7.1</td>
                                <td align="center"><?=$pe1[1]?></td>
                                <td align="center"><?=$pe2[1]?></td>
                                <td align="center"><input type="text" name="addnum1" size="5" onkeyup="value=value.replace(/[^\d]/g,'') "  onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"  /><span>&nbsp;&nbsp;</span></td>
                            </tr>
                            <?php }?>
                            <?PHP if($flevel>=7.1){?>
                            <tr>
                                <td align="center" style="font-size:14px; color:#FF0000; font-weight:bold;">7.0</td>
                                <td align="center"><?=$pe1[0]?></td>
                                <td align="center"><?=$pe2[0]?></td>
                                <td align="center"><input type="text" name="addnum0" size="5" onkeyup="value=value.replace(/[^\d]/g,'') "  onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"  /><span>&nbsp;&nbsp;</span></td>
                            </tr>
                            <?php }?>
                            <tr>
                                <td></td>
                                <td><input type="submit" name="submit" value="分配开户额"  class="btn_next" /></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </form>
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