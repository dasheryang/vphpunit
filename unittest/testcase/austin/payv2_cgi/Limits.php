<?php
/**
 * @target http://sdkpay.uu.cc/get_player_payment_group
 * 
 * 
 * @author austin.yang
 * @since 2013.08.30
 */
require_once dirname( __FILE__ ) . "/conf/config.php";
class PUTestPaymentGroup extends PHPUnit_Framework_TestCase {
	public function dataCGI(){
		$target_domain = TARGET_DOMAIN;
		
		return array(
			array(
					"http://{$target_domain}/paymentprofiles/quota?game_type=2",
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
	public function testCGIPaymentGroup( $str_target_cgi, $expect_result, $desc = '' ){
		
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		$obj_ret_data = curl_exec( $obj_curl );
		
		var_dump( $obj_ret_data );
		//检查返回数据格式是否合法
		
	}
	
	public function caculation(){
		$space = pow( 36, 10 );
		
		$p = 1.0;
		$count = 1000 * 1000 * 2;
		for( $i = 1; $i < $count; ++$i){
			$p = $p * ( floatval($space - $i) / floatval($space) );
// 			var_dump( $i + 1, $p, '================' );
		}
		
		var_dump( "finial", $p, '================' );
		echo $space;
	}
}