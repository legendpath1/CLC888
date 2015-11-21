<?php
function Create_SAPI_Url($username, $password, $newpassword, $nickname, $num, $action)
{
	global $WEBURL_QP;
	$KEY = 'rSjakvDiAvFJe41dgD23oAGDJNBa';

	//---检测传递过来的当前时间：必须60秒内方为有效操作，超过60秒，视为搜索引擎抓取的数据，全部无效
	//设置当前为东八区（北京时间）
	date_default_timezone_set('Etc/GMT-8');
	
	$date = date("Y-m-d H:i:s");
	$time = date("Y-m-d H:i:s",strtotime("$date +180 second"));
	$sign = md5($KEY . $username . $time);
	
	$url = $WEBURL_QP . '/SAPI/action.aspx?time=' . urlencode($time);
	$url .= '&username=' . urlencode($username);
	$url .= '&password=' . urlencode($password);
	$url .= '&newpassword=' . urlencode($newpassword);
	$url .= '&nickname=' . urlencode($nickname);
	$url .= '&num=' . urlencode($num);
	$url .= '&sign=' . urlencode($sign);
	
	//$action = 'login';//reg login logout changepwd getgold_money changegold_money
	
	$url .= '&action=' . $action;

	return $url;
}

function SAPI_ChangeGold_Gold($username,$num)
{
	$url = Create_SAPI_Url($username, '', '', '', $num, 'changegold_gold');
	
	$html = FCurlGet($url);
	
	$arr = json_decode($html); 
	$arr = FObjectToArray($arr);
	
	return $arr;
}

function SAPI_GetMemberGolds($username)
{
	$url = Create_SAPI_Url($username, '', '', '', 0, 'getmember_gold');
	
	$html = FCurlGet($url);
	
	$arr = json_decode($html); 
	$arr = FObjectToArray($arr);
	
	return $arr;
}

function SAPI_ChangePassword2($username,$password,$newpassword)
{
	//pwd都是md5后的
	$url = Create_SAPI_Url($username, $password, $newpassword, '', 0, 'changepwd2');
	
	$html = FCurlGet($url);
	
	$arr = json_decode($html); 
	$arr = FObjectToArray($arr);
	
	return $arr;
}

function SAPI_ChangePassword($username,$password,$newpassword)
{
	//pwd都是md5后的
	$url = Create_SAPI_Url($username, $password, $newpassword, '', 0, 'changepwd');
	
	$html = FCurlGet($url);
	
	$arr = json_decode($html); 
	$arr = FObjectToArray($arr);
	
	return $arr;
}

function SAPI_Reg($username, $password, $newpassword, $nickname)
{
	$url = Create_SAPI_Url($username, $password, $newpassword, $nickname, 0, 'reg');
	
	$html = FCurlGet($url);
	//$html = iconv("gb2312","utf-8//IGNORE",$html);
	
	$arr = Split_SAPI_Result($html);
	
	return $arr;
	
//	echo $url;
//	echo "\r\n\r\n";
//	echo $html;
//	echo "\r\n\r\n";
//	print_r($arr);
//	exit();
	
//	if ($arr[0] != 'SUCCESS')
//	{
//
//	}
}

function SAPI_GetMemberInfo($username)
{
	$url = Create_SAPI_Url($username, '', '', '', 0, 'getmember_info');
	
	$html = FCurlGet($url);
	
	$arr = json_decode($html); 
	$arr = FObjectToArray($arr);
	
	return $arr;
}


function Split_SAPI_Result($str)
{
	$arr = explode('|',$str);

	if (count($arr) < 2)
		$arr = explode('FAIL|未知错误',$str);

	return $arr;
}

function FObjectToArray($array){
	if(is_object($array)){
		$array = (array)$array;
	}
	if(is_array($array)){
		foreach($array as $key=>$value){
			$array[$key] = FObjectToArray($value);
		}
	}
	return $array;
}

function FCurlGet($url)
{
	//初始化
	$ch = curl_init();

	//设置选项，包括URL
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);

	//执行并获取HTML文档内容
	$output = curl_exec($ch);
	
	//释放curl句柄
	curl_close($ch);
	
	//打印获得的数据
	return $output;
}

function FStrLeft($str,$len)
{
	$strLen = strlen($str);
	if($len > $strLen)
		return $str;
	else
		return substr($str,0,$len);
}

function FHintAndBack($info)
{
	echo("<script language='javascript'> alert('$info'); history.go(-1); </script>");
	exit();
}

function FHintAndTurn($langinfo,$url)
{
	echo("<script language='javascript'> alert('$langinfo'); location.href='$url'; </script>");
	exit();
}