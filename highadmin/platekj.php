<SCRIPT type="text/javascript">
//if (top.location == self.location) top.location.href = "index.php"; </script>
<?php
error_reporting(0);
require_once 'conn.php';

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=15;
$page2=($page-1)*$pagesize;

	$sql = "SELECT * FROM ssc_config";
	$query2 = mysql_query($sql);
	$dconfig = mysql_fetch_array($query2);
	$dsxnum = $dconfig['sxnum'];
	$sx=11-$dsxnum;
	$x=array("猪","狗","鸡","猴","羊","马","蛇","龙","兔","虎","牛","鼠"); 

	$query = mysql_query( "select * from ssc_data where zt=3 and cid='12' order by id asc limit 1");
	$rs = mysql_fetch_array($query);
	$issue=$rs['issue'];
			
if ( isset( $_GET['act'] ) )
{
	$act = $_GET['act'];
	if($act=="save" ){
		mysql_query( "update ssc_data set n1='".$_POST['n1']."',n2='".$_POST['n2']."',n3='".$_POST['n3']."',n4='".$_POST['n4']."',n5='".$_POST['n5']."',n6='".$_POST['n6']."',na='".$_POST['na']."',sx1='".$x[($_POST['n1']+$sx) % 12]."',sx2='".$x[($_POST['n2']+$sx) % 12]."',sx3='".$x[($_POST['n3']+$sx) % 12]."',sx4='".$x[($_POST['n4']+$sx) % 12]."',sx5='".$x[($_POST['n5']+$sx) % 12]."',sx6='".$x[($_POST['n6']+$sx) % 12]."',sxna='".$x[($_POST['na']+$sx) % 12]."',issue='".$_POST['issue']."' where id='".$_POST['id']."'") or  die("数据库修改出错");;
		echo "<script>window.location.href='platekj.php';</script>"; 
		exit;
	}
	if($act=="in" ){
	$num=number_format($_POST['num']);
	$query = mysql_query( "select * from ssc_data where issue='".$issue."' and cid='12'");
	$rs = mysql_fetch_array($query);
	
	if($num=="0" || $num>49){
		echo "<script>alert('请输入正确开奖号码!');window.location.href='platekj.php';</script>"; 
		exit;
	}

	if($rs['n1']==$num || $rs['n2']==$num || $rs['n3']==$num || $rs['n4']==$num || $rs['n5']==$num || $rs['n6']==$num || $rs['na']==$num){
		echo "<script>alert('开奖号码重复!');window.location.href='platekj.php';</script>"; 
		exit;
	}
	
	if($rs['n1']=="0" || $rs['n1']==""){
		$trs="n1";
	}else{
		if($rs['n2']=="0" || $rs['n2']==""){
			$trs="n2";
		}else{
			if($rs['n3']=="0" || $rs['n3']==""){
				$trs="n3";
			}else{
				if($rs['n4']=="0" || $rs['n4']==""){
					$trs="n4";
				}else{
					if($rs['n5']=="0" || $rs['n5']==""){
						$trs="n5";
					}else{
						if($rs['n6']=="0" || $rs['n6']==""){
							$trs="n6";
						}else{
							if($rs['na']=="0" || $rs['na']==""){
								$trs="na";
							}	
						}	
					}	
				}	
			}			
		}
	}
		
		mysql_query( "update ssc_data set ".$trs."='".$num."' where issue='".$issue."' and cid='12'");
		if($trs=="na"){

			mysql_query( "update ssc_data set zt='0',sign='6',sx1='".$x[($rs['n1']+$sx) % 12]."', sx2='".$x[($rs['n2']+$sx) % 12]."', sx3='".$x[($rs['n3']+$sx) % 12]."', sx4='".$x[($rs['n4']+$sx) % 12]."', sx5='".$x[($rs['n5']+$sx) % 12]."', sx6='".$x[($rs['n6']+$sx) % 12]."', sxna='".$x[($num+$sx) % 12]."'  where issue='".$issue."' and cid='12'");			

			$query = mysql_query( "select * from ssc_data where zt='3' and cid='12' order by id desc limit 1");
			$rs = mysql_fetch_array($query);
			
			$w1=date("w",strtotime($rs['endtime']));
			if($w1==6){
				$w2=date("Y-m-d H:i:s",strtotime("3 days",strtotime($rs['endtime'])));
			}else if($w1==0 || $w1==2 || $w1==4){
				$w2=date("Y-m-d H:i:s",strtotime("2 days",strtotime($rs['endtime'])));
			}else if($w1==1 || $w1==3 || $w1==5){
				$w2=date("Y-m-d H:i:s",strtotime("1 days",strtotime($rs['endtime'])));
			}
			$w3=date("Y-m-d H:i:s",strtotime($w2)+60);
			$w5=$rs['issue']+1;
			mysql_query("insert into ssc_data set issue='".$w5."', endtime='".$w2."', opentime='".$w3."', cid='12', name='六合彩',zt='3'");
		
		}
		echo "<script>window.location.href='platekj.php';</script>"; 
		exit;
	}else if($act=="cancel" )
	{
		mysql_query( "update ssc_data set n1='0',n2='0',n3='0',n4='0',n5='0',n6='0',na='0' where issue='".$issue."' and cid='12'");
		echo "<script>window.location.href='platekj.php';</script>"; 
		exit;
	}else if($act=="del" )
	{
		mysql_query("Delete from ssc_data where id=".$_GET['id']);
		echo "<script>window.location.href='platekj.php';</script>"; 
		exit;
	}else if($act=="js" )
	{
		mysql_query("update ssc_data set zt='0',sign='6' where id=".$_GET['id']);
		echo "<script>window.location.href='platekj.php';</script>"; 
		exit;
	}
}
$sql="select * from ssc_data where cid='12' order by id desc";
$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

$sql="select * from ssc_data where cid='12' order by id desc  limit $page2,$pagesize";
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
<link href="css/index.css" rel="stylesheet" type="text/css" />
    
    <link href="css/ball2.css" rel="stylesheet" type="text/css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<br>
	<form method=post action="?act=in">
    <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="200">开奖号码录入 第<?=$issue?>期</td>
            <td width="626">同步录入<input name="num" type="text" id="num" ONKEYPRESS="digitOnly(event)" size="6" maxlength="2"><input type="submit" name="Submit" value="確定"><input name="cnum" type="button"  id="cnum" onClick="location='?act=cancel'" value="取消"></td>
        </tr>
    </table>
    </form>
	<?php if($act=="mod" ){
	$query2 = mysql_query( "select * from ssc_data where id='".$_GET['id']."' and cid='12' order by id desc");
	$drs = mysql_fetch_array($query2);
	?>
    <form method=post action="?act=save">
    <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="826">期数:<INPUT class="inp1" onKeyPress="digitOnly(event)" value="<?=$drs['issue']?>" maxLength="8" size="8" name="issue"> 开奖时间：號碼1<INPUT class="inp1" onKeyPress="digitOnly(event)" value="<?=$drs['n1']?>" maxLength="2" size="2" name="n1"> 
            號碼2
              <INPUT class="inp1" onKeyPress="digitOnly(event)" value="<?=$drs['n2']?>" maxLength="2" size="2" name="n2"> 
              號碼3
              <INPUT class="inp1" onKeyPress="digitOnly(event)" value="<?=$drs['n3']?>" maxLength="2" size="2" name="n3"> 
              號碼4
              <INPUT class="inp1" onKeyPress="digitOnly(event)" value="<?=$drs['n4']?>" maxLength="2" size="2" name="n4"> 
              號碼5
              <INPUT class="inp1" onKeyPress="digitOnly(event)" value="<?=$drs['n5']?>" maxLength="2" size="2" name="n5"> 
              號碼6
              <INPUT class="inp1" onKeyPress="digitOnly(event)" value="<?=$drs['n6']?>" maxLength="2" size="2" name="n6"> 
              特碼
              <INPUT class="inp1" onKeyPress="digitOnly(event)" value="<?=$drs['na']?>" maxLength="2" size="2" name="na"><INPUT type="hidden" value="<?=$_GET['id']?>" name="id"><input type="submit" name="Submit" value="確定">
                
            </td>
        </tr>
    </table>
    </form>
    <?php }?>
    <table border="0" cellpadding="0" cellspacing="1" class="t_list">
        <tr>
            <td class="t_list_caption F_bold" colspan="11">香港㈥合彩</td>
            <td class="t_list_caption F_bold" colspan="3">特碼</td>
            <td class="t_list_caption F_bold">特合</td>
            <td class="t_list_caption F_bold" colspan="3">總數</td>
            <td class="t_list_caption F_bold">功能</td>
       </tr>
        <tr>
            <td class="t_list_caption" width="50">期號</td>
            <td class="t_list_caption" width="75">開獎日期</td>
            <td class="t_list_caption" colspan="8" width="206">開獎號碼</td>
            <td class="t_list_caption" width="140">生肖</td>
            <td class="t_list_caption" width="35">單雙</td>
            <td class="t_list_caption" width="35">大小</td>
            <td class="t_list_caption" width="35">尾數</td>
            <td class="t_list_caption" width="35">單雙</td>
            <td class="t_list_caption" width="40">總和</td>
            <td class="t_list_caption" width="35">單雙</td>
            <td class="t_list_caption" width="35">大小</td>
            <td class="t_list_caption" width="105">功能</td>
        </tr>
        <?php
		while ($row = mysql_fetch_array($rsnewslist))
		{
		?>
      <tr class="Ball_tr_H" onMouseOut="this.style.backgroundColor=''" onMouseOver="this.style.backgroundColor='#FFFFA2'">
            <td><b><?=$row['issue']?></b></td>
            <td><?php echo date("y-m-d",strtotime($row['endtime']));?></td>
            <td class="No_<?=$row['n1']?>" width="27">
            </td>
            <td class="No_<?=$row['n2']?>" width="27">
            </td>
            <td class="No_<?=$row['n3']?>" width="27">
            </td>
            <td class="No_<?=$row['n4']?>" width="27">
            </td>
            <td class="No_<?=$row['n5']?>" width="27">
            </td>
            <td class="No_<?=$row['n6']?>" width="27">
            </td>
            <td width="17">
                <b>＋</b></td>
            <td class="No_<?=$row['na']?>" width="27">
            </td>
            
            <td>
                 <?php if($row['na']=="0" || $row['na']==""){}else{?><?=$row['sx1']?>&nbsp;<?=$row['sx2']?>&nbsp;<?=$row['sx3']?>&nbsp;<?=$row['sx4']?>&nbsp;<?=$row['sx5']?>&nbsp;<?=$row['sx6']?>&nbsp;<b>＋</b>&nbsp;<?=$row['sxna']?><?php }?>
            </td>
            <td>
            	<?php if ($row['na']=="49") {?> 
                	<span class='Font_G'>合</span>                
				<?php }else if($row['na']=="0" || $row['na']==""){
				}else{
				if ($row['na']%2) {?>
                	<span class='Font_R'>單</span>
                <?php }else{?>
                	<span class='Font_B'>雙</span>
                <?php }}?>
            </td>
            <td>
            	<?php if ($row['na']=="49") {?> 
                	<span class='Font_G'>合</span>                
				<?php }else if($row['na']=="0" || $row['na']==""){
				}else{
            	if ($row['na']>24) {?>
                	<span class='Font_B'>大</span>                
                <?php }else{?>
                	<span class='Font_R'>小</span>
                <?php }}?>
            </td>
            <td>
            	<?php if ($row['na']=="49") {?> 
                	<span class='Font_G'>合</span>                
				<?php }else if($row['na']=="0" || $row['na']==""){
				}else{
            	if ($row['na']%10>4) {?>
                	<span class='Font_B'>大</span>                
                <?php }else{?>
                	<span class='Font_R'>小</span>
                <?php }}?>
            </td>
            <td>
            	<?php if ($row['na']=="49") {?> 
                	<span class='Font_G'>合</span>                
				<?php }else if($row['na']=="0" || $row['na']==""){
				}else{
            	if ((floor($row['na']/10)+$row['na']%10)%2) {?>
                	<span class='Font_R'>單</span>                
                <?php }else{?>
                	<span class='Font_B'>雙</span>
                <?php }}?>
            </td>
            <td>
                <?php  if($row['na']=="0" || $row['na']==""){}else{$tnum=$row['n1']+$row['n2']+$row['n3']+$row['n4']+$row['n5']+$row['n6']+$row['na']; echo $tnum;}?>
            </td>
            <td>
            	<?php if($row['na']=="0" || $row['na']==""){}else{
				 if ($tnum%2) {?>
                	<span class='Font_R'>單</span>                
                <?php }else{?>
                	<span class='Font_B'>雙</span>
                <?php }}?>
            </td>
        <td>
            	<?php if($row['na']=="0" || $row['na']==""){}else{
				if ($tnum>174) {?>
                	<span class='Font_B'>大</span>                
                <?php }else{?>
                	<span class='Font_R'>小</span>
                <?php }}?>
        </td>
            <td><?php if($row['na']=="0" || $row['na']==""){}else{?><a href="?act=mod&id=<?=$row['id']?>">修改</a> <a href="?act=del&id=<?=$row['id']?>">刪除</a> <a href="?act=js&id=<?=$row['id']?>">結算</a>              <?php }?></td>
      </tr>
 		<?php
		}
		?> 
        
        <tr class="t_list_bottom">
            <td colspan="19">共&nbsp;<?=$total?>&nbsp;期記錄&nbsp;&nbsp;&nbsp;&nbsp;分&nbsp;<?=$lastpg?>&nbsp;頁&nbsp;&nbsp;&nbsp;<?php if($page>1){?><a href="?page=<?=$page-1?>"><?php }?>上一頁<?php if($page>1){?></a><?php }?>【&nbsp;
			<?php for($i=$p1;$i<=$p2;$i++){
				if($i==$page){?><span class='Font_R'><?=$i?></span>&nbsp;<?php }else{?><a href="?page=<?=$i?>"><?=$i?></a>&nbsp;<?php }}?>】<?php if($page!=$lastpg){?><a href="?page=<?=$page+1?>"><?php }?>下一頁<?php if($page!=$lastpg){?></a><?php }?></td>
        </tr>
    </table><br>
</body>
</html>