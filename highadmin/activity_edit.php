<SCRIPT type="text/javascript">
if (top.location == self.location) top.location.href = "index.php"; </script>
<?php
session_start();
error_reporting(0);

require_once 'conn.php';

if($_GET['act']=="edit"){
	$sql="select * from ssc_activity where id= ".$_GET['id'];
	$query = mysql_query($sql);
	$rs = mysql_fetch_array($query);
}else{
//	if(date("H:i:s")<"03:00:00"){
//		$starttime=date("Y-m-d",strtotime("-1 day"))." 03:00:00";
//		$endtime=date("Y-m-d")." 03:00:00";
//	}else{
//		$starttime=date("Y-m-d")." 03:00:00";
//		$endtime=date("Y-m-d",strtotime("+1 day"))." 03:00:00";
//	}
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
        <td class="top_list_td icons_a9">　　您现在的位置是：系统管理 &gt; <?php if($_GET['act']=="edit"){echo "编辑活动";}else{echo "新增活动";}?></td>
      </tr>
    </table>
<br>
<form name="sonMemberForm" method="post" action="activity.php?act=<?=$_GET['act']?>&id=<?=$_GET['id']?>">
<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
    <tr>
        <td width="150" height="40" class="t_Edit_caption">活动名称</td>
        <td class="t_Edit_td"><input name="topic" type="text" class="inp2" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['topic']?>" size="70">
          <label></label></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">起始时间</td>
      <td class="t_Edit_td"><input name="starttime" type="text" class="inp2" id="starttime" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['starttime']?>" size="30"></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">截止时间</td>
      <td class="t_Edit_td"><input name="endtime" type="text" class="inp2" id="endtime" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['endtime']?>" size="30"></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">填写示范</td>
      <td class="t_Edit_td"><?=$rs['txsf']?></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">条件值</td>
      <td class="t_Edit_td"><input name="endtime2" type="text" class="inp2" id="endtime2" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['tjz']?>" size="70"></td>
    </tr>
    <tr>
      <td height="110" class="t_Edit_caption">活动内容</td>
      <td class="t_Edit_td"><textarea name="content" cols="100" rows="6"  id="content"><?=$rs['content']?></textarea></td>
    </tr>
  <tr>
    <td height="430" class="t_Edit_caption">活动规则</td>
    <td class="t_Edit_td"><textarea id="content1" name="content1" class="xheditor-simple" rows="28" cols="80" style="width: 80%"><?=$rs['intro']?></textarea></td>
  </tr>
  <tr>
    <td height="40" class="t_Edit_caption">状态</td>
    <td class="t_Edit_td"><input name="zt" type="checkbox" id="zt" value="1" <?php if($rs['zt']==1){echo "checked";}?>>
开启</td>
  </tr>
  </table>
<table width="500">
        <tr align="center">
            <td><br>
<input type="submit" name="Submit" value="確 定" class="btn2" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'" />　<input type="button" name="cancel" value="取 消" class="btn2" onClick="javascript:history.go(-1)" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'" />
            </td>
        </tr>
    </table>
</form>

</body>
</html>