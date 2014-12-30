<?php
/**
 * @target http://sdkpay.uu.cc/config/config_sms_limit
 * 
 * 
 * @author austin.yang
 * @since 2013.12.30
 */

require_once dirname( __FILE__ ) . "/conf/config.php";
require_once dirname( __FILE__ ) . "/vendor/SnsSigCheck.php";

class PUTestTXMOBILECallback extends PHPUnit_Framework_TestCase {
	public function dataCGI(){
		$target_domain = TARGET_DOMAIN;
		return array(
			array(
					'cgi' => "http://{$target_domain}/tecent_mobile_callback?amt=10&appid=1101135157&appmeta=%tx_vuwrwurxw0yzzur0XlYXzzzzzzz0vv0ywrqtsuuywxwv%*qdqb*qq&billno=-APPDJSX16875-20140114-1258291400&clientver=android&openid=591F9D17F34E9F33B7EA3844D14F1E7D&payamt_coins=0&payitem=44*1*1&providetype=5&pubacct_payamt_coins=&token=C11A428025D49C9C929ACEBEA244F34130683&ts=1389675509&version=v3&zoneid=1&sig=1TbJJO%2B50I4ObgvO0PZjhZ8J%2BXQ%3D",
					'expect_result' => array(),
					'desc' => '正常情况',
			),
		);
	}

	/**
	 * @dataProvider dataCGI
	 *
	 * @param unknown $str_target_cgi
	 * @param unknown $expect_result
	 */
	public function _testSignatureChecker( $str_target_cgi, $post_arr, $expect_result, $desc = '' ){
// 		echo "test";
		$sign_checker = new SnsSigCheck();
		
		$method = 'GET';
		$url_path = '/mqqpay.php';
		$params_str =<<<EOF
amt=10&appid=1101135157&appmeta=%tx_wzytzzwsq0yzzur0mYzYzczzzyz0vv0ywrrsxqrzvtrr%*qdqb*qq&billno=-APPDJSX16875-20140103-1417392942&clientver=android&openid=591F9D17F34E9F33B7EA3844D14F1E7D&payamt_coins=0&payitem=44*1*1&providetype=5&pubacct_payamt_coins=&token=4EDB368A41106A3B1954D144786AC4EA08358&ts=1388729859&version=v3&zoneid=1&sig=vxyHmlgXjpNIdLZ%2BIwswpqYVwGU%3D
EOF;
		
		$params_set = explode( '&', $params_str );
		$params_kv_arr = array();

		foreach( $params_set as $item ){
			$dset = explode( '=', $item );
			$k = $dset[0];
			$v = $dset[1];
						
			$params_kv_arr[$k] = $v;
		}
		ksort( $params_kv_arr );
		
		
		$secret = 'lACGpJHw2twrmEJ1&';
		$sig = rawurldecode( 'vxyHmlgXjpNIdLZ%2BIwswpqYVwGU%3D' );
		
		var_dump( "demo input", $params_kv_arr );
		
		$v_ret = $sign_checker->verifySig($method, $url_path, $params_kv_arr, $secret, $sig);

		var_dump( $v_ret );
	}
	
	
	/**
	 * @dataProvider dataCGI
	 * 
	 * @param unknown $str_target_cgi
	 * @param unknown $expect_result
	 */
	public function testCGITXMobileCallback( $str_target_cgi, $post_arr, $expect_result, $desc = '' ){
		
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $obj_curl, CURLOPT_HEADER, 1);
// 		curl_setopt( $obj_curl, CURLOPT_POST, count($post_arr) );
// 		curl_setopt( $obj_curl, CURLOPT_POSTFIELDS, json_encode( $post_arr ) );
		
		$request_header_str_set = array();		
		$request_header_str_set[] = "Content-Type: application/json";

		curl_setopt( $obj_curl, CURLOPT_HTTPHEADER, $request_header_str_set );
		
		$obj_ret_data = curl_exec( $obj_curl );
		
		$curl_info = curl_getinfo($obj_curl);
		$header_size = $curl_info['header_size'];
		$header_text = substr( $obj_ret_data, 0,$header_size );
		
		$body_str = substr($obj_ret_data, $header_size);
		
		var_dump("===header===", $header_text );
		var_dump("===body===", $body_str );
	}
}


