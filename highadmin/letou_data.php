<?php
session_start();
error_reporting(0);
require_once 'conn.php';

if (strpos($_SESSION['flag'],'72') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

$act=$_GET['act'];
if($act=="edit"){
	if($_POST['button']=="修改"){
		if (!mysql_query($sql)){
			die('数据库修改出错!!!!' );
		}
		echo "<script language=javascript>alert('修改成功！');window.location='';</script>";
		exit;
	}else if($_POST['button']=="开奖"){
		if (!mysql_query($sql)){
			die('数据库修改出错!!!!' );
		}
		echo "<script language=javascript>alert('开奖成功！');window.location='';</script>";
		exit;	
	}
}

//$sql="select * from ssc_data where cid='1' and DATE_FORMAT(opentime, '%Y-%m-%d')='".$tday."' order by id asc";
$sql="select * from clc_letourecords where status='2' order by id desc limit 10";
$rsnewslist = mysql_query($sql) or  die("数据库修改出错!!!!");
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
        <td class="top_list_td icons_a7">　　您现在的位置是：游戏管理 &gt; 乐透开奖</td>
      </tr>
    </table>
  	<br />
  <br />
<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
		  	<tr>
				<td width="70" class="t_list_caption">场次</td>
				<td width="120" class="t_list_caption">期数</td>
				<td width="120" class="t_list_caption">销售额</td>
				<td width="120" class="t_list_caption">奖金</td>
				<td class="t_list_caption">开奖号码</td>
			  <td width="150" class="t_list_caption">开始时间</td>
			  <td width="150" class="t_list_caption">结束时间</td>
				<td width="80" class="t_list_caption">状态</td>
				<td width="120" class="t_list_caption">操作</td>
	</tr>
            <form action="?act=edit&id=<?=$cid?>" method="post" name="form1" id="form1">
			<tr class="t_list_tr_1" onMouseOver="this.style.backgroundColor='#E8F1FF'" onMouseOut="this.style.backgroundColor=''">
				<td height="25"  align="center"></td>
				<td align="center"><?=Get_lottery($cid)?></td>
				<td align="center"><input type="text" name="sid" maxlength="15" size="20" value="" onkeypress="alphaOnly(event);" onblur="this.className='inp1';" class="inp1" onfocus="this.className='inp1a'" ></td>
				<td align="center"><input type="text" name="code" maxlength="60" size="20" value="" onkeypress="alphaOnly(event);" onblur="this.className='inp1';" class="inp1" onfocus="this.className='inp1a'" /></td>
				<td align="center"></td>
				<td align="center"></td>
				<td align="center"><input type="submit" class="but1" value="修改" name="button" onClick="return confirm('确认要修改吗?');"/>&nbsp;&nbsp;<input type="submit" class="but1" value="开奖" name="button" onClick="return confirm('确认要开奖吗?');"/></td>
		  </tr>
		  </form>

			<?php 
			$i=0;
			while ($row = mysql_fetch_array($rsnewslist)){
				if($row['status'] == 0){
					$zt="未开始";
				}else if($row['status'] == 1){
					$zt="销售中";
				}else if($row['status'] == 2){
					$zt="已开奖";
				}	
				
			?>
            <form action="?act=edit&id=<?=$cid?>" method="post" name="form1" id="form1">
			<tr class="t_list_tr_<?=$i%2?>" onMouseOver="this.style.backgroundColor='#E8F1FF'" onMouseOut="this.style.backgroundColor=''">
				<td height="25"  align="center"><input type="hidden" name="sid" value="<?=$issue?>"><?=$row['nums']?></td>
				<td align="center"><?=$row['name']?></td>
				<td align="center"><?=$row['sales']?></td>
				<td align="center"><?=$row['prize']?></td>
				<td align="center"><input type="text" name="code" maxlength="60" size="20" value="<?=$row['nums']?>" onkeypress="alphaOnly(event);" onblur="this.className='inp1';" class="inp1" onfocus="this.className='inp1a'" /></td>
				<td align="center"><?=$row['starttime']?></td>
				<td align="center"><?=$row['endtime']?></td>
				<td align="center"><?=$zt?></td>
				<?php if ($zt != 2) {?>
				<td align="center"><input type="submit" class="but1" value="修改" name="button" onClick="return confirm('确认要修改吗?');"/>&nbsp;&nbsp;<input type="submit" class="but1" value="开奖" name="button" onClick="return confirm('确认要开奖吗?');"/></td>
				<?php } ?>
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
