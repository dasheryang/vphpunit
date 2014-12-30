<?php
/**
 * 
 * 
 * @author austin.yang
 * @since 2013.10.14
 */

require_once dirname( __FILE__ ) . "/conf/config.php";

class PUTestChangePlan extends PHPUnit_Framework_TestCase {
	public function dataCGI(){
		$target_domain = TARGET_DOMAIN;
		return array(
			array(
					'cgi' => "http://{$target_domain}/payment_change_plans?debug=2",
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
	public function testCGI( $str_target_cgi, $post_arr, $expect_result, $desc = '' ){
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		$obj_ret_data = curl_exec( $obj_curl );
var_dump( $obj_ret_data ); return;
// return;
		
		//检查返回数据格式是否合法
		$json_ret = json_decode( $obj_ret_data, true );
		$this->assertFalse( empty( $json_ret ) );
		
		//检查返回数据 reuslt 字段
		$this->assertFalse( empty( $json_ret['result'] ) );
		

	}
}