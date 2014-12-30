<?php
class GameConfigTest extends PHPUnit_Framework_TestCase {
	
	function dataCgi() {
		$target_domain = 'daniel.sdkfeed.com';
		$target_domain = "test.feed.ids111.com:81";
		$target_domain = 'sb1.feed.uu.cc';
//		$target_domain = 'in1.feed.uu.cc';
//		
		
		return array(
			array(
				'target_domain'	=> $target_domain,
				'params'		=> array(
					'consumer_key'	=> 'ff15f96a336e5340a33c',
					'channel_id'	=> 'TEST00000001',
					'level'			=> 2,
					'source_type'	=> '25'
				),
				'desc'		=> '游戏配制'
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
	function testGameConfig( $target_domain, $params, $desc ) {
		$target_cgi = "http://{$target_domain}/game_config?debug=0&" . http_build_query( $params ) ;
		//echo $target_cgi . "\r\n";
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $target_cgi ) ;
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 ) ;
		$result = curl_exec($ch) ;
		echo $result ;
		echo "\r\n\r\n";
		print_r( json_decode( $result ) ) ;
		return;
	}
}