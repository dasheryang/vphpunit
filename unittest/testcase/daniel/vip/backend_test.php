<?php
require_once dirname( __FILE__ ) . "/conf/config.php";
class BackendTest extends PHPUnit_Framework_TestCase {
	
	const STATE_BIT_VALID = 				0x001;
	const STATE_BIT_EXPIRED = 				0x002;
	const STATE_BIT_YEAR = 					0x004;
	const STATE_BIT_CELLPHONE_BIND = 		0x008;
	
	
	
	function dataSetVip() {
		$target_domain = TARGET_DOMAIN;
		return array(
			array(
				'target_domain' => $target_domain,
				'udid'			=> '10000000-62b1-fd46-317b-74d84365ca4a',
				'target_state_bit' => self::STATE_BIT_YEAR,
				'state'			=> false,
				'desc'			=> '设置会员1'
			),
		);		
	}
	
	
	/**
	 * 
	 * @dataProvider dataSetVip
	 * @param unknown_type $target_domain
	 * @param unknown_type $udid
	 * @param unknown_type $target_state_bit
	 * @param unknown_type $state
	 * @param unknown_type $desc
	 */
	public function testGetVip($target_domain, $udid, $target_state_bit, $state, $desc){
		$target_domain = TARGET_DOMAIN;
		
		$target_cgi = "http://{$target_domain}/backend/get_vip?udid=$udid";
echo $target_cgi . "\r\n";
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $target_cgi ) ;
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ) ;
		$result = curl_exec($ch);
		var_dump($result);
	}
	
	
	
	/**
	 * 
	 * @dataProvider dataSetVip
	 * @param unknown_type $target_domain
	 * @param unknown_type $vid
	 * @param unknown_type $target_state_bit
	 * @param unknown_type $state
	 * @param unknown_type $desc
	 */
	public function testSetVip($target_domain, $udid, $target_state_bit, $state, $desc){
		$target_cgi = "http://{$target_domain}/backend/set_vip?udid=$udid&target_state_bit=$target_state_bit&state=$state";
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $target_cgi ) ;
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ) ;
		$result = curl_exec($ch);
		var_dump($result);
	}
//	
//	/**
//	 * 
//	 * @dataProvider dataSetVip
//	 * @param unknown_type $target_domain
//	 * @param unknown_type $udid
//	 * @param unknown_type $target_state_bit
//	 * @param unknown_type $state
//	 * @param unknown_type $desc
//	 */
//	public function testDelVip($target_domain, $udid, $target_state_bit, $state, $desc){
//		$target_domain = TARGET_DOMAIN;
//		$target_cgi = "http://{$target_domain}/backend/del_vip?udid=$udid";
//		$ch = curl_init();
//		curl_setopt( $ch, CURLOPT_URL, $target_cgi ) ;
//		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ) ;
//		$result = curl_exec($ch);
//		var_dump($result);
//	}
	
}