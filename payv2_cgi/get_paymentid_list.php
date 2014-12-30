<?php
/**
 * @target http://sdkpay.uu.cc/get_paymentid_list
 *
 *
 * @author austin.yang
 * @since 2013.08.02
 */

class PUTestPaymentPList extends PHPUnit_Framework_TestCase {
	
	public function dataCGIPaymentProfilePList(){
		$target_domain = 'payv2.dev.ids111.com';
		
		return array(
			array(
					"http://{$target_domain}/get_paymentid_list?spec_method=1&app_key=8fee977f5ba1244dc4f1&pay=1&sim=1&udid=testudid&p_list=0fff&isadmin=1",
					array( 	'set_bits' => array(),
							'unset_bits' => array()
					),
					'制定返回空json 对象',
			),
// 			array(
// 					"http://{$svr_domain}/get_paymentid_list?app_key=8fee977f5ba1244dc4f1&pay=1&sim=1&udid=testudid&p_list=0fff&isadmin=1",
// 					array( 	'set_bits' => array( 1 ), 
// 							'unset_bits' => array()
// 					),
// 					'测试正常情况',
// 			),
	
// 			array(
// 						"http://{$svr_domain}/get_paymentid_list?d_mm_payment_day=50&app_key=8fee977f5ba1244dc4f1&pay=1&sim=1&udid=testudid&p_list=1&isadmin=1",
// 						array( 	'set_bits' => array( 1 ),
//  								'unset_bits' => array( 4 )
// 						),
// 						'测试MM-日-限额超限情况',
// 				),
// 			array(
// 					"http://{$svr_domain}/get_paymentid_list?d_mm_payment_day=1&app_key=8fee977f5ba1244dc4f1&pay=1&sim=1&udid=testudid&p_list=0fff&isadmin=1",
// 					array( 	'set_bits' => array( ),
// 							'unset_bits' => array()
// 					),
// 					'测试MM-日-限额超限情况',
// 			),
// 			array(
// 					"http://{$svr_domain}/get_paymentid_list?d_mm_payment_month=100&app_key=8fee977f5ba1244dc4f1&pay=1&sim=1&udid=testudid&p_list=1&isadmin=1",
// 					array( 	'set_bits' => array( ),
// 							'unset_bits' => array( 4, 9 ),
// 					),
// 					'测试MM-月-限额超限情况',
// 			),
		);
	}
	

	/**
	 * @dataProvider dataCGIPaymentProfilePList
	 * 
	 * @param unknown $str_target_cgi
	 * @param unknown $expect_result
	 */
	public function testCGIPaymentProfilePList( $str_target_cgi, $expect_result, $desc ){
		
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		$obj_ret_data = curl_exec( $obj_curl );
// var_dump( $str_target_cgi, $obj_ret_data ); 

		$json_data = json_decode( $obj_ret_data, true );
		$code_str = $json_data['result']['code'];
		
		$code_value = hexdec( $code_str );
	
// 		var_dump( $code_str );
		$set_bits = $expect_result['set_bits'];
		if( !empty( $set_bits ) ){
			foreach( $set_bits as $offset ){
				$offset -= 1;
				$check_bit = 1 << $offset;
				$bin_result = ( $check_bit & $code_value );
				$this->assertEquals( $check_bit, $bin_result );
			}
		}
		
		$unset_bits = $expect_result['unset_bits'];
		if( !empty( $unset_bits ) ){
			foreach( $unset_bits as $offset ){
				$offset -= 1;
				$check_bit = 1 << $offset;
				$bin_result = ( $check_bit & ~$code_value );
				$this->assertEquals( $check_bit, $bin_result );
			}
		}
	}
	
	
	public function dataCGIPaymentProfilePListJDSwitchMM(){
		$svr_domain = 'payv2.dev.ids111.com';
		return array(
				array(
						"http://{$svr_domain}/get_paymentid_list?app_key=0f881ba4e517c6c28d88&pay=1&sim=1&channel_id=DJ0S0N00000&udid=testudid&p_list=0fff&isadmin=1",
						5,
						1,
						'测试正常切换',
				),
				array(
						"http://{$svr_domain}/get_paymentid_list?app_key=0f881ba4e517c6c28d88&channel_id=DJ0S0N00000&pay=1&sim=1&udid=testudid&p_list=00ff&isadmin=1",
						1,
						0,
						'测试由于客户端plist 导致后台不切换的',
				),
				array(
						"http://{$svr_domain}/get_paymentid_list?app_key=0f881ba4e517c6c28d88&channel_id=stestset&pay=1&sim=1&udid=testudid&p_list=0fff&isadmin=1",
						100,
						0,
						'测试由于channel_id  导致不切换的情况',
				),
		);
	}
		
	/**
	 * @dataProvider dataCGIPaymentProfilePListJDSwitchMM
	 *
	 * @param unknown $str_target_cgi
	 * @param unknown $expect_result
	 */
	public function _testCGIPaymentProfilePListJDSwitchMM( $str_target_cgi, $repeat_times, $expect_times, $desc ){
		$switched_time = 0;
		for( $i = 0; $i < $repeat_times; ++$i){
			$obj_curl = curl_init();
			curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
			curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
			$obj_ret_data = curl_exec( $obj_curl );
						
			$json_data = json_decode( $obj_ret_data, true );
			$code_str = $json_data['result']['code'];

// 			var_dump( $obj_ret_data, $code_str );
			
			$code_value = hexdec( $code_str );
			$bit_jd = 1 << 0;
			$bit_mm = 1 << 8;
			
			$set_jd = ( $bit_jd & $code_value );
//			var_dump( $set_jd);
			$set_mm = ( $bit_mm & $code_value );
			if( empty( $set_jd ) && $set_mm ){
				$switched_time += 1;
			}
		}
		
		echo " switched times :{$switched_time}";
		if( $expect_times > 0 ){
			$this->assertTrue( $switched_time > 0 );
		}else{
			$this->assertTrue( 0 == $switched_time );
		}
		
		
	}
	
	
	public function dataCGIPaymentProfilePlistSameCompanyFilter(){
		//		$svr_domain = 'test.feed.uu.cc';
		//		$svr_domain = 'test.ids.com';
		//		$svr_domain = 'payv2.dev.ids.com';
				$svr_domain = 'test.feed.ids111.com';
		//		$svr_domain = 'sb1.feed.uu.cc';
		//		$svr_domain = 'payv2.dev.ids111.com';
		//		$svr_domain = 'in1.feed.uu.cc';
		//		$svr_domain = 'ly.feed.uu.cc';
		return array(
				array(
						"http://{$svr_domain}/get_paymentid_list?company_filter=1&app_key=0f881ba4e517c6c28d88&pay=1&sim=1&channel_id=DJ0S0N00000&udid=testudid&p_list=0fff&isadmin=1",
						array(),
						'测试正常情况',
				),
				array(
						"http://{$svr_domain}/get_paymentid_list?company_filter=1&app_key=0f881ba4e517c6c28d88&channel_id=DJ0S0N00000&pay=1&sim=1&udid=testudid&p_list=00ff&isadmin=1",
						array(),
						'测试',
				),
		);
	}
	
	/**
	 * @dataProvider dataCGIPaymentProfilePlistSameCompanyFilter
	 *
	 */
	public function _testCGIPaymentProfilePlistSameCompanyFilter( $str_target_cgi, $expect_result, $desc ){
		
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		$obj_ret_data = curl_exec( $obj_curl );
		
		$json_data = json_decode( $obj_ret_data, true );
		$code_str = $json_data['result']['code'];
		$debug_str = empty( $json_data['result']['debug_str'] ) ? '' : $json_data['result']['debug_str'];
		
		var_dump( $code_str, $debug_str );
	}
}