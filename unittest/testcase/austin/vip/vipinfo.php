<?php
/**
 * @target http://sdkpay.uu.cc/get_player_payment_group
 * 
 * 
 * @author austin.yang
 * @since 2013.08.30
 */
require_once dirname( __FILE__ ) . "/conf/config.php";
class PUTestAccountInfo extends PHPUnit_Framework_TestCase {
	public function dataCGI(){
		$target_domain = TARGET_DOMAIN;
		
		$test_arr = array();
		$test_arr[] = array(
					'cgi' => "http://{$target_domain}/account/get_by_udid?udid=78318p6_565724988555443n1p8r5n22&a_debug=2",
					'post' => array(
					),
					'',
					'',
			);
// 		$test_arr[] = array(
// 				'cgi' => "http://{$target_domain}/backend/del_vip?udid=78318p6_565724988555443n1p8r5n22&a_debug=2",
// 				'post' => array(
// 				),
// 				'',
// 				'',
// 		);
		
		return $test_arr;
	}
	
	/**
	 * @dataProvider dataCGI
	 * 
	 * @param unknown $str_target_cgi
	 * @param unknown $expect_result
	 */
	public function testCGIAccountInfo( $str_target_cgi, $post_arr, $expect_result, $desc = '' ){
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		
		$obj_ret_data = curl_exec( $obj_curl );
		
		var_dump( $obj_ret_data );
	}
	
	
	public function dataCGISMSVerfiy(){
		$target_domain = TARGET_DOMAIN;
	
		return array(
				array(
						'cgi' => "http://{$target_domain}/account/sms_verify?vid=12052&udid=00000000-62b1-fd46-317b-74d84365ca4a&phone=18688999460&verify_type=1",
						'post' => array(
						),
						'',
						'',
		),
		);
	}
	/**
	 * @dataProvider dataCGISMSVerfiy
	 *
	 * @param unknown $str_target_cgi
	 * @param unknown $expect_result
	 */
	public function _testCGISMSVerify( $str_target_cgi, $post_arr, $expect_result, $desc = '' ){
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		
		$obj_ret_data = curl_exec( $obj_curl );
		
		var_dump( $obj_ret_data );
	}
	
	
	public function dataCGICellphoneBind(){
		$target_domain = TARGET_DOMAIN;
	
		return array(
				array(
						'cgi' => "http://{$target_domain}/account/cellphone_bind",
						'post' => array(
							'udid' =>'00000000-62b1-fd46-317b-74d84365ca4a',
							'verify_type' => 1,
							'phone' => 18688999460,
							'code' => 800280,
							'game_id' => 10058,
							'channel_id' => 'TEST000000000',
						),
						'',
						'',
		),
		);
	}
	/**
	 * @dataProvider dataCGICellphoneBind
	 *
	 * @param unknown $str_target_cgi
	 * @param unknown $expect_result
	 */
	public function _testCGICellphoneBind( $str_target_cgi, $post_arr, $expect_result, $desc = '' ){
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
	
		curl_setopt( $obj_curl, CURLOPT_POST, count($post_arr) );
		curl_setopt( $obj_curl, CURLOPT_POSTFIELDS,  $post_arr );
		
		$obj_ret_data = curl_exec( $obj_curl );
	
		var_dump( $obj_ret_data );
	}
}