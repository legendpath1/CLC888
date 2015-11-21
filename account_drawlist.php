<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

if($_REQUEST['check']!="914"){
	if($_SESSION["cwflag"]!="ok"){
		$_SESSION["cwurl"]="account_drawlist.php";
		echo "<script language=javascript>window.location='account_check.php';</script>";
		exit;
	}
}
$_SESSION["cwflag"]="";

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=25;
$page2=($page-1)*$pagesize;

$time_min = $_REQUEST['time_min'];
$time_max = $_REQUEST['time_max'];

if($time_min==""){
	$time_min=date("Y-m-d",strtotime("-2 week"))." 02:20";
}
	$s1=$s1." and adddate>='".$time_min."'";

if($time_max!=""){
	$s1=$s1." and adddate>='".$time_max."'";
}

$urls="time_min=".$time_min."&time_max=".$time_max."&check=914";
$s1=$s1." order by id desc";
$sql="select * from ssc_drawlist where username='" . $_SESSION["username"] . "'".$s1;
//echo $sql;
$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

$sql="select * from ssc_drawlist where username='" . $_SESSION["username"] . "'".$s1." limit $page2,$pagesize";
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
    <title>娱乐平台  - 提现记录</title>
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
</div><script type="text/javascript">
    jQuery("#loadhtml").hide();	//去掉loading界面
    jQuery(document).ready(function() {		
        jQuery("#time_min").dynDateTime({
            ifFormat: "%Y-%m-%d %H:%M",
            daFormat: "%l;%M %p, %e %m,  %Y",
            align: "Br",
            electric: true,
            singleClick: false,
            button: ".next()", //next sibling
            showOthers: true,
            weekNumbers: true,
            //onUpdate: function(){alert('1');}
            showsTime: true
        });
        jQuery("#time_max").dynDateTime({
            ifFormat: "%Y-%m-%d %H:%M",
            daFormat: "%l;%M %p, %e %m,  %Y",
            align: "Br",
            electric: true,
            singleClick: false,
            button: ".next()", //next sibling
            showOthers: true,
            weekNumbers: true,
            //onUpdate: function(){alert('1');}
            showsTime: true
        });
        jQuery("#helpimg").click(function(){
            jQuery("#helpnotice").toggle();
        });
		
        // 取消
        cancelWithdraw = function(id){
            if (confirm("确认取消吗？")){
                $.ajax({
                    type:"POST",
                    url:'',
                    data:'id=' + id + '&flag=ajax',
                    success:function(data){
                        if (data == true){
                            $("#status" + id).html("已取消");
                            $("#cancel" + id).fadeOut("slow");
                            alert("取消成功");
                        } else if (data == -1){
                            alert("系统结算时间,暂停提现操作");
                        } else {
                            alert("取消失败");
                        }
                    }
                });
            }
        }
    });

    function checkForm(obj)
    {
        if( jQuery.trim(obj.time_min.value) != "" )
        {
            if( false == validateInputDate(obj.time_min.value) )
            {
                alert("时间格式不正确");
                obj.time_min.focus();
                return false;
            }
        }
        if( jQuery.trim(obj.time_max.value) != "" )
        {
            if( false == validateInputDate(obj.time_max.value) )
            {
                alert("时间格式不正确");
                obj.time_max.focus();
                return false;
            }
        }
    }
</script>
<STYLE>
    .sbox{font-weight:bold;font-size:16px;padding:3px 8px;height:23px;line-height:23px;background-color:#222;color:#B4FF00;border:#BBB 1px solid;}
</STYLE>
<div class="top_menu">
    <div class="tm_left"></div>
    <div class="tm_title"></div>
    <div class="tm_right"></div>
    <div class="tm_menu">
        <a class="act" href="/account_drawlist.php?check=914">提现记录</a>
        <a href="/account_draw.php?check=914">平台提现</a>
        <a href="/account_savelist.php?check=914">充值记录</a>
        <a href="/account_autosavea.php?check=914">在线充值</a>
        <a href="/ws_money_in.php">网站间转账</a>
    </div>
</div>
<div class="rc_con betting">
    <div class="rc_con_lt"></div>
    <div class="rc_con_rt"></div>
    <div class="rc_con_lb"></div>
    <div class="rc_con_rb"></div>
    <h5><div class="rc_con_title">提现记录</div></h5>
    <div class="rc_con_to">
        <div class="rc_con_ti">
            <div class="betting_input">
                <table class='st' border="0" cellspacing="0" cellpadding="0">
                    <form action="" method="get" name="search" onsubmit="return checkForm(this)">
                        <input type="hidden" name="check" value="" />
                        <tr><td>
                                提现时间: <input type="text" size="20" name="time_min" id="time_min" value="<?=$time_min?>" /> 
                                <img class='icons_mb4' src="./images/comm/t.gif" id="time_min_button" />
                                &nbsp;至&nbsp;
                                <input type="text" size="16" name="time_max" id="time_max" value="<?=$time_max?>" /> 
                                <img class='icons_mb4' src="./images/comm/t.gif" />&nbsp;&nbsp;<button name="submit" type="submit" width='69' height='26' class="btn_search" /></button>&nbsp;&nbsp;&nbsp;
                            </td>
                        </tr>
                    </form>
                </table>
            </div>
            <div class="rc_list">
                <div class="rl_list">
                    <table class="lt" border="0" cellspacing="0" cellpadding="0" width="100%">
                        <tr class='th'>
                            <th><div>提现编号</div></th>
                        <th align="center"><div class='line'>申请发起时间</div></th>
                        <th align="center"><div class='line'>提现银行</div></th>
                        <th align="center" title="银行卡尾号"><div class='line'>尾号</div></th>
                        <th align="center"><div class='line'>提现金额</div></th>
                        <th align="center"><div class='line'>手续费</div></th>
                        <th align="center"><div class='line'>到账金额</div></th>
                        <th align="center"><div class='line'>备注</div></th>
                        <th align="center"><div class='line'>状态</div></th>
                        </tr>
<?php
  if($total==0){
?>
    	<tr align="center"><td colspan="9" class='no-records'><span>暂无数据</span></td></tr>
<?php
  }else{
	while ($row = mysql_fetch_array($rsnewslist)){
  	$tmoney=$tmoney+$row['money'];
	$tsxmoney=$tsxmoney+$row['sxmoney'];
  	$trmoney=$trmoney+$row['rmoney'];
?>
                        <tr align="center">
                            <td><?=$row['dan']?></td>
                            <td><?=$row['adddate']?></td>
                            <td><?=$row['bank']?></td>
                            <td><?=substr($row['cardno'],-4)?></td>
                            <td><?=number_format($row['money'],2)?></td>
                            <td><?=number_format($row['sxmoney'],2)?></td>
                            <td><?=number_format($row['rmoney'],2)?></td>
                            <td><?=$row['tag']?></td>
                            <td id="status274173"><?php if($row['zt']=="0"){?><font color="#999999">等待处理</font><?php }else if($row['zt']=="1"){?><font color=#669900>提现成功</font><?php }else if($row['zt']=="2"){?><font color="#FF3300">提现失败</font><?php }?></tr>
<?php }}?>

                        <tr style="color:#FF3300">
                            <td colspan=4>&nbsp;&nbsp;&nbsp;&nbsp;
                                <font color="#FF3300">合计: </font>&nbsp;&nbsp;</td>
                            <td align="center"><font color="#FF3300"><?=number_format($tmoney,2)?></font></td>
                            <td align="center"><font color="#FF3300"><?=number_format($tsxmoney,2)?></font></td>
                            <td align="center"><font color="#FF3300"><?=number_format($trmoney,2)?></font></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr><td class='b' colspan="9" valign="middle"><div style='text-align:right;'><ul class="pager">总计 <?=$total?> 条数据,  共 <?=$lastpg?> 页 , 当前第 <?=$page?> 页  |  <?php if($page>1){?><LI><A HREF="?<?=$urls?>&page=1">首页</A></LI><LI><A HREF="?<?=$urls?>&page=<?=$page-1?>">上页</A></LI><?php }?><?php for($i=$p1;$i<=$p2;$i++){
		if($i==$page){?><LI CLASS='current' ><A HREF="#"><?=$i?></A></LI><?php }else{?><LI><A HREF="?<?=$urls?>&page=<?=$i?>"><?=$i?></A></LI><?php }}?><?php if($page!=$lastpg){?><LI><A HREF="?<?=$urls?>&page=<?=$page+1?>">下页</A></LI><LI><A HREF="?<?=$urls?>&page=<?=$lastpg?>">尾页</A></LI><?php }?> | 转至 <SCRIPT LANGUAGE="JAVASCRIPT">function keepKeyNum(obj,evt){var  k=window.event?evt.keyCode:evt.which; if( k==13 ){ goPage(obj.value);return false; }} function goPage( iPage ){ if( !isNaN(parseInt(iPage)) ) { if(iPage> <?=$lastpg?> ){iPage=<?=$lastpg?>;} window.location.href="?<?=$urls?>&page="+iPage;}}</SCRIPT><INPUT onKeyPress="return keepKeyNum(this,event);" TYPE="TEXT" ID="iGotoPage" NAME="iGotoPage" size="3"> 页  &nbsp;<BUTTON onclick="javascript:goPage( document.getElementById('iGotoPage').value );return false;">GO</BUTTON>&nbsp;&nbsp;</ul></div></td></tr>
                    </table>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
<SCRIPT>
    function showH(objId)
    {
        var obj = document.getElementById(objId);
        if(obj.style.display=="none")
        {
            obj.style.display="block";
        }
        else
        {
            obj.style.display="none";
        }
    }
</SCRIPT>
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