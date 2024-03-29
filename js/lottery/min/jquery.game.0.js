(function($){
	if(/^1.2/.test($.fn.jquery)||/^1.1/.test($.fn.jquery)){
		alert("requires jQuery v1.3 or later!  You are using v"+$.fn.jquery);
		return
	}
	$(document).ready(function(){
		$.playInit({
			data_label:face,
			data_prize:pri_user_data,
			cur_issue:pri_cur_issue,
			last_open:pri_lastopen,
			issues:pri_issues,
			issuecount:pri_issuecount,
			servertime:pri_servertime,
			lotteryid:pri_lotteryid,
			isdynamic:pri_isdynamic,
			showrecord:pri_showhistoryrecord,
			ajaxurl:pri_ajaxurl
		})
	});
	$.playInit=function(opts){
		var ps={
			data_label:[],
			data_prize:[],
			data_id:{
				id_cur_issue:"#current_issue",
				id_cur_end:"#current_endtime",
				id_cur_sale:"#current_sale",
				id_cur_left:"#current_left",
				id_count_down:"#count_down",
				id_labelbox:"#tabbar-div-s2",
				id_smalllabel:"#tabbar-div-s3",
				id_desc:"#lt_desc",
				id_help:"#lt_help",
				id_example:"#lt_example",
				id_selector:"#lt_selector",
				id_sel_num:"#lt_sel_nums",
				id_sel_money:"#lt_sel_money",
				id_sel_times:"#lt_sel_times",
				id_reduce_times:"#reducetime",
				id_plus_times:"#plustime",
				id_sel_insert:"#lt_sel_insert",
				id_sel_modes:"#lt_sel_modes",
				id_sel_prize:"#lt_sel_prize",
				id_cf_count:"#lt_cf_count",
				id_cf_clear:"#lt_cf_clear",
				id_cf_content:"#lt_cf_content",
				id_cf_num:"#lt_cf_nums",
				id_cf_money:"#lt_cf_money",
				id_cf_help:"#lt_cf_help",
				id_issues:"#lt_issues",
				id_sendok:"#lt_buy",
				id_tra_if:"#lt_trace_if",
				id_tra_stop:"#lt_trace_stop",
				id_tra_box:"#lt_trace_box",
				id_tra_alct:"#lt_trace_alcount",
				id_tra_label:"#lt_trace_label",
				id_tra_lhtml:"#lt_trace_labelhtml",
				id_tra_ok:"#lt_trace_ok",
				id_tra_issues:"#lt_trace_issues"
			},
			cur_issue:{issue:"20100210-001",endtime:"2010-02-10 09:10:00",opentime:"2011-02-10 09:10:00"},
			last_open:{issue:"20100210-001",code:"12345",endtime:"2010-02-10 09:10:00",opentime:"2011-02-10 09:10:00"},
			issues:{},
			servertime:"2011-02-10 09:09:40",
			ajaxurl:"",
			lotteryid:1,
			isdynamic:1,
			ontimeout:function(){},
			onfinishbuy:function(){},
			test:""
		};
		opts=$.extend({},ps,opts||{});
		$.extend({
			lt_id_data:opts.data_id,lt_method_data:{},lt_method:methods,lt_issues:opts.issues,lt_issuecount:opts.issuecount,lt_ajaxurl:opts.ajaxurl,lt_lottid:opts.lotteryid,lt_isdyna:opts.isdynamic,lt_showrecord:opts.showrecord,lt_total_nums:0,lt_total_money:0,lt_time_leave:0,lt_time_open:0,lt_open_time:opts.cur_issue.opentime,lt_end_time:opts.cur_issue.endtime,lt_open_status:true,lt_last_open:opts.last_open,lt_same_code:[],lt_ontimeout:opts.ontimeout,lt_onfinishbuy:opts.onfinishbuy,lt_trace_base:0,lt_submiting:false,lt_ismargin:true,lt_prizes:[],lt_rxmode:false,lt_position_sel:[],lt_position_title:lot_lang.dec_s41});ps=null;opts.data_id=null;opts.issues=null;opts.ajaxurl=null;opts.lotteryid=null;if($.browser.msie){$($.lt_id_data.id_tra_if).show();CollectGarbage()}var noRightMethod=[];var noRightGroup=[];var haveRight=false;$.each(opts.data_label,function(l,h){noRightGroup=[];$.each(h.label,function(i,n){noRightMethod=[];$.each(n.label,function(j,m){haveRight=false;for(k in opts.data_prize){if(m.methodid==opts.data_prize[k].methodid){m.prize=opts.data_prize[k].prize;m.dyprize=opts.data_prize[k].dyprize;haveRight=true;break}}if(haveRight==false){noRightMethod.push(m)}});for(var ll=0;ll<noRightMethod.length;ll++){opts.data_label[l].label[i].label.remove(noRightMethod[ll])}if(opts.data_label[l].label[i].label.length==0){noRightGroup.push(n)}});for(var mm=0;mm<noRightGroup.length;mm++){opts.data_label[l].label.remove(noRightGroup[mm])}});$($.lt_id_data.id_count_down).lt_timer(opts.servertime,opts.cur_issue.endtime);
		if($.lt_last_open.statuscode<1&&$.lt_last_open.issue!=""&&$.lt_open_status==true){
			$("#lt_opentimeleft").lt_opentimer($.lt_last_open.endtime,$.lt_last_open.opentime,$.lt_last_open.issue)
		}
		var bhtml="";
		var postion=0;
		var haverx=0;
		$.each(opts.data_label,function(i,n){
			if(n.label.length>0){
				if(typeof(n)=="object"){
					if(n.isrx==1&&haverx==0){
						haverx=1
					}
					if(postion==0||n.isdefault==1){
						bhtml=bhtml.replace("front","back");
						bhtml+='<span class="tab-front" value="'+i+'" tag="'+n.isrx+'" default="'+n.isdefault+'"><span class="tabbar-left"></span><span class="content">'+n.title+'</span><span class="tabbar-right"></span></span>';
						lt_smalllabel({title:n.title,label:n.label})
					}else{
						bhtml+='<span class="tab-back" value="'+i+'" tag="'+n.isrx+'" default="'+n.isdefault+'"><span class="tabbar-left"></span><span class="content">'+n.title+'</span><span class="tabbar-right"></span></span>'
					}
				}
				postion++
			}
		});
		if(haverx==1){
			bhtml+='<span class="tab-back" id="changemode"><span class="tabbar-left"></span><span class="content" title="'+lot_lang.dec_s44+'">'+lot_lang.dec_s42+'</span><span class="tabbar-right"></span></span>'
		}
		$bhtml=$(bhtml);
		$($.lt_id_data.id_labelbox).empty();
		$(bhtml).appendTo($.lt_id_data.id_labelbox);
		$.each($($.lt_id_data.id_labelbox).children(),function(i,n){if($.lt_rxmode==false){if($(this).attr("tag")==1){$(this).hide()}}else{if($(this).attr("tag")==0){$(this).hide()}}});$("#changemode").click(function(){if($.lt_rxmode==false){$.lt_rxmode=true;$(this).find(".content").html(lot_lang.dec_s43)}else{$.lt_rxmode=false;$(this).find(".content").html(lot_lang.dec_s42)}var j=0;$.each($($.lt_id_data.id_labelbox).children(),function(i,n){if($.lt_rxmode==false){if($(this).attr("tag")==1){$(this).hide()}else{$(this).show();if(j==0||$(this).attr("default")==1){$(this).click()}j++}}else{if($(this).attr("tag")==0){$(this).hide()}else{$(this).show();if(j==0||$(this).attr("default")==1){$(this).click()}j++}}})});$($.lt_id_data.id_labelbox).children().click(function(){if($.trim($(this).attr("class"))=="tab-front"||$.trim($(this).attr("id"))=="changemode"){return}$($.lt_id_data.id_labelbox).children().attr("class","tab-back");$(this).attr("class","tab-front");var index=parseInt($(this).attr("value"),10);lt_smalllabel({title:opts.data_label[index].title,label:opts.data_label[index].label})});var chtml='<select name="lt_issue_start" id="lt_issue_start">';var j=0;var endtime=0;var currentendtime=new Date($.lt_end_time.replace(/[\-\u4e00-\u9fa5]/g,"/")).getTime();$.each($.lt_issues,function(i,n){endtime=new Date(n.endtime.replace(/[\-\u4e00-\u9fa5]/g,"/")).getTime();if(j<$.lt_issuecount&&endtime>=currentendtime){j++;chtml+='<option value="'+n.issue+'">'+n.issue+(n.issue==opts.cur_issue.issue?lot_lang.dec_s7:"")+"</option>"}});chtml+='</select><input type="hidden" name="lt_total_nums" id="lt_total_nums" value="0"><input type="hidden" name="lt_total_money" id="lt_total_money" value="0">';$(chtml).appendTo($.lt_id_data.id_issues);$("tr",$($.lt_id_data.id_cf_content)).live("mouseover",function(){$(this).addClass("on")}).live("mouseout",function(){$(this).removeClass("on")});$($.lt_id_data.id_cf_clear).click(function(){$.confirm(lot_lang.am_s5,function(){$.lt_total_nums=0;$.lt_total_money=0;$.lt_trace_base=0;$.lt_same_code=[];$($.lt_id_data.id_cf_num).html(0);$($.lt_id_data.id_cf_money).html(0);$($.lt_id_data.id_cf_count).html(0);$($.lt_id_data.id_cf_content).children().empty();$('<tr class="nr"><td class="tl_li_l" width="4"></td><td colspan="6" class="noinfo">\u6682\u65e0\u6295\u6ce8\u9879</td><td class="tl_li_rn" width="4"></td></tr>').prependTo($.lt_id_data.id_cf_content);cleanTraceIssue();if($.lt_ismargin==false){traceCheckMarginSup()}})});$($.lt_id_data.id_cf_help).mouseover(function(){var $h=$('<div class=ibox><table border=0 cellspacing=0 cellpadding=0><tr class=t><td class=tl></td><td class=tm></td><td class=tr></td></tr><tr class=mm><td class=ml><img src="'+pri_imgserver+'/images/comm/t.gif"></td><td>'+lot_lang.am_s35+'</td><td class=mr><img src="'+pri_imgserver+'/images/comm/t.gif"></td></tr><tr class=b><td class=bl></td><td class=bm><img src="'+pri_imgserver+'/images/comm/t.gif"></td><td class=br> </td></tr></table><div class=ar><div class=ic></div></div></div>');var offset=$(this).offset();var left=offset.left-37;var top=offset.top-51;$(this).openFloat($h,"more",left,top)}).mouseout(function(){$(this).closeFloat()});$($.lt_id_data.id_help).mouseover(function(){var $h=$('<div class=ibox><table border=0 cellspacing=0 cellpadding=0><tr class=t><td class=tl></td><td class=tm></td><td class=tr></td></tr><tr class=mm><td class=ml><img src="'+pri_imgserver+'/images/comm/t.gif"></td><td>'+$.lt_method_data.methodhelp+'</td><td class=mr><img src="'+pri_imgserver+'/images/comm/t.gif"></td></tr><tr class=b><td class=bl></td><td class=bm><img src="'+pri_imgserver+'/images/comm/t.gif"></td><td class=br> </td></tr></table><div class=ar><div class=ic></div></div></div>');var offset=$(this).offset();var left=offset.left-37;var top=offset.top-35;$(this).openFloat($h,"more",left,top)}).mouseout(function(){$(this).closeFloat()});$($.lt_id_data.id_example).mouseover(function(){var $h=$('<div class=ibox><table border=0 cellspacing=0 cellpadding=0><tr class=t><td class=tl></td><td class=tm></td><td class=tr></td></tr><tr class=mm><td class=ml><img src="'+pri_imgserver+'/images/comm/t.gif"></td><td>'+$.lt_method_data.methodexample+'</td><td class=mr><img src="'+pri_imgserver+'/images/comm/t.gif"></td></tr><tr class=b><td class=bl></td><td class=bm><img src="'+pri_imgserver+'/images/comm/t.gif"></td><td class=br> </td></tr></table><div class=ar><div class=ic></div></div></div>');var offset=$(this).offset();var left=offset.left-37;var top=offset.top-35;$(this).openFloat($h,"more",left,top)}).mouseout(function(){$(this).closeFloat()});$($.lt_id_data.id_tra_if).lt_trace({issues:opts.issues});$($.lt_id_data.id_sendok).lt_ajaxSubmit();$("a[rel='projectinfo']").live("click",function(){me=this;$pid=$(this).html();$.blockUI({message:'<div style="width:200px;padding:10px 100px;background-color:#fff;border:4px #666 solid;"><img src="'+pri_imgserver+'/images/comm/loading.gif" style="margin-right:10px;">\u6b63\u5728\u8bfb\u53d6\u6295\u6ce8\u8be6\u60c5...</div>',overlayCSS:{backgroundColor:"#000000",opacity:0.3,cursor:"wait"}});$.ajax({type:"POST",url:"history_playinfo.php",data:"id="+$pid,success:function(data){$.unblockUI({fadeInTime:0,fadeOutTime:0});try{eval("data = "+data+";");if(data.stats=="error"){$.alert('<IMG src="'+pri_imgserver+'/images/comm/t.gif" class=icons_mb5_e style="margin:5px 15px 0 0;">'+data.data)}else{data=data.data;stat="\u672a\u5f00\u5956";if(data.project.iscancel==0){if(data.project.isgetprize==0){stat="\u672a\u5f00\u5956"}else{if(data.project.isgetprize==2){stat="\u672a\u4e2d\u5956"}else{if(data.project.isgetprize==1){if(data.project.prizestatus==0){stat="\u672a\u6d3e\u5956"}else{stat="\u5df2\u6d3e\u5956"}}}}}else{if(data.project.iscancel==1){stat="\u672c\u4eba\u64a4\u5355"}else{if(data.project.iscancel==2){stat="\u7ba1\u7406\u5458\u64a4\u5355"}else{if(data.project.iscancel==3){stat="\u5f00\u9519\u5956\u64a4\u5355"}}}}$.blockUI_lang.button_sure="\u5173&nbsp;\u95ed";html='<table class="hisinfo" border=0 cellspacing=0 cellpadding=0>';html+="<tr><td width=30%>\u6e38\u620f\u7528\u6237\uff1a<span>"+data.project.username+"</span></td><td width=25%>\u6e38\u620f\uff1a<span>"+data.project.cnname+"</span></td><td width=45% colspan=2>\u603b\u91d1\u989d\uff1a<span>"+data.project.totalprice+"</span></td></tr>";html+="<tr><td>\u6ce8\u5355\u7f16\u53f7\uff1a<span>"+data.project.projectid+"</span></td><td>\u73a9\u6cd5\uff1a<span>"+data.project.methodname+(data.project.taskid!=0?'&nbsp;<a href="history_taskinfo.php?id='+data.project.taskid+'" target="_blank" style="color:#F77;">\u8ffd\u53f7\u5355\u8be6\u60c5</a>':"")+"</span></td><td>\u6ce8\u5355\u72b6\u6001\uff1a<span>"+stat+"</span></td><td>&nbsp;&nbsp;&nbsp;&nbsp;\u500d\u6570\u6a21\u5f0f\uff1a<span>"+data.project.multiple+"\u500d, "+data.project.modes+"\u6a21\u5f0f</span></td></tr>";html+="<tr><td>\u6295\u5355\u65f6\u95f4\uff1a<span>"+data.project.writetime+"</span></td><td>\u5956\u671f\uff1a<span>"+data.project.issue+"</span></td><td>\u6ce8\u5355\u5956\u91d1\uff1a<span>"+data.project.bonus+"</span></td><td>";if(data.project.dypointdec.length>2){html+="\u52a8\u6001\u5956\u91d1\u8fd4\u70b9\uff1a<span>"+data.project.dypointdec+"</span>"}else{html+="&nbsp;"}if(data.project.nocode!=""){html+="</td></tr><td width=18% colspan=4 >\u5f00\u5956\u53f7\u7801\uff1a<span>"+data.project.nocode+"</span>"}else{html+="</td></tr><td width=18% colspan=4 >\u5f00\u5956\u53f7\u7801\uff1a<span>---</span>"}html+='</td></tr><tr><td colspan=4 STYLE="height:50px;">\u6295\u6ce8\u5185\u5bb9\uff1a<textarea class=t1 READONLY=TRUE style="width:790px;margin-bottom:5px;height:50px;">'+data.project.code+"</textarea></td></tr>";html+="</table>";if(typeof(data.projectprize)!=="undefined"){html+='<div class="title">\u5b9e\u9645\u4e2d\u5956\u60c5\u51b5\uff1a</div>';html+='<table class="hisinfo" border=0 cellspacing=0 cellpadding=0><tr class=th><td width=150>\u5956\u7ea7\u540d\u79f0</td><td width=60><div class=line></div>\u4e2d\u5956\u6ce8\u6570</td><td><div class=line></div>\u5355\u6ce8\u5956\u91d1</td><td width=90><div class=line></div>\u500d\u6570</td><td width=150><div class=line></div>\u603b\u5956\u91d1(\u6ce8\u6570*\u5956\u91d1*\u500d\u6570)</td></tr>';$.each(data.projectprize.detail,function(i,k){html+='<tr class=d><td style="cursor:pointer;" title="'+k.levelcodedesc+'">'+k.leveldesc+"</td><td>"+k.times+"</td><td>"+k.singleprize+"</td><td>"+k.multiple+"</td><td>"+k.prize+"</td></tr>"});html+="</table>"}else{if(data.can==1){html+='<div class="title">&nbsp;&nbsp;<input type="button" value="&nbsp;\u64a4&nbsp;\u5355&nbsp;" class="button yh" id="cancelproject"></div>'}html+='<div class="title">\u53ef\u80fd\u4e2d\u5956\u60c5\u51b5\uff1a</div>';html+='<table class="hisinfo" border=0 cellspacing=0 cellpadding=0><tr class=th><td width=150>\u5956\u7ea7\u540d\u79f0</td><td><div class=line></div>\u53f7\u7801</td><td width=45><div class=line></div>\u500d\u6570</td><td width=45><div class=line></div>\u5956\u7ea7</td><td width=90><div class=line></div>\u5956\u91d1</td></tr>';$.each(data.prizelevel,function(i,k){html+='<tr class=d><td style="cursor:pointer;" title="'+k.levelcodedesc+'">'+k.leveldesc+"</td><td>"+(k.expandcode.length>60?'<textarea READONLY=TRUE style="width:386px;height:50px;">'+k.expandcode+"</textarea>":k.expandcode)+"</td><td>"+k.codetimes+"</td><td>"+k.level+"</td><td>"+k.prize+"</td></tr>"});html+="</table>"}$.alert(html,"\u6295\u6ce8\u8be6\u60c5","",820,false);$.blockUI_lang.button_sure="\u786e&nbsp;\u5b9a";$("#cancelproject").click(function(){if(confirm("\u771f\u7684\u8981\u64a4\u5355\u5417?"+(data.need==1?"\n\u64a4\u9500\u6b64\u5355\u5c06\u6536\u53d6\u64a4\u5355\u624b\u7eed\u8d39\u91d1\u989d:"+data.money+"\u5143.":""))){$.blockUI({message:'<div style="width:200px;padding:10px 100px;background-color:#fff;border:4px #666 solid;"><img src="'+pri_imgserver+'/images/comm/loading.gif" style="margin-right:10px;">\u6b63\u5728\u63d0\u4ea4\u64a4\u5355\u8bf7\u6c42...</div>',overlayCSS:{backgroundColor:"#000000",opacity:0.3,cursor:"wait"}});$.ajax({type:"POST",url:"history_playcancel.php",data:"id="+data.project.projectid,success:function(data){$.unblockUI({fadeInTime:0,fadeOutTime:0});try{eval("data = "+data+";");if(data.stats=="error"){$.alert('<IMG src="'+pri_imgserver+'/images/comm/t.gif" class=icons_mb5_e style="margin:5px 15px 0 0;">'+data.data)}else{$(me).closest("tr").addClass("cancel");$(me).parent().siblings("td:last").html("\u672c\u4eba\u64a4\u5355");$.alert('<IMG src="'+pri_imgserver+'/images/comm/t.gif" class=icons_mb5_s style="margin:5px 15px 0 0;">\u64a4\u5355\u6210\u529f');$.fn.fastData()}}catch(e){$.alert('<IMG src="'+pri_imgserver+'/images/comm/t.gif" class=icons_mb5_e style="margin:5px 15px 0 0;">\u64a4\u5355\u5931\u8d25\uff0c\u8bf7\u68a2\u540e\u91cd\u8bd5')}}})}})}}catch(e){$.alert('<IMG src="'+pri_imgserver+'/images/comm/t.gif" class=icons_mb5_e style="margin:5px 15px 0 0;">\u8bfb\u53d6\u6570\u636e\u51fa\u9519\uff0c\u8bf7\u91cd\u8bd5')}}})})};var lt_smalllabel=function(opts){var ps={title:"",label:[]};opts=$.extend({},ps,opts||{});var html="";var dyhtml="";var hasmore=0;$.each(opts.label,function(j,m){if(m.label.length>0){html+='<li class="tz_li">';if(!(opts.label.length==1&&m.label.length==1)){hasmore=1;html+='<span class="tz_title">'+m.gtitle+"</span>"}$.each(m.label,function(i,n){if(typeof(n)=="object"){if(j==0&&i==0){if(!(opts.label.length==1&&m.label.length==1)){html+='<div class="act"><span class="method-tab-front" id="smalllabel_'+j+"_"+i+'">'+n.desc+"</span></div>"}lt_selcountback();$.lt_method_data={methodid:n.methodid,title:opts.title,name:n.name,str:n.show_str,prize:n.prize,dyprize:n.dyprize,modes:$.lt_method_data.modes?$.lt_method_data.modes:{},sp:n.code_sp,methodhelp:n.methodhelp,methoddesc:n.methoddesc,methodexample:n.methodexample,maxcodecount:n.maxcodecount,isrx:n.isrx,numcount:n.numcount,defaultposition:n.defaultposition};$($.lt_id_data.id_selector).lt_selectarea(n.selectarea);selmodes=getCookie("modes");$($.lt_id_data.id_sel_modes).empty();$.each(n.modes,function(j,m){$.lt_method_data.modes[m.modeid]={name:m.name,rate:Number(m.rate)};addItem($($.lt_id_data.id_sel_modes)[0],""+m.name+"",m.modeid)});SelectItem($($.lt_id_data.id_sel_modes)[0],selmodes);dypoint=getCookie("dypoint");$($.lt_id_data.id_sel_prize).empty();if(n.dyprize.length==1&&$.lt_isdyna==1){dyhtml='<SELECT name="lt_sel_dyprize" id="lt_sel_dyprize">';$.each(n.dyprize[0].prize,function(j,m){dyhtml+='<OPTION value="'+m.prize+"|"+m.point+'"'+(dypoint==m.point?" selected":"")+">"+m.prize+"-"+(Math.ceil(m.point*1000)/10)+"%</OPTION>"});dyhtml+="</SELECT>";$($.lt_id_data.id_sel_prize).html(lot_lang.dec_s37);$(dyhtml).appendTo($.lt_id_data.id_sel_prize)}}else{if(!(opts.label.length==1&&m.label.length==1)){html+='<div class="back"><span class="method-tab-back" id="smalllabel_'+j+"_"+i+'">'+n.desc+"</span></div>"}}}});html+="</li>"}});$html=$(html);$($.lt_id_data.id_smalllabel).empty();$html.appendTo($.lt_id_data.id_smalllabel);if(hasmore==0){$($.lt_id_data.id_smalllabel).empty();$($.lt_id_data.id_smalllabel).parent().hide()}else{$($.lt_id_data.id_smalllabel).parent().show()}$("span[id^='smalllabel_']:first",$($.lt_id_data.id_smalllabel)).attr("class","method-tab-front").data("ischecked","yes");$("span[id^='smalllabel_']",$($.lt_id_data.id_smalllabel)).click(function(){if($(this).data("ischecked")=="yes"){return}var aIdIndex=$(this).attr("id").split("_");var groupindex=parseInt(aIdIndex[1],10);var index=parseInt(aIdIndex[2],10);var tmpopts=opts.label;tmpopts=tmpopts[groupindex];lt_selcountback();$.lt_method_data={methodid:tmpopts.label[index].methodid,title:tmpopts.gtitle,name:tmpopts.label[index].name,str:tmpopts.label[index].show_str,prize:tmpopts.label[index].prize,dyprize:tmpopts.label[index].dyprize,modes:$.lt_method_data.modes?$.lt_method_data.modes:{},sp:tmpopts.label[index].code_sp,methoddesc:tmpopts.label[index].methoddesc,methodhelp:tmpopts.label[index].methodhelp,methodexample:tmpopts.label[index].methodexample,maxcodecount:tmpopts.label[index].maxcodecount,isrx:tmpopts.label[index].isrx,numcount:tmpopts.label[index].numcount,defaultposition:tmpopts.label[index].defaultposition};$("span[id^='smalllabel_']",$($.lt_id_data.id_smalllabel)).removeData("ischecked").attr("class","method-tab-back").parent().attr("class","back");$(this).data("ischecked","yes").attr("class","method-tab-front").parent().attr("class","act");$($.lt_id_data.id_selector).lt_selectarea(tmpopts.label[index].selectarea);$($.lt_id_data.id_sel_modes).empty();selmodes=getCookie("modes");$.each(tmpopts.label[index].modes,function(j,m){$.lt_method_data.modes[m.modeid]={name:m.name,rate:Number(m.rate)};addItem($($.lt_id_data.id_sel_modes)[0],""+m.name+"",m.modeid)});SelectItem($($.lt_id_data.id_sel_modes)[0],selmodes);dypoint=getCookie("dypoint");$($.lt_id_data.id_sel_prize).empty();if(tmpopts.label[index].dyprize.length==1&&$.lt_isdyna==1){dyhtml='<SELECT name="lt_sel_dyprize" id="lt_sel_dyprize">';$.each(tmpopts.label[index].dyprize[0].prize,function(j,m){dyhtml+='<OPTION value="'+m.prize+"|"+m.point+'"'+(dypoint==m.point?" selected":"")+">"+m.prize+"-"+(Math.ceil(m.point*1000)/10)+"%</OPTION>"});dyhtml+="</SELECT>";$($.lt_id_data.id_sel_prize).html(lot_lang.dec_s37);$(dyhtml).appendTo($.lt_id_data.id_sel_prize)}})};var lt_selcountback=function(){$($.lt_id_data.id_sel_times).val(1);$($.lt_id_data.id_sel_money).html(0);$($.lt_id_data.id_sel_num).html(0)};$.fn.lt_selectarea=function(opts){var ps={type:"digital",layout:[{title:"\u767e\u4f4d",no:"0|1|2|3|4|5|6|7|8|9",place:0,cols:1},{title:"\u5341\u4f4d",no:"0|1|2|3|4|5|6|7|8|9",place:1,cols:1},{title:"\u4e2a\u4f4d",no:"0|1|2|3|4|5|6|7|8|9",place:2,cols:1}],noBigIndex:5,isButton:true};opts=$.extend({},ps,opts||{});
	var data_sel=[];
	var minchosen=[];
	var max_place=0;
	var otype=opts.type.toLowerCase();
	var methodname=$.lt_method[$.lt_method_data.methodid];
	var defaultposition=$.lt_method_data.defaultposition;
	var html="";
	var positionvalue=0;
	$.lt_position_sel=[];
	if(opts.selPosition==true){
		defaultposition=defaultposition.split("");
		html+='<div class="selposition">';
		var positionlen=defaultposition.length;
		for(var i=0;i<positionlen;i++){
			if(defaultposition[i]==1){
				$.lt_position_sel.push(i);
				html+='<label for="position_'+i+'"><input type="checkbox" name="position_'+i+'" id="position_'+i+'" value="1" class="selpositioninput" checked>'+$.lt_position_title[i]+"</label>"
			}else{
				html+='<label for="position_'+i+'"><input type="checkbox" name="position_'+i+'" id="position_'+i+'" value="1" class="selpositioninput">'+$.lt_position_title[i]+"</label>"
			}
		}
		html+=lot_lang.dec_s45.replace("%n",$.lt_method_data.numcount)+"</div>"
	}
	if(otype=="input"){
		var tempdes=lot_lang.dec_s4;
		html+='<div class="nbs single"><table class=ha><tr><td valign=top><textarea id="lt_write_box" style="width:600px;height:80px;"></textarea><br />'+tempdes+'</td><td valign=top><span class=ds><span class=lsbb><input name="lt_write_del" type="button" value="\u5220\u9664\u91cd\u590d\u53f7" class="lsb" id="lt_write_del"></span></span><span class=ds><span class=lsbb><input name="lt_write_import" type="button" value="&nbsp;\u5bfc\u5165\u6587\u4ef6&nbsp;" class="lsb" id="lt_write_import"></span></span><span class=ds><span class=lsbb><input name="lt_write_empty" type="button" value="&nbsp;\u6e05&nbsp;&nbsp;\u7a7a&nbsp;" class="lsb" id="lt_write_empty"></span></span></td></tr></table></div>';
		data_sel[0]=[];tempdes=null
		}else{
			if(otype=="digital"||otype=="digitalts"){
				$.each(opts.layout,function(i,n){
					if(typeof(n)=="object"){
						n.place=parseInt(n.place,10);
						max_place=n.place>max_place?n.place:max_place;
						data_sel[n.place]=[];
						minchosen[n.place]=(typeof(n.minchosen)=="undefined")?0:n.minchosen;html+='<div class="nbs">';						
						
						if(n.cols>0){
							html+="<div class=ti>";
							if(n.title.length>0){
								html+=n.title
							}
							html+="</div>"
						}else{
							html+="<div class=tiempty></div>"
						}
						if(otype=="digital"){
							if(n.isRange==true){
								html+='<div class="nb range">'
							}else if(n.isBigsmall==true){
								html+='<div class="nb bigsmall">'
							}else if(n.isSmall==true){
								html+='<div class="nb small">'
							}else{
								html+='<div class="nb">'
							}
						}else{
							html+='<div class="nbts">'
						}
						numbers=n.no.split("|");
						j=numbers.length;
						if(j>12){html+="<span>"}
						for(i=0;i<j;i++){
							if((methodname=="ZXHZ"&&i==14)||(methodname=="ZUHZ"&&i==13)||(methodname=="ZXHZ2"&&i==10)){
								html+="</span><span>"
							}
							html+='<div name="lt_place_'+n.place+'">'+numbers[i]+"</div>"
						}
						if(j>12){html+="</span>"}
						html+="</div>";
						if(opts.isButton==true&&isNaN(n.isBigsmall)){
							html+='<div class=to><ul><li class="l"></li><li class="dxjoq" name="all">'+lot_lang.bt_sel_all+'</li><li class="dxjoq" name="big">'+lot_lang.bt_sel_big+'</li><li class="dxjoq" name="small">'+lot_lang.bt_sel_small+'</li><li class="dxjoq" name="odd">'+lot_lang.bt_sel_odd+'</li><li class="dxjoq" name="even">'+lot_lang.bt_sel_even+'</li><li class="dxjoq" name="clean">'+lot_lang.bt_sel_clean+'</li><li class="r"></li></ul></div>'
						}
						html+="</div>"
					}
				})
			}else{
				if(otype=="dxds"){
					$.each(opts.layout,function(i,n){
						n.place=parseInt(n.place,10);
						max_place=n.place>max_place?n.place:max_place;
						data_sel[n.place]=[];
						html+='<div class="nbs">';
						if(n.cols>0){
							html+="<div class=ti><div class=l></div>";
							if(n.title.length>0){
								html+=n.title
							}
							html+="<div class=r></div></div>"
						}
						html+='<div class="nb">';
						numbers=n.no.split("|");
						j=numbers.length;
						for(i=0;i<j;i++){
							html+='<div name="lt_place_'+n.place+'">'+numbers[i]+"</div>"
						}
						html+='</div><div class=to><ul><li class="l"></li><li class="dxjoq" name="clean">'+lot_lang.bt_sel_clean+'</li><li class="r"></li></ul></div></div>'
					})
				}
			}
		}
		html+='<div class="c"></div>';
		if(opts.isDm){
			$.lt_dm=true;
		}else{
			$.lt_dm=false
		}
		$html=$(html);$(this).empty();$html.appendTo(this);$($.lt_id_data.id_desc).html($.lt_method_data.methoddesc);
				$(".selpositioninput").click(function(){
					$.lt_position_sel=[];
					$.each($(".selpositioninput"),function(){
						positionvalue=$(this).attr("name");
						positionvalue=positionvalue.split("_");
						if($(this).attr("checked")==true){
							$.lt_position_sel.push(positionvalue[1])
						}
					});
					$("#positioncount").html($.lt_position_sel.length);
					var projectCount=$.lt_position_sel.length==0?0:Combination($.lt_position_sel.length,$.lt_method_data.numcount);
					$("#positioninfo").html(projectCount);
					checkNum()
				});
				var me=this;
				var _SortNum=function(a,b){
					if(otype!="input"){
						a=a.replace(/\u8c79\u5b50/g,0).replace(/\u987a\u5b50/g,1).replace(/\u5bf9\u5b50/g,2);
						a=a.replace(/\u5927/g,0).replace(/\u5c0f/g,1).replace(/\u5355/g,2).replace(/\u53cc/g,3).replace(/\s/g,"");
						b=b.replace(/\u8c79\u5b50/g,0).replace(/\u987a\u5b50/g,1).replace(/\u5bf9\u5b50/g,2);
						b=b.replace(/\u5927/g,0).replace(/\u5c0f/g,1).replace(/\u5355/g,2).replace(/\u53cc/g,3).replace(/\s/g,"")
					}
					a=parseInt(a,10);
					b=parseInt(b,10);
					if(isNaN(a)||isNaN(b)){return true}
					return(a-b)
				};
				var _HHZXcheck=function(n,len){
					if(len==2){
						var a=["00","11","22","33","44","55","66","77","88","99"]
					}else{
						var a=["000","111","222","333","444","555","666","777","888","999"]
					}
					n=n.toString();
					if($.inArray(n,a)==-1){return true}
					return false
				};
				var _ZUSDScheck=function(n,len){
					if(len!=3){return false}
					var first="";
					var second="";
					var third="";
					var i=0;
					for(i=0;i<len;i++){
						if(i==0){first=n.substr(i,1)}
						if(i==1){second=n.substr(i,1)}
						if(i==2){third=n.substr(i,1)}
					}
					if(first==second&&second==third){return false}
					if(first==second||second==third||third==first){return true}
					return false
				};
				var _ZULDScheck=function(n,len){
					if(len!=3){return false}
					var first="";
					var second="";
					var third="";
					var i=0;
					for(i=0;i<len;i++){
						if(i==0){first=n.substr(i,1)}
						if(i==1){second=n.substr(i,1)}
						if(i==2){third=n.substr(i,1)}
					}
					if(first==second||second==third||third==first){return false}else{return true}
					return false
				};
				var _inputCheck_Num=function(l,e,fun,sort){
					var nums=data_sel[0].length;
					var error=[];
					var newsel=[];
					var partn="";
					l=parseInt(l,10);
					switch(l){
						case 2:partn=/^[0-9]{2}$/;break;
						case 4:partn=/^[0-9]{4}$/;break;
						case 5:partn=/^[0-9]{5}$/;break;
						default:partn=/^[0-9]{3}$/;break
					}
					fun=$.isFunction(fun)?fun:function(s){return true};
					$.each(data_sel[0],function(i,n){
						n=$.trim(n);
						if(partn.test(n)&&fun(n,l)){
							if(sort){
								if(n.indexOf(" ")==-1){
									n=n.split("");
									n.sort(_SortNum);
									n=n.join("")
								}else{
									n=n.split(" ");
									n.sort(_SortNum);
									n=n.join(" ")
								}
							}
							data_sel[0][i]=n;
							newsel.push(n)
						}else{
							if(n.length>0){error.push(n)}
							nums=nums-1
						}
					});
					if(e==true){
						data_sel[0]=newsel;
						return error
					}
					return nums
				};
		function checkNum(){
			var nums=0,mname=$.lt_method[$.lt_method_data.methodid];
			var modes=parseInt($($.lt_id_data.id_sel_modes).val(),10);
			var isrx=$.lt_method_data.isrx;
			if(otype=="input"){
				if(data_sel[0].length>0){
					switch(mname){
						case"ZX5":nums=_inputCheck_Num(5,false);break;
						case"ZX4":nums=_inputCheck_Num(4,false);break;
						case"ZX3":nums=_inputCheck_Num(3,false);break;
						case"ZUS":nums=_inputCheck_Num(3,false,_ZUSDScheck,true);if(isrx==1){nums*=$.lt_position_sel.length==0?0:Combination($.lt_position_sel.length,3)}break;
						case"ZUL":nums=_inputCheck_Num(3,false,_ZULDScheck,true);if(isrx==1){nums*=$.lt_position_sel.length==0?0:Combination($.lt_position_sel.length,3)}break;
						case"HHZX":nums=_inputCheck_Num(3,false,_HHZXcheck,true);if(isrx==1){nums*=$.lt_position_sel.length==0?0:Combination($.lt_position_sel.length,3)}break;
						case"ZX2":nums=_inputCheck_Num(2,false);break;
						case"ZU2":nums=_inputCheck_Num(2,false,_HHZXcheck,true);if(isrx==1){nums*=$.lt_position_sel.length==0?0:Combination($.lt_position_sel.length,2)}break;
						case"RZX2":case"RZX3":case"RZX4":var sellen=mname.substring(mname.length-1);nums=_inputCheck_Num(sellen,false);nums*=$.lt_position_sel.length==0?0:Combination($.lt_position_sel.length,sellen);break;
						default:break
					}
				}
			}else{
				var tmp_nums=1;
				switch(mname){
					case"ZH5":
					case"ZH4":
					case"ZH3":
						for(i=0;i<=max_place;i++){
							if(data_sel[i].length==0){tmp_nums=0;break}
							tmp_nums*=data_sel[i].length
						}
						nums=tmp_nums*parseInt(mname.charAt(mname.length-1));
						break;
					case"WXZU120":
						var s=data_sel[0].length;
						if(s>4){nums+=Combination(s,5)}
						break;
					case"WXZU60":
					case"WXZU30":
					case"WXZU20":
					case"WXZU10":
					case"WXZU5":
						if(data_sel[0].length>=minchosen[0]&&data_sel[1].length>=minchosen[1]){
							var h=Array.intersect(data_sel[0],data_sel[1]).length;
							tmp_nums=Combination(data_sel[0].length,minchosen[0])*Combination(data_sel[1].length,minchosen[1]);
							if(h>0){
								if(mname=="WXZU60"){
									tmp_nums-=Combination(h,1)*Combination(data_sel[1].length-1,2)
								}else{
									if(mname=="WXZU30"){
										tmp_nums-=Combination(h,2)*Combination(2,1);
										if(data_sel[0].length-h>0){
											tmp_nums-=Combination(h,1)*Combination(data_sel[0].length-h,1)
										}
									}else{
										if(mname=="WXZU20"){
											tmp_nums-=Combination(h,1)*Combination(data_sel[1].length-1,1)
										}else{
											if(mname=="WXZU10"||mname=="WXZU5"){
												tmp_nums-=Combination(h,1)
											}
										}
									}
								}
							}
							nums+=tmp_nums
						}
						break;
					case"SXZU24":
						var s=data_sel[0].length;
						if(s>3){nums+=Combination(s,4)}
						if(isrx==1){
							nums*=$.lt_position_sel.length==0?0:Combination($.lt_position_sel.length,4)
						}
						break;
					case"SXZU6":
						if(data_sel[0].length>=minchosen[0]){
							nums+=Combination(data_sel[0].length,minchosen[0])
						}
						if(isrx==1){
							nums*=$.lt_position_sel.length==0?0:Combination($.lt_position_sel.length,4)
						}
						break;
					case"SXZU12":
					case"SXZU4":
						if(data_sel[0].length>=minchosen[0]&&data_sel[1].length>=minchosen[1]){
							var h=Array.intersect(data_sel[0],data_sel[1]).length;
							tmp_nums=Combination(data_sel[0].length,minchosen[0])*Combination(data_sel[1].length,minchosen[1]);
							if(h>0){
								if(mname=="SXZU12"){
									tmp_nums-=Combination(h,1)*Combination(data_sel[1].length-1,1)
								}else{
									if(mname=="SXZU4"){
										tmp_nums-=Combination(h,1)
									}
								}
							}
							nums+=tmp_nums
						}
						if(isrx==1){
							nums*=$.lt_position_sel.length==0?0:Combination($.lt_position_sel.length,4)
						}
						break;
					case"ZXKD":
						var cc={0:10,1:54,2:96,3:126,4:144,5:150,6:144,7:126,8:96,9:54};
						for(i=0;i<=max_place;i++){
							var s=data_sel[i].length;
							for(j=0;j<s;j++){
								nums+=cc[parseInt(data_sel[i][j],10)]
							}
						}
						if(isrx==1){
							nums*=$.lt_position_sel.length==0?0:Combination($.lt_position_sel.length,3)
						}
						break;
					case"ZXKD2":
						var cc={0:10,1:18,2:16,3:14,4:12,5:10,6:8,7:6,8:4,9:2};
						for(i=0;i<=max_place;i++){
							var s=data_sel[i].length;
							for(j=0;j<s;j++){
								nums+=cc[parseInt(data_sel[i][j],10)]
							}
						}
						if(isrx==1){
							nums*=$.lt_position_sel.length==0?0:Combination($.lt_position_sel.length,2)
						}
						break;
					case"ZXHZ":
						var cc={0:1,1:3,2:6,3:10,4:15,5:21,6:28,7:36,8:45,9:55,10:63,11:69,12:73,13:75,14:75,15:73,16:69,17:63,18:55,19:45,20:36,21:28,22:21,23:15,24:10,25:6,26:3,27:1};
					case"ZUHZ":
						if(mname=="ZUHZ"){
							cc={1:1,2:2,3:2,4:4,5:5,6:6,7:8,8:10,9:11,10:13,11:14,12:14,13:15,14:15,15:14,16:14,17:13,18:11,19:10,20:8,21:6,22:5,23:4,24:2,25:2,26:1}
						}
						for(i=0;i<=max_place;i++){
							var s=data_sel[i].length;
							for(j=0;j<s;j++){
								nums+=cc[parseInt(data_sel[i][j],10)]
							}
						}
						if(isrx==1){
							nums*=$.lt_position_sel.length==0?0:Combination($.lt_position_sel.length,3)
						}
						break;
					case"ZUS":
						for(i=0;i<=max_place;i++){
							var s=data_sel[i].length;if(s>1){
								nums+=s*(s-1)
							}
						}
						if(isrx==1){
							nums*=$.lt_position_sel.length==0?0:Combination($.lt_position_sel.length,3)
						}
						break;
					case"ZUL":
						for(i=0;i<=max_place;i++){
							var s=data_sel[i].length;
							if(s>2){
								nums+=s*(s-1)*(s-2)/6
							}
						}
						if(isrx==1){
							nums*=$.lt_position_sel.length==0?0:Combination($.lt_position_sel.length,3)
						}
						break;
					case"ZXHZ2":
						cc={0:1,1:2,2:3,3:4,4:5,5:6,6:7,7:8,8:9,9:10,10:9,11:8,12:7,13:6,14:5,15:4,16:3,17:2,18:1};
						for(i=0;i<=max_place;i++){
							var s=data_sel[i].length;
							for(j=0;j<s;j++){
								nums+=cc[parseInt(data_sel[i][j],10)]
							}
						}
						if(isrx==1){
							nums*=$.lt_position_sel.length==0?0:Combination($.lt_position_sel.length,2)
						}
						break;
					case"ZUHZ2":
						cc={0:0,1:1,2:1,3:2,4:2,5:3,6:3,7:4,8:4,9:5,10:4,11:4,12:3,13:3,14:2,15:2,16:1,17:1,18:0};
						for(i=0;i<=max_place;i++){
							var s=data_sel[i].length;
							for(j=0;j<s;j++){
								nums+=cc[parseInt(data_sel[i][j],10)]
							}
						}
						if(isrx==1){
							nums*=$.lt_position_sel.length==0?0:Combination($.lt_position_sel.length,2)
						}
						break;
					case"ZU3BD":
						nums=data_sel[0].length*54;
						if(isrx==1){
							nums*=$.lt_position_sel.length==0?0:Combination($.lt_position_sel.length,3)
						}
						break;
					case"ZU2BD":
						nums=data_sel[0].length*9;
						if(isrx==1){
							nums*=$.lt_position_sel.length==0?0:Combination($.lt_position_sel.length,2)
						}
						break;
					case"BDW3":
						for(i=0;i<=max_place;i++){
							var s=data_sel[i].length;if(s>2){
								nums+=Combination(data_sel[i].length,3)
							}
						}
						break;
					case"BDW2":
					case"ZU2":
						for(i=0;i<=max_place;i++){
							var s=data_sel[i].length;
							if(s>1){
								nums+=s*(s-1)/2
							}
						}
						if(isrx==1){
							nums*=$.lt_position_sel.length==0?0:Combination($.lt_position_sel.length,2)
						}
						break;
					case"R3BDW2":
					case"R4BDW2":
						for(i=0;i<=max_place;i++){
							var s=data_sel[i].length;
							if(s>1){
								nums+=s*(s-1)/2
							}
						}
						if(isrx==1){
							if(mname=="R3BDW2"){
								nums*=$.lt_position_sel.length==0?0:Combination($.lt_position_sel.length,3)
							}else{
								nums*=$.lt_position_sel.length==0?0:Combination($.lt_position_sel.length,4)
							}
						}
						break;
					case"R3BDW1":
					case"R4BDW1":
						for(i=0;i<=max_place;i++){
							if(data_sel[i].length==0){
								tmp_nums=0;
								break;
								break
							}
							tmp_nums*=data_sel[i].length
						}
						nums=tmp_nums;
						if(isrx==1){
							if(mname=="R3BDW1"){
								nums*=$.lt_position_sel.length==0?0:Combination($.lt_position_sel.length,3)
							}else{
								nums*=$.lt_position_sel.length==0?0:Combination($.lt_position_sel.length,4)
							}
						}
						break;
					case"DWD":
						for(i=0;i<=max_place;i++){
							nums+=data_sel[i].length
						}
						break;
					case"R3DXDS":
					case"HZWS":
					case"TSH3":
						for(i=0;i<=max_place;i++){
							if(data_sel[i].length==0){
								tmp_nums=0;
								break;
								break
							}
							tmp_nums*=data_sel[i].length
						}
						nums=tmp_nums;
						if(isrx==1){
							nums*=$.lt_position_sel.length==0?0:Combination($.lt_position_sel.length,3)
						}
						break;
					case"R2DXDS":
						for(i=0;i<=max_place;i++){
							if(data_sel[i].length==0){
								tmp_nums=0;
								break;
								break
							}
							tmp_nums*=data_sel[i].length
						}
						nums=tmp_nums;
						if(isrx==1){
							nums*=$.lt_position_sel.length==0?0:Combination($.lt_position_sel.length,2)
						}
						break;
					case"RZX2":
					case"RZX3":
					case"RZX4":
						var aCodePosition=[];
						for(i=0;i<=max_place;i++){
							var codelen=data_sel[i].length;
							if(codelen>0){
								aCodePosition.push(i)
							}
						}
						var sellen=mname.substring(mname.length-1);
						var aPositionCombo=getCombination(aCodePosition,sellen);
						var iComboLen=aPositionCombo.length;
						var aCombo=[];
						var iLen=0;
						var tmpNums=1;
						for(j=0;j<iComboLen;j++){
							aCombo=aPositionCombo[j].split(",");
							iLen=aCombo.length;
							tmpNums=1;
							for(h=0;h<iLen;h++){
								tmpNums*=data_sel[aCombo[h]].length
							}
							nums+=tmpNums
						}
						break;
					case"RZH3":
					case"RZH4":
						var aCodePosition=[];
						for(i=0;i<=max_place;i++){
							var codelen=data_sel[i].length;
							if(codelen>0){
								aCodePosition.push(i)
							}
						}
						var sellen=mname.substring(mname.length-1);
						var aPositionCombo=getCombination(aCodePosition,sellen);
						var iComboLen=aPositionCombo.length;
						var aCombo=[];
						var iLen=0;
						var tmpNums=1;
						for(j=0;j<iComboLen;j++){
							aCombo=aPositionCombo[j].split(",");
							iLen=aCombo.length;
							tmpNums=1;
							for(h=0;h<iLen;h++){
								tmpNums*=data_sel[aCombo[h]].length
							}
							nums+=tmpNums
						}
						if(mname=="RZH3"){
							nums=nums*3;
						}else{
							nums=nums*4;
						}
						break;
					case"DM5":
						nums=0;
						if(data_sel[0].length>0){
							for(ia=0;ia<10;ia++){
								for(ib=0;ib<10;ib++){
									for(ic=0;ic<10;ic++){
										for(id=0;id<10;id++){
											for(ie=0;ie<10;ie++){
												numa=0;
												numb=0;
												for(i=0;i<data_sel[0].length;i++){
													if(ia==data_sel[0][i] || ib==data_sel[0][i] || ic==data_sel[0][i] || id==data_sel[0][i] || ie==data_sel[0][i]){
														numb++;
													}
												}
												if(numb>0){
													if(data_sel[1].length>0){
														strta=data_sel[1][0].split("-");
														if(numb>=strta[0] && numb<=strta[1]){
															numa++;
														}
													}else{
														numa++;
													}
													if(data_sel[2].length>0 && numa==1){
														if(ia>=ib){
															imax=ia;
															imin=ib;
														}else{
															imax=ib;
															imin=ia;
														}
														if(ic>imax){imax=ic}
														if(ic<imin){imin=ic}
														if(id>imax){imax=id}
														if(id<imin){imin=id}
														if(ie>imax){imax=ie}
														if(ie<imin){imin=ie}
														
														for(i=0;i<data_sel[2].length;i++){
															if(data_sel[2][i]==imax-imin){
																numa++;
																break;
															}
														}
													}else{
														numa++;
													}
													imax=ia+ib+ic+id+ie;													
													if(data_sel[3].length>0 && numa==2){
														imin=imax % 10;
														for(i=0;i<data_sel[3].length;i++){
															if(data_sel[3][i]==imin){
																numa++;
																break;
															}
														}
													}else{
														numa++;
													}
													if(data_sel[4].length>0 && numa==3){
														for(i=0;i<data_sel[4].length;i++){
															strta=data_sel[4][i].split("-");
															if(imax>=strta[0] && imax<=strta[1]){
																numa++;
																break;
															}
														}
													}else{
														numa++;
													}
													if(data_sel[5].length>0 && numa==4){//奇
														imax=0;
														if(ia%2==1){imax++}
														if(ib%2==1){imax++}
														if(ic%2==1){imax++}
														if(id%2==1){imax++}
														if(ie%2==1){imax++}
														imin=5-imax;
														for(i=0;i<data_sel[5].length;i++){
															if(data_sel[5][i]==imax + ":" + imin){
																numa++;
																break;
															}
														}
													}else{
														numa++;
													}
													if(data_sel[6].length>0 && numa==5){//大
														imax=0;
														if(ia>=5){imax++}
														if(ib>=5){imax++}
														if(ic>=5){imax++}
														if(id>=5){imax++}
														if(ie>=5){imax++}
														imin=5-imax;
														for(i=0;i<data_sel[6].length;i++){
															if(data_sel[6][i]==imax + ":" + imin){
																numa++;
																break;
															}
														}
													}else{
														numa++;
													}
													if(data_sel[7].length>0 && numa==6){//组
														na = [ia, ib, ic, id, ie];
														na.sort();
														if(na[0]==na[3] || na[1]==na[4]){
															strtb="\u7ec4\u90095";
														}else{
															if((na[0]==na[2] && na[3]==na[4]) || (na[0]==na[1] && na[2]==na[4])){
																strtb="\u7ec4\u900910";
															}else{
																if((na[0]==na[2] && na[3]!=na[4]) || (na[0]!=na[1] && na[2]==na[4]) || na[1]==na[3]){
																	strtb="\u7ec4\u900920";
																}else{
																	if((na[0]==na[1] && na[2]==na[3]) || (na[0]==na[1] && na[2]==na[4]) || (na[0]==na[1] && na[3]==na[4]) || (na[0]==na[2] && na[3]==na[4]) || (na[1]==na[2] && na[3]==na[4])){
																		strtb="\u7ec4\u900930";
																	}else{
																		if(na[0]==na[1] || na[1]==na[2] || na[2]==na[3] || na[3]==na[4]){
																			strtb="\u7ec4\u900960";
																		}else{
																			strtb="\u7ec4\u9009120";
																		}
																	}
																}
															}
														}
														for(i=0;i<data_sel[7].length;i++){
															if(data_sel[7][i]==strtb){
																numa++;
																break;
															}
														}
													}else{
														numa++;
													}
												}

												if(numa>=7){
													nums++;
												}
											}
										}
									}
								}
							}
						}
						break;
					case"DM4":
						nums=0;
						if(data_sel[0].length>0){
							for(ia=0;ia<10;ia++){
								for(ib=0;ib<10;ib++){
									for(ic=0;ic<10;ic++){
										for(id=0;id<10;id++){
											numa=0;
											numb=0;
											for(i=0;i<data_sel[0].length;i++){
												if(ia==data_sel[0][i] || ib==data_sel[0][i] || ic==data_sel[0][i] || id==data_sel[0][i]){
													numb++;
												}
											}
											if(numb>0){
												if(data_sel[1].length>0){
													strta=data_sel[1][0].split("-");
													if(numb>=strta[0] && numb<=strta[1]){
														numa++;
													}
												}else{
													numa++;
												}
												if(data_sel[2].length>0 && numa==1){
													if(ia>=ib){
														imax=ia;
														imin=ib;
													}else{
														imax=ib;
														imin=ia;
													}
													if(ic>imax){imax=ic}
													if(ic<imin){imin=ic}
													if(id>imax){imax=id}
													if(id<imin){imin=id}
													
													for(i=0;i<data_sel[2].length;i++){
														if(data_sel[2][i]==imax-imin){
															numa++;
															break;
														}
													}
												}else{
													numa++;
												}
												imax=ia+ib+ic+id;
												if(data_sel[3].length>0 && numa==2){
													imin=imax % 10;
													for(i=0;i<data_sel[3].length;i++){
														if(data_sel[3][i]==imin){
															numa++;
															break;
														}
													}
												}else{
													numa++;
												}
												if(data_sel[4].length>0 && numa==3){
													for(i=0;i<data_sel[4].length;i++){
														strta=data_sel[4][i].split("-");
														if(imax>=strta[0] && imax<=strta[1]){
															numa++;
															break;
														}
													}
												}else{
													numa++;
												}
												if(data_sel[5].length>0 && numa==4){//奇
													imax=0;
													if(ia%2==1){imax++}
													if(ib%2==1){imax++}
													if(ic%2==1){imax++}
													if(id%2==1){imax++}
													imin=4-imax;
													for(i=0;i<data_sel[5].length;i++){
														if(data_sel[5][i]==imax + ":" + imin){
															numa++;
															break;
														}
													}
												}else{
													numa++;
												}
												if(data_sel[6].length>0 && numa==5){//大
													imax=0;
													if(ia>=5){imax++}
													if(ib>=5){imax++}
													if(ic>=5){imax++}
													if(id>=5){imax++}
													imin=4-imax;
													for(i=0;i<data_sel[6].length;i++){
														if(data_sel[6][i]==imax + ":" + imin){
															numa++;
															break;
														}
													}
												}else{
													numa++;
												}
												if(data_sel[7].length>0 && numa==6){//组
													na = [ia, ib, ic, id];
													na.sort();
													if(na[0]==na[2] || na[1]==na[3]){
														strtb="\u7ec4\u90094";
													}else{
														if(na[0]==na[1] && na[2]==na[3]){
															strtb="\u7ec4\u90096";
														}else{
															if(na[0]==na[1] || na[1]==na[2] || na[2]==na[3]){
																strtb="\u7ec4\u900912";
															}else{
																strtb="\u7ec4\u900924";
															}
														}
													}
													for(i=0;i<data_sel[7].length;i++){
														if(data_sel[7][i]==strtb){
															numa++;
															break;
														}
													}
												}else{
													numa++;
												}
											}

											if(numa>=7){
												nums++;
											}
										}
									}
								}
							}
						}
						if(isrx==1){
							nums*=$.lt_position_sel.length==0?0:Combination($.lt_position_sel.length,4)
						}
						break;
					case"DM3":
						nums=0;
						if(data_sel[0].length>0){
							for(ia=0;ia<10;ia++){
								for(ib=0;ib<10;ib++){
									for(ic=0;ic<10;ic++){
										numa=0;
										numb=0;
										for(i=0;i<data_sel[0].length;i++){
											if(ia==data_sel[0][i] || ib==data_sel[0][i] || ic==data_sel[0][i]){
												numb++;
											}
										}
										if(numb>0){
											if(data_sel[1].length>0){
												strta=data_sel[1][0].split("-");
												if(numb>=strta[0] && numb<=strta[1]){
													numa++;
												}
											}else{
												numa++;
											}
											if(data_sel[2].length>0 && numa==1){
												if(ia>=ib){
													imax=ia;
													imin=ib;
												}else{
													imax=ib;
													imin=ia;
												}
												if(ic>imax){imax=ic}
												if(ic<imin){imin=ic}
												
												for(i=0;i<data_sel[2].length;i++){
													if(data_sel[2][i]==imax-imin){
														numa++;
														break;
													}
												}
											}else{
												numa++;
											}
											imax=ia+ib+ic;
											if(data_sel[3].length>0 && numa==2){
												imin=imax % 10;
												for(i=0;i<data_sel[3].length;i++){
													if(data_sel[3][i]==imin){
														numa++;
														break;
													}
												}
											}else{
												numa++;
											}
											if(data_sel[4].length>0 && numa==3){
												for(i=0;i<data_sel[4].length;i++){
													strta=data_sel[4][i].split("-");
													if(imax>=strta[0] && imax<=strta[1]){
														numa++;
														break;
													}
												}
											}else{
												numa++;
											}
											if(data_sel[5].length>0 && numa==4){//奇
												imax=0;
												if(ia%2==1){imax++}
												if(ib%2==1){imax++}
												if(ic%2==1){imax++}
												imin=3-imax;
												for(i=0;i<data_sel[5].length;i++){
													if(data_sel[5][i]==imax + ":" + imin){
														numa++;
														break;
													}
												}
											}else{
												numa++;
											}
											if(data_sel[6].length>0 && numa==5){//大
												imax=0;
												if(ia>=5){imax++}
												if(ib>=5){imax++}
												if(ic>=5){imax++}
												imin=3-imax;
												for(i=0;i<data_sel[6].length;i++){
													if(data_sel[6][i]==imax + ":" + imin){
														numa++;
														break;
													}
												}
											}else{
												numa++;
											}
											if(data_sel[7].length>0 && numa==6){//组
												if(ia==ib || ia==ic || ib==ic){
													strtb="\u7ec4\u9009\u4e09";
												}else{
													strtb="\u7ec4\u9009\u516d";
												}
												for(i=0;i<data_sel[7].length;i++){
													if(data_sel[7][i]==strtb){
														numa++;
														break;
													}
												}
											}else{
												numa++;
											}
										}

										if(numa>=7){
											nums++;
										}
									}
								}
							}
						}
						if(isrx==1){
							nums*=$.lt_position_sel.length==0?0:Combination($.lt_position_sel.length,3)
						}
						break;
					case"DM2":
						nums=0;
						if(data_sel[0].length>0){
							for(ia=0;ia<10;ia++){
								for(ib=0;ib<10;ib++){
									numa=0;
									numb=0;
									for(i=0;i<data_sel[0].length;i++){
										if(ia==data_sel[0][i] || ib==data_sel[0][i]){
											numb++;
										}
									}
									if(numb>0){
										if(data_sel[1].length>0){
											strta=data_sel[1][0].split("-");
											if(numb>=strta[0] && numb<=strta[1]){
												numa++;
											}
										}else{
											numa++;
										}
										if(data_sel[2].length>0 && numa==1){
											if(ia>=ib){
												imax=ia;
												imin=ib;
											}else{
												imax=ib;
												imin=ia;
											}
											
											for(i=0;i<data_sel[2].length;i++){
												if(data_sel[2][i]==imax-imin){
													numa++;
													break;
												}
											}
										}else{
											numa++;
										}
										imax=ia+ib;
										if(data_sel[3].length>0 && numa==2){
											imin=imax % 10;
											for(i=0;i<data_sel[3].length;i++){
												if(data_sel[3][i]==imin){
													numa++;
													break;
												}
											}
										}else{
											numa++;
										}
										if(data_sel[4].length>0 && numa==3){
											for(i=0;i<data_sel[4].length;i++){
												strta=data_sel[4][i].split("-");
												if(imax>=strta[0] && imax<=strta[1]){
													numa++;
													break;
												}
											}
										}else{
											numa++;
										}
										if(data_sel[5].length>0 && numa==4){//奇
											imax=0;
											if(ia%2==1){imax++}
											if(ib%2==1){imax++}
											imin=2-imax;
											for(i=0;i<data_sel[5].length;i++){
												if(data_sel[5][i]==imax + ":" + imin){
													numa++;
													break;
												}
											}
										}else{
											numa++;
										}
										if(data_sel[6].length>0 && numa==5){//大
											imax=0;
											if(ia>=5){imax++}
											if(ib>=5){imax++}
											imin=2-imax;
											for(i=0;i<data_sel[6].length;i++){
												if(data_sel[6][i]==imax + ":" + imin){
													numa++;
													break;
												}
											}
										}else{
											numa++;
										}
									}

									if(numa>=6){
										nums++;
									}
								}
							}
						}
						if(isrx==1){
							nums*=$.lt_position_sel.length==0?0:Combination($.lt_position_sel.length,2)
						}
						break;
					default:
						for(i=0;i<=max_place;i++){
							if(data_sel[i].length==0){
								tmp_nums=0;
								break;
								break
							}
							tmp_nums*=data_sel[i].length
						}
						nums=tmp_nums;
						
						break
					}
				}
				var times=parseInt($($.lt_id_data.id_sel_times).val(),10);
				if(isNaN(times)){
					times=1;
					$($.lt_id_data.id_sel_times).val(1)
				}
				var money=Math.round(times*nums*2*($.lt_method_data.modes[modes].rate*1000))/1000;
				money=isNaN(money)?0:money;$($.lt_id_data.id_sel_num).html(nums);
				$($.lt_id_data.id_sel_money).html(money)
			}
			
		var dumpNum=function(isdeal){
			var l=data_sel[0].length;
			var err=[];
			var news=[];
			if(l==0){return err}
			for(i=0;i<l;i++){
				if($.inArray(data_sel[0][i],err)!=-1){continue}
				for(j=i+1;j<l;j++){
					if(data_sel[0][i]==data_sel[0][j]){
						err.push(data_sel[0][i]);
						break
					}
				}
				news.push(data_sel[0][i])
			}
			if(isdeal){
				data_sel[0]=news
			}
			return err
		};
		function _inptu_deal(){
			var s=$.trim($("#lt_write_box",$(me)).val());
			s=$.trim(s.replace(/[^\s\r,;\uff0c\uff1b\u3000\uff10\uff11\uff12\uff13\uff14\uff15\uff16\uff17\uff18\uff190-9]/g,""));
			var m=s;
			switch(methodname){
				default:s=s.replace(/[\s\r,;\uff0c\uff1b\u3000]/g,"|").replace(/(\|)+/g,"|");
				break
			}
			s=s.replace(/\uff10/g,"0").replace(/\uff11/g,"1").replace(/\uff12/g,"2").replace(/\uff13/g,"3").replace(/\uff14/g,"4").replace(/\uff15/g,"5").replace(/\uff16/g,"6").replace(/\uff17/g,"7").replace(/\uff18/g,"8").replace(/\uff19/g,"9");
			if(s==""){
				data_sel[0]=[]
			}else{
				data_sel[0]=s.split("|")
			}
			return m
		}
		if(otype=="input"){
			$("#lt_write_del",$(me)).click(function(){
				var err=dumpNum(true);
				if(err.length>0){
					checkNum();
					switch(methodname){
						default:
							$("#lt_write_box",$(me)).val(data_sel[0].join(" "));
							$.alert('<div class="datainfo">'+lot_lang.am_s3+"\r"+err.join(" ")+"\r&nbsp;</div>","","",400);
							break
					}
				}else{
					$.alert(lot_lang.am_s4)
				}
			});
			$("#lt_write_import",$(me)).click(function(){$.ajaxUploadUI({title:lot_lang.dec_s27,url:"./js/dialog/fileupload.php",loadok:lot_lang.dec_s28,filetype:["txt","csv"],success:function(data){$("#lt_write_box",$(me)).val(data).change()},onfinish:function(){$("#lt_write_box",$(me)).focus()}})});
			$("#lt_write_box",$(me)).change(function(){var s=_inptu_deal();$(this).val(s);checkNum()}).keyup(function(){_inptu_deal();checkNum()});$("#lt_write_empty",$(me)).click(function(){data_sel[0]=[];$("#lt_write_box",$(me)).val("");checkNum()})
		}
		function selectNum(obj,isButton){
			if($.trim($(obj).attr("class"))=="on"){return}
			$(obj).attr("class","on");
			place=Number($(obj).attr("name").replace("lt_place_",""));
			var number=$.trim($(obj).html());
			number=number.replace(/\<span.*\<\/span>/gi,"").replace(/\r\n/gi,"");
			number=number.replace(/\<div.*>(.*)\<\/div>/gi,"$1").replace(/\r\n/gi,"");
			data_sel[place].push(number);
			if(!isButton){
				var numlimit=parseInt($.lt_method_data.maxcodecount);
				if(numlimit>0){
					if(data_sel[place].length>numlimit){
						$.each($(obj).parent().find("div[name^='lt_place_']"),function(i,n){unSelectNum(n,false)});
						selectNum(obj,false)
					}
				}
				if($.lt_dm){
					if(data_sel[1].length>1&&place==1){
						var lastnumber=data_sel[1][data_sel[1].length-1];
						$.each($('div[name="lt_place_1"][class="on"]'),function(i,n){
							if($(this).html()!=lastnumber){
								$(this).attr("class","");
								data_sel[1]=$.grep(data_sel[1],function(n,i){return n!=lastnumber},true)
							}
						})
					}
				}
				checkNum()
			}
		}
		function unSelectNum(obj,isButton){
			if($.trim($(obj).attr("class"))!="on"){return}
			$(obj).attr("class","");
			place=Number($(obj).attr("name").replace("lt_place_",""));
			var number=$.trim($(obj).html());
			data_sel[place]=$.grep(data_sel[place],function(n,i){return n==number},true);
			if(!isButton){checkNum()}
		}
		function changeNoCss(obj){if($.trim($(obj).attr("class"))=="on"){unSelectNum(obj,false)}else{selectNum(obj,false)}}function selectOdd(obj){if(Number($(obj).html())%2==1){selectNum(obj,true)}else{unSelectNum(obj,true)}}function selectEven(obj){if(Number($(obj).html())%2==0){selectNum(obj,true)}else{unSelectNum(obj,true)}}function selectBig(i,obj){if(i>=opts.noBigIndex){selectNum(obj,true)}else{unSelectNum(obj,true)}}function selectSmall(i,obj){if(i<opts.noBigIndex){selectNum(obj,true)}else{unSelectNum(obj,true)}}$(this).find("div[name^='lt_place_']").click(function(){changeNoCss(this);$("li[class^='dxjoq']",$(this).closest("div[class='nbs']")).attr("class","dxjoq")});if(opts.isButton==true||otype=="dxds"){$("li[class='dxjoq']",$(this)).click(function(){$("li[class^='dxjoq']",$(this).parent()).attr("class","dxjoq");$(this).attr("class","dxjoq on");switch($(this).attr("name")){case"all":$.each($(this).closest("div[class='nbs']").find("div[name^='lt_place_']"),function(i,n){selectNum(n,true)});break;case"big":$.each($(this).closest("div[class='nbs']").find("div[name^='lt_place_']"),function(i,n){selectBig(i,n)});break;case"small":$.each($(this).closest("div[class='nbs']").find("div[name^='lt_place_']"),function(i,n){selectSmall(i,n)});break;case"odd":$.each($(this).closest("div[class='nbs']").find("div[name^='lt_place_']"),function(i,n){selectOdd(n)});break;case"even":$.each($(this).closest("div[class='nbs']").find("div[name^='lt_place_']"),function(i,n){selectEven(n)});break;case"clean":$.each($(this).closest("div[class='nbs']").find("div[name^='lt_place_']"),function(i,n){unSelectNum(n,true)});default:break}checkNum()})}$($.lt_id_data.id_sel_times).unbind("keyup").keyup(function(){var times=$(this).val().replace(/[^0-9]/g,"").substring(0,5);if(times==""){times=0}else{times=parseInt(times,10)}var nums=parseInt($($.lt_id_data.id_sel_num).html(),10);var modes=parseInt($($.lt_id_data.id_sel_modes).val(),10);var money=Math.round(times*nums*2*($.lt_method_data.modes[modes].rate*1000))/1000;money=isNaN(money)?0:money;$($.lt_id_data.id_sel_money).html(money);$(this).val(times)});$($.lt_id_data.id_sel_times).nextAll("a").click(function(){$($.lt_id_data.id_sel_times).val($(this).html()).keyup()});$($.lt_id_data.id_reduce_times).unbind("click").click(function(){var times=Math.round(parseInt($($.lt_id_data.id_sel_times).val(),10)-1);if(times<1){times=1}$($.lt_id_data.id_sel_times).val(times).keyup()});$($.lt_id_data.id_plus_times).unbind("click").click(function(){var times=Math.round(parseInt($($.lt_id_data.id_sel_times).val(),10)+1);if(times>99999){times=99999}$($.lt_id_data.id_sel_times).val(times).keyup()});$($.lt_id_data.id_sel_modes).change(function(){var nums=parseInt($($.lt_id_data.id_sel_num).html(),10);var times=parseInt($($.lt_id_data.id_sel_times).val(),10);var modes=parseInt($($.lt_id_data.id_sel_modes).val(),10);var money=Math.round(times*nums*2*($.lt_method_data.modes[modes].rate*1000))/1000;money=isNaN(money)?0:money;$($.lt_id_data.id_sel_money).html(money)});
		$($.lt_id_data.id_sel_insert).unbind("click").click(function(){
			var nums=parseInt($($.lt_id_data.id_sel_num).html(),10);
			var times=parseInt($($.lt_id_data.id_sel_times).val(),10);
			var modes=parseInt($($.lt_id_data.id_sel_modes).val(),10);
			var money=Math.round(times*nums*2*($.lt_method_data.modes[modes].rate*1000))/1000;
			var mid=$.lt_method_data.methodid;
			var current_positionsel=$.lt_position_sel;
			var current_methodtitle=$.lt_method_data.title;
			var current_methodname=$.lt_method_data.name;
			if(current_positionsel.length>0&&$.lt_rxmode==true){
				if(current_positionsel.length<$.lt_method_data.numcount){
					$.alert(lot_lang.am_s37.replace("%s",$.lt_method_data.numcount).replace("%m",current_methodtitle));return
				}
			}
			var cur_position=0;
			if(current_positionsel.length>0){
				$.each(current_positionsel,function(i,n){
					cur_position+=Math.pow(2,4-parseInt(n,10))
				})
			}
			if(isNaN(nums)||isNaN(times)||isNaN(money)||money<=0){
				$.alert(otype=="input"?lot_lang.am_s29:lot_lang.am_s19);
				return
			}
			if(otype=="input"){
				var mname=$.lt_method[mid];
				var error=[];
				var edump=[];
				var ermsg="";
//				edump=dumpNum(true);//allow repeat nums
//				if(edump.length>0){
//					ermsg+=lot_lang.em_s2+"\n"+edump.join(", ")+"\r&nbsp;";
//					checkNum();
//					nums=parseInt($($.lt_id_data.id_sel_num).html(),10);
//					money=Math.round(times*nums*2*($.lt_method_data.modes[modes].rate*1000))/1000
//				}
				switch(mname){
					case"ZX5":error=_inputCheck_Num(5,true);break;
					case"ZX4":case"RZX4":error=_inputCheck_Num(4,true);break;
					case"ZX3":case"RZX3":error=_inputCheck_Num(3,true);break;
					case"HHZX":error=_inputCheck_Num(3,true,_HHZXcheck,true);break;
					case"ZX2":case"RZX2":error=_inputCheck_Num(2,true);break;
					case"ZU2":error=_inputCheck_Num(2,true,_HHZXcheck,true);break;
					case"ZUS":error=_inputCheck_Num(3,true,_ZUSDScheck,true);break;
					case"ZUL":error=_inputCheck_Num(3,true,_ZULDScheck,true);break;
					default:break
				}
				if(error.length>0){
					ermsg+=lot_lang.em_s1+"\n"+error.join(", ")+"\r&nbsp;"
				}
				if(ermsg.length>1){
					$.alert("<div class='datainfo'>"+ermsg+"</div>","","",400)
				}
			}
			var nos=$.lt_method_data.str;
			var serverdata="{'type':'"+otype+"','methodid':"+mid+",'codes':'";
			var temp=[];
			for(i=0;i<data_sel.length;i++){
				if(otype=="input"){
					nos=nos.replace("X",data_sel[i].sort(_SortNum).join("|"))
				}else{
					nos=nos.replace("X",data_sel[i].sort(_SortNum).join($.lt_method_data.sp))
				}
				temp.push(data_sel[i].sort(_SortNum).join("&"))
			}
			if(nos.length>40){
				var nohtml=nos.substring(0,35)+"..."
			}else{
				var nohtml=nos
			}
			if($.lt_same_code[mid]!=undefined&&$.lt_same_code[mid][modes]!=undefined&&$.lt_same_code[mid][modes][cur_position]!=undefined&&$.lt_same_code[mid][modes][cur_position].length>0){
				if($.inArray(temp.join("|"),$.lt_same_code[mid][modes][cur_position])!=-1){
					$.alert(lot_lang.am_s28);
					return false
				}
			}
			var sel_isdy=false;
			var sel_prize=0;
			var sel_point=1;
			if($.lt_method_data.dyprize.length==1&&$.lt_isdyna==1){
				if($("#lt_sel_dyprize")==undefined){
					$.alert(lot_lang.am_s27);
					return false
				}
				var sel_dy=$("#lt_sel_dyprize").val();
				sel_dy=sel_dy.split("|");
				if(sel_dy[1]==undefined){
					$.alert(lot_lang.am_s27);
					return false
				}
				sel_isdy=true;
				sel_prize=Math.round(Number(sel_dy[0])*($.lt_method_data.modes[modes].rate*1000))/1000;
				sel_point=Number(sel_dy[1])
			}
			noshtml="["+$.lt_method_data.title+"_"+$.lt_method_data.name+"] "+nohtml;
			if($.lt_method[mid]=="DXDS" || $.lt_method[mid]=="R2DXDS" || $.lt_method[mid]=="R3DXDS"){
				noshtml="["+$.lt_method_data.name+"] "+nohtml
			}
			var myDate=new Date();
			var curTimes=myDate.getTime();
			if(current_positionsel.length>0){
				serverdata+=temp.join("|")+"','nums':"+nums+",'times':"+times+",'money':"+money+",'mode':"+modes+",'point':'"+sel_point+"','desc':'"+noshtml+"','position':'"+current_positionsel.join("&")+"','curtimes':'"+curTimes+"'}"
			}else{
				serverdata+=temp.join("|")+"','nums':"+nums+",'times':"+times+",'money':"+money+",'mode':"+modes+",'point':'"+sel_point+"','desc':'"+noshtml+"','curtimes':'"+curTimes+"'}"
			}
			var cfhtml='<tr style="cursor:pointer;"><td class="tl_li_l" width="4"><td>'+noshtml.substring(0,20)+"</td><td width=25>"+$.lt_method_data.modes[modes].name+'</td><td width=80 class="r">'+nums+lot_lang.dec_s1+'</td><td width=80 class="r">'+times+lot_lang.dec_s2+'</td><td width=120 class="r">'+money+lot_lang.dec_s3+'</td><td class="c tl_li_r" width="16"><input type="hidden" name="lt_project[]" value="'+serverdata+'" /><input type="hidden" name="lt_jm[]" value="'+$.md5(serverdata+'test009')+'" /></td></tr>';var $cfhtml=$(cfhtml);if($.lt_total_nums==0){$($.lt_id_data.id_cf_content).children().empty()}$cfhtml.prependTo($.lt_id_data.id_cf_content);$('td[class="tl_li_l"]',$cfhtml).parent().mouseover(function(){var $h=$('<div class=fbox><table border=0 cellspacing=0 cellpadding=0><tr class=t><td class=tl></td><td class=tm></td><td class=tr></td></tr><tr class=mm><td class=ml><img src="'+pri_imgserver+'/images/comm/t.gif"></td><td>'+lot_lang.dec_s30+": "+current_methodtitle+"_"+current_methodname+"<br/>"+lot_lang.dec_s31+": "+nohtml+"<br/>"+lot_lang.dec_s32+": "+$.lt_method_data.modes[modes].name+lot_lang.dec_s32+(sel_isdy?(", "+lot_lang.dec_s33+" "+sel_prize+", "+lot_lang.dec_s34+" "+(Math.ceil(sel_point*1000)/10)+"%"):"")+"<br/><div class=in><span class=ic></span>  "+lot_lang.dec_s35+" "+nums+" "+lot_lang.dec_s1+", "+times+" "+lot_lang.dec_s2+", "+lot_lang.dec_s36+" "+money+" "+lot_lang.dec_s3+'</div></td><td class=mr><img src="'+pri_imgserver+'/images/comm/t.gif"></td></tr><tr class=b><td class=bl></td><td class=bm><img src="'+pri_imgserver+'/images/comm/t.gif"></td><td class=br></td></tr></table><div class=ar><div class=ic></div></div></div>');var offset=$(this).offset();var left=offset.left+200;var top=offset.top-79;$(this).openFloat($h,"more",left,top)}).mouseout(function(){$(this).closeFloat()}).click(function(){
		var aPositionTile=$.lt_position_title;
		var iPositionLen=current_positionsel.length;
		var positionname="";
		if(iPositionLen>0){
			positionname+="<br/>"+lot_lang.dec_s40;
			for(var i=0;i<iPositionLen;i++){
				positionname+=aPositionTile[current_positionsel[i]];
				if(i<iPositionLen-1){positionname+="\u3001"}
			}
		}
		var sss='<h4 style="text-align:left;">'+lot_lang.dec_s30+": "+current_methodtitle+"_"+current_methodname+positionname+"<br/>"+lot_lang.dec_s32+": "+$.lt_method_data.modes[modes].name+lot_lang.dec_s32+(sel_isdy?(", "+lot_lang.dec_s33+" "+sel_prize+", "+lot_lang.dec_s34+" "+(Math.ceil(sel_point*1000)/10)+"%"):"")+"<br/>"+lot_lang.dec_s35+" "+nums+" "+lot_lang.dec_s1+", "+times+" "+lot_lang.dec_s2+", "+lot_lang.dec_s36+" "+money+" "+lot_lang.dec_s3;var methodcode=$.lt_method[mid];var tmpcodenos="";var dataheight=60;switch(methodcode){case"RZX2":case"RZX3":case"RZX4":if(otype=="input"){tmpcodenos=nos;sss+="</h4>"}else{var aAllCode=nos.split(",");var iCodeLen=aAllCode.length;var len=0;var aCodePosition=[];for(i=0;i<iCodeLen;i++){len=aAllCode[i].length;if(len>0){aCodePosition.push(i)}}var sellen=methodcode.substring(methodcode.length-1);var aPositionCombo=getCombination(aCodePosition,sellen);var iComboLen=aPositionCombo.length;dataheight=iComboLen<5?60:iComboLen*15;var aCombo=[];var iLen=0;for(j=0;j<iComboLen;j++){aCombo=aPositionCombo[j].split(",");iLen=aCombo.length;var tmpnum="";var tmptitle="";var tmpnums=1;for(h=0;h<iLen;h++){tmpnum+=aAllCode[aCombo[h]];tmpnums*=aAllCode[aCombo[h]].length;tmptitle+=aPositionTile[aCombo[h]];if(h<iLen-1){tmpnum+=",";tmptitle+="\u3001"}}tmpcodenos+="["+tmptitle+"]  "+tmpnum+"&nbsp;&nbsp;|&nbsp;&nbsp;"+tmpnums+lot_lang.dec_s1;if(j<iComboLen-1){tmpcodenos+="<br>"}}sss+=" , "+lot_lang.dec_s36+iComboLen+lot_lang.dec_s38;sss+="<br><font color=red>"+lot_lang.dec_s39+"</font></h4>"}break;default:sss+="</h4>";tmpcodenos=nos;break}sss+='<div class="data" style="height:'+dataheight+'px;"><table border=0 cellspacing=0 cellpadding=0><tr><td>'+tmpcodenos+"</td></tr></table></div>";$.alert(sss,lot_lang.dec_s5,"",450,false)});$.lt_total_nums+=nums;$.lt_total_money+=money;$.lt_total_money=Math.round($.lt_total_money*1000)/1000;basemoney=Math.round(nums*2*($.lt_method_data.modes[modes].rate*1000))/1000;$.lt_trace_base=Math.round(($.lt_trace_base+basemoney)*1000)/1000;$($.lt_id_data.id_cf_num).html($.lt_total_nums);$($.lt_id_data.id_cf_money).html($.lt_total_money);$($.lt_id_data.id_cf_count).html(parseInt($($.lt_id_data.id_cf_count).html(),10)+1);var pc=0;var pz=0;$.each($.lt_method_data.prize,function(i,n){n=isNaN(Number(n))?0:Number(n);pz=pz>n?pz:n;pc++});if(pc!=1){pz=0}pz=Math.round(pz*($.lt_method_data.modes[modes].rate*1000))/1000;
			pz=sel_isdy?sel_prize:pz;
			var aPositionTile=$.lt_position_title;
			var iPositionLen=current_positionsel.length;
			var positiondesc="";
			if(iPositionLen>0){
				for(var i=0;i<iPositionLen;i++){
					positiondesc+=aPositionTile[current_positionsel[i]];
					if(i<iPositionLen-1){positiondesc+="\u3001"}
				}
			}
			$cfhtml.data("data",{methodid:mid,methodname:$.lt_method_data.title+"_"+$.lt_method_data.name,nums:nums,money:money,modes:modes,position:cur_position,positiondesc:positiondesc,modename:$.lt_method_data.modes[modes].name,basemoney:basemoney,prize:pz,code:temp.join("|"),desc:nohtml,isrx:$.lt_method_data.isrx});if($.lt_same_code[mid]==undefined){$.lt_same_code[mid]=[]}if($.lt_same_code[mid][modes]==undefined){$.lt_same_code[mid][modes]=[]}if($.lt_same_code[mid][modes][cur_position]==undefined){$.lt_same_code[mid][modes][cur_position]=[]}$.lt_same_code[mid][modes][cur_position].push(temp.join("|"));$("td",$cfhtml).filter(".c").attr("title",lot_lang.dec_s24).click(function(){var n=$cfhtml.data("data").nums;var m=$cfhtml.data("data").money;var b=$cfhtml.data("data").basemoney;var c=$cfhtml.data("data").code;var d=$cfhtml.data("data").methodid;var f=$cfhtml.data("data").modes;var p=$cfhtml.data("data").position;var i=null;$.each($.lt_same_code[d][f][p],function(k,code){if(code==c){i=k}});if(i!=null){$.lt_same_code[d][f][p].splice(i,1)}else{$.alert(lot_lang.am_s27);return}$.lt_total_nums-=n;$.lt_total_money-=m;$.lt_total_money=Math.round($.lt_total_money*1000)/1000;$.lt_trace_base=Math.round(($.lt_trace_base-b)*1000)/1000;$(this).parent().remove();if($.lt_total_nums==0){$('<tr class="nr"><td class="tl_li_l" width="4"></td><td colspan="6" class="noinfo">\u6682\u65e0\u6295\u6ce8\u9879</td><td class="tl_li_rn" width="4"></td></tr>').prependTo($.lt_id_data.id_cf_content)}$($.lt_id_data.id_cf_num).html($.lt_total_nums);$($.lt_id_data.id_cf_money).html($.lt_total_money);$($.lt_id_data.id_cf_count).html(parseInt($($.lt_id_data.id_cf_count).html(),10)-1);cleanTraceIssue();if($.lt_ismargin==false){traceCheckMarginSup()}$(this).parent().closeFloat()});SetCookie("modes",modes,86400);SetCookie("dypoint",sel_point,86400);for(i=0;i<data_sel.length;i++){data_sel[i]=[]}if(otype=="input"){$("#lt_write_box",$(me)).val("")}else{if(otype=="digital"||otype=="dxds"||otype=="dds"||otype=="digitalts"){$("div",$(me)).filter(".on").removeClass("on");$("li[class^='dxjoq']",$(me)).attr("class","dxjoq")}}$($.lt_id_data.id_sel_times).val(1);checkNum();cleanTraceIssue();if($.lt_ismargin==true){traceCheckMarginSup()}})};$.fn.lt_trace=function(){var t_type="margin";$.extend({lt_trace_issue:0,lt_trace_money:0});var t_count=$.lt_issuecount;var currentendtime=new Date($.lt_end_time.replace(/[\-\u4e00-\u9fa5]/g,"/")).getTime();var t_nowpos=0;var htmllabel='<span id="lt_margin" class="tab-front"><span class="tabbar-left"></span><span class="content">'+lot_lang.dec_s13+'</span><span class="tabbar-right"></span></span>';htmllabel+='<span id="lt_sametime" class="tab-back"><span class="tabbar-left"></span><span class="content">'+lot_lang.dec_s10+'</span><span class="tabbar-right"></span></span>';htmllabel+='<span id="lt_difftime" class="tab-back"><span class="tabbar-left"></span><span class="content">'+lot_lang.dec_s11+'</span><span class="tabbar-right"></span></span>';var htmltext='<span id="lt_margin_html">'+lot_lang.dec_s14+'&nbsp;<input name="lt_trace_times_margin" type="text" id="lt_trace_times_margin" value="1" size="3" />&nbsp;&nbsp;'+lot_lang.dec_s29+'&nbsp;<input name="lt_trace_margin" type="text" id="lt_trace_margin" value="50" size="5" />'+lot_lang.dec_s3+'&nbsp;&nbsp;</span>';htmltext+='<span id="lt_sametime_html" style="display:none;">'+lot_lang.dec_s14+'&nbsp;<input name="lt_trace_times_same" type="text" id="lt_trace_times_same" value="1" size="3" /></span>';htmltext+='<span id="lt_difftime_html" style="display:none;">'+lot_lang.dec_s17+'&nbsp;<input name="lt_trace_diff" type="text" id="lt_trace_diff" value="1" size="3" />&nbsp;'+lot_lang.dec_s18+"&nbsp;&nbsp;"+lot_lang.dec_s2+" "+lot_lang.dec_s19+' <input name="lt_trace_times_diff" type="text" id="lt_trace_times_diff" value="2" size="3" /></span>';htmltext+="&nbsp;&nbsp;"+lot_lang.dec_s15+'&nbsp;<input name="lt_trace_count_input" type="text" id="lt_trace_count_input" style="width:36px" value="10" size="3" /><input type="hidden" id="lt_trace_money" name="lt_trace_money" value="0" /><input type="hidden" id="lt_trace_alcount" />';$(htmllabel).appendTo($.lt_id_data.id_tra_label);$(htmltext).appendTo($.lt_id_data.id_tra_lhtml);$($.lt_id_data.id_tra_alct).val(t_count);$("#lt_margin").click(function(){if($(this).attr("class")!="tab-front"){$(this).attr("class","tab-front");$("#lt_sametime").attr("class","tab-back");$("#lt_difftime").attr("class","tab-back");$("#lt_margin_html").show();$("#lt_sametime_html").hide();$("#lt_difftime_html").hide();t_type="margin"}});$("#lt_sametime").click(function(){if($(this).attr("class")!="tab-front"){$(this).attr("class","tab-front");$("#lt_margin").attr("class","tab-back");$("#lt_difftime").attr("class","tab-back");$("#lt_margin_html").hide();$("#lt_sametime_html").show();$("#lt_difftime_html").hide();t_type="same"}});$("#lt_difftime").click(function(){if($(this).attr("class")!="tab-front"){$(this).attr("class","tab-front");$("#lt_margin").attr("class","tab-back");$("#lt_sametime").attr("class","tab-back");$("#lt_margin_html").hide();$("#lt_sametime_html").hide();$("#lt_difftime_html").show();t_type="diff"}});function upTraceCount(){$("#lt_trace_count").html($.lt_trace_issue);if(parseInt($.lt_trace_issue,10)==0){$("#lt_trace_qissueno").change()}else{$("#lt_trace_count_input").val($.lt_trace_issue)}$("#lt_trace_hmoney").html(JsRound($.lt_trace_money,2,true));$("#lt_trace_money").val($.lt_trace_money)}$("input",$($.lt_id_data.id_tra_lhtml)).keyup(function(){$(this).val(Number($(this).val().replace(/[^0-9]/g,"0")))});$("#lt_trace_qissueno").change(function(){var t=0;if($(this).val()=="all"){t=parseInt($($.lt_id_data.id_tra_alct).val(),10)}else{t=parseInt($(this).val(),10)}t=isNaN(t)?0:t;$("#lt_trace_count_input").val(t)});
		var issueshtml='<table width="100%" cellspacing=0 cellpadding=0 border=0 id="lt_trace_issues_table">';
//		issueshtml+='<tr><td class="r1">issue1</td><td>issue2</td><td class="nosel">issue3</td><td>issue4</td><td>times</td></tr>';
		var endtime=0;
		var m=0;
		$.each($.lt_issues,function(i,n){
			endtime=new Date(n.endtime.replace(/[\-\u4e00-\u9fa5]/g,"/")).getTime();
			if(m<t_count&&endtime>=currentendtime){
				m++;
				issueshtml+='<tr id="tr_trace_'+n.issue+'"><td class="r1"><input type="checkbox" name="lt_trace_issues[]" value="'+n.issue+'" /></td><td>'+n.issue+'</td><td class="nosel"><input name="lt_trace_times_'+n.issue+'" type="text" class="r2" value="0" disabled/>'+lot_lang.dec_s2+"</td><td>"+lot_lang.dec_s20+'<span id="lt_trace_money_'+n.issue+'">0.00</span></td><td>'+n.endtime+"</td></tr>"
			}
		});
		issueshtml+="</table>";
		$(issueshtml).appendTo($.lt_id_data.id_tra_issues);
		function changeIssueCheck(obj){
			var money=$.lt_trace_base;
			var $j=$(obj).closest("tr");
			if($(obj).attr("checked")==true){
				$j.find("input[name^='lt_trace_times_']").val(1).attr("disabled",false).data("times",1);
				$j.find("span[id^='lt_trace_money_']").html(JsRound(money,2,true));
				$.lt_trace_issue++;
				$.lt_trace_money+=money
			}else{
				var t=$j.find("input[name^='lt_trace_times_']").val();
				$j.find("input[name^='lt_trace_times_']").val(0).attr("disabled",true).data("times",0);
				$j.find("span[id^='lt_trace_money_']").html("0.00");
				$.lt_trace_issue--;
				$.lt_trace_money-=money*parseInt(t,10)
			}
			$.lt_trace_money=JsRound($.lt_trace_money,2);
			upTraceCount()
		}
		$("input[name^='lt_trace_times_']",$($.lt_id_data.id_tra_issues)).live("keyup",function(){
			var v=Number($(this).val().replace(/[^0-9]/g,"0"));
			$.lt_trace_money+=$.lt_trace_base*(v-$(this).data("times"));
			upTraceCount();
			$(this).val(v).data("times",v);
			$(this).closest("tr").find("span[id^='lt_trace_money_']").html(JsRound($.lt_trace_base*v,2,true))
		});
		$(":checkbox",$.lt_id_data.id_tra_issues).live("click",function(){
			changeIssueCheck(this);
			stopPropagation()
		});
		$("tr",$($.lt_id_data.id_tra_issues)).live("mouseover",function(){$(this).attr("class","hv")}).live("mouseout",function(){
			if($(this).find(":checkbox").attr("checked")==false){
				$(this).removeClass("hv")
			}else{
				$(this).attr("class","on")
			}
		}).live("click",function(){
			if($(this).find(":checkbox").attr("checked")==false){
				$(this).find(":checkbox").attr("checked",true)
			}else{
				$(this).find(":checkbox").attr("checked",false)
			}
			changeIssueCheck($(this).find(":checkbox"))
		});
		$("input[name^='lt_trace_times_']",$($.lt_id_data.id_tra_issues)).live("click",function(){return false});
		var _initTraceByIssue=function(){
			var st_issue=$("#lt_issue_start").val();
			cleanTraceIssue();
			var isshow=false;
			var acount=0;
			var loop=0;
			var mins=t_nowpos;
			var maxe=t_nowpos;
			var endtime=0;
			var k=0;
			var currentendtime=new Date($.lt_end_time.replace(/[\-\u4e00-\u9fa5]/g,"/")).getTime();
			$.each($.lt_issues,function(i,n){
				endtime=new Date(n.endtime.replace(/[\-\u4e00-\u9fa5]/g,"/")).getTime();
				if(k<$.lt_issuecount&&endtime>=currentendtime){
					k++;
					loop++;
					if(isshow==false&&st_issue==n.issue){isshow=true}
					if(isshow==false){
						acount++;
						maxe=Math.max(maxe,acount)
					}else{
						mins=Math.min(mins,acount)
					}
					if(loop>=mins&&loop<=maxe){
						if(isshow==true){
							$("#tr_trace_"+n.issue,$($.lt_id_data.id_tra_issues)).show()
						}else{
							$("#tr_trace_"+n.issue,$($.lt_id_data.id_tra_issues)).hide()
						}
					}
					if(loop>maxe){return false}
				}
			});
			t_count=$.lt_issuecount-acount;
			if($("#lt_trace_qissueno").val()=="all"){
				$("#lt_trace_count_input").val(t_count)
			}
			t_nowpos=acount;
			$($.lt_id_data.id_tra_alct).val(t_count);
			$.lt_trace_issue=0;
			$.lt_trace_money=0;
			upTraceCount()
		};
		$("#lt_issue_start").change(function(){
			if($($.lt_id_data.id_tra_if).attr("checked")==true){_initTraceByIssue()}
		});
		$($.lt_id_data.id_tra_if).attr("checked",false).click(function(){
			if($(this).attr("checked")==true){
				if($.lt_total_nums<=0){
					$.alert(lot_lang.am_s7);
					$(this).attr("checked",false);
					return
				}
				$($.lt_id_data.id_tra_stop).attr("disabled",false).attr("checked",true);
				$($.lt_id_data.id_tra_box).show();
				_initTraceByIssue()
			}else{
				$($.lt_id_data.id_tra_stop).attr("disabled",true).attr("checked",false);
				$($.lt_id_data.id_tra_box).hide()
			}
		});
		var computeByMargin=function(s,m,b,o,p){
			s=s?parseInt(s,10):0;
			m=m?parseInt(m,10):0;
			b=b?Number(b):0;
			o=o?Number(o):0;
			p=p?Number(p):0;
			var t=0;
			if(b>0){
				if(m>0){
//					t=Math.ceil(((m/100+1)*o)/(p-(b*(m/100+1))))
					t=Math.ceil((m+o)/(p-b))
				}else{
					t=1
				}
				if(t<s){t=s}
			}
			return t
		};
		$($.lt_id_data.id_tra_ok).click(function(){		//生成追号
			var c=parseInt($.lt_total_nums,10);
			if(c<=0){
				$.alert(lot_lang.am_s7);		//添加投注内容
				return false
			}
			var p=0;
			if(t_type=="margin"){
				var marmt=0;
				var marmd=0;
				var martype=0;
				$.each($("tr",$($.lt_id_data.id_cf_content)),function(i,n){
					if(marmt!=0&&marmt!=$(n).data("data").methodid){
						martype=2;return false
					}else{
						marmt=$(n).data("data").methodid
					}
					if(marmd!=0&&marmd!=$(n).data("data").modes){
						martype=3;return false
					}else{
						marmd=$(n).data("data").modes
					}
					if($(n).data("data").prize<=0||(p!=0&&p!=$(n).data("data").prize)){
						martype=1;return false
					}else{
						p=$(n).data("data").prize
					}
				});
				if(martype==1){
					$.alert(lot_lang.am_s32);	//此玩法不支持利润率追号
					return false
				}else{
					if(martype==2){
						$.alert(lot_lang.am_s31);	//多玩法不支持利润率追号
						return false
					}else{
						if(martype==3){
							$.alert(lot_lang.am_s33);	//混合圆角模式不支持利润率追号
							return false
						}
					}
				}
			}
			var ic=parseInt($("#lt_trace_count_input").val(),10);
			ic=isNaN(ic)?0:ic;
			if(ic<=0){
				$.alert(lot_lang.am_s8);	//追号期数
				return false
			}
			if(ic>$.lt_issuecount){
				$.alert(lot_lang.am_s9,"","",300);	//追号期数不正确，超出了最大可追号期数
				return false
			}
			var times=parseInt($("#lt_trace_times_"+t_type).val(),10);
			times=isNaN(times)?0:times;
			if(times<=0){
				$.alert(lot_lang.am_s10);	//请填写倍数
				return false
			}
			times=isNaN(times)?0:times;
			var td=[];
			var tm=0;
			var msg="";
			if(t_type=="same"){
				var m=$.lt_trace_base*times;
				tm=m*ic;
				for(var i=0;i<ic;i++){
					td.push({times:times,money:m})
				}
				msg=lot_lang.am_s12.replace("[times]",times)
			}else{
				if(t_type=="diff"){
					var d=parseInt($("#lt_trace_diff").val(),10);
					d=isNaN(d)?0:d;
					if(d<=0){
						$.alert(lot_lang.am_s11);
						return false
					}
					var m=$.lt_trace_base;
					var t=1;
					for(var i=0;i<ic;i++){
						if(i!=0&&(i%d)==0){t*=times}
						td.push({times:t,money:m*t});
						tm+=m*t
					}
					msg=lot_lang.am_s13.replace("[step]",d).replace("[times]",times)
				}else{
					if(t_type=="margin"){		//利润
						var e=parseInt($("#lt_trace_margin").val(),10);
						e=isNaN(e)?0:e;
						if(e<=0){
							$.alert(lot_lang.am_s30);	//利润率错误
							return false
						}
						var m=$.lt_trace_base;
//						if(e>=((p*100/m)-100)){	
//							$.alert(lot_lang.am_s30);	
//							return false
//						}
						var t=0;
						for(var i=0;i<ic;i++){
							t=computeByMargin(times,e,m,tm,p);
							td.push({times:t,money:m*t});
							tm+=m*t
						}
						msg=lot_lang.am_s34.replace("[margin]",e).replace("[times]",times)
					}
				}
			}
			msg+=lot_lang.am_s14.replace("[count]",ic);
			msg=lot_lang.am_s99.replace("[msg]",msg);
			$.confirm(msg,function(){
				cleanTraceIssue();
				var $s=$("tr:visible",$($.lt_id_data.id_tra_issues));
				for(i=0;i<ic;i++){
					$($s[i]).find(":checkbox").attr("checked",true);
					$($s[i]).find("input[name^='lt_trace_times_']").val(td[i].times).attr("disabled",false).data("times",td[i].times);
					$($s[i]).find("span[id^='lt_trace_money_']").html(JsRound(td[i].money,2,true));
					$($s[i]).addClass("on")
				}
				$.lt_trace_issue=ic;
				$.lt_trace_money=tm;
				upTraceCount()
			},"","",350)
		})
	};
	var cleanTraceIssue=function(){
		$("input[name^='lt_trace_issues']",$($.lt_id_data.id_tra_issues)).attr("checked",false);
		$("input[name^='lt_trace_times_']",$($.lt_id_data.id_tra_issues)).val(0).attr("disabled",true);
		$("span[id^='lt_trace_money_']",$($.lt_id_data.id_tra_issues)).html("0.00");
		$("tr",$($.lt_id_data.id_tra_issues)).removeClass("on");
		$("#lt_trace_hmoney").html(0);
		$("#lt_trace_money").val(0);
		$("#lt_trace_count").html(0);
		$.lt_trace_issue=0;
		$.lt_trace_money=0};
		var traceCheckMarginSup=function(){
			var marmt=0;
			var marmd=0;
			var martype=0;
			var p=0;
			if($.lt_total_nums>0){
				$.each($("tr",$($.lt_id_data.id_cf_content)),function(i,n){
					if(marmt!=0&&marmt!=$(n).data("data").methodid){
						martype=2;return false
					}else{
						marmt=$(n).data("data").methodid
					}
					if(marmd!=0&&marmd!=$(n).data("data").modes){
						martype=3;return false
					}else{
						marmd=$(n).data("data").modes
					}
					if($(n).data("data").prize<=0||(p!=0&&p!=$(n).data("data").prize)||$(n).data("data").isrx==1){
						martype=1;return false
					}else{
						p=$(n).data("data").prize
					}
				})
			}
			if(martype>0){
				$.lt_ismargin=false;
				$("#lt_margin").hide();
				$("#lt_margin_html").hide();
				$("#lt_sametime").click()
			}else{
				$.lt_ismargin=true;$("#lt_margin").show();$("#lt_margin_html").show();$("#lt_margin").click()}return true};$.fn.lt_timer=function(start,end){var me=this;if(start==""||end==""){$.lt_time_leave=0}else{$.lt_time_leave=(format(end).getTime()-format(start).getTime())/1000}function fftime(n){return Number(n)<10?""+0+Number(n):Number(n)}function format(dateStr){return new Date(dateStr.replace(/[\-\u4e00-\u9fa5]/g,"/"))}
	function diff(t){return t>0?{day:Math.floor(t/86400),hour:Math.floor(t%86400/3600),minute:Math.floor(t%3600/60),second:Math.floor(t%60)}:{day:0,hour:0,minute:0,second:0}
	}
	var firstTime=Math.ceil(Math.random()*(269-210)+210);
	var secondTime=Math.ceil(Math.random()*(89-30)+30);
	var timerno=window.setInterval(function(){
		if($.lt_time_leave>0&&($.lt_time_leave%firstTime==0||$.lt_time_leave==secondTime)){
			$.ajax({type:"POST",URL:$.lt_ajaxurl,timeout:30000,data:"lotteryid="+$.lt_lottid+"&issue="+$($.lt_id_data.id_cur_issue).html()+"&flag=gettime",success:function(data){
				data=parseInt(data,10);
				data=isNaN(data)?0:data;data=data<=0?0:data;$.lt_time_leave=data
			}})
		}
		if($.lt_time_leave<=0){
			clearInterval(timerno);
			if($.lt_open_status==true){
				$("#lt_opentimeleft").lt_opentimer($($.lt_id_data.id_cur_end).html(),$.lt_open_time,$($.lt_id_data.id_cur_issue).html())
			}
			if($.lt_submiting==false){
				$.unblockUI({fadeInTime:0,fadeOutTime:0});
				$.confirm(lot_lang.am_s99.replace("[msg]",lot_lang.am_s15),function(){	//zhou
					$.lt_reset(false);
					$.lt_ontimeout()
				},function(){
					$.lt_reset(true);$.lt_ontimeout()},"",450)
			}
		}
			var oDate=diff($.lt_time_leave--);$(me).html(""+(oDate.day>0?oDate.day+(lot_lang.dec_s21)+" ":"")+fftime(oDate.hour)+":"+fftime(oDate.minute)+":"+fftime(oDate.second))},1000)};$.fn.lt_opentimer=function(start,end,openissue){var me=this;if(start==""||end==""){var cc=0}else{var cc=(format(end).getTime()-format(start).getTime())/1000}$.lt_time_open=Math.floor(cc);function fftime(n){return Number(n)<10?""+0+Number(n):Number(n)}function format(dateStr){return new Date(dateStr.replace(/[\-\u4e00-\u9fa5]/g,"/"))}
		function diff(t){return t>0?{day:Math.floor(t/86400),hour:Math.floor(t%86400/3600),minute:Math.floor(t%3600/60),second:Math.floor(t%60)}:{day:0,hour:0,minute:0,second:0}}
		$.lt_open_status=false;
		function _getcode(issue){
			$.ajax({type:"POST",url:$.lt_ajaxurl,data:"lotteryid="+$.lt_lottid+"&flag=gethistory&issue="+issue,success:function(data){
				var partn=/<script.*>.*<\/script>/;
				if(data=="empty"||partn.test(data)){
					return
				}
				eval("data="+data);
				$.lt_open_status=true;
				var codebox=$("#showcodebox").find("div");
				var $len=codebox.length;
				var $i=0;
				clearInterval(opentimerget);
				var opencodeno=window.setInterval(function(){
					if($i>$len){
						clearInterval(moveno);
						clearInterval(opencodeno)
					}
					$(codebox[$i]).attr("flag","normal");
					if(data.code[$i]=="x"){
						$(codebox[$i]).attr("class","gr_s gr_sx")
					}else{
						$(codebox[$i]).attr("class","gr_s gr_s"+data.code[$i])
					}
					$i++
				},500);
				$("#lt_opentimebox").hide();
				$("#lt_opentimebox2").hide();
				$("#showxt").html(data.xt);
				$("#gctrh").html(data.history);
				$("#lt_gethistorycode").html(data.issue)
			}
		})
	}
//		$("#showcodebox").hide("fast");
//		$("#showadvbox").show("fast");
		$("#lt_gethistorycode").html(openissue);
		$("#lt_opentimebox").show();
		$("#lt_opentimebox2").hide();
		var _getTimes=0;
		window.setTimeout(function(){
			var tttime=Math.ceil(Math.random()*15+10)*1000;
			opentimerget=window.setInterval(function(){
				if($.lt_open_status==true||_getTimes>20){
					if(_getTimes>20){
						$("#lt_opentimebox2").html("<strong>&nbsp;\u5f00\u5956\u8d85\u65f6,\u8bf7\u5237\u65b0</strong>").show();
//						$("#showcodebox").hide("fast");
//						$("#showadvbox").show("fast")
					}
					clearInterval(moveno);
					$.each($("#showcodebox").find("div"),function(i,n){
						$(this).attr("class","gr_s gr_sx");
						$(this).attr("flag","normal")
					});
					clearInterval(opentimerget)
				}
				_getTimes++;
				_getcode($("#lt_gethistorycode").html())
			},tttime)
		},cc*1000);
		var opentimerno=window.setInterval(function(){
			if($.lt_time_open<=0){
				clearInterval(opentimerno);
				$("#lt_opentimebox").hide();
				$("#lt_opentimebox2").show();
				$("#showcodebox").find("div").not(".gr_sx").attr("flag","move");
				moveno=window.setInterval(function(){
					$.each($("#showcodebox").find("div"),function(i,n){
						if($(this).attr("flag")=="move"){
							$(this).attr("class","gr_s gr_s"+Math.floor(10*Math.random()))
						}
					})
				},40);
//				$("#showadvbox").hide("fast");
//				$("#showcodebox").show("fast")
			}
			var oDate=diff($.lt_time_open--);
			if($.lt_time_open<60){
				$("#waitopendesc").html("\u5f00\u5956\u5012\u8ba1\u65f6:");
				$(me).html(""+(oDate.hour>0?oDate.hour+":":"")+fftime(oDate.minute)+":"+fftime(oDate.second))
			}else{
				$("#waitopendesc").html("\u7b49\u5f85\u5f00\u5956");
				$(me).html("")
			}
		},1000)
	};
	$.lt_reset=function(iskeep){
		if(iskeep&&iskeep===true){iskeep=true}else{iskeep=false}
		if($.lt_time_leave<=0){
			if(iskeep==false){
				$("span[id^='smalllabel_'][class='method-tab-front']",$($.lt_id_data.id_smalllabel)).removeData("ischecked").click()
			}
			if(iskeep==false){
				$.lt_total_nums=0;
				$.lt_total_money=0;
				$.lt_trace_base=0;
				$.lt_same_code=[];
				$($.lt_id_data.id_cf_num).html(0);
				$($.lt_id_data.id_cf_money).html(0);
				$($.lt_id_data.id_cf_content).children().empty();
				$('<tr class="nr"><td class="tl_li_l" width="4"></td><td colspan="6" class="noinfo">\u6682\u65e0\u6295\u6ce8\u9879</td><td class="tl_li_rn" width="4"></td></tr>').prependTo($.lt_id_data.id_cf_content);
				$($.lt_id_data.id_cf_count).html(0);
				if($.lt_ismargin==false){traceCheckMarginSup()}
			}
			$.ajax({type:"POST",URL:$.lt_ajaxurl,timeout:30000,data:"lotteryid="+$.lt_lottid+"&flag=read",success:function(data){
				if(data.length<=0){
					$.alert(lot_lang.am_s16);
					return false
				}
				var partn=/<script.*>.*<\/script>/;
				if(partn.test(data)){
					alert(lot_lang.am_s17,"","",300);
					top.location.href="./";
					return false
				}
				if(data=="empty"){
					alert(lot_lang.am_s18);
					window.location.href="./default_notice.php";
					return false
				}
				eval("data="+data);
				$($.lt_id_data.id_cur_issue).html(data.issue);
				$($.lt_id_data.id_cur_end).html(data.saleend);
				$($.lt_id_data.id_cur_sale).html(data.sale);
				$.lt_issuecount=data.left;
				if(parseInt($("#lt_trace_count_input").val(),10)>$.lt_issuecount){
					$("#lt_trace_count_input").val($.lt_issuecount)
				}
				$($.lt_id_data.id_count_down).lt_timer(data.nowtime,data.saleend);
				$.lt_open_time=data.opentime;
				$.lt_end_time=data.saleend;
				var j=0;
				var endtime=0;
				var currentendtime=new Date($.lt_end_time.replace(/[\-\u4e00-\u9fa5]/g,"/")).getTime();
				var chtml="";
				var lastissueshtml="";
				$.each($.lt_issues,function(i,n){
					endtime=new Date(n.endtime.replace(/[\-\u4e00-\u9fa5]/g,"/")).getTime();
					if(j<$.lt_issuecount&&endtime>=currentendtime){
						j++;
						chtml+='<option value="'+n.issue+'">'+n.issue+(n.issue==data.issue?lot_lang.dec_s7:"")+"</option>";
						lastissueshtml+='<tr id="tr_trace_'+n.issue+'"><td class="r1"><input type="checkbox" name="lt_trace_issues[]" value="'+n.issue+'" /></td><td>'+n.issue+'</td><td class="nosel"><input name="lt_trace_times_'+n.issue+'" type="text" class="r2" value="0" disabled/>'+lot_lang.dec_s2+"</td><td>"+lot_lang.dec_s20+'<span id="lt_trace_money_'+n.issue+'">0.00</span></td><td>'+n.endtime+"</td></tr>"
					}
				});
				$("#lt_issue_start").empty();
				$(chtml).appendTo("#lt_issue_start");
				$("#lt_trace_issues_table").empty();
				$(lastissueshtml).appendTo("#lt_trace_issues_table");t_count=$.lt_issuecount;$($.lt_id_data.id_tra_alct).val(t_count);cleanTraceIssue()},error:function(){$.alert(lot_lang.am_s16);cleanTraceIssue();return false}})}else{if(iskeep==false){$("span[id^='smalllabel_'][class='method-tab-front']",$($.lt_id_data.id_smalllabel)).removeData("ischecked").click()}if(iskeep==false){$.lt_total_nums=0;$.lt_total_money=0;$.lt_trace_base=0;$.lt_same_code=[];$($.lt_id_data.id_cf_num).html(0);$($.lt_id_data.id_cf_money).html(0);$($.lt_id_data.id_cf_content).children().empty();$('<tr class="nr"><td class="tl_li_l" width="4"></td><td colspan="6" class="noinfo">\u6682\u65e0\u6295\u6ce8\u9879</td><td class="tl_li_rn" width="4"></td></tr>').prependTo($.lt_id_data.id_cf_content);$($.lt_id_data.id_cf_count).html(0);if($.lt_ismargin==false){traceCheckMarginSup()}}if(iskeep==false){cleanTraceIssue()}}};$.fn.lt_ajaxSubmit=function(){var me=this;$(this).click(function(){if(checkTimeOut()==false){return}$.lt_submiting=true;var istrace=$($.lt_id_data.id_tra_if).attr("checked");if($.lt_total_nums<=0||$.lt_total_money<=0){$.lt_submiting=false;$.alert(lot_lang.am_s7);return}if(istrace==true){if($.lt_trace_issue<=0||$.lt_trace_money<=0){$.lt_submiting=false;$.alert(lot_lang.am_s20);return}var terr="";$("input[name^='lt_trace_issues']:checked",$($.lt_id_data.id_tra_issues)).each(function(){if(Number($(this).closest("tr").find("input[name^='lt_trace_times_']").val())<=0){terr+=$(this).val()+"&nbsp;&nbsp;"}});if(terr.length>0){$.lt_submiting=false;$.alert(lot_lang.am_s21.replace("[errorIssue]",terr),"","",300,false);return}}if(istrace==true){var msg="<h4>"+lot_lang.am_s144.replace("[count]",$.lt_trace_issue)+"</h4>"}else{var msg="<h4>"+lot_lang.dec_s8.replace("[issue]",$("#lt_issue_start").val())+"</h4>"}msg+='<div class="data"><table border=0 cellspacing=0 cellpadding=0 width=100%><tr class=hid><td width=135></td><td width=20></td><td width=180></td><td></td></tr>';var modesmsg=[];var modes=0;$.each($("tr",$($.lt_id_data.id_cf_content)),function(i,n){datas=$(n).data("data");if(datas.positiondesc==""){msg+="<tr><td>"+datas.methodname+"</td><td>"+datas.modename+'</td><td colspan="2">'+datas.desc+"</td></tr>"}else{msg+="<tr><td>"+datas.methodname+"</td><td>"+datas.modename+"</td><td>"+datas.desc+"</td><td>"+datas.positiondesc+"</td></tr>"}});msg+="</table></div>";btmsg='<div class="binfo"><span class=bbl></span><span class=bbm>'+(istrace==true?lot_lang.dec_s16+": "+JsRound($.lt_trace_money,2,true):lot_lang.dec_s9+": "+$.lt_total_money)+" "+lot_lang.dec_s3+"</span><span class=bbr></span></div>";$.confirm(msg,function(){if(checkTimeOut()==false){$.lt_submiting=false;return}$("#lt_total_nums").val($.lt_total_nums);$("#lt_total_money").val($.lt_total_money);ajaxSubmit()},function(){$.lt_submiting=false;return checkTimeOut()},"",580,true,btmsg)});
	function checkTimeOut(){
		if($.lt_time_leave<=0){
			$.confirm(lot_lang.am_s99.replace("[msg]",lot_lang.am_s15),function(){
				$.lt_reset(false);
				$.lt_ontimeout();
			},function(){$.lt_reset(true);$.lt_ontimeout()},"",450);
			return false
		}else{
			return true
		}
	}
	function ajaxSubmit(){$.blockUI({message:lot_lang.am_s22,overlayCSS:{backgroundColor:"#000000",opacity:0.3,cursor:"wait"}});var form=$(me).closest("form");$.ajax({type:"POST",url:$.lt_ajaxurl,timeout:30000,data:$(form).serialize(),success:function(data){$.unblockUI({fadeInTime:0,fadeOutTime:0});$.lt_submiting=false;if(data.length<=0){$.alert(lot_lang.am_s16);return false}var partn=/<script.*>.*<\/script>/;if(partn.test(data)){alert(lot_lang.am_s17,"","",300);top.location.href="./";return false}if(data=="success"){$.alert(lot_lang.am_s24,lot_lang.dec_s25,function(){if(checkTimeOut()==true){$.lt_reset()}$.lt_onfinishbuy();$.fn.fastData();$.fn.updatehistory()});return false}else{eval("data = "+data+";");if(data.stats=="error"){$.alert(lot_lang.am_s100+data.data,"",function(){return checkTimeOut()},(data.data.length>10?350:250));return false}if(data.stats=="fail"){msg="<h4>"+lot_lang.am_s26+"</h4>";msg+='<div class="data"><table width="100%" border="0" cellspacing="0" cellpadding="0">';$.each(data.data.content,function(i,n){msg+="<tr><td>"+n.desc+'</td><td width="30%">'+n.errmsg+"</td></tr>"});msg+="</table></div>";btmsg='<div class="binfo"><span class=bbl></span><span class=bbm>'+lot_lang.am_s25.replace("[success]",data.data.success).replace("[fail]",data.data.fail)+"</span><span class=bbr></span></div>";$.confirm(msg,function(){if(checkTimeOut()==true){$.lt_reset()}$.lt_onfinishbuy();$.fn.fastData();$.fn.updatehistory()},function(){$.lt_onfinishbuy();$.fn.fastData();$.fn.updatehistory();return checkTimeOut()},"",500,true,btmsg)}}},error:function(){$.lt_submiting=false;$.unblockUI({fadeInTime:0,fadeOutTime:0});$.confirm(lot_lang.am_s99.replace("[msg]",lot_lang.am_s23),function(){if(checkTimeOut()==true){$.lt_reset()}$.lt_onfinishbuy();$.fn.fastData();$.fn.updatehistory()},function(){$.lt_onfinishbuy();$.fn.fastData();$.fn.updatehistory();return checkTimeOut()},"",480,true);return false}})}};$.fn.fastData=function(){if(typeof(window.top.frames.leftframe)!="object"){return true}var $lf=$("#leftusermoney",window.top.frames.leftframe.document);var $add=$("#addmoney",window.top.frames.leftframe.document);var $usermoney=$("#usermoney",window.top.frames.leftframe.document);$.ajax({type:"POST",url:"/default_getfastdata.php",timeout:9000,success:function(data){var partn=/<(.*)>.*<\/\1>/;if(partn.exec(data)){return false}eval("data="+data+";");if(data.money!="empty"){var dd=moneyFormat(data.money);var original=parseFloat($usermoney.val().replace(/,/g,""));var diff=parseFloat(data.money-original);diff=diff.toFixed(2);if(diff<-0.01||diff>0.01){var shtml="";var oridiff=diff;diff=diff.split("");$.each(diff,function(i,n){if(n=="."){shtml+='<div class="nub nubd"></div>'}else{if(n==","){}else{shtml+='<div class="nub nub'+n+'"></div>'}}});if(oridiff>0){shtml='<div class="nub nubplus"></div>'+shtml;$add.html(shtml)}else{shtml='<div class="nub nubreduce"></div>'+shtml;$add.html(shtml)}$add.css("top","10px");$add.animate({top:"-=120px"},3000)}$usermoney.val(dd);dd=dd.substring(0,(dd.length-2));var shtml="";dd=dd.split("");$.each(dd,function(i,n){if(n=="."){shtml+='<div class="nub nubd"></div>'}else{if(n==","){}else{shtml+='<div class="nub nub'+n+'"></div>'}}});$lf.html(shtml)}return true}})};$.fn.updatehistory=function(){if(parseInt($.lt_showrecord,10)==0){return true}
	$.ajax({type:"POST",URL:$.lt_ajaxurl,data:"lotteryid="+$.lt_lottid+"&flag=hisproject",success:function(data){
		if(data.length<=0){
			$.alert(lot_lang.am_s16);
			return false
		}
		var partn=/<script.*>.*<\/script>/;
		if(partn.test(data)){
			$.alert(lot_lang.am_s16);
			return false
		}
		eval("data="+data+";");
		$(".projectlist").empty();
		var $shtml="";
		$.each(data,function(i,n){
			if(parseInt(n.iscancel,10)!=0){
				$shtml+='<tr class="cancel">'
			}else{
				$shtml+="<tr>"
			}
			$shtml+='<td><a href="./history_playinfos.php?id='+n.projectid+'" target="_blank" title="\u67e5\u770b\u6295\u6ce8\u8be6\u60c5" class="blue">'+n.projectid+"</a></td>";
//			$shtml+='<td><a href="javascript:"  title="\u67e5\u770b\u6295\u6ce8\u8be6\u60c5" class="blue" rel="projectinfo">'+n.projectid+"</a></td>";		//zhou
			$shtml+="<td>"+n.writetime+"</td>";$shtml+="<td>"+n.methodname+"</td>";$shtml+="<td>"+n.issue+"</td>";$shtml+="<td>"+n.code+"</td>";
			$shtml+="<td>"+n.multiple+"</td>";$shtml+="<td>"+n.modes+"</td>";$shtml+="<td>"+n.totalprice+"</td>";$shtml+="<td>"+n.bonus+"</td>";
			$shtml+="<td>"+n.statusdesc+"</td>";$shtml+="</tr>"
		});
		$(".projectlist").html($shtml)},error:function(){$.alert(lot_lang.am_s16)}})}})(jQuery);
