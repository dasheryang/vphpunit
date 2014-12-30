<?php
require_once dirname( __FILE__ ) . "/conf/config.php";
class VipListTest extends PHPUnit_Framework_TestCase {
	
	function dataCgi() {
		$target_domain = TARGET_DOMAIN ; 
		return array(
			array( 
				'target_domain'	=> $target_domain,
				'params'	=> array(
					'db_index'			=> 0,
					'tbl_index'		=> 0,
					'page_index'	=> 0,
					'page_size'	=> 1,
				),
				'desc'			=> '会员列表'
			),
			array( 
				'target_domain'	=> $target_domain,
				'params'	=> array(
					'db_index'			=> 1,
					'tbl_index'		=> 0,
					'page_index'	=> 0,
					'page_size'	=> 10,
				),
				'desc'			=> '会员列表'
			)
		);
	}
	
	/**
	 * 
	 * @dataProvider dataCgi
	 * @param unknown_type $target_domain
	 * @param unknown_type $params
	 * @param unknown_type $desc
	 */
	function testVipList( $target_domain, $params, $desc ) {
		$query_str = http_build_query( $params ) ;
		$target_cgi = "http://{$target_domain}/backend/vip_list?$query_str";
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $target_cgi ) ;
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ) ;
		$result = curl_exec($ch);
		var_dump($result);
	}
}