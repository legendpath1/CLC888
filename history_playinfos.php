<?php
session_start();
error_reporting(0);
require_once 'conn.php';
$sql = "select * from ssc_bills WHERE  dan='" . $_REQUEST['id'] . "'";
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs);

if(date("Y-m-d H:i:s")<$row['canceldead'] && $row['zt']==0){
	$can=1;
}else{
	$can=0;
}
if($row['mode']=="元"){
	$modes2=1;
}else if($row['mode']=="角"){
	$modes2=0.1;
}else{
	$modes2=0.01;
}
$codes=dcode($row['codes'],$row['lotteryid'],$row['mid']);
$sqla = "select * from ssc_class where mid='".$row['mid']."'";
$rsa = mysql_query($sqla);
$rowa = mysql_fetch_array($rsa);
$rates=explode(";",$rowa['rates']);
if(count($rates)>1){
	$sstrd=explode(";",$rowa['rates']);
	$sstre=explode(";",$rowa['jname']);
	$dypointdec="";
}else{
	$dypointdec=($row['rates']/$modes2)."-".($row['point']*100)."%";
	$sstrd=explode(";",$row['rates']/$modes2);
}
$poss=" ";
if($rowa['isrx']==1 || (($rowa['isrx']==2) && $row['type']=="input")){
	$pos=explode(",",$row['pos']);
	if($row['lotteryid']==2 || $row['lotteryid']==8 || $row['lotteryid']==9 || $row['lotteryid']==10){
		if($pos[0]==1){$poss=$poss."第一位".",";}
		if($pos[1]==1){$poss=$poss."第二位".",";}
		if($pos[2]==1){$poss=$poss."第三位".",";}
		if($pos[3]==1){$poss=$poss."第四位".",";}
		if($pos[4]==1){$poss=$poss."第五位".",";}
	}else{
		if($pos[0]==1){$poss=$poss."万位".",";}
		if($pos[1]==1){$poss=$poss."千位".",";}
		if($pos[2]==1){$poss=$poss."百位".",";}
		if($pos[3]==1){$poss=$poss."十位".",";}
		if($pos[4]==1){$poss=$poss."个位".",";}
	}
}else{
	if($rowa['isrx']==2 && $row['type']=="digital"){
		$pos=explode("|",$row['codes']);
		if($row['lotteryid']==2 || $row['lotteryid']==8 || $row['lotteryid']==9 || $row['lotteryid']==10){
			if($pos[0]!=""){$poss=$poss."第一位".",";}
			if($pos[1]!=""){$poss=$poss."第二位".",";}
			if($pos[2]!=""){$poss=$poss."第三位".",";}
			if($pos[3]!=""){$poss=$poss."第四位".",";}
			if($pos[4]!=""){$poss=$poss."第五位".",";}
		}else{
			if($pos[0]!=""){$poss=$poss."万位".",";}
			if($pos[1]!=""){$poss=$poss."千位".",";}
			if($pos[2]!=""){$poss=$poss."百位".",";}
			if($pos[3]!=""){$poss=$poss."十位".",";}
			if($pos[4]!=""){$poss=$poss."个位".",";}
		}
	}
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<head>
    <title>娱乐平台  - 注单详情</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
        <link href="./css/v1/all.css?modidate=20130201001" rel="stylesheet" type="text/css" />
    <script>var pri_imgserver = '';</script>
        <script language="javascript" type="text/javascript" src="./js/jquery.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/common.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/lottery/min/message.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/lottery/min/jquery.dialogUI.js?modidate=20130415002"></script>
    <script LANGUAGE='JavaScript'>function ResumeError() {return true;} window.onerror = ResumeError; </script> 
<script>
    function cancel(){
            $.confirm('<IMG src="./images/comm/t.gif" class=icons_mb5_q style="margin:0 15px 0 0;">真的要撤单吗？',function(){
                $("#Form").submit();
            },function(){
                return false;
            } 
            ,'',240);
    }
</script>
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
</div>
                	

<div class="rc_con ac_list">
    <div class="rc_con_lt"></div>
    <div class="rc_con_rt"></div>
    <div class="rc_con_lb"></div>
    <div class="rc_con_rb"></div>
    <h5>
      <div class="rc_con_title">注单详情</div>
    </h5>
    <div class="rc_con_to">
        <div class="rc_con_ti">
            <div class="rc_list">
                <div class="rl_list">
<form id="Form" action="./history_playcancel2.php" method="post">
                    	<input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
                    <table class='lt' width="100%" border=0 cellpadding=2 cellspacing=0 style="table-layout:fixed;">
                        <tr><td height="37" width="200" class=nl>游戏用户：</td><td class=n2><?=$row['username']?></td>
                        <td width="200" height="37" class=nl>注单编号：</td><td class=n2><?=$row['dan']?></td></tr>
                        <tr><td height="37" class=nl>游戏：</td><td class=n2><?=$row['lottery']?></td>
                        <td height="37" class=nl>投单时间：</td class=n2><td class=n2><?=$row['adddate']?></td></tr>
                        <tr><td height="37" class=nl>玩法：</td><td class=n2><?=$row['mname']?></td>
                        <td height="37" class=nl>期号：</td><td class=n2><?=$row['issue']?></td></tr>
                        <tr><td height="37" class=nl>位置：</td><td class=n2><?=$poss?></td>
                        <td height="37" class=nl>模式：</td><td class=n2><?=$row['mode']?></td></tr>
                        <tr><td height="37" class=nl>投注总金额：</td><td class=n2><?=$row['money']?></td>
                        <td height="37" class=nl>状态：</td><td class=n2><?php if($row['zt']==0){echo "未开奖";}else if($row['zt']==1){echo "已派奖";}else if($row['zt']==2){echo "未中奖";}else if($row['zt']==4){echo "管理员撤单";}else if($row['zt']==5){echo "本人撤单";}else if($row['zt']==6){echo "开错奖撤单";}?></td></tr>
                        <tr><td height="37" class=nl>注单奖金：</td><td class=n2><?=$row['prize']?></td>
                        <td height="37" class=nl>动态奖金返点：</td><td class=n2><?=$dypointdec?></td></tr>
                        <tr><td height="37" class=nl>开奖号码：</td><td class=n2><?=$row['kjcode']?></td>
                        <td height="37" class=nl>倍数：</td><td class=n2><?=$row['times']?>倍</td></tr>
                        <tr><td height="37" class=nl>注数：</td><td class=n2><?=$row['nums']?></td>
                        <td height="37" class=nl>追号：</td><td class=n2><?php if($row['dan1']!=""){?><a href="history_taskinfo.php?id=<?=$row['dan1']?>" target="_blank" style="color:#F77;">追号单详情</a><?php }else{echo "否";}?></td></tr>
                        <tr><td height="37" class=nl>投注内容：</td><td height="37" colspan="3" class=n2>
                            <textarea name="textarea" id="textarea"  READONLY=TRUE cols="90" rows="5"><?=$codes?></textarea></td>
                        </tr>
                        <tr><td height="37" ></td><td colspan="3" class="close"><input type="button" class='button yh' value="关闭" onclick="self.close();">&nbsp;<?php if($can==1 && $row['username']==$_SESSION["username"]){?><input type="button" class='button yh' value="撤单" onclick="cancel()"><?php }?></td></tr>
                    </table>
                </form>
              </div>
            </div>
<?php if($row['zt']==1){?>
            <div class="titles">实际中奖情况：</div>
            <div class="rc_list">
                    <div class="rl_list">
                        <table class='lt' width="100%" border=0 cellpadding=0 cellspacing=0>
                            <tr>
                            <th><div><label style="cursor:pointer;">奖级名称</label></div></th>
                            <th align="center"><div class='line'>中奖注数</div></th>
                            <th align="center"><div class='line'>倍数</div></th>
                            <th align="center"><div class='line'>总奖金</div></th>
                            </tr>
                            <tr>
                                <tr align="center" class='needchangebg'>
                                <td height="37"><?=$row['mname']?></td>
                                <td><?=$row['zjnums']?></td>
                                <td><?=$row['times']?>倍</td>
                                <td><?=$row['prize']?></td>
                            </tr>
                        </table>
                    </div>
            </div>
<?php }else{?>
            <div class="titles">可能中奖情况：</div>
            <div class="rc_list">
                    <div class="rl_list">
                        <table class='lt' width="100%" border=0 cellpadding=0 cellspacing=0>
                            <tr>
                            <th><div><label style="cursor:pointer;">奖级</label></div></th>
                            <th align="center"><div class='line'>奖级名称</div></th>
                            <th align="center"><div class='line'>号码</div></th>
                            <th align="center"><div class='line'>倍数</div></th>
                            <th align="center"><div class='line'>奖金</div></th>
                            </tr>
<?php		for($i=0;$i<count($sstrd);$i=$i+1){
			$prize=number_format(floatval($sstrd[$i])*$modes2*$row['times'],4);
			if(count($sstrd)==1){
				$mname=$row['mname'];
			}else{
				$mname=$sstre[$i];
			}
?>
                            <tr>
                                <tr align="center" class='needchangebg'>
                                <td height="37"><?php echo $i+1;?></td>
                                <td><?=$mname?></td>
                                <td><?php if(strlen($codes)>60){?><textarea READONLY=TRUE style="width:386px;height:50px;"><?php echo $codes;?></textarea><?php }else{echo $codes;}?></td>
                                <td><?=$row['times']?>倍</td>
                                <td><?=$prize?></td>
                            </tr>
<?php }?>
                        </table>
                    </div>
            </div>
<?php }?>
        </div>
        <div class="clear"></div>
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