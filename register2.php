<?php
session_start();
error_reporting(0);
require_once 'conn.php';

$flag=$_REQUEST['flag'];
if($flag=="confirm"){
	$sql = "select * from ssc_member WHERE id='" . $_REQUEST['id'] . "'";
	$rs = mysql_query($sql);
	$total = mysql_num_rows($rs);
	$row = mysql_fetch_array($rs);
	if($total==0){
		echo "<script language=javascript>alert('推荐人不存在！');window.location='sysmessage.php';</script>";
		exit;
	}
	//推荐人
	$comUser = $row['username'];

	if($_REQUEST['username']!="" && $_REQUEST['pwd']!="" && $_REQUEST['nickname']!=""){

		$sqla = "SELECT * FROM ssc_member where username='".$_REQUEST['username']."'";
		$rsa = mysql_query($sqla);
		$nums=mysql_num_rows($rsa);
		if($nums>0){
			echo "<script language=javascript>alert('用户名已存在！');window.location='register.php';</script>";
			exit;
		}

//		$modes="1;1;1;1;";
		$regtop=$row['regtop'];
		if($regtop==""){
			$regtop=$row['username'];
		}
		
		//远程注册
		if($SOPEN == 1)
		{
			$sapi_regResult = SAPI_Reg($_REQUEST['username'], $_REQUEST['pwd'],$comUser, $_REQUEST['nickname']);
			if ($sapi_regResult[0] != 'SUCCESS')
			{
				$_SESSION["backtitle"]=$sapi_regResult[1];
				$_SESSION["backurl"]="/register2.php?id=".$_REQUEST['id'];
				$_SESSION["backzt"]="failed";
				$_SESSION["backname"]="用户注册";
				echo "<script language=javascript>window.location='sysmessage.php';</script>";
				exit;
			}
		}
		
		$sql = "insert into ssc_member set username='" . $_REQUEST['username'] . "', password='" . md5($_REQUEST['pwd']) . "', nickname='" . $_REQUEST['nickname'] . "', regfrom='&" .$row['username']."&".$row['regfrom'] . "', regup='" . $row['username'] . "', regtop='" . $regtop . "', flevel='" . $row['xjlevel'] . "', level='0', regdate='" . date("Y-m-d H:i:s") . "', virtual='" . $row['virtual'] . "'";
		$exe = mysql_query($sql);

		
		$_SESSION["backtitle"]="操作成功";
		$_SESSION["backurl"]="index.php";
		$_SESSION["backzt"]="successed";
		$_SESSION["backname"]="用户登陆";
		echo "<script language=javascript>alert('操作成功！');window.location='sysmessage.php';</script>";
		exit;
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transition al.dtd">
<html>
    <head>
        <title>欢迎您加入 如意彩</title>
        <meta http-equiv="pragma" content="no-cache">
        <meta http-equiv="cache-control" content="no-cache">
        <meta http-equiv="expires" content="0">
        <style type="text/css">
            body {
                margin: 0;
                background-color: #B52311;
                background-image: url(images/reg/bg_01.jpg);
                background-repeat: no-repeat;
                background-position: center top;
            }
            .k {
                width: 984px;
                margin: 0 auto;
            }
            .foot {
                background-image: url(images/reg/a6_22.jpg);
                background-repeat: no-repeat;
                background-position: center center;
                height: 76px;
                margin-top: 15px;
            }
            img {
                border-top-width: 0px;
                border-right-width: 0px;
                border-bottom-width: 0px;
                border-left-width: 0px;
            }
            #apDiv1 {
                position: absolute;
                width: 33px;
                height: 36px;
                z-index: 1;
            }
            #apDiv2 {
                position: absolute;
                width: 933px;
                height: 21px;
                z-index: 1;
                left: 45px;
                top: 8px;
                color: #A01B10;
            }
            body,td,th {
                font-size: 12px;
            }
            #apDiv3 {
                position: absolute;
                width: 777px;
                height: 147px;
                z-index: 2;
                left: 101px;
                top: 246px;
                font-family: "微软雅黑";
                font-size: 16px;
                line-height: 37px;
            }
            #apDiv4 {
                position: absolute;
                width: 771px;
                height: 424px;
                z-index: 3;
                left: 102px;
                top: 474px;
                font-size: 16px;
                line-height: 30px;
                font-family: "微软雅黑";
            }
            .k #apDiv1 #apDiv4 strong {
                font-size: 18px;
                color: #830010;
            }
            #apDiv5 {
                position: absolute;
                width: 770px;
                height: 159px;
                z-index: 4;
                left: 102px;
                top: 977px;
                font-family: "微软雅黑";
                font-size: 16px;
                line-height: 28px;
            }
            .foot .k {
                line-height: 25px;
                color: #FFDFA0;
                text-align: center;
            }
            #apDiv6 {
                position: absolute;
                width: 69px;
                height: 53px;
                z-index: 1;
            }
            #apDiv7 {
                position: absolute;
                width: 596px;
                height: 449px;
                z-index: 1;
                left: 174px;
                top: 128px;
            }
            .bai {
                color: #FFF;
            }
            .huang {
                color: #FFDE00;
            }
            .bd {
                background-image: url(images/reg/dl_03.jpg);
                background-repeat: no-repeat;
                height: 25px;
                width: 179px;
                padding: 5px;
            }
            .bd input {
                color: #333;
                background-color: #E1D3BA;
                height: 18px;
                width: 170px;
                border-top-width: 0px;
                border-right-width: 0px;
                border-bottom-width: 0px;
                border-left-width: 0px;
                line-height: 18px;
                background-image: url(images/reg/bgbg.jpg);
                background-repeat: repeat-x;
            }
            .bd1 {
                background-image: url(images/reg/dlk_06.jpg);
                background-repeat: no-repeat;
                height: 25px;
                width: 179px;
                padding: 5px;
            }
            .bd1 input {
                color: #333;
                background-color: #E1D3BA;
                height: 18px;
                width: 170px;
                border-top-width: 0px;
                border-right-width: 0px;
                border-bottom-width: 0px;
                border-left-width: 0px;
                line-height: 18px;
                background-image: url(images/reg/bgbg.jpg);
                background-repeat: repeat-x;
            }
            .bd2 {
                background-image: url(images/reg/dlk_08.jpg);
                background-repeat: no-repeat;
                height: 25px;
                width: 179px;
                padding: 5px;
            }
            .bd2 input {
                color: #333;
                background-color: #E1D3BA;
                height: 18px;
                width: 170px;
                border-top-width: 0px;
                border-right-width: 0px;
                border-bottom-width: 0px;
                border-left-width: 0px;
                line-height: 18px;
                background-image: url(images/reg/bgbg.jpg);
                background-repeat: repeat-x;
            }
            .bd3 {
                background-image: url(images/reg/dlk_10.jpg);
                background-repeat: no-repeat;
                height: 25px;
                width: 179px;
                padding: 5px;
            }
            .bd3 input {
                color: #333;
                background-color: #E1D3BA;
                height: 18px;
                width: 170px;
                border-top-width: 0px;
                border-right-width: 0px;
                border-bottom-width: 0px;
                border-left-width: 0px;
                line-height: 18px;
                background-image: url(images/reg/bgbg.jpg);
                background-repeat: repeat-x;
            }
        </style>
        <SCRIPT>
            function copyqun(url) {
                window.clipboardData.setData('Text', url);
                alert('复制QQ成功！');
            }
            function copyqq(url) {
                window.clipboardData.setData('Text', url);
                alert('复制QQ群成功！');
            }
        </SCRIPT>
<SCRIPT type="text/javascript" src="js/jquery.js"></SCRIPT>
<SCRIPT type="text/javascript" src="js/jquery.md5.js"></SCRIPT>
<script language="javascript" type="text/javascript" src="js/common.js"></script>
        <script>
		
function refreshimg(){
document.getElementById("vcsImg").src="ValiCode_new.php?"+  new Date().getTime();
}

function LoginNow() 
{ 
   var username=$("#username").val();
   var nickname=$("#nickname").val();
    var typepw = $("#pwd").val();
    
    var randnum = $("#validcode_source").val();
	//$("#pwd")[0].value = '12345678901234567890';

	if( !validateUserName(username) )
	  {
	     alert("登陆帐号 不符合规则，请重新输入");
	     $("#username").focus();
		 return false;
	  }
	  if( !validateNickName(nickname) )
	  {
	  	alert("呢称 不符合规则，请重新输入");
	  	$("#nickname").focus();
		return false;
	  }
	
	 if( !validateUserPss(typepw) )
	 {
	  	alert("为了您的帐号安全,密码必须由数字和字母组成!\n不允许使用纯数字或纯字母做密码,请重新填写!");
	  	$("#pwd").focus();
		return false;
	 }
	 
    if (randnum == '') {
        alert('请填写 图片验证码');
        return false;
    }
  
   
    $("#loginpass")[0].value = typepw;
   
    document.forms['login'].submit();     
}

        </script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
    <body>
		<form name='login' method="post" action="?" onSubmit="javascript:LoginNow(); return false;">
					<input type="hidden" name="loginpass" id="loginpass">
					<input type="hidden" name="validcode" id="validcode">
					<input type="hidden" name="flag" value="confirm" />
					<input type="hidden" name="id" value="<?=$_GET['id']?>" />
        <div class="k"><img src="images/reg/a6_02.jpg" width="984" height="122" /></div>
        <div class="k"><img src="images/reg/a6_04.jpg" width="984" height="122" /></div>
        <div class="k"><img src="images/reg/a6_05.jpg" width="984" height="122" /></div>
        <div class="k">
            <div id="apDiv6">
                <div id="apDiv7">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td height="50"></td>
                  <td></td>
                            <td class="huang">&nbsp;</td>
                      </tr>

                        <tr>
                            <td width="22%" height="50" align="right" class="bai">游戏账号：</td>
                            <td width="34%"><div class="bd"><input type="text" id="username" name="username"/></div></td>
                            <td width="44%" class="huang">*由6-16个英文字母或数字组成</td>
                        </tr>
                        <tr>
                            <td height="50" align="right" class="bai"><p>游戏昵称：</p></td>
                            <td><div class="bd">
                                    <input type="text" id="nickname" name="nickname"/>
                                </div></td>
                            <td class="huang"><p>*由2-8个英文字母、汉字或数字组成</p></td>
                        </tr>
                        <tr>
                            <td height="50" align="right" class="bai">登陆密码：</td>
                            <td><div class="bd1">
                                    <input type="password" id="pwd" name="pwd"/>
                                </div></td>
                            <td class="huang">*由数字和字母组成6-16个字符；必须包含数字和字母，不允连续三位相同</td>
                        </tr>
                        <tr>
                            <td height="50" align="right" class="bai">注册验证：</td>
                            <td><div class="bd3">
                                    <input type="text" id="validate" name="validate" maxlength="4"/>
                                </div></td>
                            <td class="huang"><img id="vcsImg" src="ValiCode_New.php"  name="validate" align="absbottom" style="margin-left:6px;cursor:pointer; border: 1px solid #999" onClick="refreshimg()" alt="点击图片更新验证码"></td>
                        </tr>
                        <tr>
                            <td height="50"></td>
                  <td></td>
                            <td class="huang">&nbsp;</td>
                      </tr>
                        <tr>
                            <td height="50" colspan="3" align="center"><a href="#" onclick="location.reload();"><img src="images/reg/dl_07.jpg" width="104" height="41" /></a>  &nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="LoginNow();
                return false;"><img src="images/reg/dl_09.jpg" width="104" height="41" /></a></td>
                        </tr>
                    </table>
              </div>
            </div>
            <img src="images/reg/z_03.jpg" width="984" height="158" /></div>
        <div class="k"><img src="images/reg/z_05.jpg" width="984" height="159" border="0" /></div>
        <div class="k"><img src="images/reg/z_06.jpg" width="984" height="158" border="0" /></div>
        <div class="k"><img src="images/reg/z_07.jpg" width="984" height="158" /></div>
        <div class="foot">
            <div class="k">* 浏览器要求：请使用 IE6.0 或以上，或者火狐firefox，Flash Player 8 或以上并开启JavaScript;<br />
                * 声明：会员须遵守所在地国家或地区之法律，且年满18周岁，请不要沉迷于游戏.<br />
                * Copyright &copy; 2013 如意彩 版权所有 </div>
        </div>
		</form>
    </body>
</html>
