
<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>找回密码</title>
    <link rel="stylesheet" href="http://static.phl58.co/static/images/common/base.css" />
    <link rel="stylesheet" href="http://static.phl58.co/static/images/ucenter/safe/safe.css" />
	<link rel="stylesheet" href="http://static.phl58.co/static/images/common/js-ui.css" />
    <script type="text/javascript">global_path_url="http://static.phl58.co/static";</script>
	<script type="text/javascript" src="http://static.phl58.co/static/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="http://static.phl58.co/static/js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="http://static.phl58.co/static/js/jquery.tmpl.min.js"></script>
	<script type="text/javascript" src="http://static.phl58.co/static/js/jquery-ui-1.10.2.js"></script>
	<script type="text/javascript" src="http://static.phl58.co/static/js/jquery.flot.js"></script>
	<script type="text/javascript" src="http://static.phl58.co/static/js/jquery.flot.crosshair.js"></script>
	<script type="text/javascript" src="http://static.phl58.co/static/js/jquery.cookie.js"></script>
	<script type="text/javascript" src="http://static.phl58.co/static/js/phoenix.base.js"></script>
	<script type="text/javascript" src="http://static.phl58.co/static/js/phoenix.Class.js"></script>
	<script type="text/javascript" src="http://static.phl58.co/static/js/phoenix.Event.js"></script>
	<script type="text/javascript" src="http://static.phl58.co/static/js/phoenix.util.js"></script>
	<script type="text/javascript" src="http://static.phl58.co/static/js/phoenix.Timer.js"></script>
	<script type="text/javascript" src="http://static.phl58.co/static/js/phoenix.Input.js"></script>
	<script type="text/javascript" src="http://static.phl58.co/static/js/phoenix.Tab.js"></script>
	<script type="text/javascript" src="http://static.phl58.co/static/js/phoenix.Slider.js"></script>
	<script type="text/javascript" src="http://static.phl58.co/static/js/phoenix.Hover.js"></script>
	<script type="text/javascript" src="http://static.phl58.co/static/js/phoenix.Tip.js"></script>
	<script type="text/javascript" src="http://static.phl58.co/static/js/phoenix.Mask.js"></script>
	<script type="text/javascript" src="http://static.phl58.co/static/js/phoenix.MiniWindow.js"></script>
	<script type="text/javascript" src="http://static.phl58.co/static/js/phoenix.Message.js"></script>
	<script type="text/javascript" src="http://static.phl58.co/static/js/phoenix.Validator.js"></script>
	<script type="text/javascript" src="http://static.phl58.co/static/js/phoenix.DatePicker.js"></script>
	<script type="text/javascript" src="http://static.phl58.co/static/js/phoenix.GlobalAd.js"></script>
    <script type="text/javascript">
	(function() {       
		function async_load(){           
			var s = document.createElement('script');          
			s.type = 'text/javascript';          
			s.async = true;           
			s.src = "http://www.26hn.com:7006/web/code/code.jsp?c=1&s=21";           
			var x = document.getElementsByTagName('script')[0];          
			x.parentNode.insertBefore(s, x);      
		}       
	if (window.attachEvent)           
	window.attachEvent('onload', async_load);
	else 
	window.addEventListener('load', async_load, false); 
	if(typeof customNum == "undefined") {
		var dt = new Date();
		customNum = "GUEST@" + dt.getHours() + dt.getMinutes() + dt.getSeconds() + "|||||||||||";
	}
	hjUserData=customNum; 
	})();
   </script>
	
	<style>
	html,body {height:100%;position:relative;overflow-x:hidden;}
	.footer {position:absolute;bottom:0;}
	.j-ui-miniwindow {width:590px;}
	</style>
	
	
</head>
<body>
    
    <div class="header">
	<div class="g_33">
		<h1 class="logo"><a title="首页" href="/index">PH158</a></h1>
	</div>
</div>    
    <!-- step-num star -->
    <div class="step-num">
        <ul>
            <li ><i class="step-num-1">1</i>输入用户名</li>
            <li class="current"><i class="step-num-2">2</i>选择找回密码方式</li>
            <li ><i class="step-num-3">3</i>重置密码</li>
            <li ><i class="step-num-4">4</i>完成</li>
        </ul>
    </div>
    <!-- step-num end -->
    
    <div class="g_33">
			<div class="find-select-content">
                        <strong class="highbig">您正在找回登录密码的账号是：<span class="highlight">zw0222</span>，请选择您准备找回登录密码的方式：</strong>
            <ul class="find-select-list">
                                <li class="disable">
                    <i class="ico-mail"></i>
                    <p>通过绑定的邮箱找回登录密码<br /></p>
                    <span>(未绑定，不可用)</span>
                </li>
                                                <li class="disable">
                    <i class="ico-safequestion"></i>
                    <p>通过回答“安全问题”找回登录密码</p>
                    <span>(未绑定，不可用)</span>
                </li>
                                                <li>
                    <i class="ico-safecode"></i>
                    <p>通过安全密码找回登录密码</p>
                    <a id="J-button-safePassword" href="?stp=4" class="btn">立即找回<b class="btn-inner"></b></a>
                </li>
                            </ul>
            <p>上面的方式都不可用？您还可以通过<a title="客服" id="custom-service" href="javascript:void(0);" />在线客服</a>进行人工申诉找回登录密码。</p>
            
            <div class="pop w-7" style="position: fixed; left: 50%; z-index: 1001; top: 50%; margin-top: -77.5px; margin-left: -186px; display: none;" id="divNoType">
	<div class="hd"><i class="close" name="divCloseUrl"></i>提示</div>
	<div class="bd">
		<h4 class="pop-title">安全问题连续三次错误，请30分钟后再试</h4>
		<div class="pop-btn">
			<a href="javascript:void(0);" class="btn btn-important " name="J-but-close">确 定<b class="btn-inner"></b></a>
		</div>
	</div>
</div>
			
		<script id="J-safePassword-tpl" type="text/html-tmpl"> 
                    <ul class="ui-form">
                        <li>
                            <label class="ui-label" for="verifyCode">输入安全密码：</label>
                            <input type="password" class="input" id="J-safePassword" value="" name="safepwd">
                            <div class="ui-check"><i class="error"></i>请输入安全密码</div>
                        </li>
                        <li class="ui-btn"><a id="J-submit-safePassword" href="#" class="btn">下一步<b class="btn-inner"></b></a></li>
                    </ul>
		</script>

<script>
(function($){
	var minWindow,mask,initFn;
		minWindow = new phoenix.MiniWindow();
		mask = phoenix.Mask.getInstance();
		minWindow.addEvent('beforeShow', function(){
			mask.show();
		});
		minWindow.addEvent('afterHide', function(){
			mask.hide();
		});
	initFn = function(){
		var safePassword = $('#J-safePassword'),
			v_safePassword;
		
		v_safePassword = new phoenix.Validator({el:safePassword,type:'password',expands:{showSuccessMessage:function(msg){
			$('.ui-check', this.dom.parent()).css('display', 'none');
		},showErrorMessage:function(msg){
			$('.ui-check', this.dom.parent()).html('<i class="error"></i>' + msg).css('display', 'inline');
		}}});
		
		$('#J-submit-safePassword').click(function(e){
			e.preventDefault();
			v_safePassword.validate();
			if(v_safePassword.validated){
				$.ajax({
					url:'?stp=4&act=1',
					dataType:'json',
					method:'POST',
					data:{safepwd:v_safePassword.getValue()},
					success:function(data){
						var errors;
						if(data['isSuccess']){
							location.href = '?stp=5';
						}else{
							errors = data['errors'];
							$.each(errors, function(){
								var err = this;
								if(err[0] == 'safepwd'){
									v_safePassword.showErrorMessage(err[1]);
								}
							});
						}
					},
					error:function(xhr, type){
						
					}
				});
			}
		});
	};
	  $("#custom-service").click(function(){
		   if(typeof hj5107 != "undefined")
		   {
			 hj5107.openChat();
		   }
	 });
	$('#J-button-safePassword').click(function(e){
		e.preventDefault();
		minWindow.setTitle('请填写您的安全密码');
		minWindow.setContent($('#J-safePassword-tpl').html());
		minWindow.show();
		initFn();
	});
})(jQuery);
</script>

			

	<script id="J-safequestions-tpl" type="text/html-tmpl"> 
                    <ul class="ui-form set-safeissue">
                        <li>
                            <label class="ui-label" for="question1">问题一：</label>
                            <select id="J-question1" name="questId" class="ui-select" data-sort="一">
								<option value="">请选择安全问题一</option>
															</select>
							<div class="ui-check"><i class="error"></i>请选择安全问题一</div>
                        </li>
                        <li>
                            <label class="ui-label" for="answer1">答案：</label>
                            <input type="text" class="input" id="J-answer1" name="questAns" value="">
                            <div class="ui-check"><i class="error"></i>请输入答案</div>
                        </li>
                        <li>
                            <label class="ui-label" for="question2">问题二：</label>
                            <select id="J-question1" name="questId2" class="ui-select" data-sort="二">
								<option value="">请选择安全问题二</option>
															</select>
							<div class="ui-check"><i class="error"></i>请选择安全问题二</div>
                        </li>
                        <li>
                            <label class="ui-label" for="answer2">答案：</label>
                            <input type="text" class="input" id="J-answer2" name="questAns2" value="">
                            <div class="ui-check"><i class="error"></i>请输入答案</div>
                        </li>
                        <li class="ui-btn"><a href="#" class="btn" id="J-submit-safequestion">下一步<b class="btn-inner"></b></a></li>
                    </ul>
	</script>
    <script id="J-safequestions-error" type="text/html-tmpl"> 
		<ul class="ui-form set-safeissue">
		    <li> 
		      <h4 class="pop-title">安全问题连续三次错误，请30分钟后再试</h4>
			</li>
			<li><div class="pop-btn"><a href="#" class="btn btn-important" id="J-submit-error">确定<b class="btn-inner"></b></a></div></li>
		</ul>
	</script>

<script>
(function($){
	var minWindow,mask,initFn,
		//安全问题最多允许填写次数
		quErrMaxTimes = 10;
		
	//$(function(){
		minWindow = new phoenix.MiniWindow();
		mask = phoenix.Mask.getInstance();
		minWindow.addEvent('beforeShow', function(){
			mask.show();
		});
		minWindow.addEvent('afterHide', function(){
			mask.hide();
		});
	//});

	$('#J-button-safequestion').click(function(e){
		e.preventDefault();
		minWindow.setTitle('请填写您的安全问题');
		minWindow.setContent($('#J-safequestions-tpl').html());
		minWindow.show();
		initFn();
	});
	

	initFn = function(){
		var cont = $('.set-safeissue'),selects = cont.find('.ui-select'),allOpts = selects.eq(0).find('option'),selValues = [],
			answer1 = $('#J-answer1'),
			answer2 = $('#J-answer2'),
			v_answer1,
			v_answer2,
			answerSuccess,
			answerError,
			vGroup,
			reBuildOptions = function(sel, v){
				var sels = selects.not(sel),_sel,_v,oldSelValue,arrStr;
	
				sels.each(function(){
					_sel = $(this);
					oldSelValue = _sel.val();
					arrStr = ['<option value="">请选择安全问题'+ _sel.attr('data-sort') +'</option>'];
					allOpts.each(function(i){
						if(i > 0){
							_v = this.getAttribute('value');
							if($.inArray(_v, selValues) < 0 || _sel.val() == _v){
								arrStr.push('<option value="'+ _v +'">'+ $.trim(this.innerHTML) +'</option>');
							}
						}
					});
					_sel.html(arrStr.join(''));
					_sel.val(oldSelValue);
				});
			};
		
		//安全问题校验
		answerSuccess = function(msg){
			$('.ui-check', this.dom.parent()).css('display', 'none');
			$('.ui-check-right', this.dom.parent()).show();
		};
		answerError = function(msg){
			$('.ui-check', this.dom.parent()).html('<i class="error"></i>' + msg).css('display', 'inline');
			$('.ui-check-right', this.dom.parent()).hide();
		};
		v_answer1 = new phoenix.Validator({el:answer1,type:'safeAnswer',expands:{showSuccessMessage:answerSuccess,showErrorMessage:answerError}});
		v_answer2 = new phoenix.Validator({el:answer2,type:'safeAnswer',expands:{showSuccessMessage:answerSuccess,showErrorMessage:answerError}});
		
		selects.change(function(){
			var me = this,v = $.trim(me.value);
			if(v == ''){
				$('.ui-check', me.parentNode).css('display', 'inline');
			}else{
				$('.ui-check', me.parentNode).hide();
			}
			selValues = [];
			selects.each(function(){
				selValues.push(this.value);
			});
			reBuildOptions(me, v);
		});
	
		vGroup = [];
		vGroup.push(v_answer1);
		vGroup.push(v_answer2);
		$('#J-submit-safequestion').click(function(e){
			var passNum = 0;
			//quErrTimes = !!quErrTimes ? quErrTimes : 0;
			//if(quErrTimes > quErrMaxTimes){
				//alert('您的安全问题验证错误次数过多，请24小时之后再试！');
				//return false;
			//}
			e.preventDefault();
			$.each(vGroup, function(){
				this.validate();
				if(this.validated){
					passNum++;
				}
			});
			selects.each(function(){
				var me = $(this);
				if(me.val() != ''){
					passNum++;
					$('.ui-check', me.parent()).hide();
				}else{
					$('.ui-check', me.parent()).css('display', 'inline');
				}
			});
			if(passNum >= (vGroup.length + selects.size())){
				$.ajax({
					url:'?stp=3&act=1',
					dataType:'json',
					method:'POST',
					data:{questId:selects.get(0).value,questId2:selects.get(1).value,questAns:v_answer1.getValue(),questAns2:v_answer2.getValue()},
					success:function(data){
						if(data['isSuccess']){
							location.href = '?stp=5';
						}else{
							//$.cookie('quErrTimes', quErrTimes+1, {expires:1});
							$.each(data['errors'], function(){
								var err = this;
								if(err[0] == 'ansError'){
									v_answer1.showErrorMessage(err[1]);
								}else if(err[0] == 'ansError1'){
									v_answer2.showErrorMessage(err[1]);
								} else{
									minWindow.setTitle('提示');
									minWindow.setContent($('#J-safequestions-error').html());
									minWindow.show();
									$("#J-submit-error").click(function(){
										minWindow.hide();
									});
								}
							});

						}
					},
					error:function(xhr, type){
						alert('网络异常，请联系客服！');
					}
				});
			}else{
				return false;
			}
		});
	};


	
	
})(jQuery);
</script>

			
			
			
			
            			
			</div>

    </div>
    
    ﻿</body>
<div class="footer footer-bottom">
		<div class="g_33 text-center">
			<span>&copy;2003-2014 如意彩 All Rights Reserved</span>
		</div>
		<div class="g_33" style="display:none;">
		<!-- <center>运行时间:0.09067798</center> -->
		</div>
	</div>
</html>    



<script>
(function($){
    var footer = $('#footer');
    footer.css('position','fixed');
    if($(document).height()>$(window).height()){
        footer.css('position','static');
    }
	
})(jQuery);
</script>


</body>
</html>