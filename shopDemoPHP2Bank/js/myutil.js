	Date.prototype.format =function(format)
	{
	    var o = {
	    "M+" : this.getMonth()+1, //month
		"d+" : this.getDate(),    //day
		"h+" : this.getHours(),   //hour
		"m+" : this.getMinutes(), //minute
		"s+" : this.getSeconds(), //second
		"q+" : Math.floor((this.getMonth()+3)/3),  //quarter
		"S" : this.getMilliseconds() //millisecond
	    };
	    if(/(y+)/.test(format)) format=format.replace(RegExp.$1,
	    (this.getFullYear()+"").substr(4- RegExp.$1.length));
	    for(var k in o)if(new RegExp("("+ k +")").test(format))
	    format = format.replace(RegExp.$1,
	    RegExp.$1.length==1? o[k] :
	    ("00"+ o[k]).substr((""+ o[k]).length));
	    return format;
	};

	function producedate(){
		var date = new Date(); 
		var d ;   
		var oldTime = date.getTime(); //得到毫秒数  
		var newTime = new Date(oldTime); //就得到普通的时间了 
	    d = date.format('yyyyMMddhhmmssS');
	    return d;
	}
	
	function data2map(){
		var m = new Map();
	   	$('table input').each(function(){
	   	    m.put(this.name,$(this).val());
	   	});
	   	return m;
	}
	function key4map(m){
		 var arr = new Array();
		    arr = m.keys();
		    arr=arr.sort();
		    return arr;
		}
	
	function preinstalldata(){
		var m = data2map();
        var arr = key4map(m);
       
        var content = "";
        for(var i=0;i<arr.length;i++){
    		var k = arr[i];
    		if('sign' !=k &&  'gatewayUrl' != k && 'flag' != k && 'bizType' != k){
    			var val = m.get(k);
    			if(content==""){
    				content = k+"="+val;
    			}else{
    				content = content+ "&"+k+"="+val;
    				}
    			}
    		
    	}
        return content;
	}