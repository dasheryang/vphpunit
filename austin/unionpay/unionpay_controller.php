<?php
class PUTestPaymentProfile extends PHPUnit_Framework_TestCase {
	public function dataUPMPCallback(){
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
		$arr_test_case_input_set[] = array( $order_input, true, '合法订单参数' );
	
// 		$order_input = $valid_union_pay_order_input;
// 		$order_input['transStatus'] = '01';
// 		$arr_test_case_input_set[] = array( $order_input, false, '测试transStatus 变更回调' );
	
// 		$order_input = $valid_union_pay_order_input;
// 		$order_input['signature'] = '';
// 		$arr_test_case_input_set[] = array( $order_input, false, '测试signature 篡改回调' );
	
		$order_input = $valid_union_pay_order_input;
		$order_input['orderNumber'] = '';
		$arr_test_case_input_set[] = array( $order_input, false, '测试orderNumber 篡改回调' );
	
		$order_input = array();
		$arr_test_case_input_set[] = array( $order_input, false, '测试空输入' );
		
		return $arr_test_case_input_set;
	}
	
	/**
	 * @dataProvider dataUPMPCallback
	 */
	public function testtestUPMPCallbackCGI( $union_pay_order_input, $bool_result_expect, $decs ){
		$str_target_url = "http://test.ids.com/upmp_callback?isadmin=1";
		
		$post_string = '';
		foreach( $union_pay_order_input as $key => $value ){
			$value = rawurlencode( $value );
			$post_string .= $key.'='.$value.'&';
		}
		rtrim( $post_string );
		
		$ch = curl_init();
		$request_header = array(
				"content-type: application/x-www-form-urlencoded; charset=UTF-8"
		);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $request_header);
		
		curl_setopt($ch, CURLOPT_URL, $str_target_url);
		curl_setopt($ch, CURLOPT_POST, count($union_pay_order_input));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
		
		$str_output = curl_exec( $ch );
		
		if( $bool_result_expect ){
			$this->assertEquals( "success" , $str_output );
		}else{
			$this->assertEquals( "fail" , $str_output );
		}

	}
	

	/**
	 * @dataProvider dataUPMPCallback
	 */
	public function testUPMPCallback( $union_pay_order_input, $bool_result_expect, $decs ){
		$controller = new PaymentCallbackController();
		
		ob_start();
		$controller->upmp_callback( $union_pay_order_input );
		
		$str_output = ob_get_contents();
		ob_end_clean();
		
// 		var_dump( "==", $str_output, "====");
		if( $bool_result_expect ){
			$this->assertEquals( "success" , $str_output );
		}else{
			$this->assertEquals( "fail" , $str_output );
		}
	}


	
	public function setUp(){
		require_once '../utility/CakeLib.php';
		
		require_once '../utility/UTDataBaseDebugger.php';
		
		require_once SRC_ROOT . '/app/Vendor/payment/upmp.php';
		require_once SRC_ROOT . '/app/Controller/PaymentCallbackController.php';
		
		require_once SRC_ROOT . '/app/Model/production.php';
		require_once SRC_ROOT . '/app/Model/order_workflow.php';
	}
}

class OrderWorkFlowInjector{
	
}