<?php
require_once dirname( __FILE__ ) . "/conf/config.php";
class VipLogTest extends PHPUnit_Framework_TestCase {
	
	function dataCgi() {
		$target_domain = TARGET_DOMAIN ; 
		return array(
			array(
				'target_domain'	=> $target_domain,
				'params'	=> array(
					'vid'	=> 15260
				),
				'desc'			=> '会员充值、积分日志查询'
			),
		);
	}
	
	/**
	 * 充值日志
	 * @dataProvider dataCgi
	 * @param unknown_type $target_domain
	 * @param unknown_type $params
	 * @param unknown_type $desc
	 */
	function testStateLog( $target_domain, $params, $desc ) {
		$query_str = http_build_query( $params ) ;
		$target_cgi = "http://{$target_domain}/backend/state_log?$query_str";
		echo $target_cgi;
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $target_cgi ) ;
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ) ;
		$result = curl_exec($ch);
		var_dump($result);
	}
	
	/**
	 * 积分日志
	 * @dataProvider dataCgi
	 * @param unknown_type $target_domain
	 * @param unknown_type $params
	 * @param unknown_type $desc
	 */
	function testLevelLog( $target_domain, $params, $desc ) {
		$query_str = http_build_query( $params ) ;
		$target_cgi = "http://{$target_domain}/backend/level_log?$query_str";
		echo $target_cgi;
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $target_cgi ) ;
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ) ;
		$result = curl_exec($ch);
		var_dump($result);
	}
	
}