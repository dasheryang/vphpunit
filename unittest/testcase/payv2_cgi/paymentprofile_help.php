<?php
/**
 * @target http://sdkpay.uu.cc/paymentprofile/help
 * 
 * 
 * @author austin.yang
 * @since 2013.08.02
 */

class PUTestCGIPaymentHelp extends PHPUnit_Framework_TestCase {
	
	public function dataCGI(){
		$target_domain = 'sdk.pay.uu.cc';
		
		return array(	
			array(
					"http://{$target_domain}/paymentprofile/help",
					array( 
							'code'	=>	200,
					),
					'测试默认情况',
			),
			
			array(
					"http://{$target_domain}/paymentprofile/help?version=40000",
					array(
							'code'	=>	304,
					),
					'测试客户端已经存在较新版本的情况',
			),
		);
	}
	

	/**
	 * @dataProvider dataCGI
	 * 
	 * @param unknown $str_target_cgi
	 * @param unknown $expect_result
	 */
	public function testCGIPaymentHelp( $str_target_cgi, $expect_result, $desc ){	
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		$obj_ret_data = curl_exec( $obj_curl );
		
		//检查返回数据格式是否合法
		$json_ret = json_decode( $obj_ret_data, true );
		$this->assertFalse( empty( $json_ret ) );
	
		//检查服务返回码是否符合预期
		$this->assertEquals( $expect_result['code'], $json_ret['code'] );
		
		//检查内容长度是否符合预期
		if( 200 == $json_ret['code']  ){
			$this->assertFalse( empty( $json_ret['content'] ) );
		}else{
			$this->assertTrue( empty( $json_ret['content'] ) );
		}
		

	}
}