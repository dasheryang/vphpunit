<?php
/**
 * @target http://sdkpay.uu.cc/payments_check
 * 
 * 
 * @author austin.yang
 * @since 2013.10.18
 */

require_once dirname( __FILE__ ) . "/conf/config.php";
class PUTestPaymentGroup extends PHPUnit_Framework_TestCase {
	public function dataCGI(){
		$target_domain = TARGET_DOMAIN;
		return array(
			array(
					'cgi' => "http://{$target_domain}/get_player_payment_group?isadmin=1&debug=2",
					'post' => array( 
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
		
		
		$request_header_str_set[] = "Content-Type: application/json";
		// 		f219e6f8c21657ee8ccf2fb47902c24e0525e2a8f
		$request_header_str_set[] = "AUTHORIZATION: OAuth oauth_consumer_key=8fee977f5ba1244dc4f1, oauth_token=a64f2baca8e5db9737dfce8666f057b30525f5196";
		
		// 		$request_header_str_set[] = "EAUTHORIZATION: OAuth oauth_consumer_key=8fee977f5ba1244dc4f1, oauth_token=8152185b1cd539d7e78359e8ccc41f290525df38b";
		curl_setopt( $obj_curl, CURLOPT_HTTPHEADER, $request_header_str_set );
		
		
		$obj_ret_data = curl_exec( $obj_curl );
		
		var_dump( $obj_ret_data ); return;
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