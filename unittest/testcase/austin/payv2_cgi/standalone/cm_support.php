<?php
/**
 * @target http://intra.pay.uu.cc:8100/camount/portal.php?udid=**
 *
 * @author austin.yang
 * @since 2013.08.02
 */

class PUTestCMSpport extends PHPUnit_Framework_TestCase {
	public function dataCGI(){
		$target_domain = 'cm.austin.ids.com';
		return array(
			array(
					"http://{$target_domain}/index.php?imei=353627055424561&start_date=2013-11-25&end_date=2013-12-02",
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
	public function _testCGICMSpport( $str_target_cgi, $expect_result, $desc ){
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		$obj_ret_data = curl_exec( $obj_curl );
		var_dump( $obj_ret_data );
	}
	
	
	
	
	public function dataUploadCGI(){
		$target_domain = 'cm.austin.ids.com';
		return array(
				array(
						"http://{$target_domain}/upload.php?file_path=./data/upload/imei.csv_2013-12-05_10-11-23",
						array(
								'cgi_code'	=>	0,
						),
						'正常请求成功请求',
		),
		);
	}
	
	
	/**
	 * @dataProvider dataUploadCGI
	 *
	 * @param unknown $str_target_cgi
	 * @param unknown $expect_result
	 */
	public function testCGICMUpload( $str_target_cgi, $expect_result, $desc ){
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		$obj_ret_data = curl_exec( $obj_curl );
		var_dump( $obj_ret_data );
	}
	
	public function dataASyncExport(){
		$target_domain = 'cm.austin.ids.com';
		return array(
				array(
						"http://{$target_domain}/AsyncExportIMEIInfo.php",
						array(
								'cgi_code'	=>	0,
						),
						'正常请求成功请求',
		),
		);
	}
	
	
	/**
	 * @dataProvider dataASyncExport
	 *
	 * @param unknown $str_target_cgi
	 * @param unknown $expect_result
	 */
	public function _testASyncExport( $str_target_cgi, $expect_result, $desc ){
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		$obj_ret_data = curl_exec( $obj_curl );
		var_dump( $obj_ret_data );
	}
	
}