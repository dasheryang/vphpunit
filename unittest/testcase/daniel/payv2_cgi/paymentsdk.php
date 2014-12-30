<?php
/**
 * @target http://sdkpay.uu.cc/paymentsdk
 * 
 * 
 * @author austin.yang
 * @since 2013.08.28
 */
class PUTestPaymentSDK extends PHPUnit_Framework_TestCase {
	public function dataCGI(){
		$target_domain = 'payv2.dev.ids111.com';
		return array(
			array(
					"http://{$target_domain}/paymentsdk?isadmin=1&version=1.2.3&type=1",
					array(),
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
	public function testCGIPaymentSDK( $str_target_cgi, $expect_result, $desc = '' ){
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		$obj_ret_data = curl_exec( $obj_curl );
		
		//检查返回数据格式是否合法
		$json_ret = json_decode( $obj_ret_data, true );
		$this->assertFalse( empty( $json_ret ) );

		//检查有更新时，返回请求数据中是否包含升级地址
// 		var_dump( $json_ret );
		if( ! $json_ret['result']['is_latest'] ){
			$this->assertFalse( empty( $json_ret['result']['url'] ) );
		}
	}
}