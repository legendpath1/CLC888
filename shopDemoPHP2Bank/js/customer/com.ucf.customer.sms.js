function sendSMS(cellNo,smsType,systemType) {
	var param = {
			systemType : systemType,
			cellNo: cellNo,
			smsType : smsType
		};
	$.ajax({
		type:'POST',
		async:true,
		timeout:30000,
		url:'/member/sms/vfycode/send',
		data:param,
		beforeSend:function() {
			$('#validPhoneCode').attr("disabled","disabled");
		},
		error:function(){
			$('#validPhoneCode').removeAttr("disabled");
		},
		success:function(json) {
			if (""!=json&&"验证码已发送"!=json) {
				$("#sendSMSTipI").css("display","");
				$("#sendSMSTipEm").text(json);
				$('#validPhoneCode').removeAttr("disabled");
			}else {
				$("#sendSMSTipI").css("display","none");
				$("#sendSMSTipEm").text("");
				freezeTime();
			}
		},
		dataType:"json"
	});
}

var sec = 60;
function freezeTime() {
	$('#validPhoneCode').attr("disabled","disabled");
	for(var i=0;i<=sec;i++) { 
		setTimeout("updateTime("+ i + ")", i * 1000); 
	}
	setTimeout("defrostTime()",60000);
}
function defrostTime() {
	$('#validPhoneCode').val('获取手机验证码');
	$('#validPhoneCode').removeAttr("disabled");
}
function updateTime(i) {
	$('#validPhoneCode').val(sec-i+'秒后可再发送');
}


function windowclose() {
    var browserName = navigator.appName;
    if (browserName=="Netscape") {
        window.open('', '_self', '');
        window.close();
    }
    else {
        if (browserName == "Microsoft Internet Explorer"){
            window.opener = "whocares";
            window.opener = null;
            window.open('', '_top');
            window.close();
        }
    }
}