<?php
/**
 * @target http://sdkpay.uu.cc/payments_check
 * 
 * 
 * @author austin.yang
 * @since 2013.08.30
 */
class PUTestPaymentCheck extends PHPUnit_Framework_TestCase {
	public function dataCGI(){
		$target_domain = 'payv2.dev.ids111.com';
		return array(
			array(
					'cgi' => "http://{$target_domain}/payments/check?isadmin=1",
					'post' => array( 
									'order_id' => json_encode( array('DD1106769', 'DD1106770', 'DD1106775') ),
					),
					'expect_result' => array( ),
					'desc' => '正常情况',
			),
		);
	}
	
	/**
	 * @dataProvider dataCGI
	 * 
	 * @param unknown $str_target_cgi
	 * @param unknown $expect_result
	 */
	public function testCGIPaymentCheck( $str_target_cgi, $post_arr, $expect_result, $desc = '' ){
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $obj_curl, CURLOPT_POSTFIELDS, $post_arr );
		$obj_ret_data = curl_exec( $obj_curl );
		
		//检查返回数据格式是否合法
		$json_ret = json_decode( $obj_ret_data, true );
		$this->assertFalse( empty( $json_ret ) );
		
		$order_id_arr = json_decode( $post_arr['order_id'], true );
		$order_id_count = count( $order_id_arr );
		
		$result_order_count = count( $json_ret['result'] );
		
		//检查返回结果数是否等于输入订单号码数
		$this->assertEquals( $result_order_count, $order_id_count );
		
// 		var_dump( $order_id_count, $result_order_count  );
	}
}