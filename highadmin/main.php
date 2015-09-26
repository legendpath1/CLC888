<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<TITLE>数据采集 QQ474038252</TITLE>

<SCRIPT type="text/javascript" src="js/jquery.js"></SCRIPT>
<SCRIPT language="javascript" type="text/javascript">
jQuery(document).ready(function(){
	
	_getData1 = setInterval(function(){
		$.ajax({
			type : 'POST',
			url  : 'query1c.php',
			timeout : 12000,
			success : function(data){
					$("#lot1").html(data);
					return true;
			}
		});
	},20000);

	_getData2 = setInterval(function(){
		$.ajax({
			type : 'POST',
			url  : 'query2c.php',
			timeout : 12000,
			success : function(data){
					$("#lot2").html(data);
					return true;
			}
		});
	},20000);

	_getData3 = setInterval(function(){
		$.ajax({
			type : 'POST',
			url  : 'query3c.php',
			timeout : 12000,
			success : function(data){
					$("#lot3").html(data);
					return true;
			}
		});
	},20000);

	_getData5 = setInterval(function(){
		$.ajax({
			type : 'POST',
			url  : 'query5.php',
			timeout : 12000,
			success : function(data){
					$("#lot5").html(data);
					return true;
			}
		});
	},20000);

	_getData6 = setInterval(function(){
		$.ajax({
			type : 'POST',
			url  : 'query6.php',
			timeout : 12000,
			success : function(data){
					$("#lot6").html(data);
					return true;
			}
		});
	},20000);

	_getData7 = setInterval(function(){
		$.ajax({
			type : 'POST',
			url  : 'query7c.php',
			timeout : 12000,
			success : function(data){
					$("#lot7").html(data);
					return true;
			}
		});
	},20000);

	_getData8 = setInterval(function(){
		$.ajax({
			type : 'POST',
			url  : 'query8c.php',
			timeout : 12000,
			success : function(data){
					$("#lot8").html(data);
					return true;
			}
		});
	},20000);

	_getData9 = setInterval(function(){
		$.ajax({
			type : 'POST',
			url  : 'query9c.php',
			timeout : 12000,
			success : function(data){
					$("#lot9").html(data);
					return true;
			}
		});
	},20000);

	_getData10 = setInterval(function(){
		$.ajax({
			type : 'POST',
			url  : 'query10c.php',
			timeout : 12000,
			success : function(data){
					$("#lot10").html(data);
					return true;
			}
		});
	},20000);

	_getData2 = setInterval(function(){
		$.ajax({
			type : 'POST',
			url  : 'query2c.php',
			timeout : 12000,
			success : function(data){
					$("#lot2").html(data);
					return true;
			}
		});
	},20000);

	_getData2 = setInterval(function(){
		$.ajax({
			type : 'POST',
			url  : 'query2c.php',
			timeout : 12000,
			success : function(data){
					$("#lot2").html(data);
					return true;
			}
		});
	},20000);

	_getData2 = setInterval(function(){
		$.ajax({
			type : 'POST',
			url  : 'query2c.php',
			timeout : 12000,
			success : function(data){
					$("#lot2").html(data);
					return true;
			}
		});
	},20000);
	
});


</script>
</HEAD>
<BODY>

<span id="lot1"></span><br>
<span id="lot2"></span><br>
<span id="lot3"></span><br>
<span id="lot4"></span><br>
<span id="lot5"></span><br>
<span id="lot6"></span><br>
<span id="lot7"></span><br>
</BODY>
</HTML>