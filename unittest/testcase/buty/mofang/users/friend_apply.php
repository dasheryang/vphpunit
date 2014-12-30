<?php
/**
 * @target http://sdkpay.uu.cc/get_player_payment_group
 * 
 * 
 * @author austin.yang
 * @since 2013.08.30
 */
require_once dirname( __FILE__ ) . "/../config/config.php";
class PUTestSDKCoreRelationContacts extends PHPUnit_Framework_TestCase {
	public function dataCGI(){
		$target_domain = TARGET_DOMAIN;
		
		$test_arr = array();
		$test_arr[] = array(
					'cgi' => "http://{$target_domain}/friend/apply",
					'post' => array(
							'token'   => 'aaaa',
							'tar_uid' => 11043,
					),
					'afwfewfwaaadddccaf', //应用app_key
					'',
					'',
			);
		
		return $test_arr;
	}
	
	/**
	 * @dataProvider dataCGI
	 *
	 * @param unknown $str_target_cgi
	 * @param unknown $expect_result
	 */
	public function testCGIcreate( $str_target_cgi, $post_arr, $app_id, $expect_result = '', $desc = ''){
		$obj_curl = curl_init();
		$headers = array('app-key: ' . $app_id);
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $obj_curl, CURLOPT_HTTPHEADER, $headers); 
		
		curl_setopt( $obj_curl, CURLOPT_POST, count($post_arr) );
		curl_setopt( $obj_curl, CURLOPT_POSTFIELDS,  $post_arr );
	
		$obj_ret_data = curl_exec( $obj_curl );
	
		var_dump( $obj_ret_data );
	}
}