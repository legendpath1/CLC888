<?php
/**
 * 后台请求
 * @param string $key 接口关键字，参考paymentapi.conf.php
 * @param array $params 参数数组
 * @return array
 */
class ApiRequest{

	public static $errno = 0;
	
	public static $error = '';
	
	public static $httpCode = 0;
	
	public static $timeout = 20;
	const APPLY_TOKEN_RETRY_COUNT = 1;
	public static function request()
	{
		$config = self::getConfig();
		if (empty($config))
		{
			return array();
		}
	
		//拼接请求参数
		$params = $_REQUEST;
		if (empty($params))
		{
			return array();
		}
		$paramsJson = json_encode($params, JSON_UNESCAPED_UNICODE);
		$url = $config['url'];
		self::log("Request. url:$url, params:$paramsJson");
	
		//发起请求，记录请求时间
		$retryCount = empty($config['retry']) ? 1 : self::REQUEST_API_RETRY_COUNT;
	
		for ($i = 0; $i < $retryCount; $i++)
		{
			if ($i > 0)
			{
				self::log("Request retry. key:, times:$i, cost:{$requestCost}s, code:$code, error:$error", "error");
			}
	
			$requestStart = microtime(true);
			$response = self::post($url, $params);
	
			$requestCost = round(microtime(true) - $requestStart, 3);
			$code = self::$httpCode;
			$error = self::$error;
			self::log("Response. cost:{$requestCost}s, code:$code, error:$error, ret:".strip_tags($response));
			self::log(print_r($response,true));
	
			if (!empty($response))
			{
				break;
			}
		}
	
		//解密
// 		$result = Aes::decode($response, self::aesKeyConvert(self::getConfig('AES_KEY')));
// 		self::log("Aes decode. result:$result");
	
		$resultArray = json_decode($response, true);
		if (empty($resultArray))
		{
			self::log("Resquest failed. cost:{$requestCost}s, code:$code, error:$error", "error");
			return array();
		}
	
		return $resultArray;
	}
	
	
	/**
	 * 申请Token
	 */
	public static function applyToken()
	{
		//获取接口Url
		$tokenConfig = self::getConfig() ;
		$url = $tokenConfig['url'];
	
		//参数拼接
		$params = $_REQUEST;
	
		//请求, 失败重试3次
		for ($i = 0; $i < self::APPLY_TOKEN_RETRY_COUNT; $i++)
		{
			if ($i > 0)
			{
				self::log("Apply token retry. times:$i, cost:{$requestCost}s, code:$code, error:$error");
			}
	
			$requestStart = microtime(true);
			$response = self::post($url, $params);
			$requestCost = round(microtime(true) - $requestStart, 3);
			$code = self::$httpCode;
			$error = self::$error;
			self::log("Apply token response. cost:{$requestCost}s, code:$code, error:$error, url:$url, params:".json_encode($params).", response:$response");
	
			if (!empty($response))
			{
				break;
			}
		}
	
		//处理结果
		$resultArray = json_decode($response, true);
		$token = isset($resultArray['result']) ? $resultArray['result'] : '';
	
		if (empty($token))
		{
			self::log("Apply token failed. code:$code, error:$error", "error");
			return '';
		}
	
		echo $token;
	}
	/**
	 * 拼接参数
	 */
	private static function getParams($config, $params)
	{
		//申请Token
		$token = self::applyToken($config, $params);
		if (empty($token))
		{
			return array();
		}
		//拼接参数
		$params = array_merge($params ,  $config["params"]);
		$params['token'] = $token;
		$params['merchantId'] = self::getConfig('MERCHANT_ID');
		$params['sign'] = self::getSignature($params);
	
		return $params;
	}
	
	public static function getConfig() {
		$content = file_get_contents ( '../file/config.ini' );
		$str = str_replace ( "\n", "&", str_replace ( "\r", "", $content ) );
		$array = array ();
		parse_str ( $str, $array );
		return $array;
	}

	/**
	 * 日志记录
	 */
	public static function log($body,$level="")
	{
		error_log($body);
	}
	
	/**
	 * curl get请求
	 *
	 * @param string $url GET请求地址
	 *
	 * @return mixed
	 */
	public static function get($url,$flag = false) {
		if(empty($url)){
			return false;
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_TIMEOUT, self::$timeout);
		curl_setopt($ch, CURLOPT_USERAGENT, '');
		curl_setopt($ch, CURLOPT_REFERER,'');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
		if (substr($url, 0, 5) === 'https')
		{
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  //信任任何证书
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //检查证书中是否设置域名
		}
	
		$result = curl_exec($ch);
	
		self::$errno = curl_errno($ch);
		self::$error = curl_error($ch);
		self::$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
		curl_close($ch);
		if($flag) {
			return array('msg'=>$result,'code'=>self::$errno);
		}
		return $result;
	}
	
	/**
	 * curl post 请求
	 * @param string $url
	 * @param array $param
	 */
	public static function post($url, $param=array()) {
		if (empty($url)) {
			return false;
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param));
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, self::$timeout);
		curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
		if (substr($url, 0, 5) === 'https')
		{
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  //信任任何证书
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //检查证书中是否设置域名
		}
	
		$result = curl_exec($ch);
		
		self::$errno = curl_errno($ch);
		self::$error = curl_error($ch);
		self::$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
		curl_close($ch);
		return $result;
	}
}

$type = $_REQUEST['type'];
switch ($_REQUEST['type']) {
	case 'token':
		if($_REQUEST['bizType']) {
			unset($_REQUEST['bizType'],$_REQUEST['type']);
		}
		ApiRequest::applyToken();
		break;
	case 'request':
		
		break;
	default:
		break;
}
