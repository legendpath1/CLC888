<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';
$_SESSION["mainframe"] = '"./report_list.php"';

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=25;
$page2=($page-1)*$pagesize;

$lntype = $_REQUEST['lntype'];
$ordertime_min = $_REQUEST['ordertime_min'];
$ordertime_max = $_REQUEST['ordertime_max'];
$ordertype=$_REQUEST['ordertype'];
$lotteryid=$_REQUEST['lotteryid'];
$methodid=$_REQUEST['methodid'];
$issue=$_REQUEST['issue'];
$mode=$_REQUEST['mode'];
$ztype=$_REQUEST['ztype'];
$code=$_REQUEST['code'];
$username=$_REQUEST['username'];
$ranges=$_REQUEST['ranges'];
$isrequery = $_REQUEST['isrequery'];


if($ordertime_min==""){
	if(date("H:i:s")<"03:00:00"){
		$ordertime_min=date("Y-m-d",strtotime("-1 day"))." 03:00:00";
	}else{
		$ordertime_min=date("Y-m-d")." 03:00:00";
	}
}
	$s1=$s1." and adddate>='".$ordertime_min."'";

if($ordertime_max==""){
	if(date("H:i:s")<"03:00:00"){
		$ordertime_max=date("Y-m-d")." 03:00:00";
	}else{
		$ordertime_max=date("Y-m-d",strtotime("+1 day"))." 03:00:00";
	}
}
	$s1=$s1." and adddate<='".$ordertime_max."'";

if($lntype=="mycz"){
	$ordertype=1;
	$ranges=6;	
	$isrequery=1;
}else if($lntype=="mytx"){
	$ordertype=2;
	$ranges=6;	
	$isrequery=1;
}else if($lntype=="mytz"){
	$ordertype=7;
	$ranges=6;
	$isrequery=1;
}else if($lntype=="myzh"){
	$ordertype=9;
	$ranges=6;	
	$isrequery=1;
}else if($lntype=="myjj"){
	$ordertype=12;
	$ranges=6;	
	$isrequery=1;
}else if($lntype=="myfd"){
	$ordertype=11;
	$ranges=6;
	$isrequery=1;
}

if($ordertype!="" && $ordertype!="0"){
	$s1=$s1." and types='".$ordertype."'";
}

if($lotteryid!="" && $lotteryid!="0"){
	$s1=$s1." and lotteryid='".$lotteryid."'";
}else{
	$lotteryid=0;
}
if($methodid!="" && $methodid!="0"){
	$s1=$s1." and mid='".$methodid."'";
}else{
	$methodid=0;
}
if($issue!="" && $issue!="0"){
	$s1=$s1." and issue='".$issue."'";
}else{
	$issue=0;
}
if($mode!="" && $mode!="0"){
	$s1=$s1." and mode='".$mode."'";
}
if($code!=""){
	$s1=$s1." and ".$ztype."='".$code."'";
}

if($username!=""){
	$s1=$s1." and username='".$username."'";
}

if($ranges==""){
	if($username!=""){
		$ranges="2";
	}else{
		$ranges="6";
	}
}
if($ranges!=""){
	if($ranges=="2"){//全部
		$s1=$s1." and (username='".$_SESSION["username"]."' or regfrom like '%&".$_SESSION["username"]."&%')";
	}else if($ranges=="6"){	//自己
		$s1=$s1." and username='".$_SESSION["username"]."'";
	}else if($ranges=="3"){	//直接下载
		$s1=$s1." and regup='".$_SESSION["username"]."'";
	}else if($ranges=="4"){	//所有下级
		$s1=$s1." and regfrom like '%&".$_SESSION["username"]."&%'";
	}
}

if($isrequery!="1"){
	$s1=$s1." and 1=0";	
}
$urls="ordertime_min=".$ordertime_min."&ordertime_max=".$ordertime_max."&ordertype=".$ordertype."&lotteryid=".$lotteryid."&methodid=".$methodid."&issue=".$issue."&mode=".$mode."&ztype=".$ztype."&code=".$code."&username=".$username."&ranges=".$ranges."&isrequery=".$isrequery;

$s1=$s1." order by id desc";
$sql="select * from ssc_record where 1=1".$s1;
//echo $sql;
$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

$sql="select * from ssc_record where 1=1".$s1." limit $page2,$pagesize";
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
    <title>娱乐平台  - 账变列表</title>
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
    <script language="javascript" type="text/javascript" src="./js/lottery/min/jquery.dialogUI.js?modidate=20130415002"></script>
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
jQuery(document).ready(function() {		
	jQuery("#ordertime_min").dynDateTime({
		ifFormat: "%Y-%m-%d %H:%M:%S",
		daFormat: "%l;%M %p, %e %m,  %Y",
		align: "Br",
		electric: true,
		singleClick: false,
		button: ".next()",
		showOthers: true,
		weekNumbers: true,
		showsTime: true
	});
	jQuery("#ordertime_max").dynDateTime({
		ifFormat: "%Y-%m-%d %H:%M:%S",
		daFormat: "%l;%M %p, %e %m,  %Y",
		align: "Br",
		electric: true,
		singleClick: false,
		button: ".next()",
		showOthers: true,
		weekNumbers: true,
		showsTime: true
	});
	jQuery("#endtime").change(function(){
		if(! validateInputDate(jQuery("#endtime").val()) )
		{
			jQuery("#endtime").val('');
			$.alert("时间格式不正确,正确的格式为:2011-01-01 08:00");
		}
		if($("#starttime").val()!="")
		{
			if($("#starttime").val()>$("#endtime").val())
			{
				$("#endtime").val("");
				$.alert("输入的时间不符合逻辑, 起始时间大于结束时间");
			}
		}
	});
	jQuery("#lotteryid").change(function(){
		var data_method = {
<?php for($i=1;$i<=14;$i=$i+1){
		echo "\"".$i."\":{";
		$sqlm="select * from ssc_class where cid='".$i."' and sign=1";
		$rsm = mysql_query($sqlm);
		$totalm = mysql_num_rows($rsm);
		$ii=0;
		while ($rowm = mysql_fetch_array($rsm)){		
			echo "\"".$rowm['mid']."\":{\"lotteryid\":\"".$i."\",\"methodid\":\"".$rowm['mid']."\",\"methodname\":".json_encode($rowm['name'])."}";
			if($ii!=$totalm-1){
				echo ",";
			}
			$ii=$ii+1;
		}
		echo "}";
		if($i!=14){
			echo ",";
		}
	}
?>};

		var data_issue = {
		<?php 
			for($i=1;$i<=14;$i++){
				echo "\"".$i."\":[";
				if($i==11 || $i==12){
					for($ii=0;$ii<20;$ii++){
						$dateend=date("Y-m-d",strtotime("-".$ii." day"));
						$issuey=date("Y",strtotime("-".$ii." day"));
						$tnums=sprintf("%03d",date("z",strtotime("-".$ii." day"))+1-7);
						echo "{\"issue\":\"".$issuey.$tnums."\",\"lotteryid\":\"".$i."\",\"dateend\":\"".$dateend."\"}";
						if($ii!=24){
							echo ",";
						}
					}
				}else{
					$sqls="select * from ssc_nums where cid='".$i."' and DATE_FORMAT(endtime, '%H:%i:%s')>='".date("H:i:s")."' order by id asc limit 1";
					$rss=mysql_query($sqls) or  die("数据库修改出错1");
					$rows = mysql_fetch_array($rss);
					$in=intval($rows['nums']);
					for($ii=0;$ii<$in;$ii++){
						echo "{\"issue\":\"".date("ymd").sprintf("%03d",$in-$ii)."\",\"lotteryid\":\"".$i."\",\"dateend\":\"".date("Y-m-d")."\"}";
						if($ii!=$in-1){
							echo ",";
						}
					}
				}
				echo "]";
				if($i!=14){
					echo ",";
				}
			}
		?>
};
		var obj_method = $("#methodid")[0];
		var obj_issue  = $("#issue")[0];
		i =  $("#lotteryid").val();
		$("#methodid").empty();
		$("#issue").empty();
		addItem( obj_method,'所有玩法',0 );
		addItem( obj_issue,'所有奖期',0 );
		if(i>0)
		{
			$.each(data_method[i],function(j,k){
//                            $.each(k,function(i,m){
                                addItem( obj_method,k.methodname,k.methodid );
//                           });
			});
			$.each(data_issue[i],function(j,k){
				addItem( obj_issue,k.issue,k.issue );
			});		
		}
		SelectItem(obj_method,0);
		SelectItem(obj_issue,'0');
	});
	$("#lotteryid").val(0);
	$("#lotteryid").change();
        
        
        
         $("a[rel='projectinfo']").click(function(){
            me = this;
            $pid = $(this).attr("title2");
            $.blockUI({
                message: '<div style="width:200px;padding:10px 100px;background-color:#fff;border:4px #666 solid;"><img src="./images/comm/loading.gif" style="margin-right:10px;">正在读取投注详情...</div>',
                overlayCSS: {backgroundColor: '#000000',opacity: 0.3,cursor:'wait'}
            });
            $.ajax({
                type: 'POST',
                url : 'history_playinfo.php',
                data: "id="+$pid,
                success : function(data){//成功
                    $.unblockUI({fadeInTime: 0, fadeOutTime: 0});
                    try{
                        eval("data = "+ data +";");
                        if( data.stats == 'error' ){
                            $.alert('<IMG src="./images/comm/t.gif" class=icons_mb5_e style="margin:5px 15px 0 0;">'+data.data);
                        }else{
                            data = data.data;
                            stat = '未开奖';
                            if(data.project.iscancel==0){
                                if(data.project.isgetprize==0){
                                    stat = '未开奖';
                                }else if(data.project.isgetprize==2){
                                    stat = '未中奖';
                                }else if(data.project.isgetprize==1){
                                    if(data.project.prizestatus==0){
                                        stat = '未派奖';
                                    }else{
                                        stat = '已派奖';
                                    }
                                }
                            }else if(data.project.iscancel==1){
                                stat = '本人撤单';
                            }else if(data.project.iscancel==2){
                                stat = '管理员撤单';
                            }else if(data.project.iscancel==3){
                                stat = '开错奖撤单';
                            }
                            $.blockUI_lang.button_sure = '关&nbsp;闭';
                            html = '<table class="zdinfo" border=0 cellspacing=0 cellpadding=0>';
                            html += '<tr><td width=30%>游戏用户：<span>'+data.project.username+'</span></td><td width=25%>游戏：<span>'+data.project.cnname+'</span></td><td width=45% colspan=2>总金额：<span>'+data.project.totalprice+'</span></td></tr>';
                            html += '<tr><td>注单编号：<span>'+data.project.projectid+'</span></td><td>玩法：<span>'+data.project.methodname+(data.project.taskid!=0 ? '&nbsp;<a href="history_taskinfo.php?id='+data.project.taskid+'" target="_blank" style="color:#F77;">追号单详情</a>' : '')+'</span></td><td>注单状态：<span>'+stat+'</span></td><td>&nbsp;&nbsp;&nbsp;&nbsp;倍数模式：<span>'+data.project.multiple+'倍, '+ data.project.modes +'模式</span></td></tr>';
                            html += '<tr><td>投单时间：<span>'+data.project.writetime+'</span></td><td>奖期：<span>'+data.project.issue+'</span></td><td>注单奖金：<span>'+data.project.bonus+'</span></td><td>';
                            
                            if( data.project.dypointdec.length>2 ){
                                html += '动态奖金返点：<span>'+data.project.dypointdec+'</span>';
                            }else{
                                html += '&nbsp;';
                            }
                            if(data.project.nocode != ""){
                                html += '</td></tr><td width=18% colspan=4 >开奖号码：<span>'+data.project.nocode+'</span>';
                            }else{
                                html += '</td></tr><td width=18% colspan=4 >开奖号码：<span>---</span>';
                            }
                            html += '</td></tr><tr><td colspan=4 STYLE="height:50px;">投注内容：<textarea class=t1 READONLY=TRUE style="width:790px;margin-bottom:5px;height:50px;">'+data.project.code+'</textarea></td></tr>';
                            html +='</table>';
                            //实际中奖情况显示内容
                            if(typeof(data.projectprize) !== 'undefined'){
                                html += '<div class="title">实际中奖情况：</div>';
                                html += '<table class="zdinfo" border=0 cellspacing=0 cellpadding=0><tr class=th><td width=150>奖级名称</td><td width=60><div class=line></div>中奖注数</td><td><div class=line></div>单注奖金</td><td width=90><div class=line></div>倍数</td><td width=150><div class=line></div>总奖金(注数*奖金*倍数)</td></tr>';
                                $.each(data.projectprize.detail,function(i,k){
                                    html += '<tr class=d><td style="cursor:pointer;" title="'+k.levelcodedesc+'">'+k.leveldesc+'</td><td>'+k.times+'</td><td>'+k.singleprize+'</td><td>'+k.multiple+'</td><td>'+k.prize+'</td></tr>';
                                });
                                html += '</table>';
                            }else{//可能中奖情况显示内容
                                if( data.can == 1 ){
                                    html += '<div class="title">&nbsp;&nbsp;<input type="button" value="&nbsp;撤&nbsp;单&nbsp;" class="button yh" id="cancelproject"></div>';
                                }
                                html += '<div class="title">可能中奖情况：</div>';
                                html += '<table class="zdinfo" border=0 cellspacing=0 cellpadding=0><tr class=th><td width=150>奖级名称</td><td><div class=line></div>号码</td><td width=45><div class=line></div>倍数</td><td width=45><div class=line></div>奖级</td><td width=90><div class=line></div>奖金</td></tr>';
                                $.each(data.prizelevel,function(i,k){
                                    html += '<tr class=d><td style="cursor:pointer;" title="'+k.levelcodedesc+'">'+k.leveldesc+'</td><td>'+(k.expandcode.length > 60 ? '<textarea READONLY=TRUE style="width:386px;height:50px;">'+k.expandcode+'</textarea>' :k.expandcode)+'</td><td>'+k.codetimes+'</td><td>'+k.level+'</td><td>'+k.prize+'</td></tr>';
                                });
                                html += '</table>';
                            }
                            $.alert(html,'投注详情','',820,false);
                            $("#cancelproject").click(function(){
                                if(confirm("真的要撤单吗?"+(data.need==1 ? "\n撤销此单将收取撤单手续费金额:"+data.money+"元." : ""))){
                                    $.blockUI({
                                        message: '<div style="width:200px;padding:10px 100px;background-color:#fff;border:4px #666 solid;"><img src="./images/comm/loading.gif" style="margin-right:10px;">正在提交撤单请求...</div>',
                                        overlayCSS: {backgroundColor: '#000000',opacity: 0.3,cursor:'wait'}
                                    });
                                    $.ajax({
                                        type: 'POST',
                                        url : 'history_playcancel.php',
                                        data: "id="+data.project.projectid,
                                        success : function(data){//成功
                                            $.unblockUI({fadeInTime: 0, fadeOutTime: 0});
                                            try{
                                                eval("data = "+ data +";");
                                                if( data.stats == 'error' ){
                                                    $.alert('<IMG src="./images/comm/t.gif" class=icons_mb5_e style="margin:5px 15px 0 0;">'+data.data);
                                                }else{
                                                    $(me).closest("tr").find("td:last").html("<font color=#004891>本人撤单</font>");
                                                    $(me).closest("tr").find("td").css("background-color","#CCCCCC");
                                                    $.alert('<IMG src="./images/comm/t.gif" class=icons_mb5_s style="margin:5px 15px 0 0;">撤单成功');
                                                    fastData();
                                                }
                                            }catch(e){
                                                $.alert('<IMG src="./images/comm/t.gif" class=icons_mb5_e style="margin:5px 15px 0 0;">撤单失败，请梢后重试');
                                            }
                                        }
                                    });
                                }
                            });
                        }
                    }catch(e){
                        $.alert('<IMG src="./images/comm/t.gif" class=icons_mb5_e style="margin:5px 15px 0 0;">读取数据出错，请重试');
                    }
                }
            });
        });
});

function checkForm(obj)
{
	if( jQuery.trim(obj.ordertime_min.value) != "" )
	{
		if( false == validateInputDate(obj.ordertime_min.value) )
		{
			alert("时间格式不正确");
			obj.ordertime_min.focus();
			return false;
		}
	}
	if( jQuery.trim(obj.ordertime_max.value) != "" )
	{
		if( false == validateInputDate(obj.ordertime_max.value) )
		{
			alert("时间格式不正确");
			obj.ordertime_max.focus();
			return false;
		}
	}
}
</script>
<div class="top_menu">
    <div class="tm_left"></div>
    <div class="tm_title"></div>
    <div class="tm_right"></div>
    <div class="tm_menu">
                <a href="/report_teambalance.php">团队余额</a>        <a href="/report_profit.php">盈亏报表</a>
        <a class="act" href="/report_list.php">账变列表</a>
    </div>
</div>
<form action="" method="get" name="search" onsubmit="return checkForm(this)">
<div class="rc_con ac_list">
<div class="rc_con_lt"></div>
<div class="rc_con_rt"></div>
<div class="rc_con_lb"></div>
<div class="rc_con_rb"></div>
<div class="act title_menu"><input type="reset" value="清空查询条件"></div>
<h5><div class="rc_con_title">账变列表</div></h5>
<div class="rc_con_to">
<div class="rc_con_ti">
<div class="betting_input">
<table class='st' border="0" cellspacing="0" cellpadding="0" width="100%">
<input type="hidden" name="isrequery" value="1" />
<tr>
    <td width='168'>
        类型:<select name="ordertype" multiple="multiple" size='7' style="width:120px;">
                <option value="0" SELECTED>所有类型</option>
                                <option value="1" >账户充值</option>
                                <option value="2" >账户提现</option>
                                <option value="3" >提现失败</option>
                                <option value="7" >投注扣款</option>
                                <option value="9" >追号扣款</option>
                                <option value="10" >追号返款</option>
                                <option value="11" >游戏返点</option>
                                <option value="12" >奖金派送</option>
                                <option value="13" >撤单返款</option>
                                <option value="14" >撤单手续费</option>
                                <option value="15" >撤消返点</option>
                                <option value="16" >撤消派奖</option>
                                <option value="30" >充值扣费</option>
                                <option value="31" >上级充值</option>
                                <option value="32" >活动礼金</option>
                                <option value="40" >系统分红</option>
                                <option value="999" >其他</option>
                            </select>
    </td>
<td valign='top' style='line-height:28px;'>
帐变时间: <input type="text" size="20" name="ordertime_min" id="ordertime_min" value="<?=$ordertime_min?>" /> <img class='icons_mb4' src="./images/comm/t.gif" id="time_min_button" /> 至 <input type="text" size="20" name="ordertime_max" id="ordertime_max" value="<?=$ordertime_max?>" / > <img class='icons_mb4' src="./images/comm/t.gif"/> &nbsp;&nbsp;&nbsp;&nbsp;<button name="submit" type="submit" width='69' height='26' class="btn_search" /></button>
<br/>
&nbsp;&nbsp;用户名: <input style='width:90px;' type="text" name="username" value="<?=$username?>" size="19" />
&nbsp;范围: <select name='ranges'><OPTION  value="2" <?php if($ranges==2){echo "selected";}?>>全部</OPTION><OPTION value="6" <?php if($ranges==6){echo "selected";}?>>自己</OPTION><OPTION  value="3" <?php if($ranges==3){echo "selected";}?>>直接下级</OPTION><OPTION  value="4" <?php if($ranges==4){echo "selected";}?>>所有下级</OPTION></select>&nbsp;&nbsp;<select name="ztype" id="ztype" >  
<option value="0">编号查询</option>
<option value="1" >注单编号</option>
<option value="2" >追号编号</option>
<option value="3" >帐变编号</option>
</select>
<input style='width:100px;' type="text" name="code" value="" id="code">
<br />
游戏名称: 
  <select name="lotteryid" id="lotteryid" style="width:100px;">
  	<option value="0">所有游戏</option>
    <option value="1">重庆时时彩</option>
<option value="2">十一运夺金</option>
<option value="3">北京快乐八</option>
<option value="4">上海时时乐</option>
<option value="5">新疆时时彩</option>
<option value="6">黑龙江时时彩</option>
<option value="7">江西时时彩</option>
<option value="8">江西多乐彩</option>
<option value="9">广东十一选五</option>
<option value="10">重庆十一选五</option>
<option value="11">福彩3D</option>
<option value="12">排列三、五</option>
<option value="13">江苏快三</option>
<option value="14">天津时时彩</option>
                                        <option value="16">如意分分彩</option>
                                        <option value="17">如意五分彩</option>
  </select>
&nbsp;玩法: <select name='methodid' id='methodid' style='width:100px;'><option value='0' selected="selected">所有玩法</option></select>
&nbsp;奖期: <select name='issue' id='issue'><option value='0' selected="selected">所有奖期</option></select>
&nbsp;模式: <select name="modes" id="modes">
<option value="0">全部</option>
<option value="1">元</option>
<option value="2">角</option>
</select>
<br />
<div class="quicksearch">
<input type="hidden" name="lntype" id="lntype" value="" />
快速查询: <input class='button' type="submit" name="submit" value="我的充值" onclick="document.getElementById('lntype').value='mycz';" />&nbsp;
<input class='button' type="submit" name="submit" value="我的提现" onclick="document.getElementById('lntype').value='mytx';" />&nbsp;
<input class='button' type="submit" name="submit" value="我的投注" onclick="document.getElementById('lntype').value='mytz';" />&nbsp;
<input class='button' type="submit" name="submit" value="我的追号" onclick="document.getElementById('lntype').value='myzh';" />&nbsp;
<input class='button' type="submit" name="submit" value="我的奖金" onclick="document.getElementById('lntype').value='myjj';" />&nbsp;
<input class='button' type="submit" name="submit" value="我的返点" onclick="document.getElementById('lntype').value='myfd';" />&nbsp;
&nbsp;&nbsp;<font color=#009900>温馨提示: 游戏账变,点击账变编号可以查看详细注单信息以及撤单.</font>
</div>
</td>
</tr>
</table>
</div>
<div class="rc_list">
<div class="rl_list">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <th><div>帐变编号</div></th>
        <th align="center"><div class='line'>用户名</div></th>
        <th align="center"><div class='line'>时间</div></th>
        <th align="center"><div class='line'>类型</div></th>
        <th align="center"><div class='line'>游戏</div></th>
        <th align="center"><div class='line'>玩法</div></th>
        <th align="center"><div class='line'>期号</div></th>
        <th align="center"><div class='line'>模式</div></th>
        <th align="center"><div class='line'>收入</div></th>
        <th align="center"><div class='line'>支出</div></th>
        <th align="center"><div class='line'>余额</div></th>
        <th align="center"><div class='line'>备注</div></th>
<?php
  if($total==0){
?>
    </tr>
        <tr class="no-records"><td height="34" colspan="12" align="center"><span>请选择查询条件之后进行查询</span></td></tr>
<?php 
  }else{
  $tsmoney=0;
  $tzmoney=0;

  while ($row = mysql_fetch_array($rsnewslist)){
    $tsmoney=$tsmoney+$row['smoney'];
	$tzmoney=$tzmoney+$row['zmoney'];
	if($row['dan']==""){
		$dan=sprintf("%07s",strtoupper(base_convert($row['id'],10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));
		$sql="update ssc_record set dan='".$dan."' where id ='".$row['id']."'";  
		mysql_query($sql); 
	}else{
		$dan=$row['dan'];
	}
  ?>
    <tr class="needchangebg">
    	<td align="center"><?=$dan?></td>
        <td align="center"><?=$row['username']?></td>
        <td align="center"><?=$row['adddate']?></td>
        <td align="center"><?php if($row['types']==1){echo "账户充值";
        }else if($row['types']==2){echo "账户提现";
        }else if($row['types']==3){echo "提现失败";
        }else if($row['types']==7){echo "投注扣款";
        }else if($row['types']==9){echo "追号扣款";
        }else if($row['types']==10){echo "追号返款";
        }else if($row['types']==11){echo "游戏返点";
        }else if($row['types']==12){echo "奖金派送";
        }else if($row['types']==13){echo "撤单返款";
        }else if($row['types']==14){echo "撤单手续费";
        }else if($row['types']==15){echo "撤消返点";
        }else if($row['types']==16){echo "撤消派奖";
        }else if($row['types']==30){echo "充值扣费";
        }else if($row['types']==31){echo "上级充值";
        }else if($row['types']==32){echo "活动礼金";
        }else if($row['types']==40){echo "系统分红";
        }else if($row['types']==50){echo "系统扣款";
        }else if($row['types']==999){echo "其他";}
		?></td>
        <td align="center"><?php if($row['lottery']!=''){echo $row['lottery'];}else{echo "<font color='#D0D0D0'>---";}?></td>
        <td align="center"><?php if($row['mid']!=''){echo $row['mname'];}else{echo "<font color='#D0D0D0'>---";}?></td>
        <td align="center"><?php if($row['issue']!=''){echo $row['issue'];}else{echo "<font color='#D0D0D0'>---";}?></td>
        <td align="center"><?php if($row['mode']!=''){echo $row['mode'];}else{echo "<font color='#D0D0D0'>---";}?></td>
        <td align="center"><?php if($row['smoney']!=""){echo "<font color='#669900'>+".number_format($row['smoney'],4)."</font>";}else{echo "<font color='#D0D0D0'>---";}?></td>
        <td align="center"><?php if($row['zmoney']!=""){echo "<font color='#FF3300'>-".number_format($row['zmoney'],4)."</font>";}else{echo "<font color='#D0D0D0'>---";}?></td>
        <td align="center"><?=number_format($row['leftmoney'],4)?></td>
        <td align="center"><?php if($row['tag']!=''){echo $row['tag'];}else{echo "<font color='#D0D0D0'>---";}?></td>
    </tr>
  <?php }?>
    <tr class="total">
    	<td align="left" colspan="8">&nbsp;&nbsp;&nbsp;&nbsp;小结: 本页变动金额: <span style="font-size:14px; font-weight:bold; color:#FF0000;"><?=number_format($tsmoney-$tzmoney,2)?></span> </td>
        <td align="center"><font color="#669900"><strong>+<?=number_format($tsmoney,2)?></strong></font></td>
        <td align="center"><font color="#FF3300"><strong>-<?=number_format($tzmoney,2)?></strong></font></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
    </tr>

    <tr class="page"><td class='b' colspan="12"><div style='text-align:right;'><ul class="pager">总计 <?=$total?> 条数据,  共 <?=$lastpg?> 页 , 当前第 <?=$page?> 页  |  <?php if($page>1){?><LI><A HREF="?<?=$urls?>&page=1">首页</A></LI><LI><A HREF="?<?=$urls?>&page=<?=$page-1?>">上页</A></LI><?php }?><?php for($i=$p1;$i<=$p2;$i++){
		if($i==$page){?><LI CLASS='current' ><A HREF="#"><?=$i?></A></LI><?php }else{?><LI><A HREF="?<?=$urls?>&page=<?=$i?>"><?=$i?></A></LI><?php }}?><?php if($page!=$lastpg){?><LI><A HREF="?<?=$urls?>&page=<?=$page+1?>">下页</A></LI><LI><A HREF="?<?=$urls?>&page=<?=$lastpg?>">尾页</A></LI><?php }?> | 转至 <SCRIPT LANGUAGE="JAVASCRIPT">function keepKeyNum(obj,evt){var  k=window.event?evt.keyCode:evt.which; if( k==13 ){ goPage(obj.value);return false; }} function goPage( iPage ){ if( !isNaN(parseInt(iPage)) ) { if(iPage> <?=$lastpg?> ){iPage=<?=$lastpg?>;} window.location.href="?<?=$urls?>&page="+iPage;}}</SCRIPT><INPUT onKeyPress="return keepKeyNum(this,event);" TYPE="TEXT" ID="iGotoPage" NAME="iGotoPage" size="3"> 页  &nbsp;<BUTTON onclick="javascript:goPage( document.getElementById('iGotoPage').value );return false;">GO</BUTTON>&nbsp;&nbsp;</ul></div></td></tr>    
  <?php }?>
    </table>
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