<?php

require_once dirname(dirname( __FILE__ )) . "/config/config.php";

class PUTestUpdateUserinfo extends PHPUnit_Framework_TestCase {
    public function dataCGI(){
        $target_domain = TARGET_DOMAIN;
        $test_case_set = array();
        
        //MM 支付测试
        $test_case = array(
                'cgi' => "http://{$target_domain}/update_userinfo",
                'post' => array(
                    'token' => '006b372e23d8895d6bc419a042cfe0be05406b91f', //身份凭证
                    'nick_name' => 'butyhu' . mt_rand(10000, 99999),
                    'gender'    => 'm',
                    'age'       => mt_rand(10,40),
                    'province'  => '北京',
                    'city'      => '北京',
                    'image_url' => '',//图片地址url, 对于微信用户，会直接下载url,保存在本地
                ),
                'expect_result' => array(),
                'desc' => '更新用户信息',
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
    public function testCGIUpdateUserinfo( $str_target_cgi, $post_arr, $url, $expect_result, $desc = '' ){
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
