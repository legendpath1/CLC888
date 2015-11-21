<SCRIPT type="text/javascript">
//if (top.location == self.location) top.location.href = "index.php"; </script>
<?php
session_start();
error_reporting(0);
require_once 'conn.php';

if (strpos($_SESSION['flag'],'33') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

$jb=array("用户","代理","总代理"); 

$sid=$_REQUEST['sid'];
$types=$_REQUEST['types'];

$sqla="select * from ssc_drawlist where id='".$sid."'";
$rsa=mysql_query($sqla) or  die("数据库修改出错!!!!");
$rowa = mysql_fetch_array($rsa);
$did=$rowa['dan'];
$username=$rowa['username'];
$adddate=$rowa['adddate'];
$bank=$rowa['bank'];
$address=$rowa['province'].$rowa['city'];
$branch=$rowa['branch'];
$realname=$rowa['realname'];
$cardno=$rowa['cardno'];
$tmoney=$rowa['money'];
$sxmoney=$rowa['sxmoney'];
$rmoney=$rowa['rmoney'];


$sqla="select * from ssc_member where username='".$username."'";
$rsa=mysql_query($sqla) or  die("数据库修改出错!!!!");
$rowa = mysql_fetch_array($rsa);
$leftmoney=$rowa['leftmoney'];
$totalmoney=$rowa['totalmoney'];
$usedmoney=$rowa['usedmoney'];
if($rowa['vip']==1){$vip="vip";}else{$vip="";}

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$page2=($page-1)*$pagesize;

$urls="sid=".$sid."&types=".$types;

if($types==1){
	$s1=" and types=1";
}else if($types==2){
	$s1=" and (types=2 or types=3)";
}
$s1=$s1." and username='".$username."' order by id desc";
$sql="select * from ssc_record where 1=1".$s1;

$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

$sql="select * from ssc_record where 1=1".$s1." limit $page2,$pagesize";
$rsnewslist=mysql_query($sql);

$lastpg=ceil($total/$pagesize); //最后页，也是总页数
$page=min($lastpg,$page);
$prepg=$page-1; //上一页
$nextpg=($page==$lastpg ? 0 : $page+1); //下一页

if($page<5){
	$p1=1;
	$p2=min($lastpg,10);
}else{
	$p2=min($lastpg,$page+5);
	$p1=max($p2-9,1);
}
?>
<html>
<head>
<link href="css/index.css" rel="stylesheet" type="text/css">
<link href="./css/v1/all2.css?modidate=20130201001" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="js/common.js"></script>
<script language="javascript" src="js/dialog/jquery.dialogUI.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {		
        $("a[rel='projectinfo']").click(function(){
            me = this;
            $pid = $(this).html();
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
                            html += '<tr><td>注单编号：<span>'+data.project.projectid+'</span></td><td>玩法：<span>'+data.project.methodname+(data.project.taskid!=0 ? '&nbsp;<a href="history_taskinfo.php?id='+data.project.taskid+'" target="_blank" style="color:#F77;">追号单详情</a>' : '')+'</span></td><td>注单状态：<span>'+stat+'</span></td><td>&nbsp;&nbsp;&nbsp;&nbsp;倍数模式：<span>'+data.project.multiple+'倍, '+ data.project.modes +'模式</span></td></tr>';
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
                                                    $(me).closest("tr").find("td").eq(-2).html("<font color=#004891>管理员撤单</font>");
                                                    $(me).closest("tr").find("td").css("background-color","#CCCCCC");
                                                    $.alert('<IMG src="./images/comm/t.gif" class=icons_mb5_s style="margin:5px 15px 0 0;">撤单成功');
                                                    //fastData();
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
</script>
        
<base target="mainframe" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body>
<br>
    <form name="memberForm" method="post" action="account_tx.php?act=tx">
      <input type="hidden" name="sid" value="<?=$sid?>" />
      <input type="hidden" name="did" value="<?=$did?>" />
      <input type="hidden" name="uid" value="<?=$username?>" /></td>
   <table width="95%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="100" class="top_list_td">用户名</td>
        <td width="20%" class="top_list_td"><?=$username?></td>
        <td width="100" class="top_list_td">提现银行</td>
        <td width="20%" class="top_list_td"><?=$bank?></td>
        <td width="100" class="top_list_td">提现金额</td>
        <td width="20%" class="top_list_td"><?=$tmoney?></td>
     </tr>
      <tr>
        <td class="top_list_td">余额</td>
        <td class="top_list_td"><?=$leftmoney?></td>
        <td class="top_list_td">开户省市</td>
        <td class="top_list_td"><?=$address?></td>
        <td class="top_list_td">手续费</td>
        <td class="top_list_td"><?=$sxmoney?></td>
      </tr>
      <tr>
        <td class="top_list_td">总充值</td>
        <td class="top_list_td"><?=$totalmoney?></td>
        <td class="top_list_td">支行名称</td>
        <td class="top_list_td"><?=$branch?></td>
        <td class="top_list_td">到帐金额</td>
        <td class="top_list_td"><?=$rmoney?></td>
      </tr>
      <tr>
        <td class="top_list_td">总消费</td>
        <td class="top_list_td"><?=$usedmoney?></td>
        <td class="top_list_td">开户姓名</td>
        <td class="top_list_td"><?=$realname?></td>
        <td class="top_list_td">申请时间</td>
        <td class="top_list_td"><?=$adddate?></td>
      </tr>
      <tr>
        <td class="top_list_td">银行帐号</td>
        <td class="top_list_td"><?=$cardno?></td>
        <td class="top_list_td"><a href='#' TITLE='复制' onClick="javascript:copyToClipboard( 'tkinfo','【提款信息】' )" >一键复制
          </a></td>
        <td class="top_list_td"><input name="dan" type="text" value=""/><span id="tkinfo" style="display:none;">姓名：<?=$realname?> 银行：<?=$bank?> 省市：<?=$address?> 支行：<?=$branch?> 金额：<?=$rmoney?></span>
        </td>
        <td class="top_list_td"><input name="button" type="submit" class="but1" id="button2" value="审核"  onClick="return confirm('确认要审核吗?');"/></td>
        <td class="top_list_td"><input name="button" type="submit" class="but1" id="button" value="拒绝"  onClick="return confirm('确认要拒绝吗?');"/>
          &nbsp;理由：
          <input name="cont" type="text" id="cont" value="" size="10"/></td>
      </tr>
    </table>
    </form>
<br>
<a href="?sid=<?=$sid?>">全部帐变</a> <a href="?sid=<?=$sid?>&types=1">充值记录</a> <a href="?sid=<?=$sid?>&types=2">提现记录</a>
<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
        <tr>
            <td class="t_list_caption">选择</td>
            <td class="t_list_caption">帐变编号</td>
            <td class="t_list_caption">注单编号</td>
          <td class="t_list_caption">用户名</td>
          <td class="t_list_caption">时间</td>
          <td class="t_list_caption">类型</td>
            <td class="t_list_caption">游戏</td>
            <td class="t_list_caption">玩法</td>
            <td class="t_list_caption">期号</td>
            <td class="t_list_caption">模式</td>
            <td class="t_list_caption">收入</td>
            <td class="t_list_caption">支出</td>
            <td class="t_list_caption">余额</td>
            <td class="t_list_caption">备注</td>
      </tr>
        <?php
		while ($row = mysql_fetch_array($rsnewslist))
		{
	if($row['dan']==""){
		$dan=sprintf("%07s",strtoupper(base_convert($row['id'],10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));
		$sql="update ssc_record set dan='".$dan."' where id ='".$row['id']."'";  
		mysql_query($sql); 
	}else{
		$dan=$row['dan'];
	}
		?>
            <tr class="t_list_tr_0" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                <td><input name="lids[]" type="checkbox" id="checkbox2" value="<?=$row['id']?>"></td> 
                <td><?=$dan?></td>
                <td><a href="javascript:"  title="查看投注详情" class="blue" rel="projectinfo"><?=$row['dan1']?></a></td>
                <td><?=$row['username'].$vip?></td>
                <td><?=$row['adddate']?></td>
              	<td><?php if($row['types']==1){echo "账户充值";
        }else if($row['types']==2){echo "账户提现";
        }else if($row['types']==3){echo "提现失败";
        }else if($row['types']==7){echo "投注扣款";
        }else if($row['types']==9){echo "追号扣款";
        }else if($row['types']==10){echo "追号返款";
        }else if($row['types']==11){echo "游戏返点";
        }else if($row['types']==12){echo "奖金派送";
        }else if($row['types']==13){echo "撤单返款";
        }else if($row['types']==14){echo "撤单手续费";
        }else if($row['types']==15){echo "撤消返点";
        }else if($row['types']==16){echo "撤消派奖";
        }else if($row['types']==30){echo "充值扣费";
        }else if($row['types']==31){echo "上级充值";
        }else if($row['types']==32){echo "活动礼金";
        }else if($row['types']==40){echo "系统分红";
        }else if($row['types']==50){echo "系统扣款";
        }else if($row['types']==999){echo "其他";}
		?></td>
                <td><?php if($row['lottery']!=''){echo $row['lottery'];}else{echo "<font color='#D0D0D0'>---";}?></td>
                <td><?php if($row['mid']!=''){echo Get_mid($row['mid']);}else{echo "<font color='#D0D0D0'>---";}?></td>
                <td><?php if($row['issue']!=''){echo $row['issue'];}else{echo "<font color='#D0D0D0'>---";}?></td>
                <td><?php if($row['mode']<>''){echo $row['mode'];}else{echo "<font color='#D0D0D0'>---";}?></td>
                <td><?php if($row['smoney']>0){echo "<font color='#669900'>+".number_format($row['smoney'],4)."</font>";}else if($row['smoney']<0){echo "<font color='#FF3300'>".number_format($row['smoney'],4)."</font>";}else{echo "<font color='#D0D0D0'>---";}?></td>
                <td><?php if($row['zmoney']!=""){echo "<font color='#FF3300'>-".number_format($row['zmoney'],4)."</font>";}else{echo "<font color='#D0D0D0'>---";}?></td>
                <td><?=number_format($row['leftmoney'],4)?></td>
                <td><?php if($row['tag']!=''){echo $row['tag'];}else{echo "<font color='#D0D0D0'>---";}?></td>
      </tr>
 		<?php
		}
		?>

      <tr>
            <td colspan="14" class="t_list_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="170" height="35"></td>
                <td width="150"></td>
                <td><div style='text-align:right;'>总计  <?=$total?> 条数据,  共 <?=$lastpg?> 页 , 当前第 <?=$page?> 页  |  <?php if($page>1){?> <A HREF="?<?=$urls?>&page=1">首页</A> <A HREF="?<?=$urls?>&page=<?=$page-1?>">上页</A><?php }?><?php for($i=$p1;$i<=$p2;$i++){
		if($i==$page){?> <span class='Font_R'><?=$i?></span> <?php }else{?> <A HREF="?<?=$urls?>&page=<?=$i?>"><?=$i?></A> <?php }}?><?php if($page!=$lastpg){?> <A HREF="?<?=$urls?>&page=<?=$page+1?>">下页</A> <A HREF="?<?=$urls?>&page=<?=$lastpg?>">尾页</A> <?php }?> | 转至 <SCRIPT LANGUAGE="JAVASCRIPT">function keepKeyNum(obj,evt){var  k=window.event?evt.keyCode:evt.which; if( k==13 ){ goPage(obj.value);return false; }} function goPage( iPage ){ if( !isNaN(parseInt(iPage)) ) { if(iPage< 0 ){iPage=0;} window.location.href="?<?=$urls?>&page="+iPage;}}</SCRIPT><INPUT onKeyPress="return keepKeyNum(this,event);" TYPE="TEXT" ID="iGotoPage" NAME="iGotoPage" size="3"> 页  &nbsp;<BUTTON onClick="javascript:goPage( document.getElementById('iGotoPage').value );return false;">GO</BUTTON></div></td>
              </tr>
            </table></td>
      </tr>
</table>
<br>


</body>
</html> 