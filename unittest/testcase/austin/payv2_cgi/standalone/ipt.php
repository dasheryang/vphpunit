<?php
/**
 * @target http://intra.pay.uu.cc:8100/camount/portal.php?udid=**
 *
 * @author austin.yang
 * @since 2013.08.02
 */

class PUTestIP extends PHPUnit_Framework_TestCase {
	public function dataCGI(){
		$target_domain = 'ip.uu.cc';
		return array(
			array(
					"http://{$target_domain}//ip.php?format=json&level=2&ip=58.31.105.2",
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
	public function testCGIIP( $str_target_cgi, $expect_result, $desc ){
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		$obj_ret_data = curl_exec( $obj_curl );
		
		$dat = json_decode( $obj_ret_data, true );
		var_dump( $dat );
	}
	
}