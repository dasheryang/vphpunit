<?php

class PUTestFCGI extends PHPUnit_Framework_TestCase {
	

	public function dataCGI(){
//		$svr_domain = 'test.feed.uu.cc';
//		$svr_domain = 'test.ids.com';
//		$svr_domain = 'payv2.dev.ids.com';
//		$svr_domain = 'test.feed.ids111.com';
//		$svr_domain = 'sb1.feed.uu.cc';
// 		$svr_domain = 'payv2.dev.ids.com';
		
		$svr_domain = "cpp.austin.com";
		return array(
			array(
					"http://cpp.austin.com/cgi-bin/ec.fcgi",
					array(
					),
					'测试正常情况',
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
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		$obj_ret_data = curl_exec( $obj_curl );
		var_dump( $obj_ret_data );
	
	}
	
	public function setUp(){
	}
}