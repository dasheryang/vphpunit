<?php
require_once dirname( __FILE__ ) . "/conf/config.php";
class SetVipLevelTest extends PHPUnit_Framework_TestCase {
	
	function dataCgi() {
		$target_domain = TARGET_DOMAIN ; 
		return array(
			array( 
				'target_domain'	=> $target_domain,
				'params'	=> array(
					'vid'			=> '15260',
					'game_id'		=> 10058,
					'channel_id'	=> 'TEST000000',
					'sub_act_id'	=> '',
					'info'			=> '00000000-62b1-fd46-317b-74d84365ca4a',
					'attach'		=> '',
					'ext_bonus'		=> -50,				// -50
				),
				'desc'			=> '设置vip等级'
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
	function testSetVipLevel( $target_domain, $params, $desc ) {
		$query_str = http_build_query( $params ) ;
		$target_cgi = "http://{$target_domain}/backend/set_vip_level?$query_str";
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $target_cgi ) ;
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ) ;
		$result = curl_exec($ch);
		var_dump($result);
	}
}