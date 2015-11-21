<?php
session_start();
error_reporting(0);
require_once 'conn.php';
$sql = "select * from ssc_zbills WHERE  dan='" . $_REQUEST['id'] . "'";
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<head>
    <title>娱乐平台  - 追号详情</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
        <link href="./css/v1/all.css?modidate=20130201001" rel="stylesheet" type="text/css" />
    <script>var pri_imgserver = '';</script>
        <script language="javascript" type="text/javascript" src="./js/jquery.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/common.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/dialog/jquery.dialogUI.js?modidate=20130415002"></script>
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
</div><script>
    jQuery(document).ready(function(){
        $("#checkall").click(function(){
            $(":input").attr("checked",$("#checkall").attr("checked"));
        });
        $("a[rel='projectinfo']").click(function(){
            me = this;
            $pid = $(this).attr("name");
            $.blockUI({
                message: '<div style="width:200px;padding:10px 100px;background-color:#fff;border:4px #666 solid;"><img src="./images/comm/loading.gif" style="margin-right:10px;">正在读取投注详情...</div>',
                overlayCSS: {backgroundColor: '#000000',opacity: 0.3,cursor:'wait'}
            });
            $.ajax({
                type: 'POST',
                url : 'history_playinfo.php',
                data: "id="+$pid,
                success : function(data){//成功
                    $.unblockUI({fadeInTime: 0, fadeOutTime: 0});
                    try{
                        eval("data = "+ data +";");
                        if( data.stats == 'error' ){
                            $.alert('<IMG src="./images/comm/t.gif" class=icons_mb5_e style="margin:5px 15px 0 0;">'+data.data);
                        }else{
                            data = data.data;
                            stat = '未开奖';
                            if(data.project.iscancel==0){
                                if(data.project.isgetprize==0){
                                    stat = '未开奖';
                                }else if(data.project.isgetprize==2){
                                    stat = '未中奖';
                                }else if(data.project.isgetprize==1){
                                    if(data.project.prizestatus==0){
                                        stat = '未派奖';
                                    }else{
                                        stat = '已派奖';
                                    }
                                }
                            }else if(data.project.iscancel==1){
                                stat = '本人撤单';
                            }else if(data.project.iscancel==2){
                                stat = '管理员撤单';
                            }else if(data.project.iscancel==3){
                                stat = '开错奖撤单';
                            }
                            $.blockUI_lang.button_sure = '关&nbsp;闭';
                            html = '<table class="zdinfo" border=0 cellspacing=0 cellpadding=0>';
                            html += '<tr><td width=30%>游戏用户：<span>'+data.project.username+'</span></td><td width=25%>游戏：<span>'+data.project.cnname+'</span></td><td width=45% colspan=2>总金额：<span>'+data.project.totalprice+'</span></td></tr>';
                            html += '<tr><td>注单编号：<span>'+data.project.projectid+'</span></td><td>玩法：<span>'+data.project.methodname+'</span></td><td>注单状态：<span>'+stat+'</span></td><td>&nbsp;&nbsp;&nbsp;&nbsp;倍数模式：<span>'+data.project.multiple+'倍, '+ data.project.modes +'模式</span></td></tr>';
                            html += '<tr><td>投单时间：<span>'+data.project.writetime+'</span></td><td>奖期：<span>'+data.project.issue+'</span></td><td>注单奖金：<span>'+data.project.bonus+'</span></td><td>';
                            if( data.project.dypointdec.length>2 ){
                                html += '动态奖金返点：<span>'+data.project.dypointdec+'</span>';
                            }else{
                                html += '&nbsp;';
                            }
                            if(data.project.nocode != ""){
                                html += '</td></tr><td width=18% colspan=4 >开奖号码：<span>'+data.project.nocode+'</span>';
                            }else{
                                html += '</td></tr><td width=18% colspan=4 >开奖号码：<span>---</span>';
                            }
                            html += '</td></tr><tr><td colspan=4 STYLE="height:50px;">投注内容：<textarea class=t1 READONLY=TRUE style="width:790px;margin-bottom:5px;height:50px;">'+data.project.code+'</textarea></td></tr>';
                            html +='</table>';
                            //实际中奖情况显示内容
                            if(typeof(data.projectprize) !== 'undefined'){
                                html += '<div class="title">实际中奖情况：</div>';
                                html += '<table class="zdinfo" border=0 cellspacing=0 cellpadding=0><tr class=th><td width=150>奖级名称</td><td width=60><div class=line></div>中奖注数</td><td><div class=line></div>单注奖金</td><td width=90><div class=line></div>倍数</td><td width=150><div class=line></div>总奖金(注数*奖金*倍数)</td></tr>';
                                $.each(data.projectprize.detail,function(i,k){
                                    html += '<tr class=d><td style="cursor:pointer;" title="'+k.levelcodedesc+'">'+k.leveldesc+'</td><td>'+k.times+'</td><td>'+k.singleprize+'</td><td>'+k.multiple+'</td><td>'+k.prize+'</td></tr>';
                                });
                                html += '</table>';
                            }else{//可能中奖情况显示内容
                                if( data.can == 1 ){
                                    html += '<div class="title">&nbsp;&nbsp;<input type="button" value="&nbsp;撤&nbsp;单&nbsp;" class="button yh" id="cancelproject"></div>';
                                }
                                html += '<div class="title">可能中奖情况：</div>';
                                html += '<table class="zdinfo" border=0 cellspacing=0 cellpadding=0><tr class=th><td width=150>奖级名称</td><td><div class=line></div>号码</td><td width=45><div class=line></div>倍数</td><td width=45><div class=line></div>奖级</td><td width=90><div class=line></div>奖金</td></tr>';
                                $.each(data.prizelevel,function(i,k){
                                    html += '<tr class=d><td style="cursor:pointer;" title="'+k.levelcodedesc+'">'+k.leveldesc+'</td><td>'+(k.expandcode.length > 60 ? '<textarea READONLY=TRUE style="width:386px;height:50px;">'+k.expandcode+'</textarea>' :k.expandcode)+'</td><td>'+k.codetimes+'</td><td>'+k.level+'</td><td>'+k.prize+'</td></tr>';
                                });
                                html += '</table>';
                            }
                            $.alert(html,'投注详情','',820,false);
                            $("#cancelproject").click(function(){
                                if(confirm("真的要撤单吗?"+(data.need==1 ? "\n撤销此单将收取撤单手续费金额:"+data.money+"元." : ""))){
                                    $.blockUI({
                                        message: '<div style="width:200px;padding:10px 100px;background-color:#fff;border:4px #666 solid;"><img src="./images/comm/loading.gif" style="margin-right:10px;">正在提交撤单请求...</div>',
                                        overlayCSS: {backgroundColor: '#000000',opacity: 0.3,cursor:'wait'}
                                    });
                                    $.ajax({
                                        type: 'POST',
                                        url : 'history_playcancel.php',
                                        data: "id="+data.project.projectid,
                                        success : function(data){//成功
                                            $.unblockUI({fadeInTime: 0, fadeOutTime: 0});
                                            try{
                                                eval("data = "+ data +";");
                                                if( data.stats == 'error' ){
                                                    $.alert('<IMG src="./images/comm/t.gif" class=icons_mb5_e style="margin:5px 15px 0 0;">'+data.data);
                                                }else{
                                                    $(me).closest("tr").find("td:eq(2)").html("已取消");
                                                    $.alert('<IMG src="./images/comm/t.gif" class=icons_mb5_s style="margin:5px 15px 0 0;">撤单成功');
                                                }
                                            }catch(e){
                                                $.alert('<IMG src="./images/comm/t.gif" class=icons_mb5_e style="margin:5px 15px 0 0;">撤单失败，请梢后重试');
                                            }
                                        }
                                    });
                                }
                            });
                        }
                    }catch(e){
                        $.alert('<IMG src="./images/comm/t.gif" class=icons_mb5_e style="margin:5px 15px 0 0;">读取数据出错，请重试');
                    }
                }
            });
        });
    });
    function cancel(){
        if($(":input[name='taskid[]'][checked=true]").size()==0){
            $.alert('<IMG src="./images/comm/t.gif" class=icons_mb5_n style="margin:5px 15px 0 0;">请选择要终止追号的奖期.');
            return false;
        }else{
            $.confirm('<IMG src="./images/comm/t.gif" class=icons_mb5_q style="margin:0 15px 0 0;">真的要终止追号任务吗？',function(){
                $("#Form").submit();
            },function(){
                return false;
            } 
            ,'',240);
        }
    }
</script>

<div class="rc_con ac_list">
    <div class="rc_con_lt"></div>
    <div class="rc_con_rt"></div>
    <div class="rc_con_lb"></div>
    <div class="rc_con_rb"></div>
    <h5><div class="rc_con_title">追号详情</div></h5>
    <div class="rc_con_to">
        <div class="rc_con_ti">
            <div class="rc_list">
                <div class="rl_list">
                    <table class='lt' width="100%" border=0 cellpadding=2 cellspacing=0 style="table-layout:fixed;">
                        <tr><td width="200" height="37" class=nl>追号编号：</td><td><?=$row['dan']?></td>
                        <td height="37" class=nl>游戏用户：</td><td><?=$row['username']?></td></tr>
                        <tr><td height="37" class=nl>追号时间：</td><td><?=$row['adddate']?></td>
                        <td height="37" class=nl>游戏：</td><td><?=$row['lottery']?></td></tr>
                        <tr><td height="37" class=nl>玩法：</td><td><?=$row['mname']?></td><td height="37" class=nl>模式：</td>
                        <td><?=$row['mode']?></td></tr>
                        <tr><td height="37" class=nl>开始期号：</td><td><?=$row['issue']?></td>
                        <td height="37" class=nl>追号期数：</td><td><?=$row['znums']?>期</td></tr>
                        <tr><td height="37" class=nl>完成期数：</td><td><?=$row['fnums']?>期</td>
                        <td height="37" class=nl>取消期数：</td><td><?=$row['cnums']?>期</td></tr>
                        <tr><td height="37" class=nl>追号总金额：</td><td><?=$row['money']?></td>
                        <td height="37" class=nl>完成金额：</td><td><?=$row['fmoney']?></td></tr>
                        <tr><td height="37" class=nl>中奖期数：</td><td><?=$row['zjnums']?></td>
                        <td height="37" class=nl>派奖总金额：</td><td><?=$row['prize']?></td></tr>
                        <tr><td height="37" class=nl>取消金额：</td><td><?=$row['cmoney']?></td><td height="37" class=nl>中奖后终止任务：</td><td><?php if($row['autostop']=="yes"){echo "是";}else{echo "否";}?></td></tr>
                        <tr><td height="37" class=nl>追号内容：</td><td style="word-break:break-all;white-space:normal; width:85%;overflow:hidden;word-wrap:break-word;"><?=dcode($row['codes'],$row['lotteryid'])?></td><td height="37" class=nl>追号状态：</td><td><?php if($row['zt']==0){echo "进行中";}else{echo "已完成";}?></td></tr>
                        <tr><td height="37" ></td><td colspan="3" class="close"><input type="button" class='button yh' value="关闭" onclick="self.close();">&nbsp;<?php if($row['zt']==0){?><input type="button" class='button yh' value="终止追号" onclick="cancel()"><?php }?></td></tr>
                    </table>
                </div>
            </div>
            <br>
            <div class="rc_list">
                <form id="Form" action="./history_taskcancel.php" method="post">
                    <input type="hidden" name="id" value="<?=$row['dan']?>" />
                    <div class="rl_list">
                        <table class='lt' width="100%" border=0 cellpadding=0 cellspacing=0>
                            <tr>
                                <th><div><label style="cursor:pointer;"><input type="checkbox" id="checkall"> 奖期</label></div></th>
                            <th align="center"><div class='line'>追号倍数</div></th>
                            <th align="center"><div class='line'>追号状态</div></th>
                            <th align="center"><div class='line'>注单详情</div></th>
                            </tr>
<?php
$sqla = "select * from ssc_zdetail WHERE  dan='" . $_REQUEST['id'] . "' order by id asc";
$rsa = mysql_query($sqla);
	while ($rowa = mysql_fetch_array($rsa)){
?>
                            <tr>
                                <tr align="center" class='needchangebg'>
                                <td height="37"><?php if($rowa['canceldead']>date("Y-m-d H:i:s") && $rowa['zt']<2){?><input type="checkbox" name="taskid[]" value="<?=$rowa['id']?>"><?php }?><?=$rowa['issue']?></td>
                                <td><?=$rowa['times']?>倍</td>
                                <td><?php if($rowa['zt']==0){echo "进行中";}else if($rowa['zt']==1){echo "已完成";}else if($rowa['zt']==2){echo "已取消";}?></td>
                                <td><?php if($rowa['zt']==1){?><a href="javascript:" rel="projectinfo" name="<?=$rowa['danb']?>" class="blue">详情</a><?php }?></td>
                            </tr>
<?php }?>
                        </table>
                    </div>
                </form>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
</div>

</div>
</body>
</html>