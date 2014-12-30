<?php
/**
 * @target http://sdkpay.uu.cc/payments/create
 * 
 * 
 * @author austin.yang
 * @since 2013.08.30
 */
require_once dirname( __FILE__ ) . "/conf/config.php";

class PUTestAlipayClientCallbackPackId extends PHPUnit_Framework_TestCase {
	public function dataCGI(){
		$target_domain = TARGET_DOMAIN;
		$test_case_set = array();
		
		$cur_time = time();
// 		$pack_id = "pk_20993303_10058_TEST0000000_1005800000001_{$cur_time}";
		$pack_id = "pk_xzzytzwzs0yzzur0XlYXzzzzzzz0vv0ywrwryzxwqxwj";
		
		$notify_data =<<<EOF
<notify><partner>2088601247204288</partner><discount>0.00</discount><payment_type>1</payment_type><subject>增大时空隧道（IAP消费类道具）</subject><trade_no>2013110677771150</trade_no><buyer_email>15986803156</buyer_email><gmt_create>2013-11-06 14:35:02</gmt_create><quantity>1</quantity><out_trade_no>{$pack_id}</out_trade_no><seller_id>2088601247204288</seller_id><trade_status>TRADE_FINISHED</trade_status><is_total_fee_adjust>N</is_total_fee_adjust><total_fee>0.01</total_fee><gmt_payment>2013-11-06 14:35:02</gmt_payment><seller_email>michael.chen@idreamsky.com</seller_email><gmt_close>2013-11-06 14:35:02</gmt_close><price>0.01</price><buyer_id>2088702850188504</buyer_id><use_coupon>N</use_coupon></notify>
EOF;
		$sign = 'lQPH+NE2YQqnhuWEToChZmxIVeP0HLb2+3ojFCKArAyhBUBaXokWAHcmDG4aQh3us7Bsh1KFzX+RDsDwKRoVLvVD4HpJJ+8V3uJ3slfDMnSLc4/y3kWIoEbQxmcyCorZ2JmntvIADYhzXn/ODwTwSx1HA1KNkfr2752cD3B4zxI=';
		
		$test_case = array(
								'cgi' => "http://{$target_domain}/alipay_client_callback?debug=0",
								'post' => array( 	"notify_data" => $notify_data,
													"sign" => $sign, ),
								'expect_result' => array(),
								'desc' => '创建测试订单',
						);
		$test_case_set[] = $test_case;

		return $test_case_set;
	}
	



	/**
	 * @dataProvider dataCGI
	 * 
	 * @param unknown $str_target_cgi
	 * @param unknown $expect_result
	 */
	public function testCGI( $str_target_cgi, $post_arr, $url, $expect_result, $desc = '' ){
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $obj_curl, CURLOPT_HEADER, 1);
		curl_setopt( $obj_curl, CURLOPT_POST, count( $post_arr ) );
		curl_setopt( $obj_curl, CURLOPT_POSTFIELDS, $post_arr );
		
		
		$request_header_str_set = array();
		// 		$request_header_str_set[] = "Content-Type: application/json";
		// 		f219e6f8c21657ee8ccf2fb47902c24e0525e2a8f
		$nonce = time();
		$request_header_str_set[] = "AUTHORIZATION: OAuth oauth_consumer_key=8fee977f5ba1244dc4f1, nonce={$nonce}, oauth_token=8285f185e6abc27036fa35508f66a5fa052831e4f, oauth_signature_method=HMAC-SHA1";
		
		// 		$request_header_str_set[] = "AUTHORIZATION: OAuth oauth_consumer_key=8fee977f5ba1244dc4f1, oauth_token=8152185b1cd539d7e78359e8ccc41f290525df38b";
		curl_setopt( $obj_curl, CURLOPT_HTTPHEADER, $request_header_str_set );
		
		$obj_ret_data = curl_exec( $obj_curl );
		
		$curl_info = curl_getinfo($obj_curl);
		$header_size = $curl_info['header_size'];
		$header_text = substr( $obj_ret_data, 0,$header_size );
		
		$body_str = substr($obj_ret_data, $header_size);
		
		var_dump("===header===", $header_text );
		var_dump("===body===", $body_str );
	}
}
