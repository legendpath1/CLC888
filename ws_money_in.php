<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';
$_SESSION["mainframe"] = '"./ws_money_in.php"';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<head>
    <title>娱乐平台  - 网站间转账</title>
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
<?php
if($SOPEN != 1){
	echo '未开启网站间转账！';
	exit();
}

//查询
$sql = "select * from ssc_member WHERE username='" . $_SESSION["username"] . "'";
$rs = mysql_fetch_array(mysql_query($sql));
if(!$rs){FHintAndBack('抱歉，未找到您的会员资料');}

if($_GET['clause'] == 'saveinfo')
{

	//验证资金密码
	$pwdSuccess = false;
	$pwd2 = $_POST['pwd2'];	
	if(md5($pwd2)==$rs['cwpwd']){
		$pwdSuccess = true;
	}
	else
	{
		//远程api
		if($SOPEN == 1)
		{
			$arr = SAPI_GetMemberInfo($_SESSION["username"]);
			if($arr['username'] != '' && $arr['password2'] != '')
			{
				if(strtolower($arr['password2']) != $rs['cwpwd'] && strlen($arr['password2']) == 32)
				{
					$sql = "update ssc_member set cwpwd='" . strtolower($arr['password2']) . "' where username='" . $arr['username'] . "'";
					mysql_query($sql);
					
					if(strtolower($arr['password2'])==md5($pwd2)){
						$pwdSuccess = true;
					}
				}
			}
		}
	}
	if($pwdSuccess == false)
	{
		FHintAndBack('抱歉，资金密码错误，兑换失败！');
	}


	$cz_zztype = (int)$_POST['cz_zztype'];
	if($cz_zztype <= 0)
	{
		FHintAndBack('请选择转账类型');
	}

	$real_money = (int)$_POST['real_money'];
	if($real_money <= 0)
	{
		FHintAndBack('转入或转出金额至少为1');
	}
	
	/*
	$arr = SAPI_GetMemberGolds($_SESSION["username"]);
	if($arr['Score'] == '' || $arr['YuanGold'] == '')
	{
		FHintAndBack('api发生错误，请重新提交！');
	}
	
	$yuan = (int)($arr['Score'] / $arr['YuanGold']);
	if($real_money > $yuan)
	{
		FHintAndBack('抱歉，您的游戏币不足');
	}
	*/
	
	//变量
	$username = $_SESSION["username"];
	$num = $real_money;
	
	//本站现有余额
	$leftmoney = (float)$rs['leftmoney'];
	
	//远程执行扣款
	if($cz_zztype == 1)
	{
		//转入，本站增加
		$overmoney = $leftmoney + $num;
		$sql = "update ssc_member set leftmoney = leftmoney + " . $num . " WHERE username='" . $username . "'";
		$sqlfield = 'smoney';
	
		//转入，远程扣除
		$arr = SAPI_ChangeGold_Gold($_SESSION["username"],0 - $num);
	}
	else
	{
		//转出，本站扣除
		$overmoney = $leftmoney - $num;
		$sql = "update ssc_member set leftmoney = leftmoney - " . $num . " WHERE username='" . $username . "'";
		$sqlfield = 'zmoney';
		//判断是否够扣
		if($overmoney < 0)
		{
			FHintAndBack('抱歉，您在本站的余额不足！');
		}
		
		//转出，远程增加
		$arr = SAPI_ChangeGold_Gold($_SESSION["username"],$num);
	}
	if($arr['state'] != 'SUCCESS')
	{
		FHintAndBack($arr['tips']);
	}
	
	//本站更新
	mysql_query($sql);
	
	//本站账变
	$sql = "select * from ssc_record order by id desc limit 1";
	$rs1 = mysql_fetch_array(mysql_query($sql));
	$dan = sprintf("%07s",strtoupper(base_convert($rs1['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));
	$sql="insert into ssc_record set dan='" . $dan . "',tag = '网站间转账', uid='".$rs['id']."', username='".$rs['username']."', types='999', " . $sqlfield . "=".abs($num).",leftmoney=".$overmoney.", regtop='".$rs['regtop']."', regup='".$rs['regup']."', regfrom='".$rs['regfrom']."', adddate='".date("Y-m-d H:i:s")."',virtual='" .$rs['virtual']. "'";
	mysql_query($sql);
	
	FHintAndTurn('转账成功！','?');
}
?>
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
<div class="top_menu">
    <div class="tm_left"></div>
    <div class="tm_title"></div>
    <div class="tm_right"></div>
    <div class="tm_menu">
        <a href="/account_drawlist.php?check=">提现记录</a>
        <a href="/account_draw.php?check=">平台提现</a>
        <a href="/account_savelist.php?check=">充值记录</a>
        <a href="/account_autosavea.php?check=">在线充值</a>
        <a class="act" href="/ws_money_in.php">网站间转账</a>
    </div>
</div>
<div class="rc_con pay">
    <div class="rc_con_lt"></div>
    <div class="rc_con_rt"></div>
    <div class="rc_con_lb"></div>
    <div class="rc_con_rb"></div>
    <h5><div class="rc_con_title">网站间转账</div></h5>
    <div class="rc_con_to">
        <div class="rc_con_ti">
            <table width="100%" class="ct" border="0" cellspacing="0" cellpadding="0">
                <form action="?clause=saveinfo" method="post" name="drawform" id="drawform">
                    <input type="hidden" name="flag" value="confirm" />
                    <tr>
                        <td class="nl"><font color="#FF3300">说明:</font></td>
                        <td STYLE='line-height:23px;padding:5px 0px'>
							<?php
							echo('如果您在 Q站 <a href="' . $WEBURL_QP . '" target="_blank" style="color:#0000CC;text-decoration:underline;">' . $WEBURL_QP . '</a> 的通行证帐号 ' . $_SESSION["username"] . ' 有余额，允许您将余额转入到本站中使用。<br />');
							?>
                        </td>
                    </tr>
                    <tr>
                        <td class="nl">兑换率: </td>
                        <td style='height:40px;' id="id_YuanGold">(<img src="/images/loader.gif" align="absmiddle" />数据载入中..)</td>
                    </tr>
                    <tr>
                        <td class="nl">Q站余额: </td>
                        <td style='height:40px;' id="id_Score">(<img src="/images/loader.gif" align="absmiddle" />数据载入中..)</td>
                    </tr>
                    <tr>
                        <td class="nl">本站余额: </td>
                        <td style='height:40px;'><?php
						echo $rs['leftmoney'];
						?>元</td>
                    </tr>
                    <tr>
                        <td class="nl">操作类型: </td>
                        <td style='height:40px;'>
						<select name="cz_zztype">
						<option value="0">-=请选择转账类型=-</option>
						<option value="1">转入 到本站</option>
						<option value="2">从本站 转出</option>
						</select> &nbsp;&nbsp;<span style="color:red;">*</span>  </td>
                    </tr>
                    <tr>
                        <td class="nl">操作金额: </td>
                        <td style='height:40px;'><input type="text" name="real_money" id="real_money" maxlength="5" />
                            &nbsp;&nbsp;<span style="color:red;">*</span> (单位：元，必须整数) </td>
                    </tr>
                    <tr>
                        <td class="nl">资金密码: </td>
                        <td style='height:40px;'><input type="password" name="pwd2" id="pwd2" maxlength="16" /> &nbsp;&nbsp;<span style="color:red;">*</span> </td>
                    </tr>
                    <tr>
                        <td class="nl"></td>
                        <td height="30"><br/><input name="submit" type="submit" value="确定转入" width='69' height='26' class="btn_next" />
                            &nbsp;&nbsp;&nbsp;&nbsp;<br/><br/></td>
                    </tr>
                </form>
            </table>
            <div class="clear"></div>
        </div>
    </div>
</div>
<script>
getKeyBoard($('#pwd2'));
</script>
<?php
//远程数据api
$sapi_url = Create_SAPI_Url($_SESSION["username"], '', '', '', 0, 'getmember_gold&cb=SAPI_Callback');
?>
<script language="javascript">
function SAPI_Callback(json)
{
	//Score
	//InsureScore
	//YuanGold
	//UserMedal
	
	var yuan = parseInt(json.Score / json.YuanGold);
	
	$('#id_Score').html(json.Score + '游戏币，取整合：' + yuan + '元');
	$('#id_YuanGold').html('1元 = ' + json.YuanGold + '游戏币');
}
function SAPI_GetGold()
{
	$.ajax({
		type : "get",
		async : true,
		url : "<?php echo $sapi_url; ?>&rnd=" + (new Date()),
		dataType : "jsonp",
		jsonp: "callback",
		jsonpCallback:"SAPI_Callback",
		error:function(){
			alert("检测失败，请重新进入本页面！");
		}
	});
}
SAPI_GetGold();
</script>
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