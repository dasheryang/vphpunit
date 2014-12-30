<?php
/**
 * @target http://sdkpay.uu.cc/payments/create
 * 
 */
class PUTestPaymentCreate extends PHPUnit_Framework_TestCase {
	public function dataCGI(){
		$target_domain = 'payv2.dev.ids111.com';
		return array(
			array(
					'cgi' => "http://{$target_domain}/payments/create?isadmin=1&debug=2",
					'post' => array(
							'type' => 2,
							'product_id' => '1005800000001',
							'channel_id' =>	'TEST0000000',
							'quantity' => 2,
							'price' => '6.98',
							'paymethod' => '0',
							
					),
					'expect_result' => array(),
					'desc' => '创建测试订单',
			),
		);
	}
	
	/**
	 * @dataProvider dataCGI
	 * 
	 * @param unknown $str_target_cgi
	 * @param unknown $expect_result
	 */
	public function testCGIPaymentCreate( $str_target_cgi, $post_arr, $expect_result, $desc = '' ){
	print_r(func_get_args());
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $obj_curl, CURLOPT_POSTFIELDS, $post_arr );
		$obj_ret_data = curl_exec( $obj_curl );
		print_r($obj_ret_data);
		//检查返回数据格式是否合法
	}
}