<?php
/**
 * @target http://sdkpay.uu.cc/payments/create
 * 
 * 
 * @author austin.yang
 * @since 2013.08.30
 */
require_once dirname( __FILE__ ) . "/conf/config.php";

class PUTestTokenSend extends PHPUnit_Framework_TestCase {
	public function dataCGI(){
		$target_domain = TARGET_DOMAIN;
		$test_case_set = array();

		
		//MM 支付测试
		$test_case = array(
				'cgi' => "http://{$target_domain}/sns/token_send?isadmin=1",
				'post' =>	array (
					  'send_type' => '2',
					  'nudid' => '52090_2769q3235687p13nr55870p5q86',
					  'package' => 'com.halfbrick.fruitninja',
					  'score' => '1',
					  'extra_info' => NULL,
					  'udid' => 'ffffffff-fecc-50a9-ffff-ffff9e8a4381',
					  'type' => 0,
					  'access_token' => '2.00owDo6CgFS5aC94f7acf275dFHuZB',
					  'channel_id' => 'TEST0000000',
					  'sns_type' => 1,
					  'mode' => '经典模式',
					),
				'expect_result' => array(),
				'desc' => '',
		);
		$test_case_set[] = $test_case;
		
// 		...
		return $test_case_set;
	}
	



	/**
	 * @dataProvider dataCGI
	 * 
	 * @param unknown $str_target_cgi
	 * @param unknown $expect_result
	 */
	public function testCGITokenSend( $str_target_cgi, $post_arr, $url, $expect_result, $desc = '' ){


		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $obj_curl, CURLOPT_HEADER, 1);
		curl_setopt( $obj_curl, CURLOPT_POST, count( $post_arr ) );
		curl_setopt( $obj_curl, CURLOPT_POSTFIELDS, $post_arr );
		
// 		curl_setopt($obj_curl, CURLOPT_HEADER, true);
		$request_header_str_set = array();		
// 		$request_header_str_set[] = "Content-Type: application/json";
// 		f219e6f8c21657ee8ccf2fb47902c24e0525e2a8f
		$nonce = time();
// 		$request_header_str_set[] = "AUTHORIZATION: OAuth oauth_consumer_key=8fee977f5ba1244dc4f1, nonce={$nonce}, oauth_token=8285f185e6abc27036fa35508f66a5fa052831e4f, oauth_signature_method=HMAC-SHA1";
		
		//sdkpay
		$request_header_str_set[] = "Authorization: OAuth oauth_consumer_key=0179030db72fac7e43cc, oauth_token=4d811e38311bdaf056d65827c2006df605292fa17, oauth_signature_method=HMAC-SHA1, oauth_signature=fDsHnl0XOkaPYrcnrSNX8Ys79Rk%3D, oauth_timestamp=1385364007, oauth_nonce=3130601815695400405, oauth_version=1.0, oauth_signature_v2=0PR8AqBUT8%2BWxdh8KQxSjsKQX9Q%3D";
// 		$request_header_str_set[] = "Authorization: OAuth oauth_consumer_key=0179030db72fac7e43cc, oauth_token=8a1fc828c3ac3dd63bb7362a3b04cf7905292fca5, oauth_signature_method=HMAC-SHA1, oauth_signature=qVoCuSku1TKIJ2PWVYEiy1C9IWg%3D, oauth_timestamp=1385364658, oauth_nonce=5941817646001803668, oauth_version=1.0, oauth_signature_v2=m5ByBf4J13DodhiaBr5TD8k%2BpJE%3D";
		
		
		//sb1
// 		$request_header_str_set[] = "AUTHORIZATION: OAuth oauth_consumer_key=0179030db72fac7e43cc, oauth_token=7ebaf5b331a5a651df1719f12ae49b6b05292f25a, oauth_signature_method=HMAC-SHA1, oauth_signature=3rIxN7g1JwvTvVaQveHuvDhHa1k%3D, oauth_timestamp=1385362025   oauth_nonce=-8630669317817686087, oauth_version=1.0, oauth_signature_v2=Hbnsk8radXWYag6LLDKP4t5Zj%2BE%3D";
// 		$request_header_str_set[] = "AUTHORIZATION: OAuth oauth_consumer_key=8fee977f5ba1244dc4f1, oauth_token=8152185b1cd539d7e78359e8ccc41f290525df38b";
		curl_setopt( $obj_curl, CURLOPT_HTTPHEADER, $request_header_str_set );
		
		$obj_ret_data = curl_exec( $obj_curl );
		
		$curl_info = curl_getinfo($obj_curl);
		$header_size = $curl_info['header_size'];
		$header_text = substr( $obj_ret_data, 0,$header_size );
		
		$body_str = substr($obj_ret_data, $header_size);
		
		var_dump("===header===", $header_text );
		var_dump("===body===", $body_str );
		
		return;
	}
}
