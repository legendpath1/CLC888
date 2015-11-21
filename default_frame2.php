<?php
session_start();
error_reporting(0);
require_once 'conn.php';

//$_SESSION["uid"]="1";
//$_SESSION["username"]="test";
//$_SESSION["valid"]="123456";

if($_SESSION["uid"]=="" || $_SESSION["username"]=="" || $_SESSION["valid"]==""){
	echo "<script language=javascript>window.location='default_logout.php';</script>";
	exit;
}

$flag=$_REQUEST['flag'];

$sql = "select ssc_bills.*,ssc_member.nickname from ssc_bills left join ssc_member on ssc_bills.uid=ssc_member.id where ssc_bills.zt=1 and ssc_bills.prize>2000 order by ssc_bills.id desc limit 15";
$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

if($flag=="gettoprize"){
//	$lotteryid=$_REQUEST['lotteryid'];
//	$issue=$_REQUEST['issue'];	//120225076	30条
	echo "[";
	$i=0;
	while ($row = mysql_fetch_array($rs)){
		echo "{\"name\":\"".$row['nickname']."\",\"lottery\":\"".$row['lottery']."\",\"issue\":\"".$row['issue']."\",\"prize\":\"".number_format($row['prize'],2)."\",\"s\":3}";
		if($i!=$total-1){echo ",";}
		$i=$i+1;
	}
	echo "]";
	exit;
}

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
                jQuery("#mainbox").height( jQuery(document).height()-jQuery("#topbox").height()-jQuery("#noticebox").height() );
                jQuery("#leftbox").height( jQuery(document).height()-jQuery("#topbox").height() );
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
                        jQuery("#leftbox").css({width:"175px"}).show();
                        jQuery("#mainbox").css({width:"auto"});
                    }
                });
                _fastData = setInterval(function(){
                    var $lf = $("#leftusermoney",window.top.frames['leftframe'].document);
                    var $add = $('#addmoney',window.top.frames['leftframe'].document);
                    var $usermoney = $('#usermoney',window.top.frames['leftframe'].document);
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
                            if( data.money != 'empty' ){
                                var dd = moneyFormat(data.money);
                                var original = parseFloat($usermoney.val().replace(/,/g,""));
                                var diff = parseFloat(data.money-original);
                                diff = diff.toFixed(2);
                                if(diff < -0.01 || diff > 0.01){
                                    var shtml = "";
                                    var oridiff = diff;
                                    diff = diff.split("");
                                    $.each(diff,function(i,n){
                                        if(n=='.'){
                                            shtml += '<div class="nub nubd"></div>';
                                        }else if(n==','){

                                        }else{
                                            shtml += '<div class="nub nub'+n+'"></div>';
                                        }
                                    })
                                    if(oridiff>0){
                                        shtml = '<div class="nub nubplus"></div>'+shtml;
                                        $add.html(shtml);
                                    }else{
                                        shtml = '<div class="nub nubreduce"></div>'+shtml;
                                        $add.html(shtml);
                                    }
                                    $add.css("top","10px");
                                    $add.animate({"top": "-=120px"}, 3000 );
                                }
                                $usermoney.val(dd);
                                dd = dd.substring(0,(dd.length-2));
                                var shtml = "";
                                dd = dd.split("");
                                $.each(dd,function(i,n){
                                    if(n=='.'){
                                        shtml += '<div class="nub nubd"></div>';
                                    }else if(n==','){

                                    }else{
                                        shtml += '<div class="nub nub'+n+'"></div>';
                                    }
                                });
                                $lf.html(shtml);
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
                jQuery("#mainbox").height( jQuery(window).height()-jQuery("#topbox").height() );
                jQuery("#leftbox").height( jQuery(window).height()-jQuery("#topbox").height() );
                resizeTimer = null;
            }
        </script>
        <script language="javascript" type="text/javascript" src="./js/lottery/min/swfobject.js?modidate=20130415002">
        <SCRIPT LANGUAGE='JavaScript'>function ResumeError() {return true;} window.onerror = ResumeError; </SCRIPT>
        <script language="javascript" type="text/javascript">
        var initialcenter = false;
        var bottomFlash = undefined;
        // For version detection, set to min. required Flash Player version, or 0 (or 0.0.0), for no version detection. 
        var swfVersionStr = "11.1.0";
        // To use express install, set to playerProductInstall.swf, otherwise the empty string. 
        var xiSwfUrlStr = "./csonline/playerProductInstall.swf";
        var flashvars = {};
        flashvars.param1 = "tianxiaxing002";
        flashvars.param2 = "d02ed9e8e45de66ad83bc06ff7c7ca0b";
        flashvars.param3 = "79494";
        flashvars.param4 = "www.sj528.com/chat/index.php?u=";
        flashvars.param5 = "./csonline";
        flashvars.rand = Math.floor((Math.random() * 4294967295) + 1);
        var params = {};
        params.quality = "high";
        params.bgcolor = "#ffffff";
        params.allowscriptaccess = "always";
        params.allowfullscreen = "true";
        var attributes = {};
        $(document).ready(function() {
            loadCenterSwf();
        });
        function loadBottomSwf(retVal)
        {
            attributes.id = "bottom";
            attributes.name = "bottom";
            attributes.align = "right";
            swfobject.embedSWF(
            "./csonline/bottom.swf", "flashContent",
            "100%", "100%",
            swfVersionStr, xiSwfUrlStr,
            flashvars, params, attributes, endLoadings);

        }

        function loadRightSwf(retVal)
        {
            bottomFlash = retVal.ref;
            attributes.id = "right";
            attributes.name = "right";
            attributes.align = "right";
            swfobject.embedSWF(
            "./csonline/right.swf", "rightContent",
            "100%", "100%",
            swfVersionStr, xiSwfUrlStr,
            flashvars, params, attributes, loadBottomSwf);
        }

        function loadCenterSwf(retVal)
        {
            attributes.id = "center";
            attributes.name = "center";
            attributes.align = "right";
            swfobject.embedSWF(
            "./csonline/center.swf", "centerContent",
            "100%", "100%",
            swfVersionStr, xiSwfUrlStr,
            flashvars, params, attributes, loadRightSwf);
        }


        function endLoadings(retVal)
        {

        }


        function showContactList(value)
        {
            if (value)
            {
                setTimeout(function() {
                    $("#rightContentContainer").css({"width": "160px", "height": "450px", "right": "0", "top": "50%", "margin-top": "-225px"});
                    clearTimeout();
                }, 1);
            }
            else
            {
                $("#rightContentContainer").css({"width": "2px", "height": "2px", "margin": "0 auto"});
            }
        }

        function showCenter(value)
        {
            if (value)
            {
                $("#centerContentContainer").css({"width": "760px", "height": "500px", "margin": "0 auto", "left": "50%", "top": "50%", "margin-left": "-380px", "margin-top": "-250px"});
            }
            else
            {
                $("#centerContentContainer").css({"width": "2px", "height": "2px", "margin": "0 auto","position":"fixed","left":"0","top":"0"});
            }
        }
        var centerhidden = false;
        function button_click()
        {
            centerhidden = !centerhidden;
            showCenter(centerhidden);
        }
        function senToActionScript(value)
        {
            if (bottomFlash && typeof bottomFlash.notify != "undefined") {
                bottomFlash.notify(value);
            }
        }
    </script>        <style>
            html {overflow: hidden;}
        </style>
    </HEAD>
    <BODY>
        <table border="0" cellpadding="0" cellspacing="0" id="toptable">
            <tr>
                <td id="topbox">
                    <div id="header">
                        <div class="logo"><a href="/"><img src="./images/header/logo.jpg" width="195" height="61" /></a></div>
                                                <div class="menu">
                                                        <a class="help_general" href="/help_general.php" target="mainframe"><span></span></a>
                                                        <a class="users_info" href="/users_info.php" target="mainframe"><span></span></a>
                                                        <a class="report_list" href="/report_list.php" target="mainframe"><span></span></a>
                                                        <a class="users_list" href="/users_list.php" target="mainframe"><span></span></a>
                                                        <a class="history_playlist" href="/history_playlist.php" target="mainframe"><span></span></a>
                                                        <a class="account_autosave" href="/account_autosave.php" target="mainframe"><span></span></a>
                                                        <a class="help_security" href="/help_security.php" target="mainframe"><span></span></a>
                                                    </div>
                        <div class="h_line"></div>
                    </div>
                </td>
            </tr>
        </table>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td valign="top" id="leftbox" rowspan="2">
                    <iframe name="leftframe" id="leftframe" frameborder="0" width="100%" height="100%" scrolling="auto" src="/default_menu.php"></iframe>
                </td>
                <td valign="middle" id="dragbox" class="left_sidbar" rowspan="2">
                    <div id="dragbutton" class="lsid_cen"></div>
                </td>
                <td id="noticebox" valign="top"><div id="bonusnotice" class="bonusnotice" title="点击关闭">
    <span class="nocticetitle">最新大奖名单(点击关闭):</span>
    <div id="zjtgul"></div>
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
    $("#bonusnotice").click(function(){
        $(".bonusnotice").css("height","0");
        $(".bonusnotice").html("");
        SetCookie('hidenotice',1,86400);
        clearInterval(_permgetdata);
        jQuery("#mainbox").height( jQuery(document).height()-jQuery("#topbox").height()-jQuery("#noticebox").height() );
        jQuery("#leftbox").height( jQuery(document).height()-jQuery("#topbox").height() );
    });
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
                        shtml += '<span class="marqueediv">恭喜 【<span class=username>'+n.name+'</span>】 '+n.lottery+' <span class=issue>'+n.issue+'</span> 期, 喜中 <span class=bonus>'+n.prize+'</span> 大奖!</span>';
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
                    <iframe name="mainframe" id="mainframe" frameborder="0" width="100%" height="100%" scrolling="auto" src="/help_security.php"></iframe>
                </td>
            </tr>
        </table>
        <div id="rightContentContainer" ><div id="rightContent"></div></div>
<div id="centerContentContainer">
    <div id="centerContent">
    </div>
</div>
<div id="flashContentContainer"><div id="flashContent"></div></div>    </BODY>
</HTML>{