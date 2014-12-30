<?php
/**
 * @target http://sdkpay.uu.cc/get_player_payment_group
 * 
 * 
 * @author austin.yang
 * @since 2013.08.30
 */
require_once dirname( __FILE__ ) . "/conf/config.php";
class PUTestCharge extends PHPUnit_Framework_TestCase {
	public function dataCGI(){
		$target_domain = TARGET_DOMAIN;
		
		return array(
			array(
					'cgi' => "http://{$target_domain}/payment/charge",
					'post' => array(
							'paymethod' => '37',
							'udid' => '00000000-62b1-fd46-317b-74d84365ca4a',							
							'channel_id' => 'AL0S0N10000',
							'vid' => 12052,
							'game_id' => 10058,
							'order_no' => 'DD100590',
							'charge_type' => '10020',
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
	public function testCGICharge( $str_target_cgi, $post_arr, $expect_result, $desc = '' ){
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		
		curl_setopt( $obj_curl, CURLOPT_POST, count($post_arr) );
		curl_setopt( $obj_curl, CURLOPT_POSTFIELDS,  $post_arr );

		
		$request_header_str_set = array();
// 		$request_header_str_set[] = "Content-Type: application/json";
		curl_setopt( $obj_curl, CURLOPT_HTTPHEADER, $request_header_str_set );
		
		$obj_ret_data = curl_exec( $obj_curl );
		
		
		var_dump( $obj_ret_data );
		
	}
}