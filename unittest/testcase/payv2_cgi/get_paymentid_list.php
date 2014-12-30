<?php
/**
 * @target http://sdkpay.uu.cc/get_paymentid_list
 *
 *
 * @author austin.yang
 * @since 2013.08.02
 */

class PUTestPaymentPList extends PHPUnit_Framework_TestCase {
	
	public function dataCgi(){
		$target_domain = 'payv2.dev.ids111.com';
//		$target_domain = 'sb1.pay.uu.cc';
		$target_domain = 'sdkpay.uu.cc';
		return array(
			array(
				'target_domain' => $target_domain,
				'nudid'			=> '722r38_33473159521530875np6s7s8rn',
				'app_key'		=> 'eec4e576059858acf97d',		//索尼克冲刺
				'app_version'	=> '1.1.1',
				'channel_id'	=> 'TEST0000000',
				'ip'			=> '192.168.0.1',
				'code'			=> '02ff',
				'desc'			=> '索尼克冲刺, 关停CM-MM2,CT-PUB 所有版本'
			),
			array(
				'target_domain' => $target_domain,
				'nudid'			=> '722r38_33473159521530875np6s7s8rn',
				'app_key'		=> 'e19081b4527963d70c7a',		
				'app_version'	=> '1.1.2',
				'channel_id'	=> 'TEST0000000',
				'ip'			=> '192.168.0.1',
				'code'			=> '07fe',
				'desc'			=> '地铁跑酷, 关停CM 所有版本'
			),
			array(
				'target_domain' => $target_domain,
				'nudid'			=> '722r38_33473159521530875np6s7s8rn',
				'app_key'		=> 'e19081b4527963d70c7a',		
				'app_version'	=> '1.1.2',
				'channel_id'	=> 'TEST0000000',
				'ip'			=> '192.168.0.1',
				'code'			=> '07fe',
				'desc'			=> '地铁跑酷激活版, 关停CM 所有版本'
			),
			
			array(
				'target_domain' => $target_domain,
				'nudid'			=> '722r38_33473159521530875np6s7s8rn',
				'app_key'		=> '078bdbdcda68dd2b3acd',		
				'app_version'	=> '1.1.2',
				'channel_id'	=> 'TEST0000000',
				'ip'			=> '192.168.0.1',
				'code'			=> '06ff',
				'desc'			=> '天天泡泡堂2, 关停CM-MM2 所有版本'
			),
			
			
		);
	}
	

	/**
	 * @dataProvider dataCgi
	 * 
	 * @param unknown $str_target_cgi
	 * @param unknown $expect_result
	 */
	public function testCgi( $target_domain, $nudid,  $app_key, $app_version, $channel_id , $ip, $code, $desc){
		$cgi_url = "http://{$target_domain}/get_paymentid_list?game_type=2&nudid={$nudid}&p_list=000007D7&sim=1&pay=4&cli_ver=201308071742&app_key=$app_key&channel_id=$channel_id&debug=0&udid=abc";
		if ( $ip ) {
			$cgi_url .= "&ip={$ip}";
		}
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $cgi_url );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, true );
		
		$userAgent = "SkyNet/1.5.2-0000(app_version:$app_version;sdk_version:2.0)";
		curl_setopt( $obj_curl , CURLOPT_USERAGENT, $userAgent ); 		
		$obj_ret_data = curl_exec( $obj_curl );
		$obj_info = curl_getinfo($obj_curl);
		
		echo "\r\n====================={$desc}=============================\r\n";
		echo "=======Priority: CM,CU,CT,CM-MM,CU-WO,CT-TY,ALI,CODE,CM-MM2,CT-TYLOCAL,CT-PUB==========\r\n";
		echo $obj_ret_data; 
		
		$obj_result = json_decode($obj_ret_data, true);
		$code_result = $obj_result['result']['code'];
		$this->assertEquals($code_result, $code);		
	}
	
	
}