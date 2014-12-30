<?php

require_once dirname(dirname( __FILE__ )) . "/config/config.php";

class PUTestFindPasswd extends PHPUnit_Framework_TestCase {
    public function dataCGI(){
        $target_domain = TARGET_DOMAIN;
        $test_case_set = array();
        
        //MM 支付测试
        $test_case = array(
                'cgi' => "http://{$target_domain}/find_passwd",
                'get' => array(
                    'phone' => '15817435814',  //phone 手机号
                    'verify_code' => '1111',   //验证码
                    'step'  => '1', //步骤1,2 分两步，步骤一为了让前端可以进行验证码的验证，步骤二则是实现重置密码的功能
                    'password' => '111111', //新密码，步骤2中为必选参数
                ),
                'expect_result' => array(),
                'desc' => '找回密码',
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
    public function testCGIFindPasswd( $str_target_cgi, $post_arr, $url, $expect_result, $desc = '' ){
        $obj_curl = curl_init();
        curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
        curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
        //curl_setopt( $obj_curl, CURLOPT_HEADER, 1);
        curl_setopt( $obj_curl, CURLOPT_POST, count( $post_arr ) );
        curl_setopt( $obj_curl, CURLOPT_POSTFIELDS, $post_arr );
        
        $obj_ret_data = curl_exec( $obj_curl );

        curl_close($obj_curl);

        echo $obj_ret_data;     
        return;
    }
}
