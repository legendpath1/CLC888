<?php
session_start();
error_reporting(0);
require_once 'conn.php';
$ztt=array("停用","使用中"); 
$jb=array("用户","代理","总代理"); 

if (strpos($_SESSION['flag'],'21') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

if($_GET['act']=="edit"){
	$sql = "select * from ssc_member WHERE id='" . $_GET['uid'] . "'";
	$rs = mysql_query($sql);
	$row = mysql_fetch_array($rs);
	$username=$row['username'];
	$nickname=$row['nickname'];
	$leftmoney=$row['leftmoney'];
	$flevel=$row['flevel'];
	$regfrom=$row['regfrom'];
	$zc=$row['zc'];
	$level=$row['level'];
	$usertype=$jb[$row['level']];
	$pe=$row['pe'];
	$banks=$row['banks'];
	$virtual=$row['virtual'];
	if($pe==""){$pe="0;0;0;0;0;0;0;0";}
	if($zc==""){$zc=0;}
}else{//新
	$level=1;
	$pe="0;0;0;0";
	$zc=0;
	$banks=0;
}

?>
<html>
<head>
<title></title> 
<script type="text/javascript" language="javascript">

function SubChk(){

	if(document.all.topic.value.length < 1){
		alert("请输入公告名称！");
		document.all.topic.focus();
		return false;
	}
	return true;
	    
}

</script>

<link href="css/index.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="../js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="../js/common.js"></script>

<script language="javascipt" type="text/javascript">
$(function(){
    if($(".needchangebg:even").eq(0).html() != null){
        $(".needchangebg:even").find("td").css("background","#FAFCFE");
        $(".needchangebg:odd").find("td").css("background","#F9F9F9");
        $(".forzenuser").find("td").css("background","#FFE8E8");
		$(".self_tr").find("td").css("background","#FFF4D2");
        $(".needchangebg").hover(function(){
            $(this).find("td").css("background","#E8F2FF");
            $(".forzenuser").find("td").css("background","#FFE8E8");
        },function(){
            $(".needchangebg:even").find("td").css("background","#FAFCFE");
            $(".needchangebg:odd").find("td").css("background","#F9F9F9");
            $(".forzenuser").find("td").css("background","#FFE8E8");
        }
        );
    }else{
        $(".needchangebg:odd").find("td").css("background","#FAFCFE");
        $(".needchangebg:even").find("td").css("background","#F9F9F9");
		$(".forzenuser").find("td").css("background","#FFE8E8");
		$(".self_tr").find("td").css("background","#FFF4D2");
        $(".gametitle").css("background","#F9F9F9");
        $(".needchangebg").hover(function(){
            $(this).find("td").css("background","#E8F2FF");
            $(".gametitle").css("background","#F9F9F9");
        },function(){
            $(".lt tr:odd").find("td").css("background","#FAFCFE");
            $(".lt tr:even").find("td").css("background","#F9F9F9");
            $(".gametitle").css("background","#F9F9F9");
        }
        );
    }
})
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<script type="text/javascript">
;(function($){
$(document).ready(function(){
	$("span[id^='general_tab_']","#tabbar-div-s2").click(function(){
		$k = $(this).attr("id").replace("general_tab_","");
		$k = parseInt($k,10);
		$("span[id^='general_tab_']","#tabbar-div-s2").attr("class","tab-back");
		$("div[id^='general_txt_']").hide();
		$(this).attr("class","tab-front");
		$("#general_txt_"+$k).show();
		$k==1 ? $("span[id^='tabbar_tab_']:first").click() : "";
		$k==1 ? $("#addtype").val("xx") : $("#addtype").val("ks");
	});
	$("span[id^='tabbar_tab_']").click(function(){
		$z = $(this).attr("id").replace("tabbar_tab_","");
		$("span[id^='tabbar_tab_']").attr("class","tab-back");
		$("table[id^='tabbar_txt_']").hide();
		$(this).attr("class","tab-front");
		$("#tabbar_txt_"+$z).show();
	});
	$("span[id^='general_tab_']:first","#tabbar-div-s2").click();
		$(":checkbox[id^='selall_']").click(function(){
		var lotid = $(this).attr("id").replace("selall_","");
		$("#tabbar_txt_"+lotid).find("input[type='checkbox']").attr("checked",$(this).attr("checked"));
	});
	$("input[type='text'][name^='point_']").keyup(function(){
		$(this).val( filterPercent($(this).val()) );
		$(this).closest("tr").find("input[type='checkbox']").attr("checked",true);
	});
	$("input[type='button'][name^='tpbutton_']").click(function(){
		var lotid = $(this).attr("id").replace("tpbutton_","");
		var p = filterPercent($("#tpoint_"+lotid).val());
		$("input[type='text'][name^='point_'][title!='spec']","#tabbar_txt_"+lotid).val(p);
		$("input[type='checkbox'][id^='method_'][title!='spec']","#tabbar_txt_"+lotid).attr("checked",true);
	});
	$("input[type='text'][name^='tpoint_']").keyup(function(){
		$(this).val( filterPercent($(this).val()) );
	});
	$("#keeppoint").keyup(function(){
		$(this).val( filterPercent($(this).val()) );
	});
});
})(jQuery);

function checkform(obj)
{
  if( $("#addtype").val() == 'xx' ){
  	isverfer = true;
	$("input[type='checkbox'][id^='method_']").each(function(){
		if( $(this).attr("checked") ==  true ){
			id   = $(this).attr("id").replace("method_","");
			maxp = Number($("input[name='maxpoint_"+id+"']").val());
			minp = Number($("input[name='minpoint_"+id+"']").val());
			point= Number($("input[name='point_"+id+"']").val());
			if( point > maxp || point < 0 || point < minp ){
				$("input[name='point_"+id+"']").nextAll("span").html('&nbsp;&nbsp;<font color="red">返点错误</font>').show();
				isverfer = false;
			}else{
				$("input[name='point_"+id+"']").nextAll("span").html('');
			}
		}
	});
	if( isverfer == false ){
		alert("返点设置错误，请检查");
		return false;
	}
  }else{
  	minp = Number($("#keepmin").val());
  	maxp = Number($("#keepmax").val());
	point= Number($("#keeppoint").val());
	if( point > maxp || point < minp ){
		alert("保留返点设置错误，请检查");
		return false;
	}
  }
  obj.submit.disabled=true;
  return true;
}
//返点输入框输入过滤
function filterPercent(num){
	num = num.replace(/^[^\d]/g,'');
	num = num.replace(/[^\d.]/g,'');
	num = num.replace(/\.{2,}/g,'.');
	num = num.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
	if( num.indexOf(".") != -1 ){
		var data = num.split('.');
		num = (data[0].substr(0,3))+'.'+(data[1].substr(0,1));
	}else{
		num = num.substr(0,3);
	}
	num = num > 100 ? 100 : num;
	return num;
}
</script>
<br />
	<table width="95%" border="0" cellpadding="0" cellspacing="0" class="top_list">
      <tr>
        <td class="top_list_td icons_a2">　　您现在的位置是：会员管理 &gt; <?php if($_GET['act']=="edit"){echo "编辑会员";}else{echo "新增会员";}?></td>
      </tr>
    </table>
<br>
<form name="sonMemberForm" method="post" action="mem_list.php?act=<?=$_GET['act']?>&uid=<?=$_GET['uid']?>" onSubmit="return SubChk()">
<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
    <tr>
        <td width="150" height="40" class="t_Edit_caption">用户级别</td>
        <td class="t_Edit_td"><label>
        <input type="radio" name="usertype" value="1" <?php if($level==1 || $level==""){echo 'checked="checked"';}?> /> 代理用户</label>&nbsp;&nbsp;<label><input type="radio" name="usertype" value="0" <?php if($level==0){echo 'checked="checked"';}?>/> 会员用户&nbsp;&nbsp;<input type="radio" name="usertype" value="2" <?php if($level==2){echo 'checked="checked"';}?>/> 总代理
</label></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">登录帐号</td>
      <td class="t_Edit_td"><?php if($_GET['act']=="edit"){echo $username;}else{?><input name="username" type="text" class="inp2" id="username" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$username?>" size="25">( 由0-9,a-z,A-Z组成的6-16个字符 )<?php }?></td>
    </tr>
    <?php if($_GET['act']=="edit"){?>
    <tr>
      <td height="40" class="t_Edit_caption">帐户余额</td>
      <td class="t_Edit_td"><?=$leftmoney?>
      <input name="cmoney" type="text" class="inp2" id="cmoney" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="0" size="15">
      附加码<input name="scode" type="text" class="inp2" id="scode" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" size="10">
      <span class="top_list_td">
      <input name="button" type="submit" class="btnb" value="充 值" id="button" onClick="return confirm('确认要充值吗?');">
      </span><span class="top_list_td">
      <input name="button" type="submit" class="btnb" value="扣 款" id="button" onClick="return confirm('确认要扣款吗?');">
      </span></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">上级</td>
      <td class="t_Edit_td"><input name="regfrom" type="text" class="inp2" id="regfrom" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$regfrom?>" size="25"></td>
    </tr>
    <?php }?>
    <tr>
      <td height="40" class="t_Edit_caption">返点</td>
      <td class="t_Edit_td"><input name="flevel" type="text" class="inp2" id="flevel" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$flevel?>" size="25"></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">登录密码</td>
      <td class="t_Edit_td"><input name="userpass" type="password" class="inp2" id="password" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="" size="25">      
      ( 由字母和数字组成6-16个字符；且必须包含数字和字母，不允许连续三位相同，如不修改请留空 )</td>
    </tr>
    <?php if($_GET['act']=="edit"){?>
    <tr>
      <td height="40" class="t_Edit_caption">资金密码</td>
      <td class="t_Edit_td"><input name="cwpassword" type="password" class="inp2" id="password2" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="" size="25">        ( 由字母和数字组成6-16个字符；且必须包含数字和字母，不允许连续三位相同 ，如不修改请留空)</td>
    </tr>
    <?php }?>
  <tr>
    <td height="40" class="t_Edit_caption">用户呢称</td>
    <td class="t_Edit_td"><input name="nickname" type="text" class="inp2" id="nickname" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$nickname?>" size="25">( 由2至8个字符组成 )</td>
  </tr>
  <tr>
    <td height="40" class="t_Edit_caption">用户配额</td>
    <td class="t_Edit_td"><input name="pe" type="text" class="inp2" id="pe" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$pe?>" size="25">
    ( 依次为 6.1-6.5;6.6-7.0;7.1-7.5;7.6-7.8 的配额个数，只有总代存在7.1及以上的配额)</td>
  </tr>
  <tr>
    <td height="40" class="t_Edit_caption">充值银行卡套餐</td>
    <td class="t_Edit_td"><input name="banks" type="text" class="inp2" id="nickname" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$banks?>" size="25">( 选择套餐 默认为0)</td>
  </tr>
  <tr>
    <td height="40" class="t_Edit_caption">虚拟用户</td>
    <td class="t_Edit_td"><input name="virtual" type="checkbox" value="1" <?php if($virtual==1){echo "checked";}?> /></td>
  </tr>
  <?php if($level==2 || $_GET['act']=="add"){ ?>
  <tr>
    <td height="40" class="t_Edit_caption">总代占成</td>
    <td class="t_Edit_td"><label>
      <input name="zc" type="text" class="inp2" id="zc" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$zc?>" size="25">
    (例5;占成5%，仅总代可设置占成)</label></td>
  </tr>
  <?php }?>
  </table>
<table width="500">
        <tr align="center">
            <td><br>
<input type="submit" name="Submit" value="確 定" class="btn2" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'" />　<input type="button" name="cancel" value="取 消" class="btn2" onClick="javascript:history.go(-1)" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'" />
            </td>
        </tr>
    </table>
<br>

</form>

</body>
</html>