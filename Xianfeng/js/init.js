$(document).ready(function(){
		var d = producedate();
		var reqid = $('#merchantNo').val();
		if(reqid==''){
			$('#merchantNo').val(d);
			}
	});