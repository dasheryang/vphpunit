<?php
require_once dirname( __FILE__ ) . "/conf/config.php";
class SmsVerifyTest extends PHPUnit_Framework_TestCase {
	
	
	function dataCgi() {
		$target_domain = TARGET_DOMAIN;
		return array(
			array(
				'target_domain'	=> $target_domain,
				'params'	=> array(
					'udid'			=> '40000000-62b1-fd46-317b-74d84365ca4a',
					'phone'			=> '13510906325',
					'verify_type'	=> 1,
					'vid'			=> 15250,
				),	
				'desc'			=> '短信验证'			
			),
		);
	}
	/**
	 * 
	 * @dataProvider dataCgi
	 * @param unknown_type $target_domain
	 * @param unknown_type $udid
	 * @param unknown_type $phone
	 * @param unknown_type $verify_type
	 * @param unknown_type $desc
	 */
	function testSmsVerify( $target_domain, $params , $desc ) {		
		$target_cgi = "http://{$target_domain}/account/sms_verify?" . http_build_query($params);
		echo $target_cgi . "\r\n";
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $target_cgi );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ) ;
		$result = curl_exec( $ch ) ;
		echo $result ;
	}
}