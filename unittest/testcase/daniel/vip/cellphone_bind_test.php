<?php
require_once dirname( __FILE__ ) . "/conf/config.php";
class CellphoneBindTest extends PHPUnit_Framework_TestCase {
	
	function dataCGICellphoneBind(){
		$target_domain = TARGET_DOMAIN;
	
		return array(
				array(
						'cgi' => "http://{$target_domain}/account/cellphone_bind",
						'post' => array(
							'udid' =>'00000000-62b1-fd46-317b-74d84365ca4a',
							'verify_type' => 1,
							'phone' => 18688999460,
							'code' => 551949,
							'game_id' => 10058,
							'channel_id' => 'TEST000000000',
						),
						'',
						'',
		),
		);
	}
	/**
	 * @dataProvider dataCGICellphoneBind
	 *
	 * @param unknown $str_target_cgi
	 * @param unknown $expect_result
	 */
	public function testCGICellphoneBind( $str_target_cgi, $post_arr, $expect_result, $desc = '' ){
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
	
		curl_setopt( $obj_curl, CURLOPT_POST, count($post_arr) );
		curl_setopt( $obj_curl, CURLOPT_POSTFIELDS,  $post_arr );
		
		$obj_ret_data = curl_exec( $obj_curl );
	
		var_dump( $obj_ret_data );
	}
}