<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';
$_SESSION["mainframe"] = '"./play_jxssc.php"';

$flag=$_REQUEST['flag'];
$lotteryid="7";
$lottery="江西时时彩";

$stoptime = " 02:00:00";
$starttime = " 08:00:00";
if(time()>strtotime(date(date("Y-m-d").$stoptime)) && time()<strtotime(date(date("Y-m-d").$starttime))) {
	echo "<script language=javascript>alert('该彩种于".$stoptime." 至".$starttime." 期间暂停销售');window.location='./help_security.php';</script>";
	exit;
}

$hstr="<table cellpadding=0 cellspacing=0 class=drawinfos><tr class=drawinfo><td width=180 class=drawinfo>期号</td><td width=202 class=drawinfo>开奖号码</td><td width=60><a href='./history_coded.php?id=7&frequencytype=0' target=_blank>更多号码</a></td></tr>";

$sqlh="select * from ssc_data where cid='".$lotteryid."' order by issue desc limit 5";
$rsh=mysql_query($sqlh) or  die("数据库修改出错!!".mysql_error());
while ($rowh = mysql_fetch_array($rsh)){
	$hstr=$hstr."<tr class=drawinfo1><td class=drawinfo2>".$rowh['issue']."</td><td class=drawinfo2>".$rowh['code']."</td><td class=drawinfo2></td></tr>";
}
$hstr=$hstr."</table>";

$sqls="select * from ssc_nums where cid='7' and DATE_FORMAT(endtime, '%H:%i:%s')>='".date("H:i:s")."' order by id asc limit 1";
$rss=mysql_query($sqls) or  die("数据库修改出错1");
$nums=mysql_num_rows($rss);
$dymd=date("ymd");
$dymd2=date("Y-m-d");
$dymdt=date("ymd",strtotime("+1 day"));
$dymdt2=date("Y-m-d",strtotime("+1 day"));
if($nums==0){
	$sqls="select * from ssc_nums where cid='7' order by id asc limit 1";
	$rss=mysql_query($sqls) or  die("数据库修改出错2");
	$dymd=date("ymd",strtotime("+1 day"));
	$dymd2=date("Y-m-d",strtotime("+1 day"));
	$dymdt=date("ymd",strtotime("+2 day"));
	$dymdt2=date("Y-m-d",strtotime("+2 day"));
}
$rows = mysql_fetch_array($rss);
//$salenums=intval($rows['nums'])-1;
//$leftnums=78-$salenums;
$salenums=84;
$leftnums=84;

$issue=$dymd.$rows['nums'];
$opentime=$dymd2." ".$rows['opentime'];
$endtime=$dymd2." ".$rows['endtime'];

if($flag=="gettime"){
	echo abs(strtotime($endtime)-time());
}else if($flag=="hisproject"){
	$htime=date("Y-m-d",strtotime("-5 day"))." 03:00:00";
	$sqls="select * from ssc_bills where lotteryid='7' and username='".$_SESSION["username"]."' and adddate >='".$htime."' order by id desc limit 10";
	$rss=mysql_query($sqls) or  die("数据库修改出错1");
	$nums=mysql_num_rows($rss);
	echo '[';
	$i=1;
	while ($rows = mysql_fetch_array($rss)){
		$codes=dcode($rows['codes'],$lotteryid,$rows['mid']);
	    if(strlen($codes)>20){
			$codes="<span class='project_more'>号码详情</span><div style='display:none;'>".$codes."</div>";
		}
		if($rows['zt']==0){
			$status="未开奖";
			$iscancel=0;
		}elseif($rows['zt']==1){
			$status="<font color=red>已派奖<\/font>";
			$iscancel=0;
		}elseif($rows['zt']==2){
			$status="未中奖";
			$iscancel=0;
		}elseif($rows['zt']==4){
			$status="管理员撤单";
			$iscancel=1;
		}elseif($rows['zt']==5){
			$status="本人撤单";
			$iscancel=1;
		}elseif($rows['zt']==6){
			$status="开错奖撤单";
			$iscancel=1;
		}
		echo '{"projectid":"'.$rows['dan'].'","methodid":"'.$rows['mid'].'","iscancel":"'.$iscancel.'","bonus":"'.number_format($rows['prize'],2).'","writetime":"'.$rows['adddate'].'","issue":"'.$rows['issue'].'","code":"'.$codes.'","multiple":"'.$rows['times'].'","modes":"'.$rows['mode'].'","totalprice":"'.number_format($rows['money'],2).'","codetype":"'.$rows['type'].'","specicalmethodname":"","methodname":"'.$rows['mname'].'","statusdesc":"'.$status.'"}';
		if($i!=$nums){echo ",";}
		$i=$i+1;
	}
	echo ']';
	exit;
}else if($flag=="gethistory"){
	$sqla="select * from ssc_data where cid='7' and issue='".$_REQUEST['issue']."'";
	$rsa=mysql_query($sqla) or  die("数据库修改出错3");
	$rowa = mysql_fetch_array($rsa);
	if(empty($rowa)){
		echo "empty";
	}else{
		$cn1=substr($rowa['code'],0,1);
		$cn2=substr($rowa['code'],2,1);
		$cn3=substr($rowa['code'],4,1);
		$cn4=substr($rowa['code'],6,1);
		$cn5=substr($rowa['code'],8,1);
		echo "{\"code\":[\"".$cn1."\",\"".$cn2."\",\"".$cn3."\",\"".$cn4."\",\"".$cn5."\"],\"issue\":\"".$_REQUEST['issue']."\",\"statuscode\":\"2\",\"xt\":\"".pxt($rowa['code'],$lotteryid)."\",\"history\":\"".$hstr."\"}";//empty
	}
}else if($flag=="read"){
	echo "{issue:'".$issue."',nowtime:'".date("Y-m-d H:i:s")."',opentime:'".$opentime."',saleend:'".$endtime."',sale:'".$salenums."',left:'".$leftnums."'}";//empty未到销售时间
}else if($flag=="save"){
	require_once 'playact.php';

}else{
//	echo "kkk".$issue;
	$sqlc="select * from ssc_data where cid='7' order by issue desc limit 1";
	$rsc=mysql_query($sqlc) or  die("数据库修改出错!!");
	$rowc = mysql_fetch_array($rsc);
	$rebate=cflevel(Get_member(flevel),$lotteryid)/100;
	$na=explode(",",$rowc['code']);
	
	if($issue-$rowc['issue']==1 || (substr($issue,-3)=="001" and substr($rowc['issue'],-3)=="084")){
		$lissue=$rowc['issue'];
		$lendtime=$rowc['endtime'];
		$lopentime=$rowc['opentime'];
		$lstatus=2;
	}else{
		if(substr($issue,-3)=="001"){
			$lnums=084;
			$lissue=date("ymd",mktime(01,01,01,substr($issue,2,2),substr($issue,4,2)-1,"20".substr($issue,0,2))).$lnums;
		}else{
			$lnums=substr($issue,-3)-1;
			$lissue=$issue-1;
		}
		$lnums=sprintf("%03d",$lnums);
		$result=mysql_query("Select * from ssc_nums where cid='".$lotteryid."' and nums='".$lnums."'"); 
		$rst=mysql_fetch_array($result);
		$lendtime=date("Y-m-d H:i:s");
		$lopentime=date("Y-m-d H:i:s",mktime(substr($rst['opentime'],0,2),substr($rst['opentime'],3,2),substr($rst['opentime'],6,2),substr($lissue,2,2),substr($lissue,4,2),"20".substr($lissue,0,2)));
		$lstatus=0;
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>娱乐平台  - 开始游戏[江西时时彩]</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="Pragma" content="no-cache" />
        <link href="./css/v1/play.css?modidate=20130201001" rel="stylesheet" type="text/css" />
        <script>var pri_imgserver = '';</script>
                <script language="javascript" type="text/javascript" src="./js/lottery/min/jquery.js?modidate=20130415002"></script>
        <script language="javascript" type="text/javascript" src="./js/lottery/min/gamecommon.js?modidate=20130415002"></script>
        <script language="javascript" type="text/javascript" src="./js/lottery/min/jquery.dialogUI.js?modidate=20130415002"></script>
        <script language="javascript" type="text/javascript" src="./js/lottery/min/lang_zh.js?modidate=20130415002"></script>
        <script language="javascript" type="text/javascript" src="./js/lottery/min/face.7.js?modidate=20130415002"></script>
        <script language="javascript" type="text/javascript" src="./js/lottery/min/methods.7.js?modidate=20130415002"></script>
        <script language="javascript" type="text/javascript" src="./js/lottery/min/jquery.game.0.js?modidate=20130415002"></script>
        <script language="javascript" type="text/javascript" src="./js/lottery/min/jquery.messager-min.js?modidate=20130415002"></script>
        <script language="javascript" type="text/javascript" src="./js/lottery/min/message.js?modidate=20130415002"></script>
        <script language="javascript" type="text/javascript" src="./js/jquery.md5.js"></script>
                <script language="javascript">
            function ResumeError() {return true;} window.onerror = ResumeError; 
            document.onselectstart = function(event){
                if(window.event) {
                    event =    window.event;
                }
                try {
                    var the = event.srcElement ;
                    if( !( ( the.tagName== "INPUT" && the.type.toLowerCase() == "text" ) || the.tagName== "TEXTAREA" ) )
                    {
                        return false;
                    }
                    return true ;
                } catch(e) {
                    return false;
                }
            } 
		jQuery(document).ready(function() {
			$('span[class="project_more"]',"#history_project").live("click",function(){
				var mme = this;
				var $h = $('<span style="display: block;" id="task_div">号码详情[<span class="close" id="codeinfos">关闭</span>]<br><textarea readonly="readonly" class="code1">'+$(mme).next().html()+'</textarea></span>');
				$(this).openFloat($h,"projects_more");
				$("#codeinfos").click(function(){
                	$(mme).closeFloat();
            	});
			});
			$("#hshow").click(function(){
				if($("#gctr").is(":hidden")){
                $("#gctrh").hide();
                $("#gctr").show();
				}else{
                $("#gctr").hide();
                $("#gctrh").show();
				}
            });
		});
        </script>
<style type="text/css"> 
.project_more{
	cursor:pointer;
	color:#0000FF;
}
.projects_more{
	width:250px;
	background:#000000;	
	position:absolute;
	z-index:100;
	border:1px #999999 double;
	padding:0px;
	color:#FFFFFF;
	text-align:left;
}
.projects_more span{
	height:20px;
	line-height:20px;
	color:#FFFFFF;
	margin-left:0px;
}
.projects_more .code{
	width:274px;
	height:80px;
	line-height:20px;
	color:#FFFFFF;
	background:#000000;	
	text-align:left;
	border:1px #999999 double;
}
.projects_more .close{
	cursor:pointer;
}
.projectidarea{
	text-decoration:none;
	color:#000000;
	}
#task_div{
	width:250px!important;width:295px;
	height:100px;
	line-weight:20px;
	color:#FFF;
	padding-left:5px;
	background-image: url(http://www.ph278.com:1180/highgame/images/new_higame/alertback.png);
	background-color:#131E31;	
	position:absolute;
	text-align:left;
	overflow:hidden;
	border:1px #131E31 double;
	padding:0px;
}
#task_div a{
    color:#FFF;
}
#task_div a:visited{
    color:#FFF;
}
.code1{
	width:250px!important;width:295px;
	height:80px;
	line-weight:20px;
	color:#000;
	background:#FFF;	
	text-align:left;
	overflow-y:auto;
	border:1px #131E31 double;
	border-left:0px;
}
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
</div>            <div class=" game_rc"> 
                <form>
                    <!--奖期基本信息开始-->
                    <div class="gm_con">
                        <div class="gm_con_tonew">
                            <div class="gct_l">
                                <h3>江西时时彩</h3>
                                <p class="gct_now">正在销售 <strong>第 <span id="current_issue"><?=$issue?></span> 期</strong> 总共: <strong><span id="current_sale">84</span></strong> 期</span></p>
                                <div class="clear"></div>
                                <div class="gct_time">
                                    <p class="gct_now">本期销售截止时间  <span class=nbox id="current_endtime"><?=$endtime?></span></p>
                                    <div class="clear"></div>
                                    <p class="gct_now gct_now1">剩余</p><div class="gct_time_now"><div class="gct_time_now_l"><span id="count_down">00:00:00</span></div></div>
                                </div>
                                <div class="clear"></div>
                                <div class="gct_menu">
                                    <a href='./history_coded.php?id=7&frequencytype=0' target="_blank">胆码走势</a> | <a href='javascript:' id="hshow">开奖号码</a> | <a href='./history_coded.php?id=7&frequencytype=0' target="_blank">遗漏分析</a>
                                </div>
                            </div>
                            <div class="gct_r1" id="gctr">
                                <h3>江西时时彩  第 <b><span class=nn id="lt_gethistorycode"><?=$rowc['issue']?></span></b> 期 <span id="lt_opentimebox" style="display:none;">&nbsp;&nbsp;<span id="waitopendesc">等待开奖</span>&nbsp;<span style="color:#F9CE46;" id="lt_opentimeleft" ></span></span><span id="lt_opentimebox2" style="display:none; color:#F9CE46;"><strong>&nbsp;&nbsp;正在开奖</strong></span></h3>
                                <div style="display:none;" class="tad" id="showadvbox"><a href="#"><img src='./images/company.gif' border="0" /></a></div>
                                <div class="gct_r_nub" id="showcodebox">
                                    <div class="gr_s gr_s<?php if($lstatus==2){echo $na[0];}else{echo "k";}?>" flag="normal"></div>
                                    <div class="gr_s gr_s<?php if($lstatus==2){echo $na[1];}else{echo "k";}?>" flag="normal"></div>
                                    <div class="gr_s gr_s<?php if($lstatus==2){echo $na[2];}else{echo "k";}?>" flag="normal"></div>
                                    <div class="gr_s gr_s<?php if($lstatus==2){echo $na[3];}else{echo "k";}?>" flag="normal"></div>
                                    <div class="gr_s gr_s<?php if($lstatus==2){echo $na[4];}else{echo "k";}?>" flag="normal"></div>
                                                                </div>
                                <div class="gct_r_cont" id="showxt">
                                    <?=pxt($rowc['code'],$lotteryid)?>
                                </div>
                            </div>
                            <div class="gct_rh" id="gctrh" STYLE='display:none'>
                            	<?=$hstr?>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <!--奖期基本信息结束-->
                    <div class="gm_con">
                        <div class="gm_con_lt"></div>
                        <div class="gm_con_rt"></div>
                        <div class="gm_con_lb"></div>
                        <div class="gm_con_rb"></div>
                        <div class="gm_con_to">
                            <!--投注选号标签开始-->
                            <div class="tz_body">
                                <div class="unit">
                                    <div class="unit_title">
                                        <div class="ut_l"></div>
                                        <div class="u_tab_div" id="tabbar-div-s2"></div>
                                        <div class="ut_r"></div>
                                    </div>
                                    <div id="tabCon">
                                        <div class="tabcon_n">
                                            <div class="nl_lt"></div>
                                            <div class="nl_rt"></div>
                                            <div class="nl_lb"></div>
                                            <div class="nl_rb"></div>
                                            <ul id="tabbar-div-s3"></ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <!--投注选标签开始-->
                            <div class="clear"></div>
                            <!--投注选号区开始-->
                            <div class="tzn_body">
                                <div class="tzn_b_n">
                                    <div class="tbn_lt"></div>
                                    <div class="tbn_lb"></div>
                                    <div class="tbn_rt"></div>
                                    <div class="tbn_rb"></div>
                                    <div class="tbn_top">
                                        <h5 id="lt_desc"></h5>
                                        <span class="methodexample" id="lt_example"></span>
                                        <span class="methodhelp" id="lt_help"></span>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="tbn_cen">
                                        <div class="tbn_c_ft"></div>
                                        <div class="tbn_c_s">
                                            <div id="lt_selector"></div>
                                            <div class="random_sel_button" id="random_sel_button" ></div>
                                            <div class="clear"></div>
                                        </div>
                                        <div class="tbn_c_fb"></div>
                                    </div>
                                    <div class="tbn_bot">
                                        <div class="tbn_b_top">
                                            <div class="tbn_bt_sel">
                                                您选择了 <strong><span class=n id="lt_sel_nums">0</span></strong> 注, 共 <strong><span class=n id="lt_sel_money">0</span></strong> 元,
                                                倍数:
                                                <span class="changetime" id="reducetime" title="减少1倍">－</span><INPUT name='lt_sel_times' type='TEXT' size=4 class='bei' id="lt_sel_times"><span class="changetime" id="plustime" title="增加1倍">＋</span>
                                                    倍
                                                    <select name="lt_sel_modes" id="lt_sel_modes">
                                                        <option>元模式</option>
                                                        <option>角模式</option>
                                                    </select>
                                                    <span id="lt_sel_prize" <?php if(false){?>STYLE='display:none'<?php }?>></span>
                                            </div>
                                            <div class="g_submit" id="lt_sel_insert"><span></span></div>
                                            <div class="clear"></div>
                                        </div>
                                        <div class="tbn_b_bot">
                                            <div class="tbn_bb_l">
                                                <div class="tbn_bb_ln">
                                                    <h4><input class="tbn_clear"  id="lt_cf_clear" name="" type="button" value="" /> <span class="icons_q1" id="lt_cf_help">&nbsp;&nbsp;&nbsp;</span> 投注项: <span id="lt_cf_count">0</span></h4>
                                                    <div class="tz_tab_list_box">
                                                        <table cellspacing=0 cellpadding=0 border=0 id="lt_cf_content" class="tz_tab_list">
                                                            <tr class='nr'>
                                                                <td class="tl_li_l" width="4"></td><td colspan="6" class="noinfo">暂无投注项</td><td class="tl_li_rn" width="4"></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tbn_bb_r">
                                                <div class="sub_txt">
                                                    总注数: <strong><span class='r' id="lt_cf_nums">0</span></strong> 注,总金额: <strong><span class='r' id="lt_cf_money">0</span></strong> 元,未来期: <span id="lt_issues"></span>
                                                </div>
                                                <div class="g_submit" id="lt_buy"><span></span></div>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--投注选号区结束-->
                            <div class="clear"></div>
                            <!--追号区开始-->
                            <div class="zh_body">
                                <div class="unit">
                                    <div class="unit_title">
                                        <div class="ut_l"></div>
                                        <h4><label class="zh_title" name="lt_trace_if"><input type="checkbox" name="lt_trace_if" id="lt_trace_if" value="yes">我要追号</label></h4>
                                        <div class="ut_zh">
                                            <label class="zh_continue" name="lt_trace_stop">
                                                <input type="checkbox" name="lt_trace_stop" id="lt_trace_stop" disabled="disabled" value="yes">中奖后停止追号
                                            </label>
                                        </div>
                                        <div class="ut_r"></div>
                                    </div>
                                    <div id="lt_trace_box" STYLE='display:none' class="trace_box">
                                        <div class="tabcon_n">
                                            <div class="nl_lt"></div>
                                            <div class="nl_rt"></div>
                                            <div class="nl_lb"></div>
                                            <div class="nl_rb"></div>
                                            <div class="unit1">
                                                <div class="unit_title2">
                                                    <div class="u_tab_div" id="tab02">
                                                        <div class=bd>
                                                            <div class=bd2 id="general_txt_100">
                                                                <table class="tabbar-div-s3" width='100%'>
                                                                    <tr><td id="lt_trace_label"></td></tr>
                                                                </table>
                                                                <div class=bl3p></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clear"></div>
                                                </div>
                                                <div class="clear"></div>
                                                <div class=zhgen>
                                                    <table width=100% border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td>
                                                                追号期数:<select id="lt_trace_qissueno">
                                                                    <option value="">请选择</option>
                                                                    <option value="5">5期</option>
                                                                    <option value="10" selected>10期</option>
                                                                    <option value="15">15期</option>
                                                                    <option value="20">20期</option>
                                                                    <option value="25">25期</option>
                                                                    <option value="all">全部</option>
                                                                </select>
                                                                总期数: <span class=y id="lt_trace_count">0</span> 期  追号总金额: <span class=y id="lt_trace_hmoney">0</span> 元
                                                                <br/>
                                                                追号计划: <span id="lt_trace_labelhtml"></span>
                                                            </td>
                                                            <td rowspan=2 valign=bottom align=right>
                                                                <div class="g_submit" id="lt_trace_ok"><span></span></div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <table width="100%" cellspacing=0 cellpadding=0 border=0 bgcolor="#F0D4D4"><tr><td width=90 align=center height=22>选择</td><td width=130 align=center>期数</td><td width=140 align=center>倍数</td><td width=100 align=center>金额</td><td align=center>截止时间</td></tr></table>
                                                <div class=zhlist id="lt_trace_issues"></div>
                                                <input type="hidden" name="lotteryid" id="lotteryid" value="7" />
                                                <input type="hidden" name="flag" id="flag" value="save" /> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--追号区结束-->
                        </div>
                    </div>
                                        <div class="clear"></div>
                    <div class="gm_con">
                        <div class="gm_con_lt"></div>
                        <div class="gm_con_rt"></div>
                        <div class="gm_con_lb"></div>
                        <div class="gm_con_rb"></div>
                        <div class="gm_con_to">
                            <div class="yx_body">
                                <div class="unit">
                                    <div class="unit_title">
                                        <div class="ut_l"></div>
                                        <h4><label class="yx_title">游戏记录</label></h4>
                                        <div class="ut_r"></div>
                                    </div>
                                </div>
                                <div class="yx_box">
                                    <div class="nl_lt"></div>
                                    <div class="nl_rt"></div>
                                    <div class="nl_lb"></div>
                                    <div class="nl_rb"></div>
                                    <div class="yxlist">
                                        <div class="nl_lt"></div>
                                        <div class="nl_rt"></div>
                                        <div class="nl_lb"></div>
                                        <div class="nl_rb"></div>
                                        <table width=100% border="0" cellspacing="0" cellpadding="0" id="history_project">
                                            <tr>
                                                <th>注单编号</th>
                                                <th>投注时间</th>
                                                <th>玩法</th>
                                                <th>期号</th>
                                                <th>投注内容</th>
                                                <th>倍数</th>
                                                <th>模式</th>
                                                <th>总金额</th>
                                                <th>奖金</th>
                                                <th>状态</th>
                                            </tr>
                                            <tbody class="projectlist">
<?php 
	$htime=date("Y-m-d",strtotime("-5 day"))." 03:00:00";
	$sqls="select * from ssc_bills where lotteryid='".$lotteryid."' and username='".$_SESSION["username"]."' and adddate >='".$htime."' order by id desc limit 10";
	$rss=mysql_query($sqls) or  die("数据库修改出错1");
	$nums = mysql_num_rows($rss);
	if($nums==0){
?>
                                                <tr class="no-records">
                                                    <td height="37" colspan="10" align="center">没有找到指定条件的投注记录</td>
                                                </tr>
<?
	}else{
	while ($rows = mysql_fetch_array($rss)){
		if($rows['zt']==0){
			$status="未开奖";
			$iscancel=0;
		}elseif($rows['zt']==1){
			$status="<font color=red>已派奖</font>";
			$iscancel=0;
		}elseif($rows['zt']==2){
			$status="未中奖";
			$iscancel=0;
		}elseif($rows['zt']==4){
			$status="管理员撤单";
			$iscancel=1;
		}elseif($rows['zt']==5){
			$status="本人撤单";
			$iscancel=1;
		}elseif($rows['zt']==6){
			$status="开错奖撤单";
			$iscancel=1;
		}
?>
                                                <tr <?php if($rows['iscancel']==1){?>class="cancel"<?php }?>>
                                                    <td><a href="./history_playinfos.php?id=<?=$rows['dan']?>"  target="_blank" title="查看投注详情" class="blue"><?=$rows['dan']?></a></td>
                                                    <td><?=$rows['adddate']?></td>
                                                    <td><?=$rows['mname']?></td>
                                                    <td><?=$rows['issue']?></td>
                                                    <td><?php $codes=dcode($rows['codes'],$lotteryid,$rows['mid']);if(strlen($codes)>20){echo '<span class="project_more">号码详情</span><div style="display:none;">'.$codes.'</div>';}else{echo $codes;}?></td>
                                                    <td><?=$rows['times']?></td>
                                                    <td><?=$rows['mode']?></td>
                                                    <td><?=number_format($rows['money'],2)?></td>
                                                    <td><?=number_format($rows['prize'],2)?></td>
                                                    <td><?=$status?></td>
                                                </tr>
<?php }}?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="gm_con">
                        <div class="gm_con_lt"></div>
                        <div class="gm_con_rt"></div>
                        <div class="gm_con_lb"></div>
                        <div class="gm_con_rb"></div>
                        <div class="gm_con_to">
                            <table width=100% border="0" cellspacing="0" cellpadding="0">
                            	<tr><td height="25" align="center">浏览器建议：首选IE 8.0,Chrome浏览器，其次为火狐浏览器,尽量不要使用IE6。</td></tr>
                            	<tr><td height="25" align="center">资金安全建议：为了您的资金安全请定期更换资金密码。</td></tr>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            var pri_user_data = [
<?php
	$sqlb="select * from ssc_class where cid='7' order by id asc";
	$rsb=mysql_query($sqlb) or  die("数据库修改出错!");
	$nums=mysql_num_rows($rsb);

	$i=1;
	while ($rowb = mysql_fetch_array($rsb)){
		echo "{methodid : ".$rowb['mid'].",prize:{";
		$rstra=explode(";",$rowb['rates']);
		for($ii=1;$ii<=count($rstra);$ii++){
			echo $ii.":'".$rstra[$ii-1]."'";
			if($ii!=count($rstra)){
				echo ",";
			}
		}
		echo "},dyprize:[";
		for($ii=1;$ii<=count($rstra);$ii++){
			echo "{\"level\":".$ii.",\"prize\":[";
			for($iii=1;$iii<=$ii;$iii++){
//				if($rstra[$iii-1]>100){
//					$rprize=$rstra[$iii-1]+floor($rstra[$iii-1]*$rebate*100/90);
//				}else{
					$rprize=$rstra[$iii-1]+round($rstra[$iii-1]*$rebate*100/90,4);
//				}
				
				echo "{\"point\":\"".$rebate."\",\"prize\":".$rstra[$iii-1]."},";
				echo "{\"point\":0,\"prize\":".$rprize."}";
				if($iii!=$ii){
					echo ",";
				}
			}
			echo "]}";
			if($ii!=count($rstra)){
				echo ",";
			}
		}
		echo "]}";
		if($i!=$nums){echo ",";}
		$i=$i+1;
	}
?>
			];
            var pri_cur_issue = {issue:'<?=$issue?>',endtime:'<?=$endtime?>',opentime:'<?=$opentime?>'};
            var pri_issues  = [
<?php
	$sqlb="select * from ssc_nums where cid='7' order by id asc";
	$rsb=mysql_query($sqlb) or  die("数据库修改出错!");
	while ($rowb = mysql_fetch_array($rsb)){
		echo "{issue:'".$dymd.$rowb['nums']."',endtime:'".$dymd2." ".$rowb['endtime']."'},";
	}
	$sqlb="select * from ssc_nums where cid='7' order by id asc";
	$rsb=mysql_query($sqlb) or  die("数据库修改出错!");
	while ($rowb = mysql_fetch_array($rsb)){
		echo "{issue:'".$dymdt.$rowb['nums']."',endtime:'".$dymdt2." ".$rowb['endtime']."'}";
		if($rowb['nums']!="084"){echo ",";}
	}
?>	
			];
            var pri_lastopen  = {issue:'<?=$lissue?>',endtime:'<?=$lendtime?>',opentime:'<?=$lopentime?>',statuscode:'<?=$lstatus?>'};
            var	pri_issuecount= 84;
            var pri_servertime= '<?=date("Y-m-d H:i:s")?>';
            var pri_lotteryid = parseInt(7,10);
            var	pri_isdynamic = 1;
            var pri_showhistoryrecord = 1;
            var pri_ajaxurl   = './play_jxssc.php';

        </script>
    </body>
</html>
<?php }?>