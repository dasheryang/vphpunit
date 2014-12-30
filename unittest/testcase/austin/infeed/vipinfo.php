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
		$taget_domain = TARGET_DOMAIN;
		
		$testcase_set = array();
		$testcase_set[] = array(
				'cgi' => "http://{$taget_domain}:81/vip/info?nudid=418ss05489790_61083080r270q10on2q&udid=ffffffff-b48a-13f7-fb58-b5400033c587",
				'post' => array(
				),
				'',
				'',
		);
		
		$testcase_set[] = array(
				'cgi' => "http://{$taget_domain}/vip/user_privilege?nudid=00000000-62b1-fd46-317b-74d84365ca4a&debug=0",
				'post' => array(
				),
				'',
				'',
		);
		
		return $testcase_set;
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

}