<?php 
session_start();
error_reporting(0);
$_SESSION["mainframe"] = '"./help_general.php"'; 
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<head>
    <title>娱乐平台  - 常见问题</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
        <link href="./css/v1/help.css?modidate=20130201001" rel="stylesheet" type="text/css" />
    <script>var pri_imgserver = '';</script>
        <script language="javascript" type="text/javascript" src="./js/jquery.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/common.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/lottery/min/message.js?modidate=20130415002"></script>
        <script LANGUAGE='JavaScript'>function ResumeError() {return true;} window.onerror = ResumeError; </script> 
</head>
<body>
<div id="rightcon">
<div id="msgbox" class="win_bot" style="display:none;">
    <h5 id="msgtitle"></h5> <div class="wb_close" onclick="javascript:msgclose();"></div>
    <div class="clear"></div>
    <div class="wb_con">
            <p id="msgcontent"></p>
    </div>
    <div class="clear"></div>
    <a class="wb_p" href="#" onclick="javascript:prenotice();" id="msgpre">上一条</a><a class="wb_n" href="#" onclick="javascript:nextnotice();">下一条</a>
</div><script type="text/javascript">
$(function(){
    $("#tab").find("span").click(function(){
        $("#tab").find("span").attr("class","u_tab_no");
        $(this).attr("class","u_tab_hover");
        var id = $(this).attr("id").split("_");
        $(".news_list").hide();
        $("#content_"+id[1]).show();
    });
});
</script>
</head>
<body>
<div class=" game_rc" style="width:98%;"> 
    <div class="gm_con help_con">
        <div class="gm_con_lt"></div>
        <div class="gm_con_rt"></div>
        <div class="gm_con_lb"></div>
        <div class="gm_con_rb"></div>
        <div class="help_menu" id="help_menu">
            <a class="act" href="./help_general.php"><strong>常见问题</strong></a>
            <a  href="./help_game.php"><strong>玩法介绍</strong></a>
            <a  href="./help_fun.php"><strong>功能介绍</strong></a>
        </div>
        <div class="gm_con_to">
            <div class="rc_con_title"></div>
            <div class="tz_body">
                <div class="unit">
                    <div class="unit_title">
                        <div class="ut_l"></div>
                        <div class="u_tab_div" id="tab">
                                                        <span id="tab_0" class="u_tab_hover"><a>常见问题</a></span>
                                                        <span id="tab_1" class="u_tab_no"><a>工行充值说明</a></span>
                                                        <span id="tab_2" class="u_tab_no"><a>建行充值说明</a></span>
                                                        <span id="tab_3" class="u_tab_no"><a>农行充值说明</a></span>
                                                        <span id="tab_4" class="u_tab_no"><a>平台提现说明</a></span>
                                                        <span id="tab_5" class="u_tab_no"><a>平台免责申明</a></span>
                                                    </div>
                        <div class="ut_r"></div>
                    </div>
                    <div id="tabCon">
                        <div class="tabcon_n">
                                                        <ul id="content_0" class="news_list" style="display:block" >
                                <li>
                                    <!--<ul>     如何识别域名是否归属本平台？
    <li>通过唯一的域名验证网址<a href="http://www.xysssc.com">www.xysssc.com</a>验证域名是否属于本平台；</li>
    <li>使用在<a href="http://www.xysssc.com">www.xysssc.com</a>验证通过的网址登陆账号，在账户中心的修改密码中设置&ldquo;登陆问候语&rdquo;，设置后每次登陆平台都会提示此问候语，问候语与您  设置的一致，则是正确网址，反之则是仿冒平台。</li>
</ul>-->
<ul>登陆过程中跳转到谷歌界面？
    <li>用户名输入错误导致。</li>
    <li>帐号不存在。</li>
    <li>当前域名为非系统指定域名，请联系上级或客服获取最新域名。</li>
</ul>
<ul>忘记密码怎么办？
    <li>登录密码遗忘，可通过资金密码在平台登陆口重新设定登录密码。</li>
    <li>资金密码遗忘，但有登录密码请联系在线客服协助处理。</li>
    <li>建议您初始拿到帐号请到平台&ldquo;账户中心&rdquo;进行登陆密码、资金密码、登陆问候语的设定；并请妥善保管好您的资金密码，如果资金密码和  登录密码遗忘将无法再修改和找回密码。</li>
</ul>
<ul>平台充值限额及服务时间？
    <li>&ldquo;工行在线充值&rdquo;
    <p>服务时间：每日上午09:00至次日凌晨02:00。</p>
    <p>充值限额：单笔最低充值50，最高充值40000。</p>
    </li>
    <li>&ldquo;建行在线充值&rdquo;
    <p>服务时间：每日上午09:00至次日凌晨22:00。</p>
    <p>充值限额：单笔最低充值100，最高充值40000。</p>
    </li>
    <li>&ldquo;农行在线充值&rdquo;
    <p>服务时间：每日上午09:00至次日凌晨02:00。</p>
    <p>充值限额：单笔最低充值100，最高充值40000。</p>
    </li>
</ul>
<ul>平台提现限额及服务时间？
    <li>平台提现支持&ldquo;工商银行&rdquo;、&ldquo;农业银行&rdquo;、&ldquo;建设银行&rdquo;。
    <p>服务时间：每日上午10:00至次日凌晨02:00。</p>
    <p>提现限额：单笔最低提现100，最高提现50000。</p>
    </li>
</ul>
<ul>
    <p>为什么提现需要手续费？<br />
    单笔提现金额100及100以上，并且投注额达到2天累计充值金额的10%后，提现免手续费。</p>
</ul>
<ul>为什么充值没有即时到帐？     以下几点都会引起您的充值不能到账，如果出现以下问题，请及时联系在线客服并提供银行回单截图。
    <li>汇款时未使用平台提供的最新银行信息；</li>
    <li>汇款时附言（充值编码）填写错误或者未填写；</li>
    <li>平台填写金额与实际汇款金额不一致；</li>
    <li>建行在线充值时未使用绑定在平台的建行卡进行支付；</li>
    <li>充值时间在平台服务时间外。</li>
</ul>
<ul>游戏撤单问题？
    <li>任何彩种游戏的撤单都必须在停止投注之前进行，当期投注时间截止后将无法再进行撤单操作；</li>
    <li>追号单的撤单需要到&ldquo;追号任务信息&rdquo;里面进行终止任务。</li>
</ul>
<ul>什么是&ldquo;奖金限额&rdquo;？平台奖金限额是多少？
    <li>每个账号在同一游戏、同一玩法、同一奖期中购买相同号码的最大可中奖金额。</li>
    <li>高频彩（时时彩、时时乐、11选5）的奖金限额30万，低频彩（3D、排列三/五）的奖金限额10万。</li>
</ul>
<ul>关于第3方开奖机构不开奖问题？
    <p>所有游戏，如遇第3方开奖机构不开奖，平台会对未获得开奖号码的期数进行撤单返款。撤单后无论第三方以任何形式补开，平台均维持撤单处理。</p>
</ul>
<ul>什么是动态奖金返点？
    <p>在投注的时候，会有个&ldquo;选择奖金返点&rdquo;，即动 态奖金返点。动态奖金返点是根据用户自身的返点，然后利用舍弃返点，来提高中奖金额的一种模式。</p>
    <p>比如您重庆时时彩的前三直选的奖金是1700，返点是 5%，那么在投注的时候可以选择动态奖金1800，返点0%。这种情况下如果您中奖，那么奖金便是1800。</p>
</ul>
<p>&nbsp;</p>                                </li>
                            </ul>
                                                        <ul id="content_1" class="news_list" style="display:none" >
                                <li>
                                    <p><span style="color: rgb(255, 0, 0); ">在充值之前，请认真阅读充值使用说明，以确保整个充值流程不发生错误，充值能正常到账。</span></p>
<ul>第一步：
    <p>点击前台【<strong>充值</strong>】或【<strong>充值提现</strong>】，选择【<strong>自动充值</strong>】，然后选择&ldquo;中国工商银行&rdquo;，输入充值金额，然后点击下一步。</p>
</ul>
<ul>第二步：
    <p>获取到平台最新的工行<strong>&ldquo;收款账户名</strong>&rdquo;，&ldquo;<strong>收款账号(E-mail)</strong>&rdquo;，&ldquo;汇款附言&rdquo; 等信息。</p>
    <p><span style="color: rgb(255, 0, 0); ">平台会不定期更换收款银行卡，请在汇款前确认最新的收款卡信息，如果汇款到非最新的收款卡而导致的损失与本平台无关。</span></p>
</ul>
<ul>第三步：
    <p>登录中国工商银行网上银行，然后点击【<strong>转账汇款</strong>】。</p>
</ul>
<ul>第四步：
    <p>在转账汇款页面的左侧菜单栏选择【<strong>E-mail汇款</strong>】。</p>
</ul>
<ul>第五步：
    <p>按以下图解对应填入相关信息：</p>
    <img src="./images/help/icbc.png" alt="" /> </ul>
    <ul>第六步：
        <p>然后提交并确认信息，输入U盾密码等步骤完成工行汇款。</p>
    </ul>
    <ul>第七步：
        <p>汇款完成后回到平台查看到账情况，自动充值一般1分钟内到账。</p>
        <p>如果5分钟内未到账，请提供您的汇款银行，汇款金额，汇款回单号给在线客服进行核实处理。</p>
    </ul>                                </li>
                            </ul>
                                                        <ul id="content_2" class="news_list" style="display:none" >
                                <li>
                                    <p><span style="color: rgb(255, 0, 0); ">在充值之前，请认真阅读充值使用说明，以确保整个充值流程</span><span style="color: rgb(255, 0, 0); ">不发生错误，充值能正常到账</span><span style="color: rgb(255, 0, 0); ">。</span></p>
<ul>第一步：
    <p>点击前台<strong>【充值】</strong>或<strong>【充值提现】</strong>，选择<strong>【自动充值】</strong>，然后选择<strong>&ldquo;中国建设银行&rdquo;</strong>，选择一张您绑定在平台的建行卡，输入充值金额，然后点击下一步。</p>
</ul>
<ul>第二步：
    <p>获取到平台最新的建设银行的<strong>&ldquo;收款账户名&rdquo;，&ldquo;<span style="color: rgb(0, 0, 255);">收款账号</span>&rdquo; </strong>等信息。</p>
    <p><span style="color: rgb(255, 0, 0); ">平台会不定期更换收款银行卡，请在汇款前确认最新的收款卡信息，如果汇款到非最新的收款卡而导致的损失与本平台无关。</span></p>
</ul>
<ul>第三步：
    <p>使用您刚才选择的绑定在平台的建行卡，登录中国建设银行网上银行，，然后点击<span style="color: rgb(0, 0, 255);"><strong>【转账汇款】</strong></span>选择<span style="color: rgb(0, 0, 255);">&ldquo;<b>活期转账汇款</b></span>&rdquo;。</p>
    <p>第四步：</p>
</ul>
<ul>
    <p>按以下图解对应填入相关信息：</p>
    <p><img src="./images/help/ccb.png" alt="" /></p>
    <p>&nbsp;</p>
</ul>
<ul>第五步：
    <p>然后点击&ldquo;下一步&rdquo;并确认信息，输入U盾密码等步骤完成建行汇款。</p>
</ul>
<ul>第六步：
    <p>汇款完成后到平台查看到账情况，自动充值一般1分钟内到账。</p>
    <p>如果5分钟内未到账，请提供您的<strong>汇款银行，汇款金额，汇款卡号</strong>后8位给在线客服进行核实处理。</p>
</ul>
<p>&nbsp;</p>                                </li>
                            </ul>
                                                        <ul id="content_3" class="news_list" style="display:none" >
                                <li>
                                    <p><span style="color: rgb(255, 0, 0); ">在充值之前，请认真阅读充值使用说明，以确保整个充值流程</span><span style="color: rgb(255, 0, 0); ">不发生错误，充值能正常到账</span><span style="color: rgb(255, 0, 0); ">。</span></p>
<ul>第一步：
    <p>点击前台<strong>【充值】</strong>或<strong>【充值提现】</strong>，选择<strong>【自动充值】</strong>，然后选择&ldquo;中国农业银行&rdquo;，输入充值金额，点击&ldquo;下一步&rdquo;。</p>
</ul>
<ul>第二步：
    <p>获得平台最新的农行<strong>&ldquo;收款账户名&rdquo;、&ldquo;收款账号&rdquo;、&ldquo;开户身份&rdquo;、&ldquo;附言编号（转账用途）&rdquo;等信息</strong>。</p>
    <p><span style="color: rgb(255, 0, 0); ">平台会不定期更换收款银行卡，请在汇款前确认最新的收款卡信息，如果汇款到非最新的收款卡而导致的损失与本平台无关。</span></p>
</ul>
<ul>第三步：
    <p>登录中国农业银行网上银行，然后点击<strong>【转账汇款】</strong>选择<strong>&ldquo;单笔转账&rdquo;</strong>。</p>
</ul>
<ul>第四步：
    <p>按以下图解对应填入相关信息：</p>
</ul>
<ul>第五步：
    <p>然后提交并确认信息，输入U盾密码等步骤完成农行汇款。</p>
    <img src="./images/help/abc.png" alt="" /> </ul>
    <ul>第六步：
        <p>汇款完成后到平台查看到账情况，自动充值一般1分钟内到账。</p>
        <p>如果5分钟内未到账，请提供您的<strong>汇款银行，汇款金额，付款编号，汇款时间</strong>给在线客服进行核实处理。</p>
    </ul>                                </li>
                            </ul>
                                                        <ul id="content_4" class="news_list" style="display:none" >
                                <li>
                                    <ul>第一步：
    <p>进入<strong>【账户中心】</strong>选择<strong>【我的银行卡】</strong>，然后进行<strong>&ldquo;绑定银行卡&rdquo;</strong>操作，如果已有绑定的银行卡，可以跳过这一步。</p>
</ul>
<ul>第二步：
    <p>填写要<strong>&ldquo;提现金额&rdquo;</strong>、选择已绑定在平台的<strong>&ldquo;收款银行卡&rdquo;</strong>，然后点击下一步。</p>
</ul>
<ul>第三步：
    <p>在确认页面，确认提现涉及的所有信息，包括：<strong>实扣金额，到账金额</strong>，以及<strong>提现银行卡</strong>信息是否正确，如无误，则提交。</p>
</ul>
<ul>第四步：
    <p>查看<strong>&ldquo;提现记录&rdquo;</strong>，并跟踪处理情况，如果系统已处理好转账，提现记录中的申请状态会变为<strong>&ldquo;提现成功&rdquo;</strong>。</p>
</ul>
<ul>第五步：
    <p>根据提现银行卡，到具体的银行查看到账情况。</p>
</ul>                                </li>
                            </ul>
                                                        <ul id="content_5" class="news_list" style="display:none" >
                                <li>
                                    <p>尊敬的客户：为避免在游戏平台使用中可能发生的各种争议，请会员与代理在开始使用本平台前，仔细阅读下述内容，客户开始使用平台即被视为已接受所有协议与规定。</p>
<p>1、会员与代理有责任确保自己的帐户、登陆和资金密码、银行卡资料的保密性，在符合网站规定下的所有投注，都被视为有效。若会员或代理账户被盗用后，所进行的投注或因此导致的损失，本公司将不承担任何责任。若您发现或怀疑自己的资料被盗用，请立即通知在线客服，并立即更改密码。</p>
<p>2、本平台的开奖数据完全来源于具有公信力的第三方公布的有效开奖结果，如发生因开奖机构引起的开奖异常，本公司将不承担任何责任。</p>
<p>3、本平台只支持个人网上银行及时到账的汇款方式，不支持任何跨行转账、手机转账、ATM转账等，如果使用非个人网银及时到账的汇款方式而导致的损失，本公司将不承担任何责任。</p>
<p>4、平台会不定期更换收款银行卡，客户在充值前有义务确认本平台收款银行账户，如因客户向平台汇款时，汇入错误银行卡或者非最新收款卡而导致的损失，本公司将不承担任何责任。</p>
<p>5、本平台敬请广大客户选择平台提供的自动充值方式直接与公司进行充值汇款，并请客户慎重选择代理代充，如果由于使用代理代充而导致的损失，本公司将不承担任何责任。</p>
<p>（<strong>所谓代充是指：代理提供自己的银行账号给下级用户，下级将钱汇款到上级指定的银行账号中，收到汇款后，上级给下级用户的平台账号加游戏币</strong>。）</p>
<p>6、本平台保有修订、更新和修改本条款和游戏规则的权利。任何修订、更新和修改将在平台上公布，客户在上述修订、更新和修改公布后，继续使用本平台进行游戏时，则视为客户同意并接受本平台对免责申明的修订、更新和修改。<br />
&nbsp;</p>                                </li>
                            </ul>
                                                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>
<div class="rc_con">
    <div class="rc_con_lt"></div>
    <div class="rc_con_rt"></div>
    <div class="rc_con_lb"></div>
    <div class="rc_con_rb"></div>
    <div class="rc_con_to">
    	<table width=100% border="0" cellspacing="0" cellpadding="0">
            <tr><td height="25" align="center">浏览器建议：首选IE 8.0,Chrome浏览器，其次为火狐浏览器,尽量不要使用IE6。</td></tr>
            <tr><td height="25" align="center">资金安全建议：为了您的资金安全请定期更换资金密码。</td></tr>
        </table>
    </div>
</div>

</div>

</body>
</html>