<?php
require_once dirname( __FILE__ ) . "/conf/config.php";
class AddLevelLogTest extends PHPUnit_Framework_TestCase {
	
	
	// 	const ACT_TYPE_CHARGE 			= 10;
	
	const ACT_TYPE_BIND_PHONE 		= 20;
	
// 	const SUB_ACT_CHARGE_MONTH 		= 10020;
// 	const SUB_ACT_CHARGE_YEAR 		= 10021;
	
	
	const ACT_TYPE_CUSTOMER_SERVICE	= 30;	//客服补单
	
	const ACT_TYPE_CHARGE_AS_YEAR_MEMBER	= 50;	//身份变更为年费会员
	const ACT_TYPE_CHARGE_AS_MONTH_MEMBER	= 51;	//身份变更为月费会员
	
	function dataCgi() {
		$target_domain = TARGET_DOMAIN ; 
		return array(
			array( 
				'target_domain'	=> $target_domain,
				'params'	=> array(					// 客服补单15260  变更为年费会员增加50分
					'vid'			=> 15260,
					'game_id'		=> 10058,
					'channel_id'	=> 'AL0S0N10000',
					'act_id'		=> self::ACT_TYPE_CUSTOMER_SERVICE,
					'sub_act_id'	=> self::ACT_TYPE_CHARGE_AS_YEAR_MEMBER,
					'info'	=>'',
					'attach'	=> '',
					'ext_bonus'	=> 50,			// -50 为减五十 
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
		$target_cgi = "http://{$target_domain}/backend/add_level_log?$query_str";
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $target_cgi ) ;
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ) ;
		$result = curl_exec($ch);
		var_dump($result);
	}
}