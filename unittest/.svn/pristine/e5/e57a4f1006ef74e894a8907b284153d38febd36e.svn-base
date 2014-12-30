<?php
define("SRC_ROOT", '/var/www/ids_test/source_code/');
define("APP", SRC_ROOT . '/app/' );
define("DS", '/' );

class PUTestUnionPayVendorAPI extends PHPUnit_Framework_TestCase {
	public function dataGetTn(){
		$arr_test_data_set = array();
		
		$arr_test_data_set[] = array( 'DD1101432', 200, 'unittest' , '' );

		$arr_test_data_set[] = array( date("YmdHis") , 300, 'unittest' , false);
		return $arr_test_data_set;
	}
	
	/**
	 * @dataProvider dataGetTn
	 * 
	 * @author austin.yang 
	 * @date 2013-06-26
	 * @description 测试银联获取订单接口
	 */
	public function _testGetTn( $order_id, $recharge, $subject, $res_tn ){
		$upmp = new upmp();
		$res = $upmp->getTn($order = array('id' => $order_id), $recharge, $subject);

		$this->assertEquals( 0 , $res['respCode'] );
		if( !empty( $res_tn ) ){
			$this->assertEquals( $res_tn , $res['tn'] );
		}
	}
	
	
	public function dataGetOrder(){
		$arr_test_data_set = array();
		$arr_test_data_set[] = array( 'DD1101432' );
// 		$arr_test_data_set[] = array( 'DD11014' . date('s')  );
		return $arr_test_data_set;
	}
	
	/**
	 * 
	 * @dataProvider dataGetOrder	
	 * @param int $order_id
	 * 
	 * @description 关联测试  -- 检查获取用户订单接口
	 */
	public function _testGetOrder( $order_id ){
		$obj_order_workflow = new OrderWorkflow();
		$arr_order = $obj_order_workflow->getOrderById( $order_id, null, null, true, false );
		
		$this->assertEquals( $order_id , $arr_order["id"] );	
	}
	
	
	public function dataNotifyVerify(){
		$arr_test_case_input_set = array();
		$valid_union_pay_order_input = array(
		    'orderTime' => '20130628160709',
		    'settleDate' => '0519',
		    'respCode' => '00',
		    'orderNumber' => 'DD1105434',
		    'exchangeRate' => '0',
		    'charset' => 'UTF-8',
		    'signature' => '46207e049e7d5009994c9e1032d40931',
		    'sysReserved' => '{traceTime=0628160709&acqCode=01022900&traceNumber=099755}',
		    'settleCurrency' => '156',
		    'version' => '1.0.0',
		    'transType' => '01',
		    'settleAmount' => '10000',
		    'signMethod' => 'MD5',
		    'transStatus' => '00',
		    'reqReserved' => '乐逗游戏',
		    'merId' => '860000000000063',
		    'qn' => '201306281607090997551'
		);
		
		$order_input = $valid_union_pay_order_input;
		$arr_test_case_input_set[] = array( $order_input, true, '测试合法订单回调' );
		
		$order_input = $valid_union_pay_order_input;
		$order_input['transStatus'] = '01';
		$arr_test_case_input_set[] = array( $order_input, false, '测试transStatus 变更回调' );
		
		$order_input = $valid_union_pay_order_input;
		$order_input['signature'] = '';
		$arr_test_case_input_set[] = array( $order_input, false, '测试signature 篡改回调' );
		
		$order_input = $valid_union_pay_order_input;
		$order_input['orderNumber'] = '';
		$arr_test_case_input_set[] = array( $order_input, false, '测试orderNumber 篡改回调' );
		
		return $arr_test_case_input_set;
	}
	
	/**
	 * @dataProvider dataNotifyVerify
	 * 
	 * @param unknown $union_pay_order_input
	 * @param unknown $bool_result_expect
	 * @param unknown $decs
	 */
	public function testNotifyVerify( $union_pay_order_input, $bool_result_expect, $decs  ){	
		$upmp = new upmp();
		$bool_result = $upmp->notify_verify( $union_pay_order_input );
		if( $bool_result_expect ){
			$this->assertTrue( $bool_result );
		}else{
			$this->assertFalse( $bool_result );
		}
	}
	
	public function setUp(){
//		require_once '../utility/UTDataBaseDebugger.php';
		
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
		
		require_once SRC_ROOT . '/app/Controller/games_controller.php';
		
		require_once SRC_ROOT . '/app/Model/production.php';
		require_once SRC_ROOT . '/app/Model/order_workflow.php';
	}
}