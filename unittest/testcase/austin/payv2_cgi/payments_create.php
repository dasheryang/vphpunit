<?php
/**
 * @target http://sdkpay.uu.cc/payments/create
 * 
 * 
 * @author austin.yang
 * @since 2013.08.30
 */
require_once dirname( __FILE__ ) . "/conf/config.php";

class PUTestPaymentCreate extends PHPUnit_Framework_TestCase {
	public function dataCGI(){
		$target_domain = TARGET_DOMAIN;
		$test_case_set = array();

		//MM 支付测试
		$test_case = array(
				'cgi' => "http://{$target_domain}/payments/create?isadmin=1",
				'post' => array(
						'cb' => '1',
						'product_id' => '1137',
						'ext_trade_id' => '"FA10990B3CC3FCE0"',
						'type' => '2',
						'callback_use_time' => 16,
						'ext_app_id' => '"300002848575"',
						'paymentstate' => '1',
						'sms_statue' => '-1',
						'paymethod' => '37',
						'quantity' => 1,
						'os' => 'MIUI-JLB21.0',
						'imei' => '862663026540312',
						'net_type' => 'wifi',
						'client_time' => 1387519652,
						'udid' => '00000000-62b1-fd46-317b-74d84365ca4a',
						'channel_id' => 'AL0S0N10000',
						'ip' => 'fe80::faa4:5fff:fe33:2985%wlan0',
						'security_software' => 'com.imangi.templerun2;com.halfbrick.fruitninja;com.miui.voiceassist;com.halfbrick.fruitninja;com.miui.video;com.xiaomi.shop;com.kiloo.subwaysurf;',
						'recharge' => '0.1',
						'price' => '0.1',
						'auth_game_type' => '2',
						'extral_info' => '',
						'nudid' => '379_01r177590768p138015r54040r3s7',
						'cli_ver' => '2.0.4',
						'imsi' => '460009471561732',
				),
				'expect_result' => array(),
				'desc' => 'MM 支付测试',
		);
// 		$test_case_set[] = $test_case;
		
		//MM 支付测试
		$test_case = array(
				'cgi' => "http://{$target_domain}/payments/create?isadmin=1&debug=0",
				'post' => array (
						  'cb' => '1',
						  'product_id' => '1029',
						  'ext_trade_id' => '"2E43E048A0D20A00"',
						  'type' => '2',
						  'callback_use_time' => 16,
						  'ext_app_id' => '"300002932641"',
						  'paymentstate' => '1',
						  'sms_statue' => '-1',
						  'apk_sign' => '952f6e9586887fcd3cb1ed7f24eb919e',
						  'paymethod' => '37',
						  'quantity' => 1,
						  'os' => 'MIUI-JLB21.0',
						  'imei' => '862663026540312',
						  'net_type' => 'wifi',
						  'client_time' => 1389065610,
						  'udid' => '00000000-62b1-fd46-317b-74d84365ca4a',
						  'channel_id' => 'AB0S0N00000',
						  'ip' => 'fe80::faa4:5fff:fe33:2985%wlan0',
						  'security_software' => 'com.miui.voiceassist;com.kiloo.subwaysurf;com.tencent.mm;com.tencent.mm;com.qihoo.wanyou;com.qihoo.appstore;com.qihoo.appstore;',
						  'recharge' => '2.0',
						  'price' => '2.0',
						  'auth_game_type' => '2',
						  'extral_info' => '',
						  'nudid' => '379_01r177590768p138015r54040r3s7',
						  'cli_ver' => '2.0.8',
						  'imsi' => '460009471561732',
							),
				'expect_result' => array(),
				'desc' => 'MM 支付测试',
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
	public function testCGIPaymentCreate( $str_target_cgi, $post_arr, $url, $expect_result, $desc = '' ){
		
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $obj_curl, CURLOPT_HEADER, 1);
		curl_setopt( $obj_curl, CURLOPT_POST, count($post_arr) );
		curl_setopt( $obj_curl, CURLOPT_POSTFIELDS, json_encode( $post_arr ) );
		
// 		curl_setopt($obj_curl, CURLOPT_HEADER, true);
		$request_header_str_set = array();		
		$request_header_str_set[] = "Content-Type: application/json";
// 		f219e6f8c21657ee8ccf2fb47902c24e0525e2a8f
		$nonce = time();
// 		$request_header_str_set[] = "AUTHORIZATION: OAuth oauth_consumer_key=8fee977f5ba1244dc4f1, nonce={$nonce}, oauth_token=8285f185e6abc27036fa35508f66a5fa052831e4f, oauth_signature_method=HMAC-SHA1";
		
		//sdkpay

// 		$request_header_str_set[] = "Authorization: OAuth oauth_consumer_key=8fee977f5ba1244dc4f1, oauth_token=71be2b8f934efd105e6424afa8e17024052bac7e6, oauth_signature_method=HMAC-SHA1, oauth_signature=J2ulUt0t2WuKLZQnsYx%2FpYwbYlA%3D, oauth_timestamp=1388025698, oauth_nonce=5223252978098474697, oauth_version=1.0, oauth_signature_v2=mMxH9qubndRsMdIS2xhOgxbKJjw%3D";
		
// 		$request_header_str_set[] = "Authorization: OAuth oauth_consumer_key=8fee977f5ba1244dc4f1, oauth_token=47548c9c516232ee6b664a2f70cfe0ab052bba0e9, oauth_signature_method=HMAC-SHA1, oauth_signature=z1VQy4mG7Ild%2BF3oIlr6K2IME3c%3D, oauth_timestamp=1388028345, oauth_nonce=3336778983267211937, oauth_version=1.0, oauth_signature_v2=1rRlyLwzvnRF9HOuM7RJ9MIJB7s%3D";
		
//		$request_header_str_set[] = "Authorization: OAuth oauth_consumer_key=8fee977f5ba1244dc4f1, oauth_token=71be2b8f934efd105e6424afa8e17024052bac7e6, oauth_signature_method=HMAC-SHA1, oauth_signature=2MEVG9RRSzAvUxVuAqQ%2FjP6lexg%3D, oauth_timestamp=1388022958, oauth_nonce=593188173238187076, oauth_version=1.0, oauth_signature_v2=dQiMpxYtmd7hwB%2FcdJ%2B3OdJqiDc%3D";
// 		User-Agent: SkyNet/2.0(android:4.2.1;channel:DS0S0N00010;udid:608_5555915654449550n706q8pqoppp9;app_version:1.0;package:com.idreamsky.linefollow;sdk_version:201308071742;network_type:wifi;imei:004999010640000;device_brand:samsung;device_model:Galaxy Nexus;resolution:720X1184;lang:zh_CN;cpu_freq:1200000;game_name:V2_Demo_Leisure_Game;encoded:true);
		
// 		$request_header_str_set[] = "Authorization: OAuth oauth_consumer_key=0179030db72fac7e43cc, oauth_token=4d811e38311bdaf056d65827c2006df605292fa17, oauth_signature_method=HMAC-SHA1, oauth_signature=fDsHnl0XOkaPYrcnrSNX8Ys79Rk%3D, oauth_timestamp=1385364007, oauth_nonce=3130601815695400405, oauth_version=1.0, oauth_signature_v2=0PR8AqBUT8%2BWxdh8KQxSjsKQX9Q%3D";
// 		$request_header_str_set[] = "Authorization: OAuth oauth_consumer_key=0179030db72fac7e43cc, oauth_token=8a1fc828c3ac3dd63bb7362a3b04cf7905292fca5, oauth_signature_method=HMAC-SHA1, oauth_signature=qVoCuSku1TKIJ2PWVYEiy1C9IWg%3D, oauth_timestamp=1385364658, oauth_nonce=5941817646001803668, oauth_version=1.0, oauth_signature_v2=m5ByBf4J13DodhiaBr5TD8k%2BpJE%3D";
		
		
		//sb1
		$request_header_str_set[] = "Authorization: OAuth oauth_consumer_key=e19081b4527963d70c7a, oauth_token=10b0238d8d66eb27c504261199daa0bf052cb7339, oauth_signature_method=HMAC-SHA1, oauth_signature=bP%2BmWLzMJRVuNO6NS7XR2Bgy2Ug%3D, oauth_timestamp=1389065173, oauth_nonce=3495990193026396601, oauth_version=1.0, oauth_signature_v2=18bkv8DDQtNrlTimF79UlAKu0Po%3D";
// 		$request_header_str_set[] = "AUTHORIZATION: OAuth oauth_consumer_key=8fee977f5ba1244dc4f1, oauth_token=8152185b1cd539d7e78359e8ccc41f290525df38b";
		curl_setopt( $obj_curl, CURLOPT_HTTPHEADER, $request_header_str_set );
		
		$obj_ret_data = curl_exec( $obj_curl );
		
		$curl_info = curl_getinfo($obj_curl);
		$header_size = $curl_info['header_size'];
		$header_text = substr( $obj_ret_data, 0,$header_size );
		
		$body_str = substr($obj_ret_data, $header_size);
		
		var_dump("===header===", $header_text );
		var_dump("===body===", $body_str );
		
		return;
	}
}
