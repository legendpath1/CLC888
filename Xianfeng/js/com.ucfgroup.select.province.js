/**
 * 省/市/县级联
 * @param province 省元素Id
 * @param city 市元素Id
 * @param district 县元素Id
 * @author WangYanCheng
 * @version 2014-03-13
 */
var CascadeSelect = function(province, city, district) {
	this.queryProvince(function(data){
		window.ucfgroup_province_data=data;
	});
	this.province = province;
	this.city = city;
	this.district = district;
	// 预加载省一级的Json缓存
	// 绑定组件change事件，当省一级对象产生事件时加载市一级对象,当市一级对象产生事件加载县一级对象
	var $this = this;
	$("#" + province).bind('change',function(e){
		//重新加载二、三级组件内容
		CascadeSelect.reloadCityData($this.province, $this.city, $this, e);
		$("#" + $this.city).change();
	});
	$("#" + city).bind('change', function(e){
		CascadeSelect.reloadDistrictData($this.city, $this.district, $this, e);
		$('#' + $this.district).change();
	});
	$('#' + district).bind('change', function(e){
		//街道变更事件
	});
	this.initSelectContext(this);
};
/**
 * 实例初始
 */
CascadeSelect.prototype.initSelectContext=function(src) {
	var $this = src;
	this.queryProvince(function(data){
		var tmpData = data['province'];
		var tmpLen = tmpData.length;
		var tmpElem = $('<div/>');
		for (var i = 0; i < tmpLen; i++) {
			$('<option value="' + tmpData[i]['code'] + '">' + tmpData[i]['name'] + '</option>').appendTo(tmpElem);
		}
		$('#' + $this.province).append(tmpElem.html());
	});
};
/**
 * 取JSON格式的省市数据
 */
CascadeSelect.prototype.queryProvince=function(callback) {
	//检测缓存
	if (window.ucfgroup_province_data) {
		if (callback instanceof Function) {
			try {
				callback(window.ucfgroup_province_data);
				return;
			} catch (e) {
			}
		}
	}
	$.ajax({
		/*
		url : '/member/js/province.json',
		*/
		url : '/member/queryProvince',
		type : 'POST',
		contentType : 'application/json; charset=UTF-8',
		success:function(data) {
			callback(data);
		},
		error:function(x, e) {
			alert(x.responseText);
		},
		complete:function(x) {
		}
	});
};
/**
 * 重新加载城市数据
 * @param parentElem 关联上级元素
 * @param cityElem 城市元素
 * @param $this 作用域
 * @param e 事件源
 */
CascadeSelect.reloadCityData=function(parentElem, cityElem, $this, e) {
	var cityElemRef = $('#' + cityElem);
	cityElemRef.empty();
	$this.queryProvince(function(data){
		var tmpData = data['city'];
//console.log("var tmpData = data['city'];==>" + tmpData.length);
		//取省级别码
		var provinceCode = $('#' + parentElem).val();
		if (-1 == (provinceCode)) {
			alert('请先选择省！');
			return;
		}
		provinceCode = provinceCode.substring(0,2);
		//过滤市级别码
		var tmpLen = tmpData.length;
		var tmpArray = new Array();
		for (var i = 0; i < tmpLen; i++) {
			var tmpCode = tmpData[i].code;
			tmpCode = tmpCode.substring(0,2);
			if (tmpCode == (provinceCode)) {
				tmpArray.push(tmpData[i]);
			}
		}
		var tmpElem = $('<div/>');
		for (var i = 0; i < tmpArray.length; i++) {
			$('<option value="' + tmpArray[i]['code'] + '">' + tmpArray[i]['name'] + '</option>').appendTo(tmpElem);
		}
		cityElemRef.append(tmpElem.html());
	});
};
/**
 * 重新加载街道区域数据
 * @param parentElem 关联上级元素
 * @param districtElem 街道区域元素
 * @param $this 作用域
 * @param e 事件源
 */
CascadeSelect.reloadDistrictData=function(parentElem, districtElem, $this, e) {
	var districtElemRef = $('#' + districtElem);
	districtElemRef.empty();
	$this.queryProvince(function(data){
		var tmpData = data['district'];
//console.log("var tmpData = data['district'];==>" + tmpData.length);
		//取省级别码
		var cityCode = $('#' + parentElem).val();
		if (-1 == (cityCode)) {
			alert('请先选择市！');
			return;
		}
		cityCode = cityCode.substring(0,4);
		//过滤市级别码
		var tmpLen = tmpData.length;
		var tmpArray = new Array();
		for (var i = 0; i < tmpLen; i++) {
			var tmpCode = tmpData[i].code;
			tmpCode = tmpCode.substring(0,4);
			if (tmpCode == (cityCode)) {
				tmpArray.push(tmpData[i]);
			}
		}
		var tmpElem = $('<div/>');
		for (var i = 0; i < tmpArray.length; i++) {
			$('<option value="' + tmpArray[i]['code'] + '">' + tmpArray[i]['name'] + '</option>').appendTo(tmpElem);
		}
		districtElemRef.append(tmpElem.html());
	});
};