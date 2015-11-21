<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$sql="select * from ssc_member where regup='".$_SESSION["username"]."' order by id asc";
//echo $sql;
$rs = mysql_query($sql);
$total = mysql_num_rows($rs);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=utf-8" />
<TITLE>用户列表</TITLE>
<script>var pri_imgserver = '';</script>
<script language="javascript" type="text/javascript" src="./js/jquery.js?modidate=20130415002"></script>
<script language="javascript" type="text/javascript" src="./js/common.js?modidate=20130415002"></script>
<SCRIPT type="text/javascript" src="./js/lottery/min/jquery.dialogUI.js"></SCRIPT>
<SCRIPT type="text/javascript">
jQuery.blockUI.defaults.message='<div style="color:#FFFFFF;">正在加载..</div>';jQuery.blockUI.defaults.css={padding:0,margin:"0 auto",width:"120px",top:"2px",left:"8px",textAlign:"center",color:"#FF0000",border:"1px solid #FF0000",backgroundColor:"#FFF",cursor:"wait"};jQuery.blockUI.defaults.overlayCSS={backgroundColor:"#000",opacity:0.7};function getChildList(obj,uid){if(jQuery(obj).parent().find("ul").html()!=null){if(jQuery(obj).attr("title")=="点击展开"){jQuery(obj).css("background-color","#360");jQuery(obj).attr("title","点击隐藏");jQuery(obj).parent().find("ul:first").slideDown("fast");}else{jQuery(obj).css("background-color","#A00");jQuery(obj).attr("title","点击展开");jQuery(obj).parent().find("ul:first").slideUp("fast");}}else{jQuery().ajaxStart($.blockUI).ajaxStop($.unblockUI);html=jQuery(obj).closest("li").html();jQuery(obj).ajaxStart(function(){jQuery(obj).attr("title","点击隐藏");jQuery(obj).css("background-color","#360");});jQuery.ajax({type:"GET",url:"./users_list.php?frame=menu&uid="+uid,dataType:"json",cache:false,success:function(data){if(data.error=="empty"){jQuery(obj).parent().append("<ul style='display:none;'><li></li></ul>");}else{if(data.error=="0"){dataHtml="<ul id=ext>";jQuery.each(data.result,function(i,n){dataHtml+="<li> &nbsp;<a TITLE='点击查看' href=\"./users_list.php?frame=show&uid="+n.userid+"\" target='userlist_content'>";if(n.childcount>0){dataHtml+=replaceHTML(n.username)+"</a><span TITLE='点击展开' class='n_links' onclick=\"getChildList(this,"+n.userid+')" >'+n.childcount+"</span>";}else{dataHtml+=replaceHTML(n.username)+"</a><span TITLE='点击展开' class='n'>"+n.childcount+"</span>";}});dataHtml+="</li></ul>";jQuery(obj).parent().append(dataHtml);}else{return true;}}}});}}
</SCRIPT>
<STYLE type="text/css">
html{overflow-y:scroll;width:132px;overflow-x: hidden;}
body{background-color:#767878;}
body, ul, li, td{margin:0; padding:0; font: 12px "宋体","sans-serif", "Arial", "Verdana";}
ul{list-style:none; margin:0; padding:0; width:132px; float:left;}
ul li{line-height:22px; width:132px; text-align:left; float:left; border-top:1px solid #767878;border-bottom:1px solid #444;}
ul li:hover{background-color: #ff9933;color: #FFF;border-top: 1px solid #fee0b9;}
.n, .n_links{margin:2px 3px 1px 0px; *margin-top:-20px;float:right; background-color:#4D4F4F;border: 1px solid #333; color:#8f8f8f;min-width:12px;text-align:center; line-height:14px; height:12px;padding:0px 3px 2px 3px;}
.n_links{cursor:pointer; color:#FC3; background-color:#A00;}
#ext {border-top:1px solid #444;border-bottom:3px solid #767878;}
#ext li{border-top:1px solid #939595;border-bottom:1px solid #646666; background-color: #7E8181;}
.b_header{color:#ffba01;height:27px; line-height:27px;width:132px;padding-top: 2px;padding-left:23px;background: url("./images/menu_bg.jpg") no-repeat left top;}
.b_box{width:132px; background-color:#767878; border-left:1px solid #202020;border-right:1px solid #202020;}
.b_bottom{height:3px;width:132px;background:#767878;}
a{padding-left:5px; color: #FFCC33; text-decoration:none;}
a:visited{color:#FC3;}
a:hover{color:#FC3; text-decoration:underline;color: #FFF;}
a:link{color:#FC3;}
</STYLE>
</HEAD>
<BODY>
<div>
<ul class='b_box'>
<?php
	if($total==0){
?>
        <li style='color:#FC3;'>&nbsp;没有下级用户</li>
<?php }else{
	while ($row = mysql_fetch_array($rs)){
?>  
    <li id="li_<?=$row['id']?>">
        <a TITLE='点击查看' href="./users_list.php?frame=show&uid=<?=$row['username']?>" 
		target="userlist_content"><?=$row['username']?></a>
		<?php if(Get_xj($row['username'])==0){?>
        <span class='n'>0</span>
		<?php }else{?>
        <span class='n_links' TITLE='点击展开' onclick="getChildList(this,<?=$row['id']?>)" ><?=Get_xj($row['username'])?></span>
		<?php }?>
    </li>
<?php }}?>
        </ul>
</div>
<div style='clear:both' class='b_bottom'></div>
</BODY>
</HTML>