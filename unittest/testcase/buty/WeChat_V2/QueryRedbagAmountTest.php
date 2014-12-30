<?php
class QueryRedbagAmountTest extends PHPUnit_Framework_TestCase {
	
	function dataCgi() {
		$target_domain = "test.feed.ids111.com:81";
//		$target_domain = 'sb1.feed.uu.cc';
//		$target_domain = 'in1.feed.uu.cc';
		$re_openid = 'oBHVnuL7_SQoEUsixPFUrU-A8u3A';
		return array(
			array(
				'target_domain'	=> $target_domain,
				'params'		=> array(
					'openid'	=> $re_openid,
					'consume_key' => 'ff15f96a336e5340a33c',
				),
				'desc'	=> 'WeChatShareConfigTest'
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
	function testQueryRedbagAmount( $target_domain, $params, $desc ) {
		$target_cgi = "http://$target_domain/query_redbag_amount/v2?" . http_build_query( $params ) ;
		echo $target_cgi, "\r\n";
		
		echo urldecode('https%3A%2F%2Fin1.secure.uu.cc%3A443%2Foauth%2Frequest_token&oauth_callback%3Ddgc-request-token-callback%26oauth_consumer_key%3DD76DCF49549589E9CE9B%26oauth_nonce%3D-8810795742582773338%26oauth_signature_method%3DHMAC-SHA1%26oauth_timestamp%3D1407312556%26oauth_version%3D1.0');
		
		
		
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $target_cgi ) ;
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ) ;
		$result = curl_exec( $ch ) ;
		echo $result ;
		echo "\r\n===========================================================================\r\n";
		$ret_obj = json_decode( $result , true ) ;
		print_r( $ret_obj ) ;
	}
}