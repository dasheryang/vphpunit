<?php
/**
 * @target http://sdkpay.uu.cc/get_player_payment_group
 * 
 * 
 * @author austin.yang
 * @since 2013.08.30
 */
require_once dirname( __FILE__ ) . "/conf/config.php";
class PUTestPromotionCode extends PHPUnit_Framework_TestCase {
	public function dataCGI(){
		$target_domain = TARGET_DOMAIN;
		
		return array(
			array(
					'cgi' => "http://{$target_domain}/promotioncode/active",
					'post' => array(
							'nudid' => '00031-adeecc-test-austin-yangaa',
							'app_key' => '8fee977f5ba1244dc4f1',
							'code' => 'Q1DL5GWS',
					),
					'',
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
	public function testCGIPaymentGroup( $str_target_cgi, $post_arr, $expect_result, $desc = '' ){
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
// 		curl_setopt( $obj_curl, CURLOPT_HEADER, 1);
		curl_setopt( $obj_curl, CURLOPT_POST, count( $post_arr ) );
		curl_setopt( $obj_curl, CURLOPT_POSTFIELDS, $post_arr );
		
		$obj_ret_data = curl_exec( $obj_curl );
		
// 		$ret_data_arr = json_decode( $obj_ret_data, true );
		
		var_dump( $obj_ret_data );
		//检查返回数据格式是否合法
		
	}
}