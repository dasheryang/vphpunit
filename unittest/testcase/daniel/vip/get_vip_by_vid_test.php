<?php
require_once dirname( __FILE__ ) . "/conf/config.php";
class GetVipByVidTest extends PHPUnit_Framework_TestCase {
	
	function dataCgi() {
		$target_domain = TARGET_DOMAIN ; 
		return array(
			array(
				'target_domain'	=> $target_domain,
				'vid'	=> '15265',
				'desc'			=> '会员ID查询会员信息'
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
	function testGetVipByVid( $target_domain, $vid, $desc ) {
		$target_cgi = "http://{$target_domain}/backend/get_vip_by_vid?vid=$vid";
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $target_cgi ) ;
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ) ;
		$result = curl_exec($ch);
		var_dump($result);
	}
}