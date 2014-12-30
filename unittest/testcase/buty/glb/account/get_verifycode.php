<?php

require_once dirname(dirname( __FILE__ )) . "/config/config.php";

class PUTestGetVerifycode extends PHPUnit_Framework_TestCase {
    public function dataCGI(){
        $target_domain = TARGET_DOMAIN;
        $test_case_set = array();
        
        //MM 支付测试
        $test_case = array(
                'cgi' => "http://{$target_domain}/get_verifycode?type=getPassword&phone=15817435814",
                'get' => array(
                    'type'  => 'getPassword', //type 类型 1:register,用户注册;2:bindPhone,绑定手机;3:getPassword,找回密码
                    'phone' => '15817435814'  //phone 手机号
                ),
                'expect_result' => array(),
                'desc' => '请求发送验证码',
        );
        $test_case_set[] = $test_case;

        return $test_case_set;
    }
    
    /**
     * @dataProvider dataCGI
     * 
     * @param unknown $str_target_cgi
     * @param unknown $expect_result
     */
    public function testCGIGetVerifycode( $str_target_cgi, $post_arr, $url, $expect_result, $desc = '' ){
        $obj_curl = curl_init();
        curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
        curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
        //curl_setopt( $obj_curl, CURLOPT_HEADER, 1);
        //curl_setopt( $obj_curl, CURLOPT_POST, count( $post_arr ) );
        //curl_setopt( $obj_curl, CURLOPT_POSTFIELDS, $post_arr );
        
        $obj_ret_data = curl_exec( $obj_curl );

        curl_close($obj_curl);

        echo $obj_ret_data;     
        return;
    }
}
