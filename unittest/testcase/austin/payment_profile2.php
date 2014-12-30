<?php
define("SRC_ROOT", '/var/www/ids_test/source_code/');
define("APP", SRC_ROOT . '/app/' );
define("DS", '/' );

class PUTestPaymentProfile extends PHPUnit_Framework_TestCase {
	
	public function testCGI( $str_target_cgi = '', $expect_result = '' ){
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		$obj_ret_data = curl_exec( $obj_curl );
		
		
	}
	
	public function dataCGIPaymentProfile(){
		return array(
 			
			array(
					'http://test.ids.com/paymentprofile?game_id=10060&channel_id=&type=0&pack_ver=1&isadmin=1',
					array( 'field_count' => 3 ),
			),
			array(
					'http://test.ids.com/paymentprofile?game_id=10060&channel_id=&type=0&isadmin=1',
					array( 'field_count' => 10 ),
			),
		);
	}
	
	/**
	 * @dataProvider dataCGIPaymentProfile
	 * 
	 * @param unknown $str_target_cgi
	 * @param unknown $expect_result
	 */
	public function _testPaymentProfileCGI( $str_target_cgi, $expect_result ){
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		$obj_ret_data = curl_exec( $obj_curl );
		
		$json_ret = json_decode( $obj_ret_data, true );
		
		$this->assertFalse( empty( $json_ret ) );
		
		$arr_result = $json_ret['result'];
		$this->assertFalse( empty( $arr_result ) );
		
		$field_count = count( array_keys( $arr_result[0] ) );
		$this->assertEquals( $expect_result['field_count'] , $field_count );
	}
	
	
	public function dataPaymentHelpInfoCGI(){
		$current_version = $this->_getCurrentHelpInfoVersion();
		$next_version = $current_version + 1;
		return array(
				array(
						"http://test.ids.com/paymentprofle/help?isadmin=1",
						array( 'code' => 200 ),
						"请求版本号参数为空，模拟用户首次请求时状况"
				),
				array(
						"http://test.ids.com/paymentprofle/help?isadmin=1&version={$current_version}",
						array( 'code' => 304 ),
						"用户版本号等于 服务器最新版本号",
				),
				
				array(
						"http://test.ids.com/paymentprofle/help?isadmin=1&version={$next_version}",
						array( 'code' => 304 ),
						"用户版本号大于 服务器最新版本号",
				),
		);
		
	}
	private function _getCurrentHelpInfoVersion(){
		$str_target_cgi = "http://test.ids.com/paymentprofle/help?isadmin=1";
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		$obj_ret_data = curl_exec( $obj_curl );
		
		$arr_result = json_decode( $obj_ret_data, true );
		$version = $arr_result['version'];
		return $version;
	}
	
	/**
	 * @dataProvider dataPaymentHelpInfoCGI
	 * @param unknown $str_target_cgi
	 * @param unknown $expect_result
	 * @param unknown $desc
	 */
	public function testPaymentHelpInfoCGI( $str_target_cgi, $expect_result, $desc ){
		$obj_curl = curl_init();
		curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
		curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
		$obj_ret_data = curl_exec( $obj_curl );
		//var_dump( $obj_ret_data );
		
		//测试返回数据完整
		$this->assertFalse( empty( $obj_ret_data ) );
		
		//测试返回json 解包完成
		$arr_result = json_decode( $obj_ret_data, true );
		$this->assertFalse( empty($arr_result ) );
		
		//测试版本号大于 0 
		$this->assertTrue( $arr_result['version'] > 0 );
		
		//测试返回码符合预期
		$this->assertEquals( $arr_result['code'] , $expect_result['code'] );
		
		//判断内容是否为空  期望返回码为 200 时 返回内容 content 字段，其他情况下 content 为空
		if( 200 == $arr_result['code'] ){
			$this->assertFalse( empty( $arr_result['content'] ) );
			var_dump( $arr_result['content'] );
		}else{
			$this->assertTrue( empty( $arr_result['content'] ) );
		}
		
		
	}
	
	
	public function setUp(){
		
		require_once '../utility/UTDataBaseDebugger.php';
		
		//include framework files
		require_once SRC_ROOT . '/lib/Cake/basics.php';
		require_once SRC_ROOT . '/lib/Cake/Core/App.php';
		require_once SRC_ROOT . '/lib/Cake/Core/Object.php';
		require_once SRC_ROOT . '/lib/Cake/Core/Configure.php';
		require_once SRC_ROOT . '/lib/Cake/Core/CakePlugin.php';
		
		require_once SRC_ROOT . '/lib/Cake/I18n/I18n.php';
		require_once SRC_ROOT . '/lib/Cake/I18n/L10n.php';
		
		require_once SRC_ROOT . '/lib/Cake/Cache/Cache.php';
		
		require_once SRC_ROOT . '/lib/Cake/Network/CakeRequest.php';
		
		require_once SRC_ROOT . '/lib/Cake/Configure/PhpReader.php';
		 
		require_once SRC_ROOT . '/lib/Cake/Utility/Set.php';
		require_once SRC_ROOT . '/lib/Cake/Utility/Inflector.php';
		require_once SRC_ROOT . '/lib/Cake/Utility/ObjectCollection.php';
		require_once SRC_ROOT . '/lib/Cake/Utility/ClassRegistry.php';
		 
		require_once SRC_ROOT . '/lib/Cake/Model/Model.php';
		require_once SRC_ROOT . '/lib/Cake/Model/ConnectionManager.php';
		require_once SRC_ROOT . '/lib/Cake/Model/BehaviorCollection.php';
		
		require_once SRC_ROOT . '/lib/Cake/Model/Datasource/DataSource.php';
		require_once SRC_ROOT . '/lib/Cake/Model/Datasource/DboSource.php';
		require_once SRC_ROOT . '/lib/Cake/Model/Datasource/Database/Mysql.php';
		
		
		require_once SRC_ROOT . '/lib/Cake/Error/exceptions.php';
		 
		require_once SRC_ROOT . '/lib/Cake/Controller/Controller.php';
		require_once SRC_ROOT . '/lib/Cake/Controller/ComponentCollection.php';
		 
		require_once APP . '/Controller/AppController.php';
		require_once APP . '/Config/define.php';
		 
		require_once APP . '/Model/AppModel.php';
		
//		\Model\Datasource\Database\Mysql.php
		 
		//include target source files
		require_once SRC_ROOT . '/app/Vendor/payment/upmp.php';
		
		require_once SRC_ROOT . '/app/Controller/paymentprofiles_controller.php';
		
		require_once SRC_ROOT . '/app/Model/production.php';
		require_once SRC_ROOT . '/app/Model/order_workflow.php';
	}
}