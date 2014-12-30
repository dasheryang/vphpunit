<?php
class PUTestPaymentProfile extends PHPUnit_Framework_TestCase {
	public function dataCallback(){
		$arr_test_case_input_set = array();
		$valid_union_pay_order_input = array(
                'version_id' => '3.00',
                'merchant_id' => '220173',
                'order_date' => '20130826',
                'order_id' => 'DD1100006',
                'result' => 'Y',
                'amount' => '30.00',
                'currency' => 'RMB',
                'pay_sq' => 'GWC13082610092407793',
                'pay_date' => '20130826100932',
                'user_name' => '',
                'user_phone' => '',
                'user_mobile' => '',
                'user_email' => '',
                'order_pname' => '',
                'order_pdesc' => '',
                'count' => '1',
                'card_num1' => 'a8a9437b00a727b17e9ff9ee2be26ba384f811381eb70bdc',
                'card_pwd1' => '3bd98c550c860e85ca8e003fdc1d09f80bec799203e1d1be',
                'pm_id1' => 'CMJFK',
                'pc_id1' => 'CMJFK00010001',
                'card_status1' => '0',
                'card_code1' => '00000',
                'card_date1' => '20130826100932',
                'r1' => '0',
                'verifystring' => '7e4229263ae1bae8d95debed23757691'
		);
	
		$order_input = $valid_union_pay_order_input;
		$arr_test_case_input_set[] = array( $order_input, true, '合法订单参数' );
	
// 		$order_input = $valid_union_pay_order_input;
// 		$order_input['transStatus'] = '01';
// 		$arr_test_case_input_set[] = array( $order_input, false, '测试transStatus 变更回调' );
	
// 		$order_input = $valid_union_pay_order_input;
// 		$order_input['signature'] = '';
// 		$arr_test_case_input_set[] = array( $order_input, false, '测试signature 篡改回调' );
	
//		$order_input = $valid_union_pay_order_input;
//		$order_input['orderNumber'] = '';
//		$arr_test_case_input_set[] = array( $order_input, false, '测试orderNumber 篡改回调' );
	
		//$order_input = array();
		//$arr_test_case_input_set[] = array( $order_input, false, '测试空输入' );
		
		return $arr_test_case_input_set;
	}
	
	/**
	 * @dataProvider dataCallback
	 */
	public function testCallbackCGI( $union_pay_order_input, $bool_result_expect, $decs ){
		$str_target_url = "http://payv2.dev.ids111.com/yijiupay_callback";
//		$str_target_url = "http://eric.payv2.ids.com/yijiupay_callback?debug=2";

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
			$this->assertEquals( "Y" , $str_output );
		}else{
			$this->assertEquals( "Y" , $str_output );
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