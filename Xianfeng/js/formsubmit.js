
	function pay(step){
		var payForm =  $('#payForm');
		if(step==1){
			//进行签名操作
	    	var val = installdata();
			$('#sign').val(val);
		}else if(step==2){
			payForm.attr("action","http://106.39.35.10:9116/gateway.do");
			payForm.submit();
		}
		
	}