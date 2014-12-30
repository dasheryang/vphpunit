<?php
class PUTestPaymentProfile extends PHPUnit_Framework_TestCase {
	public function dataPayecoCallback(){
		$arr_test_case_input_set = array();
		$valid_union_pay_order_input = array(
            'ProcCode' => '0210',
            'AccountNum' => '04',
            'ProcessCode' => '190000',
            'Amount' => '000000000001',
            'CurCode' => '01',
            'TransDatetime' => '0816183341',
            'AcqSsn' => '183341',
            'Ltime' => '183341',
            'Ldate' => '0816',
            'SettleDate' => '0816',
            'UpsNo' => '821248340213',
            'TsNo' => '006807',
            'ReturnAddress' => '02http://payv2.dev.ids111.com:81/payeco_callback?ENCODING=UTF-8',
            'RespCode' => '0000',
            'Remark' => '交易成功',
            'TerminalNo' => '50231411',
            'MerchantNo' => '02702020000003',
            'OrderNo' => '26DD1107647|702013081600012166',
            'OrderState' => '02',
            'Description' => '购买道具',
            'ValidTime' => '20130823183341',
            'OrderType' => '00',
            'TransData' => '|||01|未知|10.123.1.56|||||',
            'Mac' => '17481813BFB8BA42C022BDC5748C4C79'
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
	 * @dataProvider dataPayecoCallback
	 */
	public function testtestPayecoCallbackCGI( $union_pay_order_input, $bool_result_expect, $decs ){
		$str_target_url = "http://payv2.dev.ids111.com/payeco_callback";
//		$str_target_url = "http://eric.payv2.ids.com/payeco_callback?debug=2";

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
			$this->assertEquals( "0000" , $str_output );
		}else{
			$this->assertEquals( "0000" , $str_output );
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