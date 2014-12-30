<?php
/**
 * @target http://sdkpay.uu.cc/payments/create
 * 
 * 
 * @author austin.yang
 * @since 2013.09.11
 */
require_once dirname( __FILE__ ) . "/conf/config.php";

class PUTestPaymentCreate extends PHPUnit_Framework_TestCase {
	public function dataCGI(){
		$target_domain = TARGET_DOMAIN;
		$test_case_set = array();

		
		$test_case = array(
				'cgi' => "http://{$target_domain}/xiaomi_callback",
				'post' => array(
						'cpOrderId' => 'DD1139259',
						'appId' => '12313',
						'uid' => 'asdfasdf',
						'payFee' => 269,
						'orderStatus' => 'TRADE_SUCCESS',
						
						'signature' => 'asdfasdfsf',
				),
				'expect_result' => array(),
				'desc' => '订单回调',
		);
		$test_case_set[] = $test_case;
		
// 		...
		return $test_case_set;
	}
	
	/**
	 * @dataProvider dataCGI
	 * 
	 * @param unknown $str_target_cgi
	 * @param unknown $expect_result
	 */
	public function testCGIPaymentCreate( $str_target_cgi, $post_arr, $expect_result, $desc = '' ){
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $obj_curl, CURLOPT_POST, count( $post_arr ) );
		curl_setopt( $obj_curl, CURLOPT_POSTFIELDS, $post_arr );
		$obj_ret_data = curl_exec( $obj_curl );
		
		var_dump( $obj_ret_data );return;
		//检查返回数据格式是否合法
		$json_ret = json_decode( $obj_ret_data, true );
		$this->assertFalse( empty( $json_ret ) );
		
		var_dump( $json_ret );
	}
}