<?php
/**
 * @target http://sdkpay.uu.cc/get_player_payment_group
 * 
 * 
 * @author austin.yang
 * @since 2013.08.30
 */
require_once dirname( __FILE__ ) . "/conf/config.php";
class PUTestPaymentGroup extends PHPUnit_Framework_TestCase {
	public function dataCGI(){
		$target_domain = TARGET_DOMAIN;
		
		return array(
			array(
					"http://{$target_domain}/get_player_payment_group?isadmin=1",
					array(),
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
	public function testCGIPaymentGroup( $str_target_cgi, $expect_result, $desc = '' ){
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_HEADER, 1);
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		$obj_ret_data = curl_exec( $obj_curl );
		
		$request_header_str_set = array();
		
// 		$request_header_str_set[] = "AUTHORIZATION: OAuth oauth_consumer_key=8fee977f5ba1244dc4f1, oauth_token=ba67975548999401b38f64ebb736e2d6052662f30";
		$request_header_str_set[] = "AUTHORIZATION: OAuth oauth_consumer_key=8fee977f5ba1244dc4f1, oauth_token=a64f2baca8e5db9737dfce8666f057b30525f5196";
		
		$obj_ret_data = curl_exec( $obj_curl );
		
		$curl_info = curl_getinfo($obj_curl);
		$header_size = $curl_info['header_size'];
		$header_text = substr( $obj_ret_data, 0,$header_size );
		
		$body_str = substr($obj_ret_data, $header_size);
		
		var_dump("===header===", $header_text );
		var_dump("===body===", $body_str );
	}
}