<SCRIPT type="text/javascript">
//if (top.location == self.location) top.location.href = "index.php"; </script>
<?php
session_start();
error_reporting(0);

require_once 'conn.php';

if($_GET['act']=="a1"){
	$sql="select * from ssc_bankcard order by id asc";
	$query = mysql_query($sql);
	while ($row = mysql_fetch_array($query)){
		$sql="select * from ssc_member where username='".$row['username']."'";
        $rs = mysql_query($sql);
        $nums = mysql_num_rows($rs);
		if($nums==0){
			$sql="delete from ssc_bankcard where id='".$row['id']."'";
			$exe=mysql_query($sql) or  die("数据库修改出错2");
		}
	}

}
if($_GET['act']!=""){
	echo "<script>alert('清理成功！');</script>"; 
}

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
        <td class="top_list_td icons_a9">　　您现在的位置是：系统管理 &gt; 数据清理</td>
      </tr>
    </table>
<br>
<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
	<form name="form1" method="post" action="?act=a1">
    <tr>
        <td width="20%" height="40" class="t_Edit_caption">会员</td>
      	<td class="t_Edit_td">&nbsp;</td>
        <td width="35%" class="t_Edit_td">&nbsp;</td>
        <td width="15%" class="t_Edit_td"><div align="center">
          <input type="submit" name="Submit2" value="清 理" class="btn2" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'"  onClick="return confirm('确认要清理吗?');"/>
        </div></td>
    </tr>
    </form>
  </table>



</body>
</html>