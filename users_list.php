<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';
$_SESSION["mainframe"] = '"./users_list.php"';

$frame=$_REQUEST['frame'];

if($frame=="team"){
	$sqls="select * from ssc_member where id='".$_REQUEST['uid']."'";
	$rss=mysql_query($sqls) or  die("数据库修改出错1");
	$rows = mysql_fetch_array($rss);
	echo "{error:0,result:".$rows['leftmoney']."}";
	exit;
}else if($frame=="menu"){
	$sqls="select * from ssc_member where regup='".Get_mname($_REQUEST['uid'])."'";
	$rss=mysql_query($sqls) or  die("数据库修改出错1");
	$nums=mysql_num_rows($rss);
	$i=0;
	echo "{\"result\":[";
	while ($rows = mysql_fetch_array($rss)){
		echo "{\"userid\":\"".$rows['id']."\",\"username\":\"".$rows['username']."\",\"usertype\":\"".$rows['level']."\",\"childcount\":\"".Get_xj($rows['username'])."\"}";
		if($i!=$nums-1){echo ",";}
		$i=$i+1;
	}
	echo "],\"error\":0}";
	exit;
}


$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=10;
$page2=($page-1)*$pagesize;

$uid = $_REQUEST['uid'];
$username = $_REQUEST['username'];
$usergroup = $_REQUEST['usergroup'];
$bank_min = $_REQUEST['bank_min'];
$bank_max = $_REQUEST['bank_max'];
$point_min = $_REQUEST['point_min'];
$point_max = $_REQUEST['point_max'];
$sortby = $_REQUEST['sortby'];
$sortbymax = $_REQUEST['sortbymax'];

if($usergroup!=""){
	$s1=$s1." and level='".$usergroup."'";
}

if($bank_min!=""){
	$s1=$s1." and leftmoney>='".$bank_min."'";
}

if($bank_max!=""){
	$s1=$s1." and leftmoney<='".$bank_max."'";
}

if($point_min!=""){
	$s1=$s1." and flevel>='".$point_min."'";
}

if($point_max!=""){
	$s1=$s1." and flevel<='".$point_max."'";
}

if($username!=""){
	$s1=$s1." and username='".$username."'";
}

if($uid!=""){
	$s1=$s1." and (regup='".$uid."' or username='".$uid."')";
	$sqla="select * from ssc_member where username='".$uid."'";
	$rsa = mysql_query($sqla);
	$rowa = mysql_fetch_array($rsa);
	$regfrom=explode("&&",$rowa['regfrom']);
	$dh="	 > ".$uid;
	for ($ia=0; $ia<count($regfrom); $ia++) {								
		$susername=str_replace("&","",$regfrom[$ia]);
		if($susername==$_SESSION["username"]){
			break;
		}
		$dh="	 > <a href='./users_list.php?uid=".$susername."' style='color:#222; '>".$susername."</a>".$dh;
	}
}else{
	if($_REQUEST['flag']=="search"){
		$s1=$s1." and regfrom like '%&".$_SESSION["username"]."&%'";
	}else{
		$s1=$s1." and regup='".$_SESSION["username"]."'";
	}
}

if($sortby==""){
	$sortby="id";
}

if($sortbymax=="1"){
	$sortbys="desc";
}else{
	$sortbys="asc";
}

$urls="bank_min=".$bank_min."&bank_max=".$bank_max."&username=".$username."&usergroup=".$usergroup."&uid=".$uid;
$s1=$s1." order by ".$sortby." ".$sortbys;
$sql="select * from ssc_member where 1=1".$s1;
//echo $sql;
$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

$sql="select * from ssc_member where 1=1".$s1." limit $page2,$pagesize";
$rsnewslist=mysql_query($sql);

$lastpg=ceil($total/$pagesize); //最后页，也是总页数
$page=min($lastpg,$page);
$prepg=$page-1; //上一页
$nextpg=($page==$lastpg ? 0 : $page+1); //下一页

if($page<5){
	$p1=1;
	$p2=min($lastpg,10);
}else{
	$p2=min($lastpg,$page+5);
	$p1=max($p2-9,1);
}


function exchange($number){
	$arr=array("零","一","二","三","四","五","六","七","八","九");
	if(strlen($number)==1){
		$result=$arr[$number];
	}else{
		if($number<20){
			$result="十";
		}else{
			$result=$arr[substr($number,0,1)]."十";
		}
		if(substr($number,1,1)!="0"){
			$result.=$arr[substr($number,1,1)]; 
		}
	}
	return $result;
}
//echo exchange(15);
	$czzt=Get_member(czzt);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<head>
    <title>娱乐平台  - 用户列表</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
        <script>var pri_imgserver = '';</script>
        <link href="./css/v1/all.css?modidate=20130201001" rel="stylesheet" type="text/css" />
    <link href="./js/calendar/css/calendar-blue2.css?modidate=20130201001" rel="stylesheet" type="text/css" />
    <script language="javascript" type="text/javascript" src="./js/jquery.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/common.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/lottery/min/message.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/calendar/jquery.dyndatetime.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/calendar/lang/calendar-utf8.js?modidate=20130415002"></script>
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
</div><script language="javascript">
    $(function(){
        $("#usermenutitle").click(function(){
            if($(this).attr("title")=='显示用户'){
                $(this).attr("title","隐藏用户");
                $("#user_box_in").show();
                $(".usermenulist").css("background-position","0 top");
                $(this).css("background-position","0 bottom");
                $(this).css("color","#FFF");
            }else{
                $(this).attr("title","显示用户");
                $("#user_box_in").hide();
                $(".usermenulist").css("background-position","-50px top");
                $(this).css("background-position","-50px bottom");
                $(this).css("color","#333");
            }
        });
        $("#usermenutitle").mouseover(function(){
            if($(this).attr("title")=='显示用户'){
                $(".usermenulist").css("background-position","0 top");
                $(this).css("background-position","0 bottom");
                $(this).css("color","#FFF");
            }
        }).mouseout(function(){
            if($(this).attr("title")=='显示用户'){
                $(".usermenulist").css("background-position","-50px top");
                $(this).css("background-position","-50px bottom");
                $(this).css("color","#333");
            }
        });
    });
    function getTeamBank(obj,uid){if(jQuery(obj).closest("tr").next(".showteam").html()!=null){jQuery(obj).closest("tr").next(".showteam").show();}else{var html='<tr class="showteam"><td height="20" colspan=5>&nbsp;</td><td align="center"><span>正在读取数据....</span></td></tr>';jQuery(obj).closest("tr").after(html);jQuery.ajax({type:"GET",url:"./users_list.php?frame=team&uid="+uid,dataType:"json",cache:false,success:function(data){jQuery(obj).closest("tr").next(".showteam").find("span").html(data.error);if(data.error=="error"){jQuery(obj).closest("tr").next(".showteam").find("span").html('抱歉, 您没有权限&nbsp;&nbsp;<a href="javascript:" style="color:#CF0;" onclick="hideTeam(this)">[关闭]</a>');}else{if(data.error=="0"){jQuery(obj).closest("tr").next(".showteam").find("span").html('团队余额: <font color="green">'+moneyFormat(data.result)+'</font>&nbsp;游戏币&nbsp;&nbsp;<a href="javascript:" style="color:blue;" onclick="hideTeam(this)">[关闭]</a>');}else{return true;}}}});}}function hideTeam(obj){jQuery(obj).closest("tr").hide();}
</script>
<div class="rc_con user_list">
<div class="usermenulist">
    <div class="usermenutitle" id="usermenutitle" title="显示用户">全<br>部<br>下<br>级<br> <br>用<br>户<br>名<br></div>
    <div class="user_box_in" id="user_box_in">
        <iframe name="userlist_menu" id="userlist_content" frameborder="0" width="100%" height="100%" scrolling="auto" src="./users_listm.php"></iframe>
    </div>
</div>
<div class="rc_con_lt"></div>
<div class="rc_con_rt"></div>
<div class="rc_con_lb"></div>
<div class="rc_con_rb"></div>
<div><a class="title_menu1" href="/users_autoregisterset.php">自动注册设置</a></div><div><a class="title_menu act" href="/users_add.php">增加用户</a></div>
<h5><div class="rc_con_title">用户列表</div></h5>
<div class="rc_con_to">
<div class="rc_con_ti">
    <div class="betting_input">
        <table class='st' border="0" cellspacing="0" cellpadding="0">
            <form action="" method="get" name="search" onSubmit="return checkForm(this)">
                <input type="hidden" name="frame" value="show" />
                <input type="hidden" name="flag" value="search" />
                <tr>
                    <td width='200'>
                        用户名: <input type="text" size="16" name="username" value="" />
                    </td>
                    <td>
                        账户余额: <input type="text" size="10" name="bank_min" value="" onKeyUp="checkMoney(this)" /> 至 <input type="text" size="10" name="bank_max" value="" onKeyUp="checkMoney(this)" />
                        &nbsp;&nbsp;&nbsp;&nbsp;排序：<select name="sortby">
                            <option value="id" >默认排序</option>
                            <option value="username" >用户名</option>
                            <option value="leftmoney" >账户余额</option>
                            <option value="flevel" >返点级别</option>
                        </select>
                        <label><input type="checkbox" name="sortbymax" value="1"   />从大到小</label>      
                    </td>
                </tr>
                <tr>
                    <td>
                        用户级别: 
                        <select name="usergroup" style="width:100px; height:20px;">
                            <option value="">请选择..</option>
                            <option value="1">代理用户</option>
                            <option value="0">会员用户</option>
                        </select>
                    </td>
                    <td>
                        返点级别：
                        <input type="text" size="10" name="point_min" value="" onKeyUp="checkMoney(this)" /> 至 <input type="text" size="10" name="point_max" value="" onKeyUp="checkMoney(this)" />
                        &nbsp;&nbsp;&nbsp;
                                                <button name="submit" type="submit" width='69' height='26' class="btn_search" /></button>
                    </td>
                </tr>
            </form>
        </table>
    </div>
<div class="rc_list">
<div class="rl_list">
    <div class="rc_m_til">
        &nbsp;&nbsp;<a href="./users_list.php?frame=show">我的用户</a><?=$dh?>    </div>
    <table class="lt" border="0" cellspacing="0" cellpadding="0" width="100%">
        <form action="./" method="post">
            <tr>
                <th><div>用户名</div></td>
                <th><div class='line'>用户级别</div></th>
                <th><div class='line'>余额</div></th>
                                <th><div class='line'>返点级别</div></th>
                <th><div class='line'>注册时间</div></th>
                <th><div class='line'>状态</div></th>
                <th><div class='line'>在线</div></th>
                <th><div class='line'>银行</div></th>
                <th><div class='line'>操作</div></th>
            </tr>
<?php
if($total==0){
?>
    <tr class="needchangebg" align="center">
        <td colspan="9" class='no-records'><span>没有找到指定条件的记录.</span></td>
    </tr>
<?php
}else{
	while ($row = mysql_fetch_array($rsnewslist)){
	$regfrom=explode("&&",$row['regfrom']);
	for ($ia=0; $ia<count($regfrom); $ia++) {								
		$ib=$ia;
		$susername=str_replace("&","",$regfrom[$ia]);
		if($susername==$_SESSION["username"]){
			break;
		}
	}
?>    
            <tr  class="<?php if($row['username']==$uid){echo "self_tr";}else{echo "needchangebg";}?>" >
                <td align="center" height="20"><a href="./users_list.php?uid=<?=$row['username']?>" style="color:#003399;"><?=$row['username']?></a></td>
                <td align="center"><?php if($row['level']==0){echo "会员用户";}else{echo exchange($ib+1)."级代理";}?></td>
                <td align="center"><?=number_format($row['leftmoney'],2)?></td>
                <td align="center"><?=$row['flevel']?></td>
                <td align="center"><?=$row['regdate']?></td>
                <td align="center"><font color="green"><?php if($row['zt']==1){echo "冻结";}elseif($row['zt']==2){echo "锁定";}else{echo "正常";}?></font></td>
                <td align="center"><img src='images/USER_<?php echo Get_online($row['username'])?>.gif'></td>
                <td align="center"><img src='images/CARD_<?php echo Get_card($row['username'])?>.png'></td>
                <td align="center">
                <?php if($czzt=="1"){?><a href="./users_saveup.php?uid=<?=$row['id']?>">充值</a><?php }?>
                <?php if($row['regup']==$_SESSION["username"] || $_SESSION["level"]=="2"){?><a href="./users_update.php?uid=<?=$row['id']?>"><a href="./users_update.php?uid=<?=$row['id']?>">返点编辑</a><?php }?>
                <a href="./report_list.php?username=<?=$row['username']?>&isrequery=1">帐变</a>
                <?php if($row['flevel']>=6.3 && $ib==0){?><a href="./users_addaccount.php?uid=<?=$row['id']?>"><font color="red">开户额</font></a><?php }?>
                <a href="javascript:" onclick="getTeamBank(this,<?=$row['id']?>)">团队余额</a>
                <?php if($czzt=="1" && $row['level']!=0 && $ib==0){?><?php if($row['czzt']!="1"){?><a href="./users_editupsave.php?uid=<?=$row['id']?>&flag=open" onclick="return confirm('确定要开通此用户的代充功能吗?')">开通充值</a><?php }else{?><a href="./users_editupsave.php?uid=<?=$row['id']?>&flag=close" onclick="return confirm('确定要关闭此用户的代充功能吗?\n如果关闭，将关闭此用户和其所有下级的代充功能')">关闭充值</a><?php }?><?php }?>
                </td>
            </tr>
<?php }}?>

            <tr>
                <td class='b' colspan="9">
                    <div style='text-align:right;'><ul class="pager">总计 <?=$total?> 条数据,  共 <?=$lastpg?> 页 , 当前第 <?=$page?> 页  |  <?php if($page>1){?><LI><A HREF="?<?=$urls?>&page=1">首页</A></LI><LI><A HREF="?<?=$urls?>&page=<?=$page-1?>">上页</A></LI><?php }?><?php for($i=$p1;$i<=$p2;$i++){
		if($i==$page){?><LI CLASS='current' ><A HREF="#"><?=$i?></A></LI><?php }else{?><LI><A HREF="?<?=$urls?>&page=<?=$i?>"><?=$i?></A></LI><?php }}?><?php if($page!=$lastpg){?><LI><A HREF="?<?=$urls?>&page=<?=$page+1?>">下页</A></LI><LI><A HREF="?<?=$urls?>&page=<?=$lastpg?>">尾页</A></LI><?php }?> | 转至 <SCRIPT LANGUAGE="JAVASCRIPT">function keepKeyNum(obj,evt){var  k=window.event?evt.keyCode:evt.which; if( k==13 ){ goPage(obj.value);return false; }} function goPage( iPage ){ if( !isNaN(parseInt(iPage)) ) { if(iPage> <?=$lastpg?> ){iPage=<?=$lastpg?>;} window.location.href="?<?=$urls?>&page="+iPage;}}</SCRIPT><INPUT onKeyPress="return keepKeyNum(this,event);" TYPE="TEXT" ID="iGotoPage" NAME="iGotoPage" size="3"> 页  &nbsp;<BUTTON onclick="javascript:goPage( document.getElementById('iGotoPage').value );return false;">GO</BUTTON>&nbsp;&nbsp;</ul></div>
                </td>
            </tr>
            </form>
        </table>
</div>
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