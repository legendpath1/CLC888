<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$flag=$_REQUEST['flag'];

$sql = "select * from ssc_member where username='".$_SESSION["username"]."'";
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs);

if($flag=="changepass"){
	$changetype=$_REQUEST['changetype'];
	if($changetype=="loginpass"){
		if($_REQUEST['newpass']=="" || $_REQUEST['confirm_newpass']==""){
			echo "<script>alert('请填写新密码和确认密码');window.location.href='account_update.php';</script>"; 
			exit;
		}
		if($_REQUEST['newpass']!=$_REQUEST['confirm_newpass']){
			echo "<script>alert('新密码和确认密码不一致');window.location.href='account_update.php';</script>"; 
			exit;
		}
		if(strlen($_REQUEST['newpass'])<6 || strlen($_REQUEST['newpass'])>16 || preg_match('/(.+)\\1{2}/',$_REQUEST['newpass'])){
			echo "<script>alert('密码不符合规则');window.location.href='account_update.php';</script>"; 
			exit;
		}

		if($_REQUEST['oldpass']==""){
			echo "<script>alert('请输入原始密码');window.location.href='account_update.php';</script>"; 
			exit;
		}

		if($_REQUEST['oldpass']==$_REQUEST['newpass']){
				$_SESSION["backtitle"]="登陆密码修改失败，新密码可能和原来密码一样";
				$_SESSION["backurl"]="account_update.php";
				$_SESSION["backzt"]="failed";				
				$_SESSION["backname"]="返回上一页";
				echo "<script language=javascript>window.location='sysmessage.php';</script>";
				exit;
		}
		if(md5($_REQUEST['oldpass'])==$row['password']){
			if(md5($_REQUEST['newpass'])==$row['cwpwd']){
				$_SESSION["backtitle"]="登陆密码不能和资金密码一样";
				$_SESSION["backurl"]="account_update.php";
				$_SESSION["backzt"]="failed";				
				$_SESSION["backname"]="返回上一页";
				echo "<script language=javascript>window.location='sysmessage.php';</script>";
				exit;
			}else{
				
				
				//远程api
				if($SOPEN == 1)
				{
					$arr = SAPI_ChangePassword($_SESSION["username"],md5($_REQUEST['oldpass']),md5($_REQUEST['newpass']));
					if($arr['state'] != 'SUCCESS')
					{
						echo "<script language='javascript'>alert('" . $arr['tips'] . "');history.go(-1);</script>";
						exit;
					}
				}			
			
			
				$sql="update ssc_member set password='".md5($_REQUEST['newpass'])."' where username ='".$_SESSION["username"]."'";
				$exe=mysql_query($sql) or  die("数据库修改出错!!!!");
				amend("修改登录密码");
				$_SESSION["backtitle"]="登录密码修改成功";
				$_SESSION["backurl"]="account_update.php";
				$_SESSION["backzt"]="successed";				
				$_SESSION["backname"]="返回上一页";
				echo "<script language=javascript>window.location='sysmessage.php';</script>";
				exit;
			}
		}else{
				$_SESSION["backtitle"]="原始密码错误";
				$_SESSION["backurl"]="account_update.php";
				$_SESSION["backzt"]="failed";				
				$_SESSION["backname"]="返回上一页";
				echo "<script language=javascript>window.location='sysmessage.php';</script>";
				exit;
		}
	}else if($changetype=="secpass"){
		if($_REQUEST['newpass']=="" || $_REQUEST['confirm_newpass']==""){
			echo "<script>alert('请填写新密码和确认密码');window.location.href='account_update.php';</script>"; 
			exit;
		}
		if($_REQUEST['newpass']!=$_REQUEST['confirm_newpass']){
			echo "<script>alert('新密码和确认密码不一致');window.location.href='account_update.php';</script>"; 
			exit;
		}
		if(strlen($_REQUEST['newpass'])<6 || strlen($_REQUEST['newpass'])>16 || preg_match('/(.+)\\1{2}/',$_REQUEST['newpass'])){
			echo "<script>alert('密码不符合规则');window.location.href='account_update.php';</script>"; 
			exit;
		}
		if($row['cwpwd']==""){
			if(md5($_REQUEST['newpass'])==$row['password']){
					$_SESSION["backtitle"]="资金密码不能和登陆密码一样";
					$_SESSION["backurl"]="account_update.php";
					$_SESSION["backzt"]="failed";				
					$_SESSION["backname"]="返回上一页";
					echo "<script language=javascript>window.location='sysmessage.php';</script>";
					exit;
			}else{
			
			
				//远程api
				if($SOPEN == 1)
				{
					$arr = SAPI_ChangePassword2($_SESSION["username"],'',md5($_REQUEST['newpass']));
					if($arr['state'] != 'SUCCESS')
					{
						echo "<script language='javascript'>alert('" . $arr['tips'] . "');history.go(-1);</script>";
						exit;
					}
				}	
			
			
			
				$sql="update ssc_member set cwpwd='".md5($_REQUEST['newpass'])."' where username ='".$_SESSION["username"]."'";
				$exe=mysql_query($sql) or  die("数据库修改出错!!!!");
				amend("设置资金密码");
				$_SESSION["backtitle"]="资金密码修改成功";
				$_SESSION["backurl"]="account_update.php";
				$_SESSION["backzt"]="successed";				
				$_SESSION["backname"]="返回上一页";
				echo "<script language=javascript>window.location='sysmessage.php';</script>";
				exit;
			}
		}else{
			if($_REQUEST['oldpass']==""){
				echo "<script>alert('请输入原始密码');window.location.href='account_update.php';</script>"; 
				exit;
			}
			if($_REQUEST['oldpass']==$_REQUEST['newpass']){
					$_SESSION["backtitle"]="资金密码修改失败，新密码可能和原来密码一样";
					$_SESSION["backurl"]="account_update.php";
					$_SESSION["backzt"]="failed";				
					$_SESSION["backname"]="返回上一页";
					echo "<script language=javascript>window.location='sysmessage.php';</script>";
					exit;
			}
			if(md5($_REQUEST['oldpass'])==$row['cwpwd']){
				if(md5($_REQUEST['newpass'])==$row['password']){
					$_SESSION["backtitle"]="资金密码不能和登陆密码一样";
					$_SESSION["backurl"]="account_update.php";
					$_SESSION["backzt"]="failed";				
					$_SESSION["backname"]="返回上一页";
					echo "<script language=javascript>window.location='sysmessage.php';</script>";
					exit;
				}else{
				
					//远程api
					if($SOPEN == 1)
					{
						$arr = SAPI_ChangePassword2($_SESSION["username"],'',md5($_REQUEST['newpass']));
						if($arr['state'] != 'SUCCESS')
						{
							echo "<script language='javascript'>alert('" . $arr['tips'] . "');history.go(-1);</script>";
							exit;
						}
					}	
			
					$sql="update ssc_member set cwpwd='".md5($_REQUEST['newpass'])."' where username ='".$_SESSION["username"]."'";
					$exe=mysql_query($sql) or  die("数据库修改出错!!!!");
					amend("修改资金密码");
					$_SESSION["backtitle"]="资金密码修改成功";
					$_SESSION["backurl"]="account_update.php";
					$_SESSION["backzt"]="successed";				
					$_SESSION["backname"]="返回上一页";
					echo "<script language=javascript>window.location='sysmessage.php';</script>";
					exit;
				}
			}else{
					$_SESSION["backtitle"]="资金密码错误";
					$_SESSION["backurl"]="account_update.php";
					$_SESSION["backzt"]="failed";				
					$_SESSION["backname"]="返回上一页";
					echo "<script language=javascript>window.location='sysmessage.php';</script>";
					exit;
			}
		}
	}else if($changetype=="loginmsg"){
//		if($_REQUEST['logmsg']!=""){
			amend("修改昵称");
			$sql="update ssc_member set nickname='".$_REQUEST['logmsg']."' where username ='".$_SESSION["username"]."'";
			$exe=mysql_query($sql) or  die("数据库修改出错!!!!");
			$_SESSION["backtitle"]="呢称修改成功";
			$_SESSION["backurl"]="account_update.php";
			$_SESSION["backzt"]="successed";				
			$_SESSION["backname"]="返回上一页";
			echo "<script language=javascript>window.location='sysmessage.php';</script>";
			exit;
//		}
	}
	

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<head>
    <title>娱乐平台  - 修改密码</title>
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
        getKeyBoard($('#oldpass'));
        getKeyBoard($('#newpass'));
        getKeyBoard($('#confirm_newpass'));
        getKeyBoard($('#securityoldpass'));
        getKeyBoard($('#securitynewpass'));
        getKeyBoard($('#confirm_securitynewpass'));
    });
</script>
<script type="text/javascript">
    function checkform(obj)
    {
        if( !validateNickName(obj.nickname.value) ){
            alert("呢称不符合规则，请重新输入");
            obj.nickname.focus();
            return false;
        }
        if( !validateUserPss(obj.newpass.value) ){
            alert("密码不符合规则，请重新输入");
            obj.newpass.focus();
            return false;
        }
        if( obj.newpass.value != obj.confirm_newpass.value ){
            alert("两次输入密码不相同");
            obj.newpass.focus();
            return false;
        }
        if( obj.oldpass == "" ){
            alert("请输入原始密码");
            obj.oldpass.focus();
            return false;
        }
        return true;
    }
</script>
<div class="top_menu">
    <div class="tm_left"></div>
    <div class="tm_title"></div>
    <div class="tm_right"></div>
    <div class="tm_menu">
        <a href="/users_info.php?check=">奖金详情</a>
        <a href="/users_message.php">我的消息</a>
        <a href="/account_banks.php?check=">我的银行卡</a>
        <a class="act" href="/account_update.php?check=">修改密码</a>
    </div>
</div>
<div class="rc_con binding">
    <div class="rc_con_lt"></div>
    <div class="rc_con_rt"></div>
    <div class="rc_con_lb"></div>
    <div class="rc_con_rb"></div>
    <h5><div class="rc_con_title">修改密码</div></h5>
    <div class="rc_con_to">
        <div class="rc_con_ti">
            <div class="binding_input">
                <form action="" method="post" name="changepass" onsubmit="return checkform(this)">
                    <table class="ct" border="0" cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                            <td align='right' class="nl_title">&nbsp; A. 修改登陆密码</td>
                            <td></td>
                        </tr>
                                                <tr>
                            <td class="nl">输入旧登陆密码: </td>
                            <td>
                                <input type="password" name="oldpass"  id="oldpass"/>
                            </td>
                        </tr>
                                                <tr>
                            <td class="nl">输入新登陆密码: </td>
                            <td><input type="password" name="newpass" id="newpass"/><span class="pop"><s class="pop-l"></s><span>( 由字母和数字组成6-16个字符；且必须包含数字和字母，不允许连续三位相同，不能和资金密码相同 ) </span><s class="pop-r"></s></span></td>
                        </tr>
                        <tr>
                            <td class="nl">确认新登陆密码: </td>
                            <td>
                                <input type="password" name="confirm_newpass" id="confirm_newpass"/></td></tr><tr><td></td><td>
                                <input  value="提交" name="submit" type="submit" width='69' height='26' class="btn_submit" />
                                <input type="hidden" name="check" value="" />
                                <input type="hidden" name="flag" value="changepass" />
                                <input type="hidden" name="changetype" value="loginpass" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="clear"></div>
                        <div class="binding_input">
                <form action="" method="post" name="changepass" onsubmit="return checkform(this)">
                    <table class="ct" border="0" cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                            <td align='right' class="nl_title">&nbsp; B. 修改资金密码</td>
                            <td></td>
                        </tr>
<?php if($row["cwpwd"]!=""){?>
                        <tr>
                            <td class="nl">输入旧资金密码: </td>
                            <td>
                                <input type="password" name="oldpass"  id="securityoldpass"/>
                            </td>
                        </tr>
<?php }?>
		                <tr>
                            <td class="nl">输入新资金密码: </td>
                            <td>
                                <input type="password" name="newpass" id="securitynewpass"/><span class="pop"><s class="pop-l"></s><span>( 由字母和数字组成6-16个字符；且必须包含数字和字母，不允许连续三位相同，不能和登陆密码相同 ) </span><s class="pop-r"></s></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="nl">确认新资金密码: </td>
                            <td>
                                <input type="password" name="confirm_newpass"  id="confirm_securitynewpass"/></td></tr><tr><td></td><td>
                                <input name="submit" value="提交" type="submit" width='69' height='26' class="btn_submit" />
                                <input type="hidden" name="check" value="" />
                                <input type="hidden" name="flag" value="changepass" />
                                <input type="hidden" name="changetype" value="secpass" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            
                        <div class="clear"></div>
                        <div class="binding_input">
                <form action="" method="post" name="changepass">
                    <table class="ct" border="0" cellspacing="0" cellpadding="0" width="100%">
                         <tr>
                            <td align='right' class="nl_title">&nbsp; C. 修改呢称</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="nl">呢称: </td>
                            <td>
                                <input type="text" maxlength='50' style='color:#f33;height:25px;line-height:25px;width:360px;padding-left:3px;' name="logmsg" value='<?=$row["nickname"]?>'/>
                                <span class="pop"><s class="pop-l"></s><span>( 由2-8个英文字母、汉字或数字组成 ) </span><s class="pop-r"></s></span>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input name="submit" value="提交" type="submit" width='69' height='26' class="btn_submit" />
                                <input type="hidden" name="check" value="" />
                                <input type="hidden" name="flag" value="changepass" />
                                <input type="hidden" name="changetype" value="loginmsg" />
                            </td>
                        </tr>
                    </table>
                </form>
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