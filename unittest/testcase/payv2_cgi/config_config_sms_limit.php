<?php
/**
 * @target http://sdkpay.uu.cc/config/config_sms_limit
 * 
 * 
 * @author austin.yang
 * @since 2013.08.02
 */
class PUTestConfigSMSLimit extends PHPUnit_Framework_TestCase {
	public function dataCGI(){
		$target_domain = 'sdk.pay.uu.cc';
		return array(
			array(
					'cgi' => "http://{$target_domain}/config/config_sms_limit?appkey=8fee977f5ba1244dc4f1&channel=CURRENT00000",
					'expect_result' => array(),
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
	public function testCGIConfigSMSLimit( $str_target_cgi, $post_arr, $expect_result, $desc = '' ){
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		$obj_ret_data = curl_exec( $obj_curl );
		
		
		//检查返回数据格式是否合法
		$json_ret = json_decode( $obj_ret_data, true );
		$this->assertFalse( empty( $json_ret ) );

	}
}