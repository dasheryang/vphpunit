<?php
/**
 * @target http://sdkpay.uu.cc/payments/create
 * 
 * 
 * @author austin.yang
 * @since 2013.08.30
 */
class PUTestPaymentCreate extends PHPUnit_Framework_TestCase {
	public function dataCGI(){
		$target_domain = 'sdk.pay.uu.cc';
		return array(
			array(
					'cgi' => "http://{$target_domain}/payments/create?isadmin=1",
					'post' => array(
							'type' => 2,
							'product_id' => '1005800000001',
							'channel_id' =>	'TEST0000000',
							'quantity' => 1,
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
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $obj_curl, CURLOPT_POSTFIELDS, $post_arr );
		$obj_ret_data = curl_exec( $obj_curl );
		
		//检查返回数据格式是否合法
		$json_ret = json_decode( $obj_ret_data, true );
		$this->assertFalse( empty( $json_ret ) );
		
		//检查返回订单 ID 格式
		$this->assertFalse( empty( $json_ret['result']['id'] ) );
	}
}