<?php
/**
 * @target http://sdkpay.uu.cc/payments_check
 * 
 * 
 * @author austin.yang
 * @since 2013.08.30
 */

require_once dirname( __FILE__ ) . "/conf/config.php";
class PUTestPaymentCheck extends PHPUnit_Framework_TestCase {
	public function dataCGI(){
		$target_domain = TARGET_DOMAIN;
		return array(
			array(
					'cgi' => "http://{$target_domain}/payments/check?isadmin=1",
					'post' => array( 
// 									'order_id' => json_encode( array('DD1106769', 'DD1106770', 'DD1106775') ),
							'order_id' => json_encode( array( 'DD1106775') ),
							'auth_game_type' => 2,
					),
					'expect_result' => array( ),
					'desc' => '正常情况',
					'host' => $target_domain,
			),
		);
	}
	
	/**
	 * @dataProvider dataCGI
	 * 
	 * @param unknown $str_target_cgi
	 * @param unknown $expect_result
	 */
	public function testCGIPaymentCheck( $str_target_cgi, $post_arr, $expect_result, $desc = '', $host ){
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_HEADER, 1);
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		
		
		$request_header_str_set[] = "Content-Type: application/json";
		$nonce = time();
		
		//dev env
// 		$request_header_str_set[] = "AUTHORIZATION: OAuth oauth_consumer_key=8fee977f5ba1244dc4f1, nonce={$nonce}, oauth_token=8d80f954ef040ca6830f5fdc6934202f05281cd00, oauth_signature_method=HMAC-SHA1";
		
		//release env
		$request_header_str_set[] = "AUTHORIZATION: OAuth oauth_consumer_key=8fee977f5ba1244dc4f1, nonce={$nonce}, oauth_token=8285f185e6abc27036fa35508f66a5fa052831e4f, oauth_signature_method=HMAC-SHA1";
		
		// 		$request_header_str_set[] = "EAUTHORIZATION: OAuth oauth_consumer_key=8fee977f5ba1244dc4f1, oauth_token=8152185b1cd539d7e78359e8ccc41f290525df38b";
		curl_setopt( $obj_curl, CURLOPT_HTTPHEADER, $request_header_str_set );
		
		$post_json_str =<<<EOF
{"order_id":["DD293560915","DD293574499","DD293587375","DD293594265","DD293595525","DD293595821","DD293606189","DD293623079","DD293624267","DD293628191","DD293631707","DD293636343","DD293640097","DD293670163","DD293670955","DD293676603","DD293683441","DD293684631","DD293692481","DD293700203","DD293702389","DD293702895","DD293709795","DD293711727","DD293731043","DD295270101","DD295271057","DD295273563","DD295530447","DD295535081","DD295536967","DD295547609","DD295549885","DD295550819","DD295576225","DD295591119","DD295591441","DD295618569"]}
EOF;
		curl_setopt( $obj_curl, CURLOPT_POSTFIELDS, $post_json_str );
		
		$obj_ret_data = curl_exec( $obj_curl );
		
		$curl_info = curl_getinfo($obj_curl);
		$header_size = $curl_info['header_size'];
		$header_text = substr( $obj_ret_data, 0,$header_size );
		
		$body_str = substr($obj_ret_data, $header_size);
		
		var_dump("===header===", $header_text );
		var_dump("===body===", $body_str );
// 		var_dump( $order_id_count, $result_order_count  );
	}
}