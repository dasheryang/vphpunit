<?php
/**
 * @target http://sdkpay.uu.cc/get_player_payment_group
 * 
 * 
 * @author austin.yang
 * @since 2013.08.30
 */
require_once dirname( __FILE__ ) . "/conf/config.php";
class PUTestConsiseInfo extends PHPUnit_Framework_TestCase {
	public function dataCGI(){
		$target_domain = TARGET_DOMAIN;
		
		return array(
			array(
					'cgi' => "http://{$target_domain}/casual_notice/list?channel_id=TEST0000000&debug=2&isadmin=1",
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
	public function testCGIConsiseInfo( $str_target_cgi, $post_arr, $expect_result, $desc = '' ){
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
// 		curl_setopt( $obj_curl, CURLOPT_HEADER, 1);
		
		$obj_ret_data = curl_exec( $obj_curl );
		
// 		$ret_data_arr = json_decode( $obj_ret_data, true );
		
		var_dump( $obj_ret_data );
		
	}
}