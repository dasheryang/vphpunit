<?php
class AliPayMinTest extends PHPUnit_Framework_TestCase {
	
	function dataCgi() {
		$target_domain = 'payv2.dev.ids111.com';
		$target_domain = 'sb1.pay.uu.cc';
//		$target_domain = 'sdkpay.uu.cc';
		
		return array(
			array(
				'target_domain'	=> $target_domain,
				'params' => array (
					  'discount' => '0.00',
					  'payment_type' => '1',
					  'subject' => '双倍分数（IAP激活类道具）',
					  'trade_no' => '2014062075360287',
					  'buyer_email' => 'vinray.lee@gmail.com',
					  'gmt_create' => '2014-06-20 11:36:57',
					  'notify_type' => 'trade_status_sync',
					  'quantity' => '1',
					  'out_trade_no' => 'pk_rssvuyyqw0yzzur0XlYXzzzzzzz0rr0yvzwxwuvxrxsz',
					  'seller_id' => '2088601247204288',
					  'notify_time' => '2014-06-20 11:36:58',
					  'body' => '得分双倍（IAP激活类道具）',
					  'trade_status' => 'TRADE_FINISHED',
					  'is_total_fee_adjust' => 'N',
					  'total_fee' => '0.02',
					  'gmt_payment' => '2014-06-20 11:36:58',
					  'seller_email' => 'michael.chen@idreamsky.com',
					  'gmt_close' => '2014-06-20 11:36:58',
					  'price' => '0.02',
					  'buyer_id' => '2088112912351872',
					  'notify_id' => '5aa766cd35a8be394c83cd36b84afbf76u',
					  'use_coupon' => 'N',
					  'sign_type' => 'RSA',
					  'sign' => 'X9Pjnro9+KTx+lq2U1d96MdOnGJD5TJp7NscbftqAENh7qYP92P83995HictP6FdZlLjz196svhUgzg9+0PuWMevZ4UzzDzwzAvWUh2UqsKjAxecv2UlIcSangPKN3i4CrdCkRpIWN5xsLbAKK+1QpapfoZZBX+DJCVjkmyo2e8=',
					)
			),
		);
		
	}
	
	/**
	 * 
	 * @dataProvider dataCgi
	 * @param unknown_type $target_domain
	 * @param unknown_type $params
	 */
	function testAliPayMin($target_domain, $params ) {
		$target_cgi = "http://{$target_domain}/ali_min_callback";
		
//		echo strlen( 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCrgEB/SyTpx3g0o4z6XHS8VWwC' ) ;
//		echo "\r\n";
		echo $target_cgi . "\r\n";
		$ch = curl_init() ;
		curl_setopt( $ch, CURLOPT_URL, $target_cgi ) ;
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ) ;
		curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $params ) ) ;
		$result = curl_exec( $ch ) ;
		echo $result ;
	}
} 