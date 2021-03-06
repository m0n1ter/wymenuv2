<?php
/**
 * 
 * 
 * @author 
 * 支付宝网关 公共函数
 *
 */
class AlipayGatewayUnit {
	public static function writeLog($text) {
		// $text=iconv("GBK", "UTF-8//IGNORE", $text);
		$text = self::characet ( $text );
		file_put_contents ( Yii::app()->basePath . "/data/log.txt", date ( "Y-m-d H:i:s" ) . "  " . $text . "\r\n", FILE_APPEND );
	}
	
	//转换编码
	public static function characet($data) {
		if (! empty ( $data )) {
			$fileType = mb_detect_encoding ( $data, array (
					'UTF-8',
					'GBK',
					'GB2312',
					'LATIN1',
					'BIG5' 
			) );
			if ($fileType != 'UTF-8') {
				$data = mb_convert_encoding ( $data, 'UTF-8', $fileType );
			}
		}
		return $data;
	}
	
	/**
	 * 使用SDK执行接口请求
	 * @param unknown $request
	 * @param string $token
	 * @return Ambigous <boolean, mixed>
	 */
	public static function aopclient_request_execute($request, $token = NULL) {
		global $config;
		require 'config.php';
		$aop = new AopClient ();
		$aop->gatewayUrl = $config ['gatewayUrl'];
		$aop->appId = $config ['app_id'];
		$aop->rsaPrivateKeyFilePath = $config ['merchant_private_key_file'];
		$aop->apiVersion = "1.0";
		$result = $aop->execute ( $request, $token );
// 		writeLog("response: ".var_export($result,true));
		return $result;
	}
	
	public static function sendPostRequst($url, $data) {
		$postdata = http_build_query ( $data );
		// 		print_r($postdata);
		$opts = array (
				'http' => array (
						'method' => 'POST',
						'header' => 'Content-type: application/x-www-form-urlencoded',
						'content' => $postdata
				)
		);
	
	
		$context = stream_context_create ( $opts );
	
		$result = file_get_contents ( $url, false, $context );
		return $result;
	}
	
	public static function getRequest($key) {
		$request = null;
		if (isset ( $_GET [$key] ) && ! empty ( $_GET [$key] )) {
			$request = $_GET [$key];
		} elseif (isset ( $_POST [$key] ) && ! empty ( $_POST [$key] )) {
			$request = $_POST [$key];
		}
		return $request;
	}
}