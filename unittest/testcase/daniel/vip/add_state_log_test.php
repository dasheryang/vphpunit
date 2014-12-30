<?php
require_once dirname( __FILE__ ) . "/conf/config.php";
class AddStateLogTest extends PHPUnit_Framework_TestCase {
	
	
	const SUB_ACT_CHARGE_CM 		= 10020;		//中国移动包月支付
	
	const SUB_ACT_CHARGE_MONTH 		= 10031;		//支付宝单月付款
	const SUB_ACT_CHARGE_3_MONTH 	= 10033;		//支付宝季度付款
	const SUB_ACT_CHARGE_6_MONTH 	= 10036;		//支付宝半年付款
	const SUB_ACT_CHARGE_YEAR 		= 10030;		//支付宝年费付款
	
	function dataCgi() {
		$target_domain = TARGET_DOMAIN ; 
		return array(
			array( 
				'target_domain'	=> $target_domain,
				'params'	=> array(
					'vid'			=> 15260,
					'game_id'		=> 10058,
					'channel_id'	=> 'AL0S0N10000',
					'act_id'		=> 10,
					'sub_act_id'	=> self::SUB_ACT_CHARGE_CM,
					'state_attach'	=>'' 
				),
				'desc'			=> '充值日志'
			),
		);
	}
	
	/**
	 * 
	 * @dataProvider dataCgi
	 * @param unknown_type $target_domain
	 * @param unknown_type $params
	 * @param unknown_type $desc
	 */
	function testStateLog( $target_domain, $params, $desc ) {
		$query_str = http_build_query( $params ) ;
		$target_cgi = "http://{$target_domain}/backend/add_state_log?$query_str";
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $target_cgi ) ;
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ) ;
		$result = curl_exec($ch);
		var_dump($result);
	}
}