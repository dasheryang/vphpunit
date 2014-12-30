<?php
/**
 * @target http://intra.pay.uu.cc:8100/camount/portal.php?udid=**
 *
 * @author austin.yang
 * @since 2013.08.02
 */

class PUTestChargeAmount extends PHPUnit_Framework_TestCase {
	public function dataCGI(){
		$target_domain = 'intra.pay.uu.cc:8100';
		return array(
			array(
					"http://{$target_domain}/camount/portal.php?udid=00000000-14d1-f45b-f1ba-80972e4c3273",
					array(
							'cgi_code'	=>	0,
					),
					'正常请求成功请求',
			),
		);
	}
	

	/**
	 * @dataProvider dataCGI
	 * 
	 * @param unknown $str_target_cgi
	 * @param unknown $expect_result
	 */
	public function testCGIChargeAmount( $str_target_cgi, $expect_result, $desc ){
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		$obj_ret_data = curl_exec( $obj_curl );

		$json_data = json_decode( $obj_ret_data, true );
		
		//检查返回码是否符合预期
		$this->assertEquals( $expect_result['cgi_code'], $json_data['cgi_code'] );
	}
	
}