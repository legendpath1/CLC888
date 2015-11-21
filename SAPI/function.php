<?php
function iif($a,$b,$c)
{
	if($a)
	{
		return $b;
	}
	else
	{
		return $c;
	}
}

function RemoveHTML($str)
{
	return strip_tags($str);
}
function RemoveHTML_($str,$b)
{
    $reg = '/(<\/?p>|<br\s*\/?>)|<.+?>/i';
    return preg_replace($reg,'$1',$str);
}

function shortStringCn($instr,$len)
{
	$str = $instr;
	for($i=0;$i<$len;$i++)
	{
		$temp_str=substr($str,0,1);
		if(ord($temp_str) > 127)
		{
			$i++;
			if($i<$len)
			{
				$new_str[]=substr($str,0,3);
				$str=substr($str,3);
			}
		}
		else
		{
			$new_str[]=substr($str,0,1);
			$str=substr($str,1);
		}
	}
	$rstr = join($new_str);
	if(strlen($instr) > strlen($rstr)){$rstr .= '..';}
	return $rstr;
}

function shortString($str, $len)
{
	return substr($str, 0, $len);
}

function okinfo($url,$langinfo)
{
	HintAndTurn($langinfo,$url);
}

function HintAndTurn($langinfo,$url)
{
	echo("<script language='javascript'> alert('$langinfo'); location.href='$url'; </script>");
	exit();
}

function hintAndBack($info,$num)
{
	echo("<script language='javascript'> alert('$info'); history.go(-$num); </script>");
	exit();
}

function HintAndTurnTopFrame($message,$gourl)
{
	echo("<script language='javascript'>alert('$message');window.top.location.href='$gourl';</script>");
}

function HintAndTurnReloadLeft($message,$gourl)
{
	echo("<script language='javascript'>alert('$message');window.parent.leftFrame.location.reload();location.href='$gourl';</script>");
}

function turnToPage($url)
{
	echo("<script type='text/javascript'> location.href='$url'; </script>");
	exit;
}

function replace($y,$old,$new)
{
	return str_replace($old,$new,$y);
}

function mid($m,$s,$e)
{
	if($m.length>=0)
	{
		return substr($m,$s,$e);
	}
	else
	{
		return "";
	}
}

function right($str,$len)
{
	$strLen = strlen($str);
	if($len > $strLen)
		return $str;
	else
		return substr($str,$strLen-$len,$len);
}

function classNameToFolder($cN)
{
	$temp = replace($cN,"&","-");
	$temp = replace($temp," ","-");
	$temp = replace($temp,"(","-");
	$temp = replace($temp,")","-");
	$temp = replace($temp,"---","-");
	$temp = replace($temp,"--","-");
	if(left($temp,1) == "-")
	{
		$temp = right($temp,strlen($temp)-1);
	}
	if(right($temp,1) == "-")
	{
		$temp = left($temp,strlen($temp)-1);
	}
	
	return $temp;
}

function len($str)
{
	return (strlen($str) + mb_strlen($str,"UTF8")) / 2;	
}

function lCase($str)
{
	return strtolower($str);
}

function uCase($str)
{
	return strtoupper($str);
}

function getUserIP()
{
    if ($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"])  
    {  
    	$ip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];  
    }  
    elseif ($HTTP_SERVER_VARS["HTTP_CLIENT_IP"])  
    {  
   	 $ip = $HTTP_SERVER_VARS["HTTP_CLIENT_IP"];  
    }
    elseif ($HTTP_SERVER_VARS["REMOTE_ADDR"])  
    {  
    	$ip = $HTTP_SERVER_VARS["REMOTE_ADDR"];  
    }  
    elseif (getenv("HTTP_X_FORWARDED_FOR"))  
    {  
    	$ip = getenv("HTTP_X_FORWARDED_FOR");  
    }  
    elseif (getenv("HTTP_CLIENT_IP"))  
    {  
    	$ip = getenv("HTTP_CLIENT_IP");  
    }  
    elseif (getenv("REMOTE_ADDR"))
    {  
    	$ip = getenv("REMOTE_ADDR");  
    }  
    else  
    {  
    	$ip = "Unknown";  
    }
    
    return $ip;
}

function returnTextarea($str)
{
    return nl2br($str);
}


function writeVideoPlay($strUrl,$strWidth,$StrHeight)
{
	if($strUrl != "")
	   $Exts = substr($strUrl,strrpos($strUrl,"."));
	else
	   $Exts = "";
	
	if($Exts == "" )return ;
	switch($Exts)
	{
		case ".flv":
			echo '<object type="application/x-shockwave-flash" data="/flash/vcastr3.swf" width="' . $strWidth . '" height="' . $StrHeight . '" id="myPlayer">';
			echo '<param name="movie" value="/flash/vcastr3.swf"/> ';
			echo '<param name="allowFullScreen" value="true" />';
			echo '<param name="FlashVars" value="xml=';
			echo '	<vcastr>';
			echo '		<channel>';
			echo '			<item>';
			echo '				<source>' . $strUrl . '</source>';
			echo '				<duration></duration>';
			echo '				<title></title>';
			echo '			</item>';
			echo '		</channel>';
			echo '		<config>';
			echo '		</config>';
			echo '		<plugIns>';
			echo '			<logoPlugIn>';
			echo '				<url>/flash/logoPlugIn.swf</url>';
			echo '				<logoText></logoText>';
			echo '				<logoTextAlpha>0.75</logoTextAlpha>';
			echo '				<logoTextFontSize>30</logoTextFontSize>';
			echo '				<logoTextLink></logoTextLink>';
			echo '				<logoTextColor>0xffffff</logoTextColor>';
			echo '				<textMargin>20 20 auto auto</textMargin>';
			echo '			</logoPlugIn>';
			echo '		</plugIns>';
			echo '	</vcastr>"/>';
			echo '</object>';
			break;
		case ".swf":
			echo "		<object id='myPlayer' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0' width='$strWidth' height='$StrHeight'>		  <param name='movie' value='$strUrl'>		  <param name='quality' value='high'>		  <embed src='$strUrl' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='$strWidth' height='$StrHeight'></embed>		</object>";
			break;
		case "rm":
		case "ra":
		case "ram":
			echo "<OBJECT id='myPlayer' height='$strHeight' width='$strWidth' classid='clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA'>";
			echo "<PARAM NAME='_ExtentX' VALUE='12700'><PARAM NAME='_ExtentY' VALUE='9525'><PARAM NAME='AUTOSTART' VALUE='-1'><PARAM NAME='SHUFFLE' VALUE='0'>";
			echo "<PARAM NAME='PREFETCH' VALUE='0'><PARAM NAME='NOLABELS' VALUE='0'><PARAM NAME='SRC' VALUE='$strUrl'><PARAM NAME='CONTROLS' VALUE='ImageWindow'>";
			echo "<PARAM NAME='CONSOLE' VALUE='Clip'><PARAM NAME='LOOP' VALUE='0'><PARAM NAME='NUMLOOP' VALUE='0'><PARAM NAME='CENTER' VALUE='0'><PARAM NAME='MAINTAINASPECT' VALUE='0'>";
			echo "<PARAM NAME='BACKGROUNDCOLOR' VALUE='#000000'></OBJECT><BR><OBJECT height='50' width='$strWidth' classid='clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA'>";
			echo "<PARAM NAME='_ExtentX' VALUE='12700'><PARAM NAME='_ExtentY' VALUE='847'><PARAM NAME='AUTOSTART' VALUE='0'><PARAM NAME='SHUFFLE' VALUE='0'><PARAM NAME='PREFETCH' VALUE='0'>";
			echo "<PARAM NAME='NOLABELS' VALUE='0'><PARAM NAME='CONTROLS' VALUE='ControlPanel,StatusBar'><PARAM NAME='CONSOLE' VALUE='Clip'><PARAM NAME='LOOP' VALUE='0'>";
			echo "<PARAM NAME='NUMLOOP' VALUE='0'><PARAM NAME='CENTER' VALUE='0'><PARAM NAME='MAINTAINASPECT' VALUE='0'><PARAM NAME='BACKGROUNDCOLOR' VALUE='#000000'>";
			echo "</OBJECT>";
			break;
		default:
			//"avi","wmv","asf","mov"
			echo '<object id="myPlayer" height="' . $StrHeight . '" width="' . $strWidth . '" classid="CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6">';
			echo '    <param NAME="AutoStart" VALUE="0">';
			echo '    <param NAME="Balance" VALUE="0">';
			echo '    <param name="enabled" value="-1">';
			echo '    <param NAME="EnableContextMenu" VALUE="-1">';
			echo '    <param NAME="url" VALUE="' . $strUrl . '">';
			echo '    <param NAME="PlayCount" value="9999">';
			echo '    <param name="rate" value="1">';
			echo '    <param name="currentPosition" value="0">';
			echo '    <param name="currentMarker" value="0">';
			echo '    <param name="defaultFrame" value="">';
			echo '    <param name="invokeURLs" value="0">';
			echo '    <param name="baseURL" value="">';
			echo '    <param name="stretchToFit" value="0">';
			echo '    <param name="volume" value="50">';
			echo '    <param name="mute" value="0">';
			echo '    <param name="uiMode" value="Full">';
			echo '    <param name="windowlessVideo" value="0">';
			echo '    <param name="fullScreen" value="0">';
			echo '    <param name="enableErrorDialogs" value="-1">';
			echo '    <param name="SAMIStyle" value>';
			echo '    <param name="SAMILang" value>';
			echo '    <param name="SAMIFilename" value>';
			echo '</object>';
		break;
	}
}


function inject_check($sql_str) {
//	if(strtoupper($sql_str)=="UPDATETIME" ){
//		return eregi('select|insert|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile', $sql_str);    // 进行过滤
//	}else{	
//		return eregi('select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile', $sql_str);    // 进行过滤
//	}
	return eregi('\'|\*', $sql_str);
}  
function daddslashes($string, $force = 0, $strip= FALSE) {
	!defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
	if(!MAGIC_QUOTES_GPC || $force) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = daddslashes($val, $force);
			}
		} else {
			$string = addslashes($strip? stripslashes($string) : $string);
		}
	}
	
//  sql注入式攻击过滤
//	if(inject_check($string) && $strip){
//	$reurl="http://".$_SERVER["HTTP_HOST"];	
//	echo("<script type='text/javascript'> alert('Please Stop SQL Injecting！'); location.href='$reurl'; <");
//	echo("/script>");
//	die("Please Stop SQL Injecting！");
//	}

//	if($id!=""){
//	if(!is_numeric($id)){
//	$reurl="http://".$_SERVER["HTTP_HOST"];
//	echo("<script type='text/javascript'> alert('Parameter Error！'); location.href='$reurl'; <");
//	echo("/script>");
//	die("Parameter Error！");
//	}}

    //$string = str_replace("%", "\%", $string);     // 把 '%'过滤掉     
	return $string;
}

function formatTimeMD($date)
{
	return date('m-d',strtotime($date));
}
function formatTimeYMD($date)
{
	return date('Y-m-d',strtotime($date));
}

function isIdCard($number)
{
    //加权因子 
    $wi = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
    //校验码串 
    $ai = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
    //按顺序循环处理前17位 
    for ($i = 0;$i < 17;$i++) { 
        //提取前17位的其中一位，并将变量类型转为实数 
        $b = (int) $number{$i}; 
 
        //提取相应的加权因子 
        $w = $wi[$i]; 
 
        //把从身份证号码中提取的一位数字和加权因子相乘，并累加 
        $sigma += $b * $w; 
    }
    //计算序号 
    $snumber = $sigma % 11; 
 
    //按照序号从校验码串中提取相应的字符。 
    $check_number = $ai[$snumber];
 
    if ($number{17} == $check_number) {
        return true;
    } else {
        return false;
    }
}

function isMoveTel($mobilephone)
{
	//手机号码的正则验证    
	if(preg_match("/^13[0-9]{1}[0-9]{8}$|15[0189]{1}[0-9]{8}$|189[0-9]{8}$/",$mobilephone)){    
		//验证通过
		return true;
	}else{    
		//手机号码格式不对
		return false;
	} 
}

//取地址栏值
function GetUrl($action)
{
	$fullUrl = 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
	$parseurlinfo = parse_url($fullUrl);//Array ( [scheme] => http [host] => 127.0.0.1 [port] => 8080 [path] => /web/main.php [query] => a=1&b=2 )
	$pathinfo = pathinfo(basename($fullUrl));//Array ( [dirname] => . [basename] => main.php?a=1&b=2 [extension] => php?a=1&b=2 [filename] => main )
	switch($action)
	{
		case 1:
			//赋“http://”+域名(非80端口则含端口)
			if($_SERVER["SERVER_PORT"] == 80)
			{
				return 'http://' . $_SERVER['SERVER_NAME'];
			}
			else
			{
				return 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER["SERVER_PORT"];
			}
		case 2:
			//赋文件名
			return replace($pathinfo['basename'],'?' . $parseurlinfo['query'],'');
		case 3:
			//赋地址栏参数
			return $parseurlinfo['query'];
		case 4:
			//赋文件名+地址栏参数（不以“/”开始）
			return $pathinfo['basename'];
		case 5:
			//赋目录及文件名（以“/”开始）
			return $parseurlinfo[path];
		case 6:
			//赋“http://”+域名+目录及文件名
			return GetUrl(1) . GetUrl(5);
		default:
			//赋整个地址栏值
			return $fullUrl;
	}
}

function cutstr($string, $length, $charset,$dot = ' ...') {
    //$charset = 'utf-8';

    if(strlen($string) <= $length) {
        return $string;
    }

    $string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);

    $strcut = '';
    if(strtolower($charset) == 'utf-8') {

        $n = $tn = $noc = 0;
        while($n < strlen($string)) {

            $t = ord($string[$n]);
            if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                $tn = 1; $n++; $noc++;
            } elseif(194 <= $t && $t <= 223) {
                $tn = 2; $n += 2; $noc += 2;
            } elseif(224 <= $t && $t <= 239) {
                $tn = 3; $n += 3; $noc += 2;
            } elseif(240 <= $t && $t <= 247) {
                $tn = 4; $n += 4; $noc += 2;
            } elseif(248 <= $t && $t <= 251) {
                $tn = 5; $n += 5; $noc += 2;
            } elseif($t == 252 || $t == 253) {
                $tn = 6; $n += 6; $noc += 2;
            } else {
                $n++;
            }

            if($noc >= $length) {
                break;
            }

        }
        if($noc > $length) {
            $n -= $tn;
        }

        $strcut = substr($string, 0, $n);

    } else {
        for($i = 0; $i < $length; $i++) {
            $strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
        }
    }

    $strcut = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);

    return $strcut.$dot;
}

function rndStr($num)
{
	$str = 'abcdefghijklmnopqrstuvwxyz0123456789';  
	$radomstring = ''; 
	for ($x = 0; $x < $num; $x++)   
	{   
		$str[$x] = substr($str, mt_rand(0,strlen($str)-1),1); 
		
		$radomstring .= $str[$x];
	}   
	return $radomstring;
}

function StringToFile($str,$file_name)
{
  $handle=fopen($file_name,"w"); //写入方式打开新闻路径  
  fwrite($handle,$str); //把刚才替换的内容写进生成的HTML文件  
  fclose($handle);
}

function footer(){	
	global $db;
	$db->close();
}

function vita_get_url_content($url) {
	$file_contents = file_get_contents($url);
	if(empty($file_contents)){
		$ch = curl_init();
		$timeout = 5; 
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$file_contents = curl_exec($ch);
		curl_close($ch);
	}
	return $file_contents;
}

function get_ip(){
	if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}else{
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}