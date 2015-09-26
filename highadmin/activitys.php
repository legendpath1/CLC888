<?php
session_start();
error_reporting(0);
require_once 'conn.php';

if (strpos($_SESSION['flag'],'95') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

if($_GET['act']=="add"){
	$sql="insert into ssc_activity set topic='".$_POST['topic']."',starttime='".$_POST['starttime']."',endtime='".$_POST['endtime']."',hdrr='".$_POST['hdrr']."',hdgz='".$_POST['content1']."',adddate='".$_POST['adddate']."'";
	$exe=mysql_query($sql) or  die("数据库修改出错1");
	echo "<script>window.location.href='activitys.php';</script>"; 
	exit;
}

if($_GET['act']=="edit"){
//	echo $_POST['content1'];
	if($_POST['button']=="修改"){
		$sql="update ssc_activity set tjz='".$_POST['tjz']."',starttime='".$_POST['starttime']."',endtime='".$_POST['endtime']."' where id=".$_POST['sid'];
		$exe=mysql_query($sql) or  die("数据库修改出错2");
	}else if($_POST['button']=="开启"){
		$sql="update ssc_activity set zt='1' where id=".$_POST['sid'];
		$exe=mysql_query($sql) or  die("数据库修改出错2");
	}else if($_POST['button']=="关闭"){
		$sql="update ssc_activity set zt='0' where id=".$_POST['sid'];
		$exe=mysql_query($sql) or  die("数据库修改出错2");
	}	
	echo "<script>window.location.href='activitys.php';</script>"; 
	exit;
}
if($_GET['act']=="del"){
	mysql_query("Delete from ssc_activity where id=".$_GET['id']);
	echo "<script>window.location.href='activitys.php';</script>"; 
	exit;
}


$sql="select * from ssc_activity order by id asc";
$rsnewslist = mysql_query($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="css/index.css" rel="stylesheet" type="text/css">
</head>

<body>
<div align="center"><br />
	<table width="95%" border="0" cellpadding="0" cellspacing="0" class="top_list">
      <tr>
        <td class="top_list_td icons_a9">　　您现在的位置是：系统管理 &gt; 活动设置</td>
        <td width="100" class="top_list_td">&nbsp;</td>
      </tr>
    </table>
<br />
	<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
			<tr>
				<td class="t_list_caption">活动名称</td>
			  <td class="t_list_caption"><span class="Font_R">填写示范</span>(说明)</td>
			  <td class="t_list_caption">条件值</td>
				<td class="t_list_caption">开始时间</td>
				<td class="t_list_caption">结束时间</td>
			    <td class="t_list_caption">状态</td>
		      <td class="t_list_caption">操作</td>
			</tr>
			<?php 
			$i=0;
			while ($row = mysql_fetch_array($rsnewslist)){?>
            <form action="?act=edit" method="post" name="form1" id="form1">
			<tr class="t_list_tr_<?=$i%2?>" onMouseOver="this.style.backgroundColor='#E8F1FF'" onMouseOut="this.style.backgroundColor=''">
				<td height="25"  align="center"><?=$row['topic']?><input name="sid" type="hidden" id="sid" value="<?=$row['id']?>" /></td>
				<td align="center"><?=$row['txsf']?></td>
				<td align="center"><input name="tjz" type="text" class="inp1" id="tjz" onfocus="this.className='inp1a'" onblur="this.className='inp1';" onkeypress="alphaOnly(event);" value="<?=$row['tjz']?>" size="15" /></td>
				<td align="center"><input name="starttime" type="text" class="inp1" id="starttime" onfocus="this.className='inp1a'" onblur="this.className='inp1';" onkeypress="alphaOnly(event);" value="<?=$row['starttime']?>" size="25" />			    </td>
				<td align="center"><input name="endtime" type="text" class="inp1" id="endtime" onfocus="this.className='inp1a'" onblur="this.className='inp1';" onkeypress="alphaOnly(event);" value="<?=$row['endtime']?>" size="25" />
			    </td>
				<td align="center"><?php if($row['zt']==1){echo "<span class='Font_G'>开启</span>";}else{echo "<span class='Font_R'>关闭</span>";}?></td>
				<td align="center"><input name="button" type="submit" class="but1" id="button" value="<?php if($row['zt']==1){echo "关闭";}else{echo "开启";}?>"  onclick="return confirm('确认要修改吗?');"/>
&nbsp;
<input name="button" type="submit" class="but1" id="button" value="修改"  onclick="return confirm('确认要修改吗?');"/>
</td>
			</tr>
			</form>
			<?php 
			$i=$i+1;
			}
			?>
	</table>
</div>
</body>
</html>
