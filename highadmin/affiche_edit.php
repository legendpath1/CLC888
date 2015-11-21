<SCRIPT type="text/javascript">
if (top.location == self.location) top.location.href = "index.php"; </script>
<?php
session_start();
error_reporting(0);

require_once 'conn.php';

if (strpos($_SESSION['flag'],'11') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

if($_GET['act']=="edit"){
	$sql="select * from ssc_news where id= ".$_GET['id'];
	$query = mysql_query($sql);
	$rs = mysql_fetch_array($query);
	$adtopic = $rs['topic'];
	$adcontent = $rs['cont'];
	$adddate = $rs['adddate'];
	$lev = $rs['lev'];
	$shows = $rs['shows'];
} 
if($adddate==""){
	$adddate=date("Y-m-d");
}
?>
<html>
<head>
<title></title> 
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="editor/xheditor-1.2.1.min.js"></script>
<script type="text/javascript" src="editor/xheditor_lang/zh-cn.js"></script>
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<br />
	<table width="95%" border="0" cellpadding="0" cellspacing="0" class="top_list">
      <tr>
        <td class="top_list_td icons_a1">　　您现在的位置是：信息管理 &gt; <?php if($_GET['act']=="edit"){echo "编辑公告";}else{echo "添加公告";}?></td>
      </tr>
    </table>
<br>
<form name="sonMemberForm" method="post" action="affiche.php?act=<?=$_GET['act']?>&id=<?=$_GET['id']?>" onSubmit="return SubChk()">
<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
    <tr>
        <td width="150" height="40" class="t_Edit_caption">公告名称</td>
        <td class="t_Edit_td"><input name="topic" type="text" class="inp2" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$adtopic?>" size="70">
          <label>
          <input name="lev" type="checkbox" id="lev" value="1" <?php if($lev==1){echo "checked";}?>>
          </label>		
          醒目显示<label>
          <input name="shows" type="checkbox" id="shows" value="1" <?php if($shows==1){echo "checked";}?>>
          </label>		
          公告显示</td>
    </tr>
  <tr>
    <td height="430" class="t_Edit_caption">公告內容</td>
    <td class="t_Edit_td">
	<textarea id="content1" name="content1" class="xheditor-full" rows="28" cols="80" style="width: 80%"><?=$adcontent?></textarea></td>
  </tr>
  <tr>
    <td height="40" class="t_Edit_caption">发布时间</td>
    <td class="t_Edit_td"><label>
      <input name="adddate" type="text" onBlur="this.className='inp2';" class="inp2" onFocus="this.className='inp2a'" id="adddate" value="<?=$adddate?>">
    </label></td>
  </tr>
  </table>
<table width="500">
        <tr align="center">
            <td><br>
<input type="submit" name="Submit" value="確 定" class="btn2" onClick="return confirm('确认要发布吗?');" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'" />　<input type="button" name="cancel" value="取 消" class="btn2" onClick="javascript:history.go(-1)" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'" />
            </td>
        </tr>
    </table>
</form>

</body>
</html>