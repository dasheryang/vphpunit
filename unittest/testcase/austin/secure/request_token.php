<?php
/**
 * 
 * 
 * @author austin.yang
 * @since 2014.01.07
 */
require_once dirname( __FILE__ ) . "/conf/config.php";

class PUTestRequestToken extends PHPUnit_Framework_TestCase {
	public function dataCGI(){
		$target_domain = TARGET_DOMAIN;
		$test_case_set = array();
		
		
		//MM 支付测试
		$test_case = array(
				'cgi' => "http://{$target_domain}/oauth/request_token?adebug=0",
				'post' => array(
						'nudid' => '38o_17800q979610208291ss53904366',
						'udid' => 'ffffffff-9c51-6994-fb58-b5400033c587',
				),
				'expect_result' => array(),
				'desc' => '',
		);
		$test_case_set[] = $test_case;

		return $test_case_set;
	}
	



	/**
	 * @dataProvider dataCGI
	 * 
	 * @param unknown $str_target_cgi
	 * @param unknown $expect_result
	 */
	public function testCGIRequestToken( $str_target_cgi, $post_arr, $url, $expect_result, $desc = '' ){


		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $obj_curl, CURLOPT_HEADER, 1);
		curl_setopt( $obj_curl, CURLOPT_POST, count( 1 ) );
		curl_setopt( $obj_curl, CURLOPT_POSTFIELDS, $post_arr );
		
// 		curl_setopt($obj_curl, CURLOPT_HEADER, true);
		$request_header_str_set = array();
		$request_header_str_set[] = 'Content-Type: application/x-www-form-urlencoded';		

// 		$request_header_str_set[] = "Authorization: OAuth oauth_consumer_key=8fee977f5ba1244dc4f1, oauth_signature_method=HMAC-SHA1, oauth_signature=00lklV0hU60B2VzzvVtEmh0Iufo%3D";
		$request_header_str_set[] = "Authorization: OAuth oauth_consumer_key=8fee977f5ba1244dc4f1, oauth_signature_method=HMAC-SHA1, oauth_signature=Cc7p6i%2BzoqJY%2FE%2FASQXB4nsWgqI%3D, oauth_timestamp=1389076059, oauth_nonce=-278605153217140178, oauth_version=1.0, oauth_callback=dgc-request-token-callback, oauth_signature_v2=eSi2umnVxr76nCQ3%2BukML8CEzcM%3D";
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
