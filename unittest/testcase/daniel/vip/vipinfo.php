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
		
		return array(
			array(
					'cgi' => "http://{$target_domain}/account/get_by_udid?udid=00000000-62b1-fd46-317b-74d84365ca4a",
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
						'cgi' => "http://{$target_domain}/account/sms_verify?vid=15266&udid=00000000-62b1-fd46-317b-74d84365ca4a&phone=13510906325&verify_type=1",
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
	public function testCGISMSVerify( $str_target_cgi, $post_arr, $expect_result, $desc = '' ){
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
							'phone' => 13510906325,
							'code' => 231554,
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
	public function testCGICellphoneBind( $str_target_cgi, $post_arr, $expect_result, $desc = '' ){
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
	
		curl_setopt( $obj_curl, CURLOPT_POST, count($post_arr) );
		curl_setopt( $obj_curl, CURLOPT_POSTFIELDS,  $post_arr );
		
		$obj_ret_data = curl_exec( $obj_curl );
	
		var_dump( $obj_ret_data );
	}
}