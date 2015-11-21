<SCRIPT type="text/javascript">
if (top.location == self.location) top.location.href = "index.php"; </script>
<?php
session_start();
error_reporting(0);

require_once 'conn.php';

if (strpos($_SESSION['flag'],'91') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

if($_GET['act']=="edit"){
	if($_POST['cwpwd']==""){
		$sql="update ssc_config set webname='".$_POST['webname']."',rurl='".$_POST['rurl']."',gplimit='".$_POST['gplimit']."',dplimit='".$_POST['dplimit']."',counts='".$_POST['counts']."',stopstart='".$_POST['stopstart']."',stopend='".$_POST['stopend']."',zt='".$_POST['zt']."',ggshow='".$_POST['ggshow']."' where id='1'";
	}else{
		$sql="update ssc_config set webname='".$_POST['webname']."',rurl='".$_POST['rurl']."',gplimit='".$_POST['gplimit']."',dplimit='".$_POST['dplimit']."',counts='".$_POST['counts']."',stopstart='".$_POST['stopstart']."',stopend='".$_POST['stopend']."',cwpwd='".$_POST['cwpwd']."',zt='".$_POST['zt']."',ggshow='".$_POST['ggshow']."' where id='1'";	
	}
//	echo $sql;
	$exe=mysql_query($sql) or  die("数据库修改出错2");
	echo "<script>alert('修改成功！');window.location.href='config.php';</script>"; 
	exit;
} 
	$sql="select * from ssc_config";
	$query = mysql_query($sql);
	$rs = mysql_fetch_array($query);

?>
<html>
<head>
<title></title> 
<script type="text/javascript" language="javascript">

function SubChk(){

//	if(document.all.adcontent.value.length < 1){
//		alert("请输入公告内容！");
//		document.all.VIP_Name.focus();
//		return false;
//	}
	return true;
	    
}

</script>

<link href="css/index.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<br />
	<table width="95%" border="0" cellpadding="0" cellspacing="0" class="top_list">
      <tr>
        <td class="top_list_td icons_a9">　　您现在的位置是：系统管理 &gt; 系统设置</td>
      </tr>
    </table>
<br>
<form name="sonMemberForm" method="post" action="?act=edit" onSubmit="return SubChk()">
<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
    <tr>
        <td width="150" height="40" class="t_Edit_caption">网站名称</td>
        <td class="t_Edit_td"><input name="webname" type="text" class="inp2" id="webname" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['webname']?>" size="70">		</td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">跳转地址</td>
      <td class="t_Edit_td"><input name="rurl" type="text" class="inp2" id="rurl" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['rurl']?>" size="70">
      <span class="Font_R">用户名不对或锁定时的跳转地址</span></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">用户登陆</td>
      <td class="t_Edit_td"><input name="zt" type="radio" id="radio" value="1" <?php if($rs['zt']==1){echo "checked";}?>>
        开启  <input type="radio" name="zt" id="radio2" value="0" <?php if($rs['zt']==0){echo "checked";}?>> 
        关闭</td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">公告状态</td>
      <td class="t_Edit_td"><input name="ggshow" type="radio" id="radio" value="1" <?php if($rs['ggshow']==1){echo "checked";}?>>
        开启  <input type="radio" name="ggshow" id="radio2" value="0" <?php if($rs['ggshow']==0){echo "checked";}?>> 
        关闭</td>
    </tr>    

    <tr>
      <td height="40" class="t_Edit_caption">高频开奖限额</td>
      <td class="t_Edit_td"><input name="gplimit" type="text" class="inp2" id="cdrates" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['gplimit']?>" size="20"></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">低频开奖限额</td>
      <td class="t_Edit_td"><input name="dplimit" type="text" class="inp2" id="cdnums" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['dplimit']?>" size="20"></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">春节停开起</td>
      <td class="t_Edit_td"><input name="stopstart" type="text" class="inp2" id="stopstart" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['stopstart']?>" size="20"></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">春节停开止</td>
      <td class="t_Edit_td"><span class="Font_R">
        <input name="stopend" type="text" class="inp2" id="stopend" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['stopend']?>" size="20">
</span></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">财务密码</td>
      <td class="t_Edit_td"><span class="Font_R">
        <input name="cwpwd" type="text" class="inp2" id="cwpwd" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="" size="20"> 
        不修改请留空
</span></td>
    </tr>    
    <tr>
      <td height="100" class="t_Edit_caption">统计代码</td>
      <td class="t_Edit_td"><textarea name="counts" cols="60" rows="6" id="counts"><?=$rs['counts']?></textarea></td>
    </tr>
  </table>
<table width="500">
        <tr align="center">
            <td><br>
<input type="submit" name="Submit" value="確 定" class="btn2" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'"  onClick="return confirm('确认要保存吗?');"/>　<input type="button" name="cancel" value="取 消" class="btn2" onClick="javascript:history.go(-1)" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'" />
            </td>
        </tr>
    </table>
</form>

</body>
</html>