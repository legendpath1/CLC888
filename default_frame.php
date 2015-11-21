<?php
error_reporting(0);
session_start();
//error_reporting(0);
require_once 'conn.php';

//$_SESSION["uid"]="1";
//$_SESSION["username"]="test";
//$_SESSION["valid"]="123456";

if($_SESSION["uid"]=="" || $_SESSION["username"]=="" || $_SESSION["valid"]==""){
	echo "<script language=javascript>window.location='default_logout.php';</script>";
	exit;
}

if($_SESSION["mainframe"]=="") {
	$_SESSION["mainframe"] = '"./help_security.php"';
}

$flag=$_REQUEST['flag'];

$infon=array("蓝色芥末","老大","龙抬头","絮尘倾恬","灵之舞","爱哭的小魔女","柠檬草精铃","冰蓝水蜜桃","幸福科达琳","苍天","紫月幽魔灵","果冻","淹死的鱼","逝水无痕","寂寞的cd机","会飞的鱼","因为爱","小鱼","tank","懿切瀡缘","绝伦","浪漫樱花","she","开心果","haΡpy舞","DJ耶稣","江湖","星期八","空军一号","发大财","litter star","凮惪","火柴棍","珍惜","pea","我要发","快刀","二月二","kfc","music","独一无二","爱你1314","马上有钱","25987642","爱你的人","一生有你","快乐","完美人生","駃乐眼涙,","cattty","飞天","蓝铯峢痕","蒍祢变乖","爱死袮,","kitty","简单","开心","crazy","天使","任性撒野","永恒的心","UFO","鈨帅","将军","寻觅","lune","绝恋","马年有余","简简单单","魔鬼","蓝色之恋","天使","遗莣","绿草","wahaha","夏玉","吧吧豆","UST","star","黄金","秒杀","笑傲江湖","菱薍","寻觅","约锭","发发发","坏脾哫","sailor","潕钶取玳","覑荱曲.","东方不败","龙抬头","蒤鸦","西北孤狼","怖鲑鲑．","开心果","网管","贪翫","hello","miao","味之素","小沈阳","好运连连","pentagram","佐笾","莣忧草","消失嘚美俪","心若止水","我心飞鴹","marko","seina","gogo","依猫","优雅的颓废","闪舞","胡言乱语","埘緔芭比","蓝天","飞的车","外星人","鸳鸯戏氺","色丝线","七婇炫躌","一碗海","rainbow","空军一号","兲倥咹静.","苍井空","开心一刻","优雅的颓废","凝芸冰澜","选择莣记","二人转","梦羽","谜乱","发财猫","老虎","帅气","中华一号","痕迹","道殉霜晨","夏天","money","猛男","放飞心情","二爷","宝哥","二胖","香港人","来八及的拥抱","葫芦头","钱满仓","们偠开鈊","浅蓝铯的爱","茴亿","happy","个性男孩","龙马精神","我形我素","mylove","爱像云","我继续孤单","1楼的日记","眼泪啲錵吙","港湾","蒾纞","发大财","马上发财","lune","遗失的美好","沉默菋噵","habit","雷锋"); 
$infop=array("1900.00","5800.00","3926.80","3460.00","5780.60","17360.00","5820.00","11640.00","7768.00","15536.00","3888.00");

$sqlc = "select * from ssc_info order by adddate desc limit 6";
$rsc = mysql_query($sqlc);
$infos = mysql_num_rows($rsc);
$i=0;
while ($rowc = mysql_fetch_array($rsc)){
	$infoa[$i]=$rowc['lottery'];
	$infob[$i]=$rowc['issue'];
	$i=$i+1;
}

$sql = "select ssc_bills.*,ssc_member.nickname from ssc_bills left join ssc_member on ssc_bills.uid=ssc_member.id where ssc_bills.zt=1 and ssc_bills.prize>1700 order by ssc_bills.id desc limit 15";
$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

if($flag=="gettoprize"){
//	$lotteryid=$_REQUEST['lotteryid'];
//	$issue=$_REQUEST['issue'];	//120225076	30条
	echo "[";
	$i=0;
	while ($row = mysql_fetch_array($rs)){
		echo "{\"name\":\"".$row['nickname']."\",\"lottery\":\"".$row['lottery']."\",\"issue\":\"".$row['issue']."\",\"prize\":\"".number_format($row['prize'],2)."\",\"s\":3}";
		if($infos>0){
			echo ",";
			$ii=mt_rand(0,5);
			echo "{\"name\":\"".$infon[mt_rand(0,172)]."\",\"lottery\":\"".$infoa[$ii]."\",\"issue\":\"".$infob[$ii]."\",\"prize\":\"".$infop[mt_rand(0,10)]."\",\"s\":3}";
		}
		if($i!=$total-1){echo ",";}
		$i=$i+1;
	}
	echo "]";
	exit;
}
$sqls = "select id,topic from ssc_news where shows=1 order by id desc";
$rss = mysql_query($sqls);
while ($rows = mysql_fetch_array($rss)){
	$ggs=$ggs.'<span style="margin:50px;">&nbsp;</span><a href="help_security.php?id='.$rows['id'].'" target="mainframe"><font color="#FFFFFF">'.$rows['topic'].'</font></a>';
}
$sqls = "select ggshow from ssc_config";
$rss = mysql_query($sqls);
$rows = mysql_fetch_array($rss);
$ggshow=$rows['ggshow'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
    <HEAD>
        <META http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <TITLE>娱乐平台</TITLE>
        <LINK href="./css/v1/header.css?modidate=20130201001" rel="stylesheet" type="text/css" />
        <link href="./css/v1/innerchat.css?modidate=20130201001" rel="stylesheet" type="text/css" />
        <script language="javascript" type="text/javascript" src="./js/jquery.js?modidate=20130415002"></script>
        <script language="javascript" type="text/javascript" src="./js/common.js?modidate=20130415002"></script>
                <SCRIPT language="javascript" type="text/javascript">
            var  resizeTimer = null;
            jQuery(document).ready(function(){
                $(".menu").find("a").click(function(){
                    $(this).siblings().removeClass("active");
                    $(this).addClass("active");
                });
                if($(window).width() < 980){
                    $("#toptable").width(980);
                    $("#testlogo").css("left","200px");
                }else{
                    $("#toptable").width($(window).width());
                    $("#testlogo").css("left","255px");
                }
//				alert( jQuery(document).height() );
//                jQuery("#mainbox").height( jQuery(document).height()-jQuery("#topbox").height()-jQuery("#noticebox").height()-8 );
                jQuery("#leftbox").height( jQuery(document).height()-jQuery("#toptable").height() );
<?php if($ggshow!=1){?>
                jQuery("#mainbox").height( jQuery("#leftbox").height() );
<?php }else{?>
                jQuery("#mainbox").height( jQuery("#leftbox").height()-35 );
<?php }?>
                $(window).resize(function(){
                   if(resizeTimer==null){
                       resizeTimer = setTimeout("resizewindow()",300);
                    }
                }); 

                jQuery("#dragbox").click(function(){
                    if( jQuery("#dragbutton").attr("class") == "lsid_cen" ){
                        jQuery("#dragbutton").attr("class",'lsid_cenr');
                        jQuery("#leftbox").css({width:"0px"}).hide();
                        jQuery("#mainbox").css({width:"100%"});
                    }else{
                        jQuery("#dragbutton").attr("class",'lsid_cen');
                        jQuery("#leftbox").css({width:"193px"}).show();
                        jQuery("#mainbox").css({width:"auto"});
                    }
					//$("#marquees").width($(window).width() - $("#leftbox").width() - 90);
                });
				$("#marquees").width($(window).width() - $("#leftbox").width() - 90);

                _fastData = setInterval(function(){
                    var $lf = $("#leftusermoney",window.top.frames['leftframe'].document);
                    $.ajax({
                        type : 'POST',
                        url  : '/default_getfastdata.php?flag=fromcache',
                        timeout : 9000,
                        success : function(data){
                            var partn = /<(.*)>.*<\/\1>/;
                            if( partn.exec(data) ){
                                return false;
                            }
                            eval("data="+data+";");
                            //用户余额
							if( data.money == 'Error' ){
								window.top.location.href="./";
								return false;
							}
                            if( data.money != 'empty' ){
                                var dd = moneyFormat(data.money);
                                dd = dd.substring(0,(dd.length-2));
                                $lf.html(dd);
                            }
                            return true;
                        }
                    });
                },20000);

            });
            function resizewindow(){
                if($(window).width() < 980){
                    $("#toptable").width(980);
                }else{
                    $("#toptable").width($(window).width());
                }
                jQuery("#mainbox").height( jQuery(window).height()-jQuery("#topbox").height()-<?php if($ggshow!=1){echo 0;}else{echo 35;}?> );
                jQuery("#leftbox").height( jQuery(window).height()-jQuery("#topbox").height() );
                resizeTimer = null;
            }
        </script>
        <SCRIPT LANGUAGE='JavaScript'>function ResumeError() {return true;} window.onerror = ResumeError; </SCRIPT>
        <style>
            html {overflow: hidden;}
        </style>
    </HEAD>
    <BODY>
<?php
//远程同步登录api
$sapi_url = Create_SAPI_Url($_SESSION["username"], strtoupper($_SESSION["pwd"]), '', '', 0, 'login');
echo('<script type="text/javascript" src="' . $sapi_url . '"></script>');
?>
        <table border="0" cellpadding="0" cellspacing="0" id="toptable">
            <tr>
                <td id="topbox">
                    <div id="header">
                        <div class="logo"><a href="?"><img src="./images/header/logo.png" width="162" height="53" /></a></div>
                        <div class="hd"><a href="promotion_center.php" target="mainframe"><img src="./images/header/hd.png"/></a></div>
                                                <div class="menu">
                                                        <a class="csonline_addnew" href="http://api.pop800.com/chat/167901" target="_blank"><span></span></a>
                                                        <a class="help_general" href="/help_general.php" target="mainframe"><img src="images/header/ball1.gif" width=20 height=20 style="margin-bottom:-3px">帮助中心</a>
                                                        <a class="report_list" href="/report_list.php" target="mainframe"><img src="images/header/ball1.gif" width=20 height=20 style="margin-bottom:-3px">报表管理</a>
                                                        <a class="users_list" href="/users_list.php" target="mainframe"><img src="images/header/ball1.gif" width=20 height=20 style="margin-bottom:-3px">用户管理</a>
                                                        <a class="history_playlist" href="/history_playlist.php" target="mainframe"><img src="images/header/ball1.gif" width=20 height=20 style="margin-bottom:-3px">游戏记录</a>
                                                        <a class="users_info" href="/users_info.php" target="mainframe"><img src="images/header/ball1.gif" width=20 height=20 style="margin-bottom:-3px">我的帐户</a>
                                                        <a class="account_autosavea" href="/account_autosavea.php" target="mainframe"><img src="images/header/ball1.gif" width=20 height=20 style="margin-bottom:-3px">充值提现</a>
                                                        <a class="help_security" href="/help_security.php" target="mainframe"><img src="images/header/ball1.gif" width=20 height=20 style="margin-bottom:-3px">平台公告</a>
                                                </div>
                        <!--<div class="h_line"></div>-->
                                            <div class="gonggaodiv"><div id="zjtgul">
											</div></div>

                    </div>
                </td>
            </tr>
        </table>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td valign="top" id="leftbox" rowspan="2">
                    <iframe name="leftframe" id="leftframe" frameborder="0" width="100%" height="100%" scrolling="auto" src="./default_menu.php"></iframe>
                </td>
                <td valign="middle" id="dragbox" class="left_sidbar" rowspan="2">
                    <div id="dragbutton" class="lsid_cen"></div>
                </td>
                <td id="noticebox" valign="top" <?php if($ggshow!=1){?>STYLE='display:none'<?php }?>><div id="bonusnotice" class="bonusnotice">
    <span class="nocticetitle">重要公告:</span>
    <div id="marquee_container"><marquee id="marquees" behavior="scroll" direction="left" scrollamount="2" onMouseOut="this.start()" onMouseOver="this.stop()"><?=$ggs?></marquee></div>
</div>
<script>
    $(function(){
	var _wrap=$('#zjtgul');
	var _interval=3000;
	var _moving;
	_wrap.hover(function(){
            clearInterval(_moving);
	},function(){
            _moving=setInterval(function(){
                var _field=_wrap.find('span:first');
                var _h=_field.height();
                _field.animate({marginTop:-_h+'px'},600,function(){
                    _field.css('marginTop',0).appendTo(_wrap);
                })
            },_interval)
	}).trigger('mouseleave');
        gettopprize();
    });
//    $("#bonusnotice").click(function(){
//        $(".bonusnotice").css("height","0");
//        $(".bonusnotice").html("");

//        clearInterval(_permgetdata);
//        jQuery("#mainbox").height( jQuery(document).height()-jQuery("#topbox").height()-jQuery("#noticebox").height() );
//        jQuery("#leftbox").height( jQuery(document).height()-jQuery("#topbox").height() );
//    });
    _permgetdata = setInterval(function(){
        gettopprize();
    },290000);
    gettopprize = function(){
        $.ajax({
            type : 'POST',
            url  : './default_frame.php',
            data : 'flag=gettoprize',
            timeout : 30000,
            success : function(data){
                var partn = /<(.*)>.*<\/\1>/;
                if( partn.exec(data) ){
                    return false;
                }
                if( data != 'empty' ){
                    eval("data="+data+";");
                    var shtml = '';
                    $.each(data,function(i,n){
                        shtml += '<span class="marqueediv">恭喜用户 【<span class=username>'+n.name+'</span>】 '+n.lottery+' <span class=issue>'+n.issue+'</span> 期, 喜中 <span class=bonus>'+n.prize+'</span> 元大奖!</span>';
                    });
                    $("#zjtgul").empty();
                    $("#zjtgul").html(shtml);
                }
                return true;
            },
            error: function(){
                $lf.html("<font color='#A20000'>获取失败</font>");
            }
        });
    }
</script></td>
            </tr>
            <tr>
                <td id="mainbox" valign="top">
                    <iframe name="mainframe" id="mainframe" frameborder="0" width="100%" height="100%" scrolling="auto" src=<?php echo $_SESSION["mainframe"]; ?>></iframe>
                </td>
            </tr>
        </table>

</BODY>
</HTML>