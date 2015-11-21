<?php
if ( !isset( $_SESSION['username'] ) )
{
	echo "<script language='javascript'>alert('欢迎来到彩乐彩，请先登录');parent.location='default_logout.php'</script>";
	exit;
}
if($_SESSION["uid"]=="" || $_SESSION["username"]=="" || $_SESSION["level"]=="")
{
	echo "<script language='javascript'>alert('欢迎来到彩乐彩，请先登录! ');parent.location='default_logout.php'</script>";
	exit;
}

if($webzt!='1'){
	echo "<script>alert('对不起,系统维护中!');window.location='".$gourl."';</script>"; 
	exit;
}
if(Get_member(zt)=="2"){
	echo "<script language='javascript'>alert('您的帐户被冻结合! ');parent.location='default_logout.php'</script>";
	exit;
}
?>