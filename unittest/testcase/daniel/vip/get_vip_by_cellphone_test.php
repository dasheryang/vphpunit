<?php
require_once dirname( __FILE__ ) . "/conf/config.php";
class GetVipByCellphoneTest extends PHPUnit_Framework_TestCase {
	
	function dataCgi() {
		$target_domain = TARGET_DOMAIN ; 
		return array(
			array(
				'target_domain'	=> $target_domain,
				'cellphone_no'	=> '18688999460',
				'desc'			=> '以手机号查询vip信息'
			),
		);
	}
	/**
	 * 
	 * @dataProvider dataCgi
	 * @param unknown_type $target_domain
	 * @param unknown_type $cellphone_no
	 * @param unknown_type $desc
	 */
	function testGetVipByCellphone( $target_domain, $cellphone_no, $desc ) {
		$target_cgi = "http://{$target_domain}/backend/get_vip_by_cellphone?cellphone_no=$cellphone_no";
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $target_cgi ) ;
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ) ;
		$result = curl_exec($ch);
		var_dump($result);
	}
}