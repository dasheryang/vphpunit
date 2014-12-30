<?php
/**
 * @target http://sdkpay.uu.cc/config/config_sms_limit
 * 
 * 
 * @author austin.yang
 * @since 2013.08.02
 */

require_once dirname( __FILE__ ) . "/conf/config.php";

class PUTestSDKCallback extends PHPUnit_Framework_TestCase {
	public function dataCGI(){
		$target_domain = TARGET_DOMAIN;
		return array(
			array(
					'cgi' => "http://{$target_domain}/paymentcallback/sdk?isadmin=1",
					'post' => array( 
								'paymethod' => 37,
								'ext_trade_id' => 'A448B924674FB27D',
								'ext_app_id' => '300002932641',
								'order_id' => 'DD735446947',
					),
// 					'cgi' => "http://{$target_domain}/bind360GameOutSession?isadmin=1&appkey=3948e1a8d05275a9d5cc02822be08609&udid=ffffffff-8d6d-800c-fb58-b54010bd739b&code=2608541164c2c81132325ce43c7ab5f17aeb97bf0a3cb0139&nudid=99n_61097900527180800rr5qs65013o0&channel_id=TEST0000000&imei=353627055424561",
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
	public function testCGISdkCallback( $str_target_cgi, $post_arr, $expect_result, $desc = '' ){
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $obj_curl, CURLOPT_POST, count($post_arr) );
		curl_setopt( $obj_curl, CURLOPT_POSTFIELDS, json_encode( $post_arr ) );
		
		curl_setopt( $obj_curl, CURLOPT_HEADER, 1);
		$request_header_str_set = array();
		$request_header_str_set[] = "Content-Type: application/json";
		$nonce = time();
		//dev env
		// 		$request_header_str_set[] = "AUTHORIZATION: OAuth oauth_consumer_key=8fee977f5ba1244dc4f1, nonce={$nonce}, oauth_token=8d80f954ef040ca6830f5fdc6934202f05281cd00, oauth_signature_method=HMAC-SHA1";
		
		//release env
		$request_header_str_set[] = "AUTHORIZATION: OAuth oauth_consumer_key=8fee977f5ba1244dc4f1, nonce={$nonce}, oauth_token=8285f185e6abc27036fa35508f66a5fa052831e4f, oauth_signature_method=HMAC-SHA1";
		
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