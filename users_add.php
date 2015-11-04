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
$regtop=$row['regtop'];
$regfrom=$row['regfrom'];
$virtual=$row['virtual'];

if($flevel>7.0){
	$pe=explode(";",$row['pe']);
	$pe0=$pe[0];
	$pe1=$pe[1];
	$pe2=$pe[2];
	$pe3=$pe[3];
	$pe4=$pe[4];
	$pe5=$pe[5];
	$pe6=$pe[6];
	$pe7=$pe[7];
}else{
	$pe0=0;
	$pe1=0;
	$pe2=0;
	$pe3=0;
	$pe4=0;
	$pe5=0;
	$pe6=0;
	$pe7=0;
}
//if($level==2){
//	$flevel2=$flevel;
//}else{
	$flevel2=$flevel-0.1;
	if($flevel2<0){
		$flevel2=0;
	}
//}

$flag=$_REQUEST['flag'];

if($flag=="insert"){
	
	if($_REQUEST['usertype']!="" && $_REQUEST['username']!="" && $_REQUEST['userpass']!="" && $_REQUEST['nickname']!=""){
		
		$sqla = "SELECT * FROM ssc_member where username='".$_REQUEST['username']."'";
		$rsa = mysql_query($sqla);
		$nums=mysql_num_rows($rsa);
		if($nums>0){
			$_SESSION["backtitle"]="用户名已存在";
			$_SESSION["backurl"]="users_add.php";
			$_SESSION["backzt"]="failed";
			$_SESSION["backname"]="增加用户";
			echo "<script language=javascript>window.location='sysmessage.php';</script>";
			exit;
		}
		
		if($row['level']==0){
			$_SESSION["backtitle"]="用户无法添加会员";
			$_SESSION["backurl"]="users_add.php";
			$_SESSION["backzt"]="failed";
			$_SESSION["backname"]="增加用户";
			echo "<script language=javascript>window.location='sysmessage.php';</script>";
			exit;
		}

		if($regtop==""){
			$regtop=$_SESSION["username"];
		}
		
		$fflevel = round($_REQUEST['keeppoint'],1);
		if($fflevel>$flevel2){
			$_SESSION["backtitle"]="用户返点设置错误";
			$_SESSION["backurl"]="users_add.php";
			$_SESSION["backzt"]="failed";
			$_SESSION["backname"]="增加用户";
			echo "<script language=javascript>window.location='sysmessage.php';</script>";
			exit;
		}
		// 6.6-7 0 6.1-6.5  1 7.5  7.4  7.3  7.2   7.1 

		if($fflevel>=7.7){
			if($pe[7]>0){
				$pe[7]=$pe[7]-1;
			}else{
				$prerr=1;
			}
		}elseif($fflevel==7.6){
			if($pe[6]>0){
				$pe[6]=$pe[6]-1;
			}else{
				$prerr=1;
			}
		}elseif($fflevel==7.5){
			if($pe[5]>0){
				$pe[5]=$pe[5]-1;
			}else{
				$prerr=1;
			}
		}elseif($fflevel==7.4){
			if($pe[4]>0){
				$pe[4]=$pe[4]-1;
			}else{
				$prerr=1;
			}
		}elseif($fflevel==7.3){
			if($pe[3]>0){
				$pe[3]=$pe[3]-1;
			}else{
				$prerr=1;
			}
		}elseif($fflevel==7.2){
			if($pe[2]>0){
				$pe[2]=$pe[2]-1;
			}else{
				$prerr=1;
			}
		}elseif($fflevel==7.1){
			if($pe[1]>0){
				$pe[1]=$pe[1]-1;
			}else{
				$prerr=1;
			}
		}elseif($fflevel==7.0){
			if($pe[0]>0){
				$pe[0]=$pe[0]-1;
			}else{
				$prerr=1;
			}
		}

		if($prerr==1){
			$_SESSION["backtitle"]="配额不足，请与上级联系！";
			$_SESSION["backurl"]="users_add.php";
			$_SESSION["backzt"]="failed";
			$_SESSION["backname"]="增加用户";
			echo "<script language=javascript>window.location='sysmessage.php';</script>";
			exit;
		}
		if($fflevel>7){
			$pes=implode(";",$pe);
			$sql = "update ssc_member set pe='" . $pes . "' where username='" . $_SESSION["username"] . "'";
			$exe = mysql_query($sql);
		}
		
		//远程注册
		if($SOPEN == 1)
		{
			$sapi_regResult = SAPI_Reg($_REQUEST['username'], $_REQUEST['pwd'], $_SESSION["username"], $_REQUEST['nickname']);
			if ($sapi_regResult[0] != 'SUCCESS')
			{
				$_SESSION["backtitle"]=$sapi_regResult[1];
				$_SESSION["backurl"]="users_add.php";
				$_SESSION["backzt"]="failed";
				$_SESSION["backname"]="增加用户";
				echo "<script language=javascript>window.location='sysmessage.php';</script>";
				exit;
			}
		}

		$sql = "insert into ssc_member set username='" . $_REQUEST['username'] . "', password='" . md5($_REQUEST['userpass']) . "', nickname='" . $_REQUEST['nickname'] . "', regfrom='&" .$_SESSION["username"]."&".$regfrom."', regup='" . $_SESSION["username"] . "', regtop='" . $regtop . "', flevel='" . $fflevel . "', pe='0;0;0;0;0;0;0;0', level='" . $_REQUEST['usertype'] . "', regdate='" . date("Y-m-d H:i:s") . "', virtual='" . $virtual . "'";
		$exe = mysql_query($sql);
		
		amend("增加用户 ".$_REQUEST['username']);	
		
		$_SESSION["backtitle"]="操作成功";
		$_SESSION["backurl"]="users_list.php";
		$_SESSION["backzt"]="successed";
		$_SESSION["backname"]="用户列表";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<head>
    <title>娱乐平台  - 增加用户</title>
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
        if( !validateUserName(obj.username.value) )
        {
            alert("登陆帐号 不符合规则，请重新输入");
            obj.username.focus();
            return false;
        }
        if( !validateUserPss(obj.userpass.value) )
        {
            alert("登陆密码 不符合规则，请重新输入");
            obj.userpass.focus();
            return false;
        }
        if( !validateNickName(obj.nickname.value) )
        {
            alert("呢称 不符合规则，请重新输入");
            obj.nickname.focus();
            return false;
        }
            minp = Number($("#keepmin").val());
            maxp = Number($("#keepmax").val());
            point= Number($("#keeppoint").val());
            if( point > maxp || point < minp ){
                alert("保留返点设置错误，请检查");
                return false;
            }
        obj.submit.disabled=true;
        return true;
    }
    //返点输入框输入过滤
    function filterPercent(num){
        num = num.replace(/^[^\d]/g,'');
        num = num.replace(/[^\d.]/g,'');
        num = num.replace(/\.{2,}/g,'.');
        num = num.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
        if( num.indexOf(".") != -1 ){
            var data = num.split('.');
            num = (data[0].substr(0,3))+'.'+(data[1].substr(0,1));
        }else{
            num = num.substr(0,3);
        }
        num = num > 100 ? 100 : num;
        return num;
    }
</script>
<form method="post" name="updateform" onsubmit="return checkform(this)">
    <div class="rc_con betting">
        <div class="rc_con_lt"></div>
        <div class="rc_con_rt"></div>
        <div class="rc_con_lb"></div>
        <div class="rc_con_rb"></div>
        <h5><div class="rc_con_title">增加用户</div></h5>
        <div class="rc_con_to">
            <div class="rc_con_ti">
                <div class="rc_m_til">填写基本信息</div>
                <div class="useradd_input">
                    <input type="hidden" name="addtype" id="addtype" value="ks" />
                    <input type="hidden" name="flag" value="insert" />
                    <table class="user_infc" border="0" cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                            <td class="nl">用户级别:</td>
                            <td>
                                <label><input type="radio" name="usertype" value="1" checked="checked" />代理用户</label>&nbsp;&nbsp;
                                <label><input type="radio" name="usertype" value="0" />会员用户</label>
                            </td>
                        </tr>
                        <tr>
                            <td class="nl">登陆帐号:</td>
                            <td>
                                <input type="text" name="username" class='w160'/> 
                                <span class="pop"><s class="pop-l"></s><span>（由0-9,a-z,A-Z组成的6-16个字符）</span><s class="pop-r"></s></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="nl">登陆密码:</td>
                            <td>
                                <input type="password" name="userpass" class='w160'/> 
                                <span class="pop"><s class="pop-l"></s><span>（由字母和数字组成6-16个字符；且必须包含数字和字母，不允许连续三位相同）</span><s class="pop-r"></s></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="nl">用户呢称:</td>
                            <td>
                                <input type="text" name="nickname" class='w160'/> 
                                <span class="pop"><s class="pop-l"></s><span>（由2至8个字符组成）</span><s class="pop-r"></s></span>
                            </td>
                        </tr>
                                            </table>
                </div>
                <div class="rc_list">
                    <div class="rl_list">
                        <div class="tab_userset">
                            <table width='100%' border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td id="tabbar-div-s2">
                                        <span class="tab-front"  id="general_tab_0">
                                            <span class="tabbar-left"></span>
                                            <span class="content">返点设置</span>
                                            <span class="tabbar-right"></span>
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class='bd'>
                            <div class='bd2' id="general_txt_0">
                                <div class="user_ts">
                                    <span class="user_ts_title">剩余开户额：<br></span>
                                    <span class="c_bl">
                                    	<?php if($flevel>=7.8){?>
                                        [7.7]:<font color="#F00"> <?=$pe7?> </font>个&nbsp;&nbsp;&nbsp;
                                        <?php }?>
                                    	<?php if($flevel>=7.7){?>
                                        [7.6]:<font color="#F00"> <?=$pe6?> </font>个&nbsp;&nbsp;&nbsp;
                                        <?php }?>
                                    	<?php if($flevel>=7.6){?>
                                        [7.5]:<font color="#F00"> <?=$pe5?> </font>个&nbsp;&nbsp;&nbsp;
                                        <?php }?>
                                    	<?php if($flevel>=7.5){?>
                                        [7.4]:<font color="#F00"> <?=$pe4?> </font>个&nbsp;&nbsp;&nbsp;
                                        <?php }?>
                                    	<?php if($flevel>=7.4){?>
                                        [7.3]:<font color="#F00"> <?=$pe3?> </font>个&nbsp;&nbsp;&nbsp;
                                        <?php }?>
                                    	<?php if($flevel>=7.3){?>
                                        [7.2]:<font color="#F00"> <?=$pe2?> </font>个&nbsp;&nbsp;&nbsp;
                                        <?php }?>
                                    	<?php if($flevel>=7.2){?>
                                        [7.1]:<font color="#F00"> <?=$pe1?> </font>个&nbsp;&nbsp;&nbsp;
                                        <?php }?>
                                    	<?php if($flevel>=7.1){?>
                                        [7.0]:<font color="#F00"> <?=$pe0?> </font>个&nbsp;&nbsp;&nbsp;
                                        <?php }?>
                                    </span>
                                    <b>备注:</b><font color="red">开通返点级别为<b>【7.0】</b>以下的用户不需要开户配额。</font><br>
                                    <b>说明:</b><font color="red">用户成功添加后，可再次编辑返点。</font>                                </div>
                                <div class="user_ts">
                                    <span class="user_ts_title">您的返点级别：</span>
                                    <font color="#F00"><b><?=$flevel?></b></font>
                                    <span class="user_ts_title">用户返点: </span>
                                    <input type="text" name="keeppoint" id="keeppoint" style='width:45px;'/>
                                    <input type="hidden" name="keepmin" id="keepmin" value="0" />
                                    <input type="hidden" name="keepmax" id="keepmax" value="<?=$flevel2?>" /> % 
                                    <span class='helpinfo'>( 可填范围: 0～<?=$flevel2?> )</span>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input name='submit1' type="submit" value="执行开户" class="btn_next">
                                </div>
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