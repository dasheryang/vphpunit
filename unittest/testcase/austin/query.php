<?php
class PUTestUnionPayQuery extends PHPUnit_Framework_TestCase {
	public function testQuery(){	
		$arr_result = union_pay_query_demo();
		$this->assertEquals( upmp_config::RESPONSE_CODE_SUCCESS , $arr_result['respCode'] );
	}
	
	protected function setUp(){
		//include framework files 
		//define( "SRC_ROOT", '/var/www/austin/unionpay/' );
			
		$app_src_path = '/var/www/austin/unionpay/';
		require_once $app_src_path . '/examples/query.php';
	}
}