<?php
/**
 * @target http://sdkpay.uu.cc/get_player_payment_group
 * 
 * 
 * @author austin.yang
 * @since 2013.08.30
 */
require_once dirname( __FILE__ ) . "/conf/config.php";
class PUTestVersionCheckUpdate extends PHPUnit_Framework_TestCase {
	public function dataCGI(){
		$target_domain = TARGET_DOMAIN;
		
		return array(
			array(
					"http://{$target_domain}/version/checkupdate?game_uri=com.halfbrick.fruitninjafree&channel_id=TEST0000000&internal_version=v1.8.5_s1.5.1-380400",
					array(),
					'',
			),
			
			array(
					"http://{$target_domain}/version/checkupdate?game_uri=com.halfbrick.fruitninjafree&channel_id=TEST0000000&internal_version=v1.8.7_s1.5.2-000000",
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
	public function testCGIVerCheck( $str_target_cgi, $expect_result, $desc = '' ){
// 		$version_pack_str = "s12312313_v1.8.4";
// 		$temp_str = strstr( $version_pack_str, '_');
// 		$ver_str = substr( $temp_str, 2 ); 
// 		var_dump( $temp_str, $ver_str );

		
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		$obj_ret_data = curl_exec( $obj_curl );
		
		var_dump( $obj_ret_data );
		//检查返回数据格式是否合法
		
	}
}