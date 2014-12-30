<?php
/**
 * @target http://sdkpay.uu.cc/paymentprofile
 * 
 * 
 * @author austin.yang.....
 * @since 2013.08.02
 */
require_once dirname( __FILE__ ) . "/conf/config.php";

class PUTestPaymentProfile extends PHPUnit_Framework_TestCase {
	public function dataCGIPaymentProfile(){
		$target_domain = TARGET_DOMAIN;
		return array(
			array(
					"http://{$target_domain}/paymentprofile?game_id=10060&channel_id=&type=0&pack_ver=1&isadmin=1&debug=2",
					array( 'field_count_least' => 4 ),
					'测试游戏10060',
			),
            array(
	                "http://{$target_domain}/paymentprofile?game_id=10058&channel_id=&type=1&pack_ver=1&isadmin=1&debug=2",
	                array( 'field_count_least' => 4 ),
	            	'测试游戏10058',
            ),
		);
	}
	
	/**
	 * @dataProvider dataCGIPaymentProfile
	 * 
	 * @param unknown $str_target_cgi
	 * @param unknown $expect_result
	 */
	public function testCGIPaymentProfile( $str_target_cgi, $expect_result, $desc = '' ){
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		$obj_ret_data = curl_exec( $obj_curl );
		
		var_dump( $obj_ret_data );
		//检查返回数据格式是否合法
		$json_ret = json_decode( $obj_ret_data, true );
		$this->assertFalse( empty( $json_ret ) );
		
		//检查是否空数据
		$arr_result = $json_ret['result'];
		$this->assertFalse( empty( $arr_result ) );
		
		//检查字段数
		$field_count = count( array_keys( $arr_result[0] ) );
		$this->assertTrue( $expect_result['field_count_least'] <= $field_count );

        //检查identifier，name，list_values 是否存在。是否符合要求
        foreach($arr_result as $value) {
            $this->assertTrue(  isset($value['identifier']) );
            $this->assertTrue(  is_int($value['identifier']) );

            $this->assertTrue( isset($value['name']) );

            $this->assertTrue( isset($value['list_values']) );
            $this->assertTrue( is_array($value['list_values']) );
        }
	}
}