<?php
class WeChatShareConfigTest extends PHPUnit_Framework_TestCase {
	
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
	function testWeChatConfig( $target_domain, $params, $desc ) {
		$target_cgi = "http://$target_domain/wechat_redbag_deposit/v2?" . http_build_query( $params ) ;
		echo $target_cgi, "\r\n";
		
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