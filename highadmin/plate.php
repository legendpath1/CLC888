<?php
error_reporting(0);
require_once 'conn.php';

if ( isset( $_GET['act'] ) ){
	if ($_GET['act']=="edit") {
		$endtime=$_POST['end_year']."-".$_POST['end_month']."-".$_POST['end_date']." ".$_POST['end_hour'].":".$_POST['end_minute'].":".$_POST['end_second'];
		$opentime=date("Y-m-d H:i:s", strtotime($endtime)+60);
		$sql="update ssc_data set endtime='".$endtime."',opentime='".$opentime."',issue='".$_POST['issue']."' where id='".$_POST['id']."'";	
		$exe=mysql_query($sql) or  die("数据库修改出错");

		$exe=mysql_query($sql) or  die("数据库修改出错");
//	echo $sql;
	echo "<script>window.location.href='plate.php';</script>"; 
	exit;
	}
}

$d   =   array("日","一","二","三","四","五","六"); 
?>
<html>
<head>
<link href="css/index.css" rel="stylesheet" type="text/css">
<base target="mainframe" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

<body>
<script language="javascript">
function digitOnly(evt) {
	if (!(evt.keyCode>=48 && evt.keyCode<=57)){
		evt.returnValue=false;
	}
}
</script>

<br>
    <table border="0" cellspacing="0" cellpadding="0" width="950">
<tr>
        <td width="350"></td>
        <td></td>
        <td width="125"></td>
        <td width="125"><input name="other_close2" type="button" value="开奖号码录入" class="Font_B" onClick="javascript:window.location='platekj.php';"></td>
      </tr>
    </table>
<br>
<table border="0" cellspacing="1" cellpadding="0" class="t_list">
        <tr>
            <td width="150" class="t_list_caption">期數</td>
            <td width="100" class="t_list_caption">星期</td>
          <td width="380" class="t_list_caption">封盘时间</td>
          <td width="180" class="t_list_caption">功能</td>
        </tr>
        <?php
		$sql="select * from ssc_data where zt='3' and cid='12' order by id asc";
		$rsnewslist = mysql_query($sql);

		while ($row = mysql_fetch_array($rsnewslist))
		{
		?>
        <form method=post action="plate.php?act=edit">
            <tr class="t_list_tr_0" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                <td><INPUT class="inp1" onKeyPress="digitOnly(event)" value="<?=$row['issue']?>" maxLength="10" size="10" name="issue" id="issue">
                  期</td> 
                <td ><?=$d[date("w",strtotime($row['endtime']))]?></td>
                <td><input class="inp1" onKeyPress="digitOnly(event)" value="<?=date("Y",strtotime($row['endtime']))?>" maxlength="4" size="4" name="end_year" />
年
  <input class="inp1" onKeyPress="digitOnly(event)" value="<?=date("m",strtotime($row['endtime']))?>" maxlength="2" size="2" name="end_month" />
月
<input class="inp1" onKeyPress="digitOnly(event)" value="<?=date("d",strtotime($row['endtime']))?>" maxlength="2" size="2" name="end_date" />
日
<INPUT class="inp1" onKeyPress="digitOnly(event)" value="<?=date("H",strtotime($row['endtime']))?>" maxLength="2" size="2" name="end_hour">
時
  <INPUT class="inp1" onKeyPress="digitOnly(event)" value="<?=date("i",strtotime($row['endtime']))?>" maxLength="2" size="2" name="end_minute">
分
<INPUT class="inp1" onKeyPress="digitOnly(event)" value="<?=date("s",strtotime($row['endtime']))?>" maxLength="2" size="2" name="end_second">
秒
</DIV></td>
                <td><INPUT value="<?=$row['id']?>" name="id" type="hidden"><input type="submit" name="Submit" value="設 置"/></td>
           </tr>
        </form>
 		<?php
		}
		?>
</table>
<br>


</body>
</html> 