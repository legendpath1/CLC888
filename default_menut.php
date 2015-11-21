<?php
session_start();
error_reporting(0);
require_once 'conn.php';

	$sqla="select * from ssc_member where username='".$_SESSION["username"]."'";
	$rsa=mysql_query($sqla) or  die("数据库修改出错!!!!");
	$rowa = mysql_fetch_array($rsa);
	if(empty($rowa)){
		//退出
//		$lmoney="0.00";
	}else{
		$lmoney=$rowa['leftmoney'];
	}
	
$flag=$_REQUEST['flag'];
if($flag=="getmoney"){
	echo " {\"money\":\"".round($lmoney,4)."\"}";
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>左侧菜单</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <script language="javascript" type="text/javascript" src="./js/jquery.js?modidate=20130415002"></script>
        <script language="javascript" type="text/javascript" src="./js/common.js?modidate=20130415002"></script>
                <script language='javascript'>function ResumeError() {return true;} window.onerror = ResumeError; </script>
        <link href="./css/v1/left.css" rel="stylesheet" type="text/css" />
        <script language="javascript" type="text/javascript">
            $(function(){
                $(".menu_con").find("a").click(function(){
                    $(this).siblings().removeClass("active");
                    $(this).addClass("active");
                });
                var bFlag = false;
                $.fn.updatenickname = function () {
                    var newnickname = $("#showname").val();
                    if (newnickname == ""){
                        alert("请填写新的呢称") ;
                        return false;
                    }
                    $.ajax({
                        type : 'POST',
                        url  : './users_edit.php',
                        data : 'flag=update&type=ajax&nickname=' + newnickname,
                        timeout : 8000,
                        success : function(data){
                            if(data == '操作成功'){
                                $("#nickname").html(newnickname);
                                nickname= newnickname;
                                bFlag = false;
                            }else{
                                alert(data);
                            }
                        }
                    });
                }
                var nickname = '<?=$rowa['nickname']?>';
                $("#nickname").click(function(){
                    if (bFlag == false){
                        var content = $("<input type='text' name='nickname' id='showname' style='width:80px' value='"+nickname + "' />");
                        $("#nickname").html(content);
                        content.focus();

                        $("#showname").blur(function(){
                            $("#showname").updatenickname();
                        });

                        $(document).keydown(function(event) { 
                            if (event.keyCode == 13) { 
                                $("#showname").updatenickname();
                            } 
                        }); 
                        bFlag = true;
                    }
                });
                var isopen = false;
                $("#userswitch").click(function(){
                    if( isopen == true ){
                        isopen = false;
                        $("#refreshimg").fadeIn('fast');
                    }else{
                        isopen = true;
                        $("#refreshimg").fadeOut('fast');
                    }
                });
                $("#refreshimg").click(function(){
                    $("#leftusermoney").html("<font color='#CCFF00'>载入中</font>");
                    fastData();
                });
            });
        </script>
    </head>
    <body>
        <div id="leftcon">
            <div class="user_inf">
                <h4 class="menu_head"><a class="ext" href="./default_logout.php" onclick="javascript:return confirm('您确定要退出平台吗?');" target="_top"></a></h4>
                <div class="clear"></div>
                <div class="ui_con">
                    <table width="159" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="65" valign="middle" class="user_img" title="点击隐藏余额"><a href="#" id="userswitch"></a></td>
                            <td valign="middle"  id="nickname" title="点击修改昵称"><?=$rowa['nickname']?></td>
                        </tr>
                    </table>
                    <div class="ye" id="refreshimg" title="点击刷新余额">
                        <div style="" id="addmoney"></div>
                        <div class="ye_title"></div>
                        <div class="nub nubf"></div>
                        <input type="hidden" name="usermoney" id="usermoney" value="<?=$lmoney?>">
                        <div id="leftusermoney">
                        	<?php
								$lmoneys=floor($lmoney*100)/100;
								for($i=0;$i<strlen($lmoneys);$i++){
									$t=substr($lmoneys,$i,1);
									if($t=="."){
										echo '<div class="nub nubd"></div>';
									}else{
										echo '<div class="nub nub'.$t.'"></div>';
									}
								}
							?>
                                                </div>
                        <div class="nub"></div>
                        <div class="nub"></div>
                        <div class="nub"></div>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                    <div class="cztx">
                                                <div class="cz"><a title="充值操作" href="./account_autosave.php" target="mainframe"></a></div>
                        <div class="tx"><a title="提现申请" href="./account_draw.php" target="mainframe"></a></div>
                                                                        <div class="clear"></div>
                    </div>
                </div>
                <div class="ui_bot"></div>
            </div>
            <div class="clear"></div>
            <div class="my_menu">
                <h4 class="menu_head"></h4>
                <div class="menu_con">
			<?php 
			$sql="select * from ssc_set where zt=1 order by lid asc";
			$rsnewslist = mysql_query($sql);
			while ($row = mysql_fetch_array($rsnewslist)){
			?>
					<a target="mainframe" href="./<?=$row['urls']?>" title="<?=$row['name']?> (<?=$row['cname']?>)"><?=$row['name']?>
            <?php if($row['sign']==1){?> <span class="new">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <?php }elseif($row['sign']==2){?> <span class="hot">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><?php }?></a>
            <?php }?>
                                                        </div>
            </div>
            <div class="clear"></div>
            <div class="left_bot_box" style="position: relative;">
                <div class="left_bot"></div>
                                    <div class="downclient" style="position:absolute;top: 8px;left:20px;">
                        <a href="http://www.sj528.com/upload/WebGame.rar" target="_blank"><img src='./images/down.gif' border="0" /></a>
                    </div>
                            </div>
            <div class="clear"></div>
        </div>
    </body>
</html>