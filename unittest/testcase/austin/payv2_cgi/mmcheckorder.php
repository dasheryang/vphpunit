<?php
/**
 * @target http://sdkpay.uu.cc/get_player_payment_group
 * 
 * 
 * @author austin.yang
 * @since 2013.08.30
 */
require_once dirname( __FILE__ ) . "/conf/config.php";
class PUTestMMexport extends PHPUnit_Framework_TestCase {
	public function get_check_data(){
// 		$data_record = array(
// 				'cgi' => 'http://ospd.mmarket.com:8089/trust',
// 				'tarde_id' => '137D19664C7F5A8B',
// 				'app_id' => '300002848575',
// 		);
		
		$data_set = array();
		
		$data_record = array(
				'cgi' => 'http://ospd.mmarket.com:8089/trust?debug=2',
				'tarde_id' => 'FA10990B3CC3FCE0',
				'app_id' => '300002848575',
		);
// 		$data_set[] = $data_record;
		
		$data_record = array(
				'cgi' => 'http://ospd.mmarket.com:8089/trust?debug=2',
				'tarde_id' => '4AC03D20BD359935',
				'app_id' => '300002932641',
		);
		$data_set[] = $data_record;
		
		return $data_set;
	}
	/**
	 * @dataProvider get_check_data
	 */
	public function testCheck( $cgi, $trade_id, $app_id ){
		$post_data =<<<EOF
<?xml version="1.0" standalone="yes"?>
<Trusted2ServQueryReq>
	<MsgType>Trusted2ServQueryReq</MsgType><Version>1.0.0</Version>
	<TradeID>{$trade_id}</TradeID>
	<AppID>{$app_id}</AppID>
	<OrderType>1</OrderType>
</Trusted2ServQueryReq>
EOF;
	
		$post_arr = array();
		$str_target_cgi = $cgi;
		
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $obj_curl, CURLOPT_POST, 1 );
		curl_setopt( $obj_curl, CURLOPT_POSTFIELDS, $post_data );
	
		curl_setopt( $obj_curl, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
		
		$obj_ret_data = curl_exec( $obj_curl );
		
		$xml = simplexml_load_string( $obj_ret_data );
		$result = $xml->xpath( "ReturnCode" );
		$trade_id = $xml->xpath( "TradeID" );
		
		var_dump( $post_data, '================================', '================================', $obj_ret_data, intval($result[0]) );
	}

}
