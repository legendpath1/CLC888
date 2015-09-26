<?php 
session_start();
error_reporting(0);
require_once 'conn.php';
//require_once 'check.php';

$id=$_REQUEST['id'];
$issuecount=$_REQUEST['issuecount'];
$wday=$_REQUEST['wday'];
$starttime=$_REQUEST['starttime'];
$endtime=$_REQUEST['endtime'];

if($id==""){
	$id=1;
}

if($issuecount==""){
	$issuecount=30;
}
if($wday=="b"){
	$starttime=date("Y-m-d",strtotime("-2 day"));
	$endtime=date("Y-m-d",strtotime("-2 day"));
}
if($wday=="y"){
	$starttime=date("Y-m-d",strtotime("-1 day"));
	$endtime=date("Y-m-d",strtotime("-1 day"));
}
if($wday=="t"){
	$starttime=date("Y-m-d");
	$endtime=date("Y-m-d");
}

$ss="";
if($starttime!="" && $endtime!=""){
	$sql="select * from ssc_data2 where cid='".$id."' and (addtime >='".$starttime." 00:00:00' and addtime <='".$endtime." 23:59:59') order by issue asc";
}else{
	$sql="select id from ssc_data2 where cid='".$id."'";
	$rs=mysql_query($sql) or  die("数据库修改出错!!!!");
	$totala= mysql_num_rows($rs);
	if($totala-$issuecount<0){
		$tts=0;
	}else{
		$tts=$totala-$issuecount;
	}
	$sql="select * from ssc_data2 where cid='".$id."' order by issue asc limit ".$tts.",".$issuecount."";
}


//echo $sql;
	$rs=mysql_query($sql) or  die("数据库修改出错!!!!");
	$total= mysql_num_rows($rs);


if($id==1 || $id==5 || $id==6 || $id==7 || $id==12 || $id==14 || $id==16){
	$ns=5;
	$nts=50;
	$ntx=0;
	$ntd=9;
	$ntn=10;
	$tn1="万位";
	$tn2="千位";
	$tn3="百位";
	$tn4="十位";
	$tn5="个位";
}else if($id==4 || $id==11){
	$ns=3;
	$nts=30;
	$ntx=0;
	$ntd=9;
	$ntn=10;
	$tn1="万位";
	$tn2="千位";
	$tn3="百位";
	$tn4="十位";
	$tn5="个位";
}else if($id==2 || $id==8 || $id==9 || $id==10){
	$ns=5;
	$nts=55;
	$ntx=1;
	$ntd=11;
	$ntn=11;
	$tn1="第一位";
	$tn2="第二位";
	$tn3="第三位";
	$tn4="第四位";
	$tn5="第五位";
}else if($id==13){
	$ns=3;
	$nts=18;
	$ntx=1;
	$ntd=6;
	$ntn=6;
	$tn3="第一位";
	$tn4="第二位";
	$tn5="第三位";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<head>
    <title>娱乐平台  - 遗漏分析</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
        <script>var pri_imgserver = 'http://commonuploader.b0.upaiyun.com';</script>
        <link href="./css/v1/all.css?modidate=20130201001" rel="stylesheet" type="text/css" />
    <link href="./js/calendar/css/calendar-blue2.css?modidate=20130201001" rel="stylesheet" type="text/css" />
    <script language="javascript" type="text/javascript" src="./js/jquery.js?modidate=20130820001"></script>
    <script language="javascript" type="text/javascript" src="./js/common.js?modidate=20130820001"></script>
    <script language="javascript" type="text/javascript" src="./js/lottery/min/message.js?modidate=20130820001"></script>
    <script language="javascript" type="text/javascript" src="./js/calendar/jquery.dyndatetime.js?modidate=20130820001"></script>
    <script language="javascript" type="text/javascript" src="./js/calendar/lang/calendar-utf8.js?modidate=20130820001"></script>
    <script language="javascript" type="text/javascript" src="./js/common/line.js?modidate=20130820001"></script>
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
    fw.onReady(function(){
        if($("#chartsTable").width()>$('body').width()){
            $('body').width(($("#chartsTable").width()+30) + "px");
            $('.history_code').css("width",$("#chartsTable").width()+"px");
            $('#copyright').css("width",$("#chartsTable").width()+"px");
        }
        Chart.init();	
        DrawLine.bind("chartsTable","has_line");
 
                DrawLine.color('#FFAAAA');
        DrawLine.add((parseInt(0)*11+5+1),2,11,0);
                DrawLine.color('#B9B9FF');
        DrawLine.add((parseInt(1)*11+5+1),2,11,0);
                DrawLine.color('#FFAAAA');
        DrawLine.add((parseInt(2)*11+5+1),2,11,0);
                DrawLine.color('#B9B9FF');
        DrawLine.add((parseInt(3)*11+5+1),2,11,0);
                DrawLine.color('#FFAAAA');
        DrawLine.add((parseInt(4)*11+5+1),2,11,0);
                DrawLine.draw(Chart.ini.default_has_line);
        resize();
        jQuery("#starttime").dynDateTime({
            ifFormat: "%Y-%m-%d",
            daFormat: "%l;%M %p, %e %m,  %Y",
            align: "Br",
            electric: true,
            singleClick: true,
            button: ".next()", //next sibling
            onUpdate:function(){
                $("#starttime").change();
            },
            showOthers: true,
            weekNumbers: true,
            showsTime: false
        });
        jQuery("#starttime").change(function(){
            if(! validateInputDate(jQuery("#starttime").val()) )
            {
                jQuery("#starttime").val('');
                $.alert("日期格式不正确,正确的格式为:2011-01-01");
            }
            if($("#endtime").val()!="")
            {
                if($("#starttime").val()>$("#endtime").val())
                {
                    $("#starttime").val("");
                    $.alert("输入的时间不符合逻辑, 起始时间大于结束时间");
                }
                else
                {
                    if(daysBetween($("#starttime").val(),$("#endtime").val()) > 1)
                    {
                        $("#starttime").val("");
                        $.alert("输入的时间跨度不能超过2天！");
                    }
                }
            }
        });
        jQuery("#endtime").dynDateTime({
            ifFormat: "%Y-%m-%d",
            daFormat: "%l;%M %p, %e %m,  %Y",
            align: "Br",
            electric: true,
            singleClick: true,
            button: ".next()", //next sibling
            onUpdate:function(){
                $("#endtime").change();
            },
            showOthers: true,
            weekNumbers: true,
            showsTime: false
        });
        jQuery("#endtime").change(function(){
            if(! validateInputDate(jQuery("#endtime").val()) )
            {
                jQuery("#endtime").val('');
                $.alert("日期格式不正确,正确的格式为:2011-01-01");
            }
            if($("#starttime").val()!="")
            {
                if($("#starttime").val()>$("#endtime").val())
                {
                    $("#endtime").val("");
                    $.alert("输入的时间不符合逻辑, 起始时间大于结束时间");
                }
                else
                {
                    if(daysBetween($("#starttime").val(),$("#endtime").val()) > 1)
                    {
                        $("#endtime").val("");
                        $.alert("输入的时间跨度不能超过2天！");
                    }
                }
            }
        });
        var nols = $("div[class^='ball1']");
        $("#no_miss").click(function(){
            var checked = $(this).attr("checked");
            $.each(nols,function(i,n){
                if(checked==true){
                    n.style.display='none';
                }else{
                    n.style.display='block';
                }
            });
        });
    });
    function resize(){
        window.onresize = func;
        function func(){
            window.location.href=window.location.href;
        }
    }
    function daysBetween(start, end){
        var startY = start.substring(0, start.indexOf('-'));
        var startM = start.substring(start.indexOf('-')+1, start.lastIndexOf('-'));
        var startD = start.substring(start.lastIndexOf('-')+1, start.length);
  
        var endY = end.substring(0, end.indexOf('-'));
        var endM = end.substring(end.indexOf('-')+1, end.lastIndexOf('-'));
        var endD = end.substring(end.lastIndexOf('-')+1, end.length);
  
        var val = (Date.parse(endY+'/'+endM+'/'+endD)-Date.parse(startY+'/'+startM+'/'+startD))/86400000;
        return Math.abs(val);
    }
</script>
<style> 
    esun\:*{behavior:url(#default#VML)}
</style>
<div class="rc_con history">
    <div class="rc_con_lt"></div>
    <div class="rc_con_rt"></div>
    <div class="rc_con_lb"></div>
    <div class="rc_con_rb"></div>
    <h5><div class="rc_con_title">遗漏分析</div></h5>
    <div class="rc_con_to">
        <div class="rc_con_ti">
            <div class="history_code">
                <table width=100% id=tm border=0 cellpadding=0 cellspacing=0>
                    <tr>
                        <td align=left width=200>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>
                                <font color="#FF0000"><?=Get_lottery($id)?>：</font>
                                基本走势
                            </strong>
                        </td>
                        <td align=left>
                            <form method="POST" action="?id=<?=$id?>">
                                <span>
                                    <!--<label for="has_line">
                                        <input type="checkbox" name="checkbox2" value="checkbox" id="has_line" />显示折线
                                    </label>-->
                                </span>&nbsp;
                                <span>
                                    <label for="no_miss">
                                        <input type="checkbox" name="checkbox" value="checkbox" id="no_miss" />不带遗漏
                                    </label>
                                </span>&nbsp;&nbsp;&nbsp;
                                <a href="./history_code.php?id=<?=$id?>&issuecount=30&frequencytype=0">最近30期</a>&nbsp;
                                <a href="./history_code.php?id=<?=$id?>&issuecount=50&frequencytype=0">最近50期</a>&nbsp;
                                <a href="./history_code.php?id=<?=$id?>&issuecount=50&frequencytype=0">最近100期</a>&nbsp;
                                <a href="./history_code.php?id=<?=$id?>&wday=b&frequencytype=0">前天</a>&nbsp;
                                <a href="./history_code.php?id=<?=$id?>&wday=y&frequencytype=0">昨天</a>&nbsp;
                                <a href="./history_code.php?id=<?=$id?>&wday=t&frequencytype=0">今天</a>&nbsp;
                                <input class=in type="text" value="" name="starttime" id="starttime">
                                <img class='icons_mb4' src="./images/comm/t.gif" style="vertical-align:middle;">
                                &nbsp;至&nbsp;
                                <input class=in type="text" value="" name="endtime" id="endtime">
                                <img class='icons_mb4' src="./images/comm/t.gif" style="vertical-align:middle;">&nbsp;&nbsp;
                                <input type="submit" value="搜索" class="button">&nbsp;&nbsp;&nbsp;
                            </form>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="hrc_list">
                <div class="hrl_list">
                    <table id="chartsTable" width="100%" border="0" cellpadding="0" cellspacing="1">
                        <tr class="th">
                            <td rowspan="2">期号</td>
                            <td rowspan="2" colspan="<?=$ns?>">开奖号码</td>
<?php if($ns==5){ ?>
                            <td colspan="<?=$ntn?>"><?=$tn1?></td>
                            <td colspan="<?=$ntn?>"><?=$tn2?></td>
<?php }?>
                            <td colspan="<?=$ntn?>"><?=$tn3?></td>
                            <td colspan="<?=$ntn?>"><?=$tn4?></td>
                            <td colspan="<?=$ntn?>"><?=$tn5?></td>
                        </tr>
                        <tr class='th'>
<?php
		for($i=0;$i<$ns;$i++){
			for($ii=$ntx;$ii<=$ntd;$ii++){
?>
							<td class="wdh"><?=$ii?></td>
<?php }}?>
                        </tr>
<?php
	for($i=0;$i<=$nts;$i++){
		$a[$i]=0;
		$b[$i]=0;
		$c[$i]=0;
		$d[$i]=0;
		$s[$i]=0;
	}

	if($starttime!="" && $endtime!=""){
		$sqla="select code from ssc_data2 where cid='".$id."' and addtime <'".$starttime." 00:00:00' order by issue desc limit 100";
	}else{
		$sqla="select code from ssc_data2 where cid='".$id."' order by issue desc limit ".$total.",100";
	}
//	echo $sqla;
	$rsa=mysql_query($sqla) or  die("数据库修改出错!!!!");
	while ($rowa = mysql_fetch_array($rsa)){
//		echo $rowa['issue'];
		$na=explode(",",$rowa['code']);
		$iii=0;
		for($i=1;$i<=$ns;$i++){
			for($ii=$ntx;$ii<=$ntd;$ii++){
				$iii=$iii+1;
				if(intval($na[$i-1])!=$ii && $s[$iii]==0){
					$a[$iii]=$a[$iii]+1;
				}else{
					$s[$iii]=1;
				}
			}
		}
	}

	while ($row = mysql_fetch_array($rs)){
		$na=explode(",",$row['code']);
		
		for($i=0;$i<=$nts;$i++){
			$a[$i]=$a[$i]+1;
			$c[$i]=$c[$i]+1;
			if($b[$i]<$a[$i]){
				$b[$i]=$a[$i];
			}
			if($d[$i]<$c[$i]){
				$d[$i]=$c[$i];
			}
		}
?>			
            <tr>
				<td class='issue'><?=$row['issue']?></td>

				<td align="center" width="28"><div class="wth"><?=$na[0]?></div></td>
				<td align="center" width="28"><div class="wth"><?=$na[1]?></div></td>
				<td align="center" width="28"><div class="wth"><?=$na[2]?></div></td>
<?php if($ns==5){ ?>
				<td align="center" width="28"><div class="wth"><?=$na[3]?></div></td>
				<td align="center" width="28"><div class="wth"><?=$na[4]?></div></td>
<?php }?>

<?php
		$iii=0;
		for($i=0;$i<$ns;$i++){
			for($ii=$ntx;$ii<=$ntd;$ii++){
				$iii=$iii+1;
?>
				<td class="wdh td<?=$i%2?>" align="center"><?php if(intval($na[$i])==$ii){echo "<div class='ball0".($i%2+1)."'>".$na[$i]."</div>";$a[$iii]=0;$s[$iii]=$s[$iii]+1;}else{echo "<div class='ball13'>".$a[$iii]."</div>";$c[$iii]=0;}?></td>
<?php }}?>
			</tr>
 <?php }?>
 
 	<tr class=tb>
		<td nowrap>出现总次数</td>
		<td align="center" colspan="<?=$ns?>">&nbsp;</td>
<?php for($i=1;$i<=$nts;$i++){?>
		<td align="center"><?=$s[$i]?></td>
<?php }?>
	</tr>
	<tr class=tb>
		<td nowrap>平均遗漏值</td>
		<td align="center" colspan="<?=$ns?>">&nbsp;</td>
<?php for($i=1;$i<=$nts;$i++){
	if($s[$i]==0){$av=$total;}
	else{$av=intval($total/$s[$i]);}
?>
		<td align="center"><?=$av?></td>
<?php }?>
	</tr>
	<tr class=tb>
		<td nowrap>最大遗漏值</td>
		<td align="center" colspan="<?=$ns?>">&nbsp;</td>
<?php for($i=1;$i<=$nts;$i++){
	if($b[$i]-1<$a[$i]){$bv=$a[$i];}
	else{$bv=$b[$i]-1;}
?>
		<td align="center"><?=$bv?></td>
<?php }?>
	</tr>

	<tr class=tb>
		<td nowrap>最大连出值</td>
		<td align="center" colspan="<?=$ns?>">&nbsp;</td>
<?php for($i=1;$i<=$nts;$i++){
	if($d[$i]-1<$c[$i]){$dv=$c[$i];}
	else{$dv=$d[$i]-1;}
?>
		<td align="center"><?=$dv?></td>
<?php }?>
	</tr>

	<tr class=th>
		<td rowspan="2" >期号</td>
		<td rowspan="2" colspan="<?=$ns?>">开奖号码</td>
<?php
		for($i=0;$i<$ns;$i++){
			for($ii=$ntx;$ii<=$ntd;$ii++){
?>
		<td class="wdh"><?=$ii?></td>
<?php }}?>

	</tr>
	<tr class=th>
<?php if($ns==5){ ?>
                 <td colspan="<?=$ntn?>"><?=$tn1?></td>
                 <td colspan="<?=$ntn?>"><?=$tn2?></td>
<?php }?>
                 <td colspan="<?=$ntn?>"><?=$tn3?></td>
		 		 <td colspan="<?=$ntn?>"><?=$tn4?></td>
		 		 <td colspan="<?=$ntn?>"><?=$tn5?></td>		                      
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
