<?php $url=$_SERVER['PHP_SELF'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>首页</title>
<SCRIPT TYPE="TEXT/JAVASCRIPT" SRC="js/jquery.js"></SCRIPT>
<SCRIPT TYPE="TEXT/JAVASCRIPT" SRC="js/myutil.js"></SCRIPT>
</head>
<body>
	<div align="center">
		<a href="pages/testGetToken.php?url=<?php echo $url;?>">申请安全令牌</a><br><br>  
		<a href="pages/getToken.php?bizType=directToBank&url=<?php echo $url;?>">直连网银</a><br><br> 
		<a href="pages/getToken.php?bizType=querySingleOrder&url=<?php echo $url;?>">单笔订单查询</a><br><br> 
		
	</div>
</body>
</html>