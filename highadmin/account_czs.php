<SCRIPT type="text/javascript">
//if (top.location == self.location) top.location.href = "index.php"; </script>
<?php
session_start();
error_reporting(0);
require_once 'conn.php';

if (strpos($_SESSION['flag'],'31') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

$jb=array("用户","代理"); 

$uname=$_REQUEST['uname'];

$username=$_REQUEST['username'];
$dan=$_REQUEST['dan'];

if($_GET['act']=="cz"){
	if($_POST['button']=="到帐"){
		$sqla="update ssc_savelist set zt='1' where id='".$_POST['sid']."'";
		$exe=mysql_query($sqla) or  die("数据库修改出错6!!!");

		$sqla = "select * from ssc_member WHERE username='" . $_POST["uid"] . "'";
		$rsa = mysql_query($sqla);
		$rowa = mysql_fetch_array($rsa);
		$leftmoney=$rowa['leftmoney'];
	
		$sqlb = "select * from ssc_savelist where id='".$_POST['sid']."'";
		$rsb = mysql_query($sqlb);
		$rowb = mysql_fetch_array($rsb);
		$cmoney=$rowb['rmoney'];

		$sqlc = "select * from ssc_record order by id desc limit 1";		//帐变
		$rsc = mysql_query($sqlc);
		$rowc = mysql_fetch_array($rsc);
		$dan1 = sprintf("%07s",strtoupper(base_convert($rowc['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));

		$lmoney=$leftmoney+$cmoney;
		$sqla="insert into ssc_record set dan='".$dan1."', uid='".$rowa['id']."', username='".$rowa['username']."', types='1', smoney=".$cmoney.",leftmoney=".$lmoney.", regtop='".$rowa['regtop']."', regup='".$rowa['regup']."', regfrom='".$rowa['regfrom']."', adddate='".date("Y-m-d H:i:s")."',virtual='" .$rowa['virtual']. "'";
//		echo $sqla;
		$exe=mysql_query($sqla) or  die("数据库修改出错6!!!");

		$sqla="insert into ssc_message set username='".$_POST["uid"]."',types='充提消息',topic='&nbsp;&nbsp;&nbsp;&nbsp;恭喜您，充值成功', content='<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;您成功充值".$cmoney."元, 请注意查看您的帐变信息，如果有任何疑问请联系我们在线客服。</p>',adddate='".date("Y-m-d H:i:s")."'";
//		echo $sqla;
		$exe=mysql_query($sqla) or  die("数据库修改出错6!!!");
		
		$sql="update ssc_member set leftmoney ='".$lmoney."',totalmoney=totalmoney+ '".$cmoney."' where username ='".$_POST['uid']."'";
		if (!mysql_query($sql)){
			die('Error: ' );
		}
		
		amend("帐户充值 ".$_POST['uid']." ".$cmoney."元");
		
		echo "<script>alert('操作成功！');window.location.href='?';</script>"; 
		exit;
	}
}

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$page2=($page-1)*$pagesize;

if($username!=""){
	$s1=$s1." and username='".$username."'";
}else{
	if($uname!=""){
		$s1=$s1." and username='".$uname."'";
	}
}

if($dan!=""){
	$s1=$s1." and dan='".$dan."'";
}

	$s1=$s1." and zt='0'";

$urls="username=".$username."&dan=".$dan."&uname=".$uname;

$s1=$s1." order by id desc";
$sql="select * from ssc_savelist where 1=1".$s1;

$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

$sql="select * from ssc_savelist where 1=1".$s1." limit $page2,$pagesize";
$rsnewslist=mysql_query($sql);

$lastpg=ceil($total/$pagesize); //最后页，也是总页数
$page=min($lastpg,$page);
$prepg=$page-1; //上一页
$nextpg=($page==$lastpg ? 0 : $page+1); //下一页

if($page<5){
	$p1=1;
	$p2=min($lastpg,10);
}else{
	$p2=min($lastpg,$page+5);
	$p1=max($p2-9,1);
}
?>
<html>
<head>
<link href="css/index.css" rel="stylesheet" type="text/css">
<base target="mainframe" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<br>
	<table width="95%" border="0" cellpadding="0" cellspacing="0" class="top_list">
      <tr>
        <td class="top_list_td icons_a3">　　您现在的位置是：财务管理 &gt; 充值记录</td>
      </tr>
    </table>
    <br>
    <form name="memberForm" method="post" action="?">
    <table width="95%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="top_list_td">用户名:
          <input type="text" name="username" maxlength="30" size="15" class="inpa" id="username">
&nbsp;充值编号:
<input type="text" name="dan" maxlength="30" size="15" value="" class="inpa" id="dan">
&nbsp;
        <input name="Find_VN" type="submit" class="btnb" value="搜 索" style="position: relative; top: 2px;"></td>
        <td width="100" class="top_list_td">&nbsp;</td>
      </tr>
    </table>
    </form>
<br>
<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
  <tr>
    <td class="t_list_caption">用户编号</td>
    <td class="t_list_caption">用户名</td>
    <td class="t_list_caption">充值编号</td>
    <td class="t_list_caption">申请发起时间</td>
	<td class="t_list_caption">充值银行</td>
	<td class="t_list_caption">充值金额</td>
    <td class="t_list_caption">手续费</td>
    <td class="t_list_caption">上分金额</td>
    <td class="t_list_caption">操作</td>
  </tr>
  <?php
		while ($row = mysql_fetch_array($rsnewslist))
		{
		?>
  <form action="?act=cz" method="post" name="form1" id="form1">
      <input type="hidden" name="sid" value="<?=$row['id']?>" />
      <input type="hidden" name="uid" value="<?=$row['username']?>" /></td>
  <tr class="t_list_tr_0" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
    <td><?=$row['uid']?></td>
    <td><?=$row['username']?></td>
    <td><?=$row['id']?></td>
    <td><?=$row['adddate']?></td>
	<td><?=$row['bank']?></td>
	<td><?=number_format($row['money'],2)?></td>
    <td><?=number_format($row['sxmoney'],2)?></td>
    <td><?=number_format($row['rmoney'],2)?></td>
    <td><input name="button" type="submit" class="but1" id="button" value="到帐"  onClick="return confirm('确认已经到帐了吗?');"/></td>
  </tr>
  </form>
  <?php
		}
		?>
  <tr>
    <td colspan="9" class="t_list_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="170" height="35"></td>
                <td width="150"></td>
                <td><div style='text-align:right;'>总计  <?=$total?> 条数据,  共 <?=$lastpg?> 页 , 当前第 <?=$page?> 页  |  <?php if($page>1){?> <A HREF="?<?=$urls?>&page=1">首页</A> <A HREF="?<?=$urls?>&page=<?=$page-1?>">上页</A><?php }?><?php for($i=$p1;$i<=$p2;$i++){
		if($i==$page){?> <span class='Font_R'><?=$i?></span> <?php }else{?> <A HREF="?<?=$urls?>&page=<?=$i?>"><?=$i?></A> <?php }}?><?php if($page!=$lastpg){?> <A HREF="?<?=$urls?>&page=<?=$page+1?>">下页</A> <A HREF="?<?=$urls?>&page=<?=$lastpg?>">尾页</A> <?php }?> | 转至 <SCRIPT LANGUAGE="JAVASCRIPT">function keepKeyNum(obj,evt){var  k=window.event?evt.keyCode:evt.which; if( k==13 ){ goPage(obj.value);return false; }} function goPage( iPage ){ if( !isNaN(parseInt(iPage)) ) { if(iPage< 0 ){iPage=0;} window.location.href="?<?=$urls?>&page="+iPage;}}</SCRIPT><INPUT onKeyPress="return keepKeyNum(this,event);" TYPE="TEXT" ID="iGotoPage" NAME="iGotoPage" size="3"> 页  &nbsp;<BUTTON onClick="javascript:goPage( document.getElementById('iGotoPage').value );return false;">GO</BUTTON></div></td>
              </tr>
            </table></td>
  </tr>
</table>
</form>
<br>


</body>
</html> 