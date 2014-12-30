<?php
class PUTestACL extends PHPUnit_Framework_TestCase {
	public function dataCGI(){
		$svr_domain = 'standalone.payv2.dev.ids.com';
		return array(
			array(
					"http://{$svr_domain}/charge_amount/trunk/portal.php?udid=00000000-5b0c-44ab-88ca-48aa62cce3ff",
					array( ),
					'',
			),
			array(
					"http://{$svr_domain}/charge_amount/trunk/portal.php?udid=00000000-5b0c-44ab-88ca-48aa62cce3ff&app_key=e888e4c64296964096d1",
					array( ),
					'',
			),
			
			array(
					"http://{$svr_domain}/charge_amount/trunk/portal.php?udid=00000000-5b0c-44ab-88ca-48aa62cce3ff&app_key=e888e4c64296964096d2",
					array( ),
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
	public function testCGI( $str_target_cgi, $expect_result, $desc ){
		
// 		$obj_curl = curl_init();
// 		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
// 		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
// 		$obj_ret_data = curl_exec( $obj_curl );

		$result = array(
			"error_code" => 0, //错误代码 0：表示成功；其它表示失败
    		"msg" => "ok", //返回信息说明
    		"contacts" => array(
    				'friends' => 2,
    				'relatives' => 2,
    		),	
		);
		
		$json_result = json_encode( $result );
		var_dump( $json_result );

	}
}