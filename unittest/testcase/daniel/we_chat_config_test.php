<?php
class WeChatConfigTest extends PHPUnit_Framework_TestCase {
	
	
	function dataCgi() {
		
		$target_domain = "test.feed.ids111.com:81";
		$target_domain = 'sb1.feed.uu.cc';
//		$target_domain = 'in1.feed.uu.cc';
		return array(
			array(
				'target_domain'	=> $target_domain,
				'params'		=> array(
					'consume_key'	=> 'e19081b4527963d70c7a',
					'channel_id'	=> 'TEST0000000',
					'share_target'	=> '',
					'is_red_bag'	=> 1,
					'red_bag_num'	=> rand(1,5),
					'test'			=> 1
				),
				'desc'	=> 'We Chat Config'
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
		$target_cgi = "http://$target_domain/sns/wechat_share_config?" . http_build_query( $params ) ;
		echo $target_cgi, "\r\n";
		
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $target_cgi ) ;
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ) ;
		$result = curl_exec( $ch ) ;
		$ret_obj = json_decode( $result , true ) ;
		print_r( $ret_obj ) ;
	}
	/**
	 * 
	 * 红包发放总数
	 * @dataProvider dataCgi
	 * @param unknown_type $target_domain
	 */
	function testRedBagCount( $target_domain ) {
		$target_cgi = "http://$target_domain/sns/wechat_redbag_count?" ;
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $target_cgi ) ;
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ) ;
		$result = curl_exec( $ch ) ;
		echo $result;
		return;
	}
}