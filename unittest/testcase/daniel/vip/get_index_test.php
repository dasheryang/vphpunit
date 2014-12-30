<?php
require_once dirname( __FILE__ ) . "/conf/config.php";
class GetIndexTest extends PHPUnit_Framework_TestCase {
	
	function dataCgi() {
		$target_domain = TARGET_DOMAIN ; 
		return array(
			array( 
				'target_domain'	=> $target_domain,
				'type'	=> 'udid',
				'value'	=> '00000000-62b1-fd46-317b-74d84365ca4a',
				'desc'	=> '设备ID'
			),
			array( 
				'target_domain'	=> $target_domain,
				'type'	=> 'vid',
				'value'	=> '15265',
				'desc'	=> '会员ID'
			),
			array( 
				'target_domain'	=> $target_domain,
				'type'	=> 'cellphone_no',
				'value'	=> '18688999460',
				'desc'	=> '手机号'
			),
		);
	}
	/**
	 * 
	 * @dataProvider dataCgi
	 * @param unknown_type $target_domain
	 * @param unknown_type $type
	 * @param unknown_type $value
	 */
	function testGetIndex( $target_domain, $type, $value, $desc ) {
		$target_cgi = "http://{$target_domain}/backend/get_index?type=$type&$type=$value";
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $target_cgi ) ;
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ) ;
		$result = curl_exec($ch);
		var_dump($result);
	}
}