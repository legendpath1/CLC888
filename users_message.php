<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';
$_SESSION["mainframe"] = '"./users_message.php"';

if($_GET['act']=="del"){
	mysql_query("Delete from ssc_message where id=".$_GET['mid']);
	$_SESSION["backtitle"]="操作成功";
	$_SESSION["backurl"]="users_message.php";
	$_SESSION["backzt"]="success";
	$_SESSION["backname"]="消息列表";
	echo "<script language=javascript>window.location='sysmessage.php';</script>";
	exit;
}

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=15;
$page2=($page-1)*$pagesize;

$s1=$s1." order by id desc";
$sql="select * from ssc_message where username='" . $_SESSION["username"] . "'".$s1;
//echo $sql;
$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

$sql="select * from ssc_message where username='" . $_SESSION["username"] . "'".$s1." limit $page2,$pagesize";
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<head>
    <title>娱乐平台  - 消息列表</title>
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
</div><div class="top_menu">
    <div class="tm_left"></div>
    <div class="tm_title"></div>
    <div class="tm_right"></div>
    <div class="tm_menu">
        <a href="/users_info.php?check=">奖金详情</a>
        <a class="act" href="/users_message.php">我的消息</a>
        <a href="/account_banks.php?check=">我的银行卡</a>
        <a href="/account_update.php?check=">修改密码</a>
    </div>
</div>
<div class="rc_con betting">
    <div class="rc_con_lt"></div>
    <div class="rc_con_rt"></div>
    <div class="rc_con_lb"></div>
    <div class="rc_con_rb"></div>
    <h5><div class="rc_con_title">消息列表</div></h5>
    <div class="rc_con_to">
        <div class="rc_con_ti">            
            <div class="clear"></div>
            <div class="rc_list">
                <div class="rl_list">
                                <table class="lt" id="tabbar_txt__" border="0" cellspacing="0" cellpadding="0" width="100%">
                                    <tr>
                                        <th>消息标题</td>
                                        <th><div class='line'>时间</div></th>
                                        <th><div class='line'>类型</div></th>
                                        <th><div class='line'>状态</div></th>
                                        <th><div class='line'>操作</div></th>
                                    </tr>
<?php
  if($total==0){
?>
    <tr>
		<td colspan='5' class='no-records'><span>您现在还没有收到任何消息</span></td>
	</tr>
<?php
  }else{
	while ($row = mysql_fetch_array($rsnewslist)){
?>   
                                    <tr>
                                        <td align="center"><?=$row['topic']?></td>
                                        <td align="center"><?=$row['adddate']?></td>
                                        <td align="center"><?=$row['types']?></td>
                                        <td align="center"><?php if($row['zt']=="0"){?><font color=#ff3300>未读</font><?php }else{?>已读<?php }?></td>
                                        <td align="center"><a href="./users_messaged.php?mid=<?=$row['id']?>">查看</a>&nbsp;<a href='./users_message.php?mid=<?=$row['id']?>&act=del'>删除</a></td>
                                    </tr>
<?php }}?>

                                    <tr align="right">
                                        <td height="37" colspan="5"><ul class="pager">总计 <?=$total?> 条数据,  共 <?=$lastpg?> 页 , 当前第 <?=$page?> 页  |  <?php if($page>1){?><LI><A HREF="?page=1">首页</A></LI><LI><A HREF="?page=<?=$page-1?>">上页</A></LI><?php }?><?php for($i=$p1;$i<=$p2;$i++){
		if($i==$page){?><LI CLASS='current' ><A HREF="#"><?=$i?></A></LI><?php }else{?><LI><A HREF="?page=<?=$i?>"><?=$i?></A></LI><?php }}?><?php if($page!=$lastpg){?><LI><A HREF="?page=<?=$page+1?>">下页</A></LI><LI><A HREF="?page=<?=$lastpg?>">尾页</A></LI><?php }?> | 转至 <SCRIPT LANGUAGE="JAVASCRIPT">function keepKeyNum(obj,evt){var  k=window.event?evt.keyCode:evt.which; if( k==13 ){ goPage(obj.value);return false; }} function goPage( iPage ){ if( !isNaN(parseInt(iPage)) ) { if(iPage> <?=$lastpg?> ){iPage=<?=$lastpg?>;} window.location.href="?page="+iPage;}}</SCRIPT><INPUT onKeyPress="return keepKeyNum(this,event);" TYPE="TEXT" ID="iGotoPage" NAME="iGotoPage" size="3"> 页  &nbsp;<BUTTON onclick="javascript:goPage( document.getElementById('iGotoPage').value );return false;">GO</BUTTON>&nbsp;&nbsp;</ul></td>
                                    </tr>
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