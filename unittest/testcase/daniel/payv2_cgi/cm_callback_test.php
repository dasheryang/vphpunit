<?php
class CmCallbackTest extends PHPUnit_Framework_TestCase {
	
	function dataCgi() {
		$target_domain = 'payv2.dev.ids111.com';
		$target_domain = 'sb1.pay.uu.cc';
//		$target_domain = 'sdkpay.uu.cc';
		return array(
			array( 'target_domain'	=> $target_domain ),
			array( 'target_domain'	=> 'ly.feed.uu.cc')
		);
	}
	/**
	 * 
	 * @dataProvider dataCgi
	 * @param unknown_type $target_domain
	 */
	function testCgi( $target_domain ) {
		$target_cgi = "http://{$target_domain}/cm_callback/";
//		echo $target_cgi . "\r\n";
		
//		echo strstr('DD754751453', 'DD') . "\r\n";
		
		$post_data = '<?xml version="1.0" encoding="UTF-8"?><request><userId>1294487529</userId><contentId>651710063434</contentId><consumeCode>000063433002</consumeCode><cpid>710517</cpid><hRet>0</hRet><status>1800</status><versionId>21010</versionId><cpparam>00000DD754751453</cpparam><packageID /></request>';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $target_cgi);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$result = curl_exec($ch);
		var_export($result);
	}
}