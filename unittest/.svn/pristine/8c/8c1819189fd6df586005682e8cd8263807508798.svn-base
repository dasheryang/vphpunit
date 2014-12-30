<?php
class PUTestUnionPayPurchase extends PHPUnit_Framework_TestCase {

	/**
	 * @author austin
	 * @date	2013-06-25
	 * 
	 * @description 测试银联接口POST请求
	 */
	public function testPurchasePost(){	
//		$arr_result = union_pay_purchase_demo();
		$obj_upay = new UnionPaymentAPI();
		$arr_result = $obj_upay->purchase();
		$this->assertEquals( upmp_config::RESPONSE_CODE_SUCCESS , $arr_result['respCode'] );

		
	}
	
	/**
	 * @author austin
	 * @date	2013-06-25
	 * 
	 * @description 测试银联接口回调通知信息
	 */
	public function _testPurchaseCallBackNotify(){
		$this->assertFalse( false === $mix_conn_result );
	}
	
	/**
	 * @author austin
	 * @date	2013-06-25
	 *
	 * @description 测试银联接口回调处理函数
	 */
	public function _testPurchaseCallBackProcess(){
		$str_target_cgi = 'http://test.feed.uu.cc/test/func';
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		$obj_ret_data = curl_exec( $obj_curl );
	}
	
	protected function setUp(){
		//include framework files
		$app_src_path = '/var/www/austin/dgc/app/Lib/unionpay/';
		require_once $app_src_path . 'union_payment_api.php';
	}
}