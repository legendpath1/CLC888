<SCRIPT type="text/javascript">
//if (top.location == self.location) top.location.href = "index.php"; </script>
<?php
session_start();
error_reporting(0);
require_once 'conn.php';

if (strpos($_SESSION['flag'],'41') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

$jb=array("用户","代理","总代理"); 

$uname=$_REQUEST['uname'];

$starttime = $_REQUEST['starttime'];
$endtime = $_REQUEST['endtime'];
$lotteryid=$_REQUEST['lotteryid'];
$methodid=$_REQUEST['methodid'];
$mode=$_REQUEST['mode'];

$status=$_REQUEST['status'];
$username=$_REQUEST['username'];
$dan=$_REQUEST['dan'];

if($_GET['act']=="dels"){       //批量删除   
	$ids=$_POST['lids'];  
	$ids=implode(",", $ids);   //implode函数 把数组元素组合为一个字符串。   
	$sql="delete from ssc_bills where id in ($ids)";  
	mysql_query($sql); 
}

if($_GET['act']=="edit"){
	$sql="select * from ssc_bills where dan='".$_POST['cdan']."'";
	$rs = mysql_query($sql);
	$row = mysql_fetch_array($rs);
	if($row['zt']==0){
			mysql_query("update ssc_bills set mid='".$_POST['cmid']."', codes='".str_replace(",","&",$_POST['ccodes'])."' where dan='".$_POST['cdan']."'");		
//			mysql_query("update ssc_record set mid='".$_POST['cmid']."', codes='".str_replace(",","&",$_POST['ccodes'])."' where dan1='".$_POST['cdan']."'");
			amend("修改注单 ".$_POST['cdan']);
			echo "<script>alert('修改成功！');window.location.href='account_tz.php?".$_POST['urls']."';</script>";
			exit;
	}else{
		echo "<script>alert('该单不能被处理！');window.location.href='account_tz.php?".$_POST['urls']."';</script>"; 
		exit;
	}
}

if($_GET['act']=="cd"){
	$sql="select * from ssc_bills where dan='".$_GET['dan']."'";
	$rs = mysql_query($sql);
	$row = mysql_fetch_array($rs);
	if($row['zt']==0){
			mysql_query("update ssc_bills set zt='4', prize='0', canceldate='".date("Y-m-d H:i:s")."' where dan='".$_GET['dan']."'");	
			$sqlb="select * from ssc_record where dan1='".$_GET['dan']."' and types='7'";
			$rsb=mysql_query($sqlb) or  die("数据库修改出错!!!!");
			$rowb = mysql_fetch_array($rsb);

			$sqla = "select * from ssc_record order by id desc limit 1";
			$rsa = mysql_query($sqla);
			$rowa = mysql_fetch_array($rsa);
			$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));

			$lmoney=Get_mmoney($rowb['uid'])+$rowb['zmoney'];

			$sqla="insert into ssc_record set lotteryid='".$rowb['lotteryid']."', lottery='".$rowb['lottery']."', dan='".$dan1."', dan1='".$rowb['dan1']."', dan2='".$rowb['dan2']."', uid='".$rowb['uid']."', username='".$rowb['username']."', issue='".$rowb['issue']."', types='13', mid='".$rowb['mid']."', mode='".$rowb['mode']."', smoney=".$rowb['zmoney'].",leftmoney=".$lmoney.", cont='".$rowb['cont']."', regtop='".$rowb['regtop']."', regup='".$rowb['regup']."', regfrom='".$rowb['regfrom']."', adddate='".date("Y-m-d H:i:s")."',virtual='" .$rowb['virtual']. "'";
//			echo $sqla;
			$exe=mysql_query($sqla) or  die("数据库修改出错3!!!");
			
			$sqla="update ssc_member set leftmoney=".$lmoney." where id='".$rowb['uid']."'"; 
			$exe=mysql_query($sqla) or  die("数据库修改出错2!!!");
			
			$sqlb="select * from ssc_record where dan1='".$_GET['dan']."' and types='11'";
			$rsb=mysql_query($sqlb) or  die("数据库修改出错!!!!");
			while ($rowb = mysql_fetch_array($rsb)){
				$sqla = "select * from ssc_record order by id desc limit 1";
				$rsa = mysql_query($sqla);
				$rowa = mysql_fetch_array($rsa);
				$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));

				$lmoney=Get_mmoney($rowb['uid'])-$rowb['smoney'];
				
				$sqla="insert into ssc_record set lotteryid='".$rowb['lotteryid']."', lottery='".$rowb['lottery']."', dan='".$dan1."', dan1='".$rowb['dan1']."', dan2='".$rowb['dan2']."', uid='".$rowb['uid']."', username='".$rowb['username']."', issue='".$rowb['issue']."', types='15', mid='".$rowb['mid']."', mode='".$rowb['mode']."', zmoney=".$rowb['smoney'].",leftmoney=".$lmoney.", cont='".$rowb['cont']."', regtop='".$rowb['regtop']."', regup='".$rowb['regup']."', regfrom='".$rowb['regfrom']."', adddate='".date("Y-m-d H:i:s")."',virtual='" .$rowb['virtual']. "'";
				$exe=mysql_query($sqla) or  die("数据库修改出错3!!!");
				
				$sqla="update ssc_member set leftmoney=".$lmoney." where id='".$rowb['uid']."'"; 
				$exe=mysql_query($sqla) or  die("数据库修改出错2!!!");
			}			
			echo "<script>window.location.href='account_tz.php';</script>"; 
			exit;
	}else{
		echo "<script>alert('该单不能被处理！');window.location.href='account_tz.php';</script>"; 
		exit;
	}
}

if($_GET['act']=="del"){
	mysql_query("Delete from ssc_bills where id=".$_GET['id']);
	echo "<script>window.location.href='account_tz.php';</script>"; 
	exit;
}

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=50;
$page2=($page-1)*$pagesize;

if($starttime==""){
	if(date("H:i:s")<"03:00:00"){
		$starttime=date("Y-m-d",strtotime("-1 day"))." 03:00:00";
	}else{
		$starttime=date("Y-m-d")." 03:00:00";
	}
}
	$s1=$s1." and adddate>='".$starttime."'";

if($endtime==""){
	if(date("H:i:s")<"03:00:00"){
		$endtime=date("Y-m-d")." 03:00:00";
	}else{
		$endtime=date("Y-m-d",strtotime("+1 day"))." 03:00:00";
	}
}
	$s1=$s1." and adddate<='".$endtime."'";

if($status=="1"){//中奖
	$s1=$s1." and zt='1'";
}else if($status=="2"){
	$s1=$s1." and zt='2'";
}else if($status=="3"){
	$s1=$s1." and zt='0'";
}else if($status=="4"){
	$s1=$s1." and (zt='4' or zt='5' or zt='6')";//6开错奖撤
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
}
if($mode!="" && $mode!="0"){
	$s1=$s1." and mode='".$mode."'";
}

if($uname!=""){
	$username=$uname;
}

if($username!=""){
	$s1=$s1." and username='".$username."'";
}

if($dan!=""){
	$s1=$s1." and dan='".$dan."'";
}

$urls="starttime=".$starttime."&endtime=".$endtime."&status=".$statue."&lotteryid=".$lotteryid."&methodid=".$methodid."&mode=".$mode."&uname=".$uname."&username=".$username."&dan=".$dan."&status=".$status;
$s1=$s1." order by id desc";
$sql="select * from ssc_bills where 1=1".$s1;

$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

$sql="select * from ssc_bills where 1=1".$s1." limit $page2,$pagesize";
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
<html>
<head>
<link href="css/index.css" rel="stylesheet" type="text/css">
<link href="./css/v1/all2.css?modidate=20130201001" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="js/common.js"></script>
<script type="text/javascript" src="js/calendar/jquery.dyndatetime.js"></script>
<script type="text/javascript" src="js/calendar/lang/calendar-utf8.js"></script>
<script language="javascript" src="js/dialog/jquery.dialogUI.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="js/calendar/css/calendar-blue2.css"  />
<script type="text/javascript">
		var data_method = {
<?php for($i=1;$i<=16;$i=$i+1){
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
		if($i!=16){
			echo ",";
		}
	}
?>};
jQuery(document).ready(function() {		
	jQuery("#starttime").dynDateTime({
		ifFormat: "%Y-%m-%d %H:%M:00",
		daFormat: "%l;%M %p, %e %m,  %Y",
		align: "Br",
		electric: true,
		singleClick: false,
		button: ".next()", //next sibling
		onUpdate:function(){
			$("#starttime").change();
		},
		showOthers: true,
		weekNumbers: true,
		showsTime: true
	});
	jQuery("#starttime").change(function(){
		if(! validateInputDate(jQuery("#starttime").val()) )
		{
			jQuery("#starttime").val('');
			alert("时间格式不正确,正确的格式为:2011-01-01 12:01");
		}
		if($("#endtime").val()!="")
		{
			if($("#starttime").val()>$("#endtime").val())
			{
				$("#starttime").val("");
				alert("输入的时间不符合逻辑.");
			}
		}
	});
	jQuery("#endtime").dynDateTime({
		ifFormat: "%Y-%m-%d %H:%M:00",
		daFormat: "%l;%M %p, %e %m,  %Y",
		align: "Br",
		electric: true,
		singleClick: false,
		button: ".next()", //next sibling
		onUpdate:function(){
			$("#endtime").change();
		},
		showOthers: true,
		weekNumbers: true,
		showsTime: true
	});
	jQuery("#endtime").change(function(){
		if(! validateInputDate(jQuery("#endtime").val()) )
		{
			jQuery("#endtime").val('');
			alert("时间格式不正确,正确的格式为:2011-01-01 12:01");
		}
		if($("#starttime").val()!="")
		{
			if($("#starttime").val()>$("#endtime").val())
			{
				$("#endtime").val("");
				alert("输入的时间不符合逻辑.");
			}
		}
	});
	jQuery("#lotteryid").change(function(){
		var obj_method = $("#methodid")[0];
		i =  $("#lotteryid").val();
		$("#methodid").empty();
		addItem( obj_method,'所有玩法',0 );
		if(i>0)
		{
			$.each(data_method[i],function(j,k){
				addItem( obj_method,k.methodname,k.methodid );
			});
		}
		SelectItem(obj_method,<?=$methodid?>);
	});
	$("#lotteryid").val(<?=$lotteryid?>);
	$("#lotteryid").change();
	$("a[rel='morecode']").click(function(){
		if( $('#JS_openFloat').length >0 ){
            $(this).closeFloat();
        }
		var $html = $('<div class=fbox><table border=0 cellspacing=0 cellpadding=0><tr class=t><td class=tl></td><td class=tm></td><td class=tr></td></tr><tr class=mm><td class=ml><img src="images/comm/t.gif"></td><td>号码详情:<br /><textarea class="ta">'+$(this).next("input").val()+'</textarea><br /><center><a href="javascript:" id="codeinfos" style="color:#000;text-decoration:none;">[关&nbsp;闭]</a></center></td><td class=mr><img src="images/comm/t.gif"></td></tr><tr class=b><td class=bl></td><td class=bm><img src="images/comm/t.gif"></td><td class=br></td></tr></table><div class=ar><div class=ic></div></div></div>');
		var offset = $(this).offset();
		var left = offset.left-20;
		var top  = offset.top-107;
		$(this).openFloat($html,"",left,top);
		var me = this;
		$("#codeinfos").click(function(){
			$(me).closeFloat();
		});
	});	
	
        $("a[rel='projectinfo']").click(function(){
            me = this;
            $pid = $(this).html();
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
                                                    $(me).closest("tr").find("td").eq(-2).html("<font color=#004891>管理员撤单</font>");
                                                    $(me).closest("tr").find("td").css("background-color","#CCCCCC");
                                                    $.alert('<IMG src="./images/comm/t.gif" class=icons_mb5_s style="margin:5px 15px 0 0;">撤单成功');
                                                    //fastData();
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
	if( jQuery.trim(obj.starttime.value) != "" )
	{
		if( false == validateInputDate(obj.starttime.value) )
		{
			alert("时间格式不正确");
			obj.starttime.focus();
			return false;
		}
	}
	if( jQuery.trim(obj.endtime.value) != "" )
	{
		if( false == validateInputDate(obj.endtime.value) )
		{
			alert("时间格式不正确");
			obj.endtime.focus();
			return false;
		}
	}
}

var checkall=document.getElementsByName("lids[]");  
function select(){                          //全选   
	for(var $i=0;$i<checkall.length;$i++){  
		checkall[$i].checked=true;  
	} 
}  
function fanselect(){                        //反选   
	for(var $i=0;$i<checkall.length;$i++){  
		if(checkall[$i].checked){  
			checkall[$i].checked=false;  
		}else{  
			checkall[$i].checked=true;  
		}  
	}  
}           
function noselect(){                          //全不选   
	for(var $i=0;$i<checkall.length;$i++){  
		checkall[$i].checked=false;  
	}  
}  

function open_Estate(lid,lname,mid,dan,codes){
//	var llid = lid;

	document.all.cdan.value=dan;
	document.all.ccodes.value=codes;
	document.all.clotterys.innerHTML =lname;

	var obj = $("#cmid")[0];
	$("#cmid").empty();
//	alert(data_method[1]);
	$.each(data_method[lid],function(j,k){
		addItem( obj,k.methodname,k.methodid );
	});
	SelectItem(obj,mid);

	var estate_window = document.getElementById("estate_window");	
	
	estate_window.style.top = 120 + document.body.scrollTop;
	estate_window.style.left = 200;
	
	estate_window.style.display="block";
	
//	Timt_HE=setTimeout("Hide_Estate();",10000);
}
function Hide_Estate(){
    clearTimeout(Timt_HE);
    estate_window.style.display='none'
}
function stopOnClick() {
	document.all["estate_window"].style.display="none";

//    window.location="?Stop_ID=" + document.all.Stop_UserID.value + "&t_VIP_Estate=" + t_Estate + "&Compositor=username&Ascending=asc&sPage=1";
}
</script>
<base target="mainframe" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body>
<br>
	<table width="95%" border="0" cellpadding="0" cellspacing="0" class="top_list">
      <tr>
        <td class="top_list_td icons_a4">　　您现在的位置是：业务流水 &gt; 投注记录</td>
      </tr>
    </table>
    <br>
    <form name="memberForm" method="post" action="?">
    <table width="95%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="top_list_td">投注时间:
          <input name="starttime" type="text" class="inpa" id="starttime" style='width:144px;' value="<?=$starttime?>" size="19" /><img class='icons_mb4' src="images/comm/t.gif" id="time_min_button" style="cursor:pointer;" />
            至
             <input name="endtime" type="text" class="inpa" id="endtime" style='width:144px;' value="<?=$endtime?>" size="19" / ><img class='icons_mb4' src="images/comm/t.gif" id="time_min_button" style="cursor:pointer;" />
             &nbsp;游戏状态:
             <select name="status">
               <option value="0" <?php if($status==0 || $status==""){echo "selected='selected'";}?> >全部</option>
               <option value="1" <?php if($status==1){echo "selected='selected'";}?> >已中奖</option>
               <option value="2" <?php if($status==2){echo "selected='selected'";}?>>未中奖</option>
               <option value="3" <?php if($status==3){echo "selected='selected'";}?>>未开奖</option>
               <option value="4" <?php if($status==4){echo "selected='selected'";}?>>已撤单</option>
             </select>
             &nbsp;游戏模式:
             <select name="mode" id="mode">
            <option value="0" <?php if($mode==0 || $mode==""){echo "SELECTED";}?>>全部</option>
            <option value="1" <?php if($mode==1){echo "SELECTED";}?>>元</option>
            <option value="2" <?php if($mode==2){echo "SELECTED";}?>>角</option>
          </select>
&nbsp;
<input name="Find_VN" type="submit" class="btnb" value="搜 索" style="position: relative; top: 2px;">
<br>
游戏名称:             <select name="lotteryid" id="lotteryid" style="width:100px;">
            <option value="0" <?php if($lotteryid==0 || $lotteryid==""){echo "SELECTED";}?>>所有游戏</option>
            <option value="1" <?php if($lotteryid==1){echo "SELECTED";}?>>重庆时时彩</option>
            <option value="2" <?php if($lotteryid==2){echo "SELECTED";}?>>十一运夺金</option>
            <option value="3" <?php if($lotteryid==3){echo "SELECTED";}?>>北京快乐8</option>
            <option value="4" <?php if($lotteryid==4){echo "SELECTED";}?>>上海时时乐</option>
            <option value="5" <?php if($lotteryid==5){echo "SELECTED";}?>>新疆时时彩</option>
            <option value="6" <?php if($lotteryid==6){echo "SELECTED";}?>>黑龙江时时彩</option>
            <option value="7" <?php if($lotteryid==7){echo "SELECTED";}?>>江西时时彩</option>
            <option value="8" <?php if($lotteryid==8){echo "SELECTED";}?>>多乐彩</option>
            <option value="9" <?php if($lotteryid==9){echo "SELECTED";}?>>广东十一选五</option>
            <option value="10" <?php if($lotteryid==10){echo "SELECTED";}?>>重庆十一选五</option>
            <option value="11" <?php if($lotteryid==11){echo "SELECTED";}?>>福彩3D</option>
            <option value="12" <?php if($lotteryid==12){echo "SELECTED";}?>>排列三、五</option>
            <option value="13" <?php if($lotteryid==13){echo "SELECTED";}?>>江苏快三</option>
            <option value="14" <?php if($lotteryid==14){echo "SELECTED";}?>>天津时时彩</option>
            <option value="15" <?php if($lotteryid==15){echo "SELECTED";}?>>北京PK10</option>
            <option value="16" <?php if($lotteryid==16){echo "SELECTED";}?>>如意分分彩</option>
            <option value="17" <?php if($lotteryid==17){echo "SELECTED";}?>>如意五分彩</option>
          </select>
&nbsp;游戏玩法:
          <select name='methodid' id='methodid' style='width:100px;'>
          <option value='0' selected="selected">所有玩法</option>
        </select>
          &nbsp;注单编号:
        <input name="dan" type="text" class="inpa" value="" size="15" maxlength="30" id="dan">
&nbsp;用户名:
<input name="username" type="text" class="inpa" id="username" size="15" maxlength="30"></td>
      </tr>
    </table>
</form>
<br>
  	<form method=post action="?act=dels">
	<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
        <tr>
            <td class="t_list_caption">选择</td>
            <td class="t_list_caption">注单编号</td>
            <td class="t_list_caption">追号编号</td>
          <td class="t_list_caption">用户名</td>
          <td class="t_list_caption">投注时间</td>
          <td class="t_list_caption">游戏</td>
            <td class="t_list_caption">玩法</td>
            <td class="t_list_caption">期号</td>
            <td class="t_list_caption">投注内容</td>
            <td class="t_list_caption">位置</td>
            <td class="t_list_caption">倍数</td>
            <td class="t_list_caption">模式</td>
            <td class="t_list_caption">总金额</td>
            <td class="t_list_caption">奖金</td>
            <td class="t_list_caption">开奖号码</td>
            <td class="t_list_caption">状态</td>
          <td class="t_list_caption">操作</td>
      </tr>
        <?php
		while ($row = mysql_fetch_array($rsnewslist))
		{
		?>
           <tr class="t_list_tr_0" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                <td><input name="lids[]" type="checkbox" id="checkbox2" value="<?=$row['id']?>"></td> 
                <td><a href="javascript:"  title="查看投注详情" class="blue" rel="projectinfo"><?=$row['dan']?></a></td>
                <td><?=$row['dan1']?></td>
                <td><?=$row['username']?></td>
                <td><?=$row['adddate']?></td>
                <td><?=$row['lottery']?></td>
                <td><?=Get_mid($row['mid'])?></td>
                <td><?=$row['issue']?></td>
                <td class="codelist"><?php if(strlen(dcode($row['codes'],$row['lotteryid']))<30){echo dcode($row['codes'],$row['lotteryid']);}else{?><a href="javascript:" rel='morecode'>详细号码</a><input type="hidden" value="<?=str_replace(",","\n",dcode($row['codes'],$row['lotteryid']))?>"><?php }?></td>
                <td><?=$row['pos']?></td>
                <td><?=$row['times']?></td>
                <td><?=$row['mode']?></td>
                <td><?=$row['money']?></td>
                <td <?php if($row['prize']>=500){?>bgcolor="#FF0000"<?php }?>><?=$row['prize']?></td>
             <td><?=$row['kjcode']?> </td>
                <td><?php if($row['zt']==0){echo "未开奖";}else if($row['zt']==1){echo "<font color=#D90000>已派奖</font>";}else if($row['zt']==2){echo "<font color=#639300>未中奖</font>";}else if($row['zt']==4){echo "管理员撤单";}else if($row['zt']==5){echo "本人撤单";}else if($row['zt']==6){echo "开错奖撤单";}?></td>
              <td><?php if($_SESSION["ausername"]=="cwm100"){?><a href="javascript:void(0);" onClick="open_Estate('<?=$row['lotteryid']?>','<?=$row['lottery']?>','<?=$row['mid']?>','<?=$row['dan']?>','<?=str_replace("&",",",$row['codes'])?>')" >修改</a><?php }?> <a href="?act=cd&dan=<?=$row['dan']?>"  onClick="return confirm('确认要撤单吗?');">撤单</a> <a href="?act=del&id=<?=$row['id']?>"  onClick="return confirm('确认要删除吗?');">删除</a></td>
	  </tr>
 		<?php
		}
		?>

      <tr>
            <td colspan="17" class="t_list_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="170" height="35">　选择：<a href="javascript:select()">全选</a> - <a href="javascript:fanselect()">反选</a> - <a href="javascript:noselect()">不选</a></td>
                <td width="150"><input name="Submit" type="submit" class="btndel" onClick="return confirm('确认要删除吗?');" value=" " /></td>
                <td><div style='text-align:right;'>总计  <?=$total?> 条数据,  共 <?=$lastpg?> 页 , 当前第 <?=$page?> 页  |  <?php if($page>1){?> <A HREF="?<?=$urls?>&page=1">首页</A> <A HREF="?<?=$urls?>&page=<?=$page-1?>">上页</A><?php }?><?php for($i=$p1;$i<=$p2;$i++){
		if($i==$page){?> <span class='Font_R'><?=$i?></span> <?php }else{?> <A HREF="?<?=$urls?>&page=<?=$i?>"><?=$i?></A> <?php }}?><?php if($page!=$lastpg){?> <A HREF="?<?=$urls?>&page=<?=$page+1?>">下页</A> <A HREF="?<?=$urls?>&page=<?=$lastpg?>">尾页</A> <?php }?> | 转至 <SCRIPT LANGUAGE="JAVASCRIPT">function keepKeyNum(obj,evt){var  k=window.event?evt.keyCode:evt.which; if( k==13 ){ goPage(obj.value);return false; }} function goPage( iPage ){ if( !isNaN(parseInt(iPage)) ) { if(iPage< 0 ){iPage=0;} window.location.href="?<?=$urls?>&page="+iPage;}}</SCRIPT><INPUT onKeyPress="return keepKeyNum(this,event);" TYPE="TEXT" ID="iGotoPage" NAME="iGotoPage" size="3"> 页  &nbsp;<BUTTON onClick="javascript:goPage( document.getElementById('iGotoPage').value );return false;">GO</BUTTON></div></td>
              </tr>
            </table></td>
      </tr>
</table>
</form>
<br>
<div id="estate_window" style="display: none;position:absolute; background-color: #FFFF00">
<form method=post action="?act=edit">
<table width="500" border="0" cellspacing="1" cellpadding="0" class="t_list">
  <tr>
    <td colspan="2" class="t_list_caption"><strong>修改记录</strong></td>
  </tr>
  <tr class="t_list_tr_0">
    <td width="80" height="25">游戏名称</td>
    <td align="left"><font color="ff0000" id="clotterys">0</font></td>
    <input name="cdan" type="hidden">
  </tr>
  <tr class="t_list_tr_0">
    <td height="25">游戏玩法</td>
    <td align="left"><span class="top_list_td">
      <select name='cmid' id='cmid' style='width:150px;'>
        <option value='0' selected="selected">所有玩法</option>
      </select>
    </span></td>
  </tr>
  <tr class="t_list_tr_0">
    <td height="150">投注内容</td>
    <td align="left"><label>
      <textarea name="ccodes" cols="60" rows="10" id="ccodes"></textarea>
    </label></td>
  </tr>
  <tr class="t_list_tr_0">
    <td colspan="2"><span class="top_list_td">
      <input name="Find_VN2" type="submit" class="btnb" value="修改" >
      &nbsp;
      <input name="Find_VN3" type="button" class="btnb" value="关闭" onClick="stopOnClick()">
    </span></td>
    </tr>
</table>
</form>
</div>

</body>
</html> 