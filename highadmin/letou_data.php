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
		$sql = "update clg_letou set prize='".$_POST['prize']."', prize_nums='".$_POST['nums']."', status='".$_POST['zt']."' where id='".$_GET['id']."'";
		if (!mysql_query($sql)){
			die('数据库修改出错!!!!' );
		}
		echo "<script language=javascript>alert('修改成功！');window.location='';</script>";
		exit;
	}else if($_POST['button']=="开奖"){
		$sql = "update clg_letou set prize_nums='".$_POST['nums']."', status='2' where id='".$_GET['id']."'";
		if (!mysql_query($sql)){
			die('数据库修改出错!!!!' );
		}
		echo "<script language=javascript>alert('开奖成功！');window.location='';</script>";
		exit;	
	}
}
elseif ($act=="add") {
	if($_POST['button']=="添加"){
		$sql = "insert clg_letou set sales='0', prize='".$_POST['prize']."', starttime='".date("Y-m-d H:i:s")."', status='1'";
		if (!mysql_query($sql)){
			die('数据库修改出错!!!!' );
		}
		echo "<script language=javascript>alert('添加成功！');window.location='';</script>";
		exit;	
	}
}

//$sql="select * from ssc_data where cid='1' and DATE_FORMAT(opentime, '%Y-%m-%d')='".$tday."' order by id asc";
$sql="select * from clg_letou order by id desc limit 10";
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
            <form action="?act=add" method="post" name="form1" id="form1">
			<tr class="t_list_tr_1" onMouseOver="this.style.backgroundColor='#E8F1FF'" onMouseOut="this.style.backgroundColor=''">
				<td height="25"  align="center"><?php echo $id?></td>
				<td align="center"></td>
				<td align="center">0</td>
				<td align="center"><input type="text" name="code" maxlength="60" size="20" value="50000" onkeypress="alphaOnly(event);" onblur="this.className='inp1';" class="inp1" onfocus="this.className='inp1a'" /></td>
				<td align="center"></td>
				<td align="center"></td>
				<td align="center"></td>
				<td align="center"></td>
				<td align="center"><input type="submit" class="but1" value="添加" name="button" onClick="return confirm('确认要添加吗?');"/></td>
		  </tr>
		  </form>

			<?php 
			$i=0;
			while ($row = mysql_fetch_array($rsnewslist)){
				$zt = $row['status'];
				$id = $row['id'];
			?>
            <form action="?act=edit&id=<?=$id?>" method="post" name="form1" id="form1">
			<tr class="t_list_tr_1" onMouseOver="this.style.backgroundColor='#E8F1FF'" onMouseOut="this.style.backgroundColor=''">
				<td height="25" align="center"><?=$id?></td>
				<td align="center"></td>
				<td align="center"><?=$row['sales']?></td>
				<td align="center"><input type="text" name="prize" maxlength="60" size="20" value="<?=$row['prize']?>" onkeypress="alphaOnly(event);" onblur="this.className='inp1';" class="inp1" onfocus="this.className='inp1a'" /></td>
				<td align="center"><input type="text" name="nums" maxlength="60" size="20" value="<?=$row['prize_nums']?>" onkeypress="alphaOnly(event);" onblur="this.className='inp1';" class="inp1" onfocus="this.className='inp1a'" /></td>
				<td align="center"><?=$row['starttime']?></td>
				<td align="center"><?=$row['endtime']?></td>
				<td align="center">
					<select name="zt" id="zt">
                    	<option value="0" <?php if ($zt==0) { echo 'selected="selected"'; }?>>未开始</option>
                    	<option value="1" <?php if ($zt==1) { echo 'selected="selected"'; }?>>销售中</option>
                    	<option value="2" <?php if ($zt==2) { echo 'selected="selected"'; }?>>已开奖</option>
                    </select>
				</td>
				<td align="center">
					<input type="submit" class="but1" value="修改" name="button" onClick="return confirm('确认要修改吗?');"/>
					<?php if ($zt != 2) {?>
					&nbsp;&nbsp;<input type="submit" class="but1" value="开奖" name="button" onClick="return confirm('确认要开奖吗?');"/>
					<?php } ?>
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
