<?php
/**
 * @target http://sdkpay.uu.cc/get_player_payment_group
 * 
 * 
 * @author austin.yang
 * @since 2013.08.30
 */
require_once dirname( __FILE__ ) . "/conf/config.php";
class PUTestNotice extends PHPUnit_Framework_TestCase {
	public function dataCGI(){
		$target_domain = TARGET_DOMAIN;
		
		return array(
			array(
					'cgi' => "http://{$target_domain}/account/verify_credentials?game_version=1.7.9.1&init=1&sdk_version=1.5.1&channel_id=YY0S0N00000",
					'post' => array(
					),
					'',
					'',
			),
		);
	}
	
	/**
	 * @dataProvider dataCGI
	 * 
	 * @param unknown $str_target_cgi
	 * @param unknown $expect_result
	 */
	public function testCGINoticeList( $str_target_cgi, $post_arr, $expect_result, $desc = '' ){
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		
		
// 		curl_setopt( $obj_curl, CURLOPT_HEADER, 1);
		$request_header_str_set = array();
		$request_header_str_set[] = "Authorization: OAuth oauth_consumer_key=29051bf5feb7d4ecc5cf, oauth_token=61a7d905752fb5c2977afa124345a60a052e2fa3f, oauth_signature_method=HMAC-SHA1, oauth_signature=PnnJRGtKrLbUYt1HBU2qJS8Y9cQ%3D, oauth_timestamp=1395141692, oauth_nonce=1171136951381951523, oauth_version=1.0";
		// 		$request_header_str_set[] = "AUTHORIZATION: OAuth oauth_consumer_key=8fee977f5ba1244dc4f1, oauth_token=8152185b1cd539d7e78359e8ccc41f290525df38b";
		curl_setopt( $obj_curl, CURLOPT_HTTPHEADER, $request_header_str_set );
		
		$obj_ret_data = curl_exec( $obj_curl );
		
// 		$ret_data_arr = json_decode( $obj_ret_data, true );
		
		var_dump( $obj_ret_data );
		
	}
}