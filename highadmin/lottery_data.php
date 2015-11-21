<?php
session_start();
error_reporting(0);
require_once 'conn.php';

if (strpos($_SESSION['flag'],'72') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

$cid=$_GET['id'];
$tday=date("Y-m-d");

if($cid==""){
	$cid="1";
}

if($cid==11 || $cid==12){
	$sqls = "select * from ssc_config";
	$rss = mysql_query($sqls);
	$rows = mysql_fetch_array($rss);
	$stopstart=$rows['stopstart'];
	$stopend=$rows['stopend'];

	$tday2=date("y");
	if($tday<$stopstart){
		$tnums=sprintf("%03d",date("z",strtotime($tday))+1);
	}
	if($tday>=$stopstart && $dymd2<=$stopend){
		$tnums=sprintf("%03d",date("z",strtotime($tday))+1-8);
	}
	if($tday>$stopstart){
		$tnums=sprintf("%03d",date("z",strtotime($tday))+1-8);
	}
	$tnums=$tday2.$tnums;
}elseif($cid==3){
	$sday=strtotime("2013-06-29");
	$snum=575051;
	$dymd2=date("Y-m-d");
	$sjc=ceil((strtotime($dymd2)-$sday)/3600/24);//时间差（天数）
}elseif($cid==6){
	$sday=strtotime("2013-07-07");
	$snum=119569;
	$dymd2=date("Y-m-d");
	$sjc=ceil((strtotime($dymd2)-$sday)/3600/24);//时间差（天数）
}else{

	$tday2=date("ymd");	
}

$act=$_GET['act'];
if($act=="edit"){
	if($_POST['button']=="修改"){
		$stra=split(",",$_POST['code']);

		if($cid==16){
			$sql="select * from ssc_data2 where issue ='".$_POST['sid']."' and cid='".$cid."'";
			$rs=mysql_query($sql);
			$row = mysql_fetch_array($rs);
			if(empty($row)){
				$sql="insert into ssc_data2 set cid ='".$cid."', name ='".Get_lottery($cid)."', issue ='".$_POST['sid']."', code = '".$_POST['code']."', addtime = '".date("Y-m-d H:i:s")."', opentime = '".date("Y-m-d H:i:s")."', sign = '1'";
				echo $sql;
				if (!mysql_query($sql)){
					die('Error: ' );
				}
			}else{
				$sql="update ssc_data2 set code = '".$_POST['code']."', addtime = '".date("Y-m-d H:i:s")."', sign = '7', zt = '0' where issue ='".$_POST['sid']."' and cid='".$cid."'";
				if (!mysql_query($sql)){
					die('Error: ' );
				}
			}
		}else{
			$sql="select * from ssc_data where issue ='".$_POST['sid']."' and cid='".$cid."'";
			$rs=mysql_query($sql);
			$row = mysql_fetch_array($rs);
			if(empty($row)){
				$sql="insert into ssc_data set cid ='".$cid."', name ='".Get_lottery($cid)."', issue ='".$_POST['sid']."', code = '".$_POST['code']."', addtime = '".date("Y-m-d H:i:s")."', opentime = '".date("Y-m-d H:i:s")."', sign = '1'";
				echo $sql;
				if (!mysql_query($sql)){
					die('Error: ' );
				}
			}else{
				$sql="update ssc_data set code = '".$_POST['code']."', addtime = '".date("Y-m-d H:i:s")."', sign = '7', zt = '0' where issue ='".$_POST['sid']."' and cid='".$cid."'";
				if (!mysql_query($sql)){
					die('Error: ' );
				}
			}
		}
		echo "<script language=javascript>alert('修改成功！');window.location='?id=".$cid."';</script>";
		exit;
	}else if($_POST['button']=="开奖"){
		if($cid==16){
		$sql="update ssc_data2 set zt = '0',sign='6' where issue ='".$_POST['sid']."' and cid='".$cid."'";
		}else{
		$sql="update ssc_data set zt = '0',sign='6' where issue ='".$_POST['sid']."' and cid='".$cid."'";
		}
		if (!mysql_query($sql)){
			die('Error: ' );
		}
		echo "<script language=javascript>alert('开奖成功！');window.location='?id=".$cid."';</script>";
		exit;	
	}
}

//$sql="select * from ssc_data where cid='1' and DATE_FORMAT(opentime, '%Y-%m-%d')='".$tday."' order by id asc";
$sql="select * from ssc_nums where cid='".$cid."' order by id desc";
$rsnewslist = mysql_query($sql) or  die("数据库修改出错!!!!");;
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
        <td class="top_list_td icons_a7">　　您现在的位置是：游戏管理 &gt; 开奖号码</td>
      </tr>
    </table>
  	<br />
  	<table width="95%" border="0" cellspacing="0" cellpadding="0" class="nav_list">
    	<tr>
      		<td class="nav_list_td"><div class="tabs">	
			<ul><li <?php if($cid==1){echo "class='select'";}?>><a href="?id=1">重庆</a></li><li <?php if($cid==2){echo "class='select'";}?>><a href="?id=2">十一运</a></li><li <?php if($cid==3){echo "class='select'";}?>><a href="?id=3">快乐8</a></li><li <?php if($cid==4){echo "class='select'";}?>><a href="?id=4">时时乐</a></li><li <?php if($cid==5){echo "class='select'";}?>><a href="?id=5">新疆</a></li><li <?php if($cid==6){echo "class='select'";}?>><a href="?id=6">黑龙江</a></li><li <?php if($cid==7){echo "class='select'";}?>><a href="?id=7">江西</a></li><li <?php if($cid==8){echo "class='select'";}?>><a href="?id=8">多乐彩</a></li><li <?php if($cid==9){echo "class='select'";}?>><a href="?id=9">广东11选5</a></li><li <?php if($cid==10){echo "class='select'";}?>><a href="?id=10">重庆11选5</a></li><li <?php if($cid==11){echo "class='select'";}?>><a href="?id=11">3D</a></li><li <?php if($cid==12){echo "class='select'";}?>><a href="?id=12">排列3-5</a></li><li <?php if($cid==13){echo "class='select'";}?>><a href="?id=13">快三</a></li><li <?php if($cid==14){echo "class='select'";}?>><a href="?id=14">天津</a></li><li <?php if($cid==16){echo "class='select'";}?>><a href="?id=16">如意</a></li><li <?php if($cid==17){echo "class='select'";}?>><a href="?id=17">五分</a></li></ul></div></td>
    	</tr>
  	</table>
  <br />
<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
		  	<tr>
				<td width="70" class="t_list_caption">场次</td>
			  <td width="120" class="t_list_caption">名称</td>
				<td width="120" class="t_list_caption">期数</td>
				<td class="t_list_caption">开奖号码</td>
			  <td width="150" class="t_list_caption">开奖时间</td>
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
				if($cid==11 || $cid==12){
					$issue=$tnums;
				}elseif($cid==3){
					$issue = 178+$snum+$sjc*179-$i;	
				}elseif($cid==6){
					$issue = sprintf("%07u",83+$snum+$sjc*84-$i);	
				}else{
					$issue=$tday2.$row['nums'];
				}
				if($cid==16){
				$sqla="select * from ssc_data2 where cid='".$cid."' and issue='".$issue."' order by id asc";		
				}else{
				$sqla="select * from ssc_data where cid='".$cid."' and issue='".$issue."' order by id asc";		
				}		
				$rsa = mysql_query($sqla) or  die("数据库修改出错!!!!");
				$rowa = mysql_fetch_array($rsa);
				if(empty($rowa)){
					$zt="等待";
//					$codes="";
				}else if($rowa['zt']==0){
					$zt="未开奖";
//					$codes=$rowa['code'];
				}else if($rowa['zt']==1){
					$zt="已开奖";
//					$codes=$rowa['code'];
				}else if($rowa['zt']==3){
					$zt="已修改";
				}
					$codes=$rowa['code'];
			?>
            <form action="?act=edit&id=<?=$cid?>" method="post" name="form1" id="form1">
			<tr class="t_list_tr_<?=$i%2?>" onMouseOver="this.style.backgroundColor='#E8F1FF'" onMouseOut="this.style.backgroundColor=''">
				<td height="25"  align="center"><input type="hidden" name="sid" value="<?=$issue?>"><?=$row['nums']?></td>
				<td align="center"><?=$row['name']?></td>
				<td align="center"><?=$issue?></td>
				<td align="center"><input type="text" name="code" maxlength="60" size="20" value="<?=$codes?>" onkeypress="alphaOnly(event);" onblur="this.className='inp1';" class="inp1" onfocus="this.className='inp1a'" /></td>
				<td align="center"><?=$row['opentime']?></td>
				<td align="center"><?=$zt?></td>
				<td align="center"><input type="submit" class="but1" value="修改" name="button" onClick="return confirm('确认要修改吗?');"/>&nbsp;&nbsp;<input type="submit" class="but1" value="开奖" name="button" onClick="return confirm('确认要开奖吗?');"/></td>
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
