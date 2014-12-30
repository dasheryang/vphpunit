<?php

require_once dirname(dirname( __FILE__ )) . "/config/config.php";

class PUTestRequestUser extends PHPUnit_Framework_TestCase {
    public function dataCGI(){
        $target_domain = TARGET_DOMAIN;
        $test_case_set = array();
        
        //MM 支付测试
        $test_case = array(
                'cgi' => "http://{$target_domain}/radar/request_user",
                'post' => array(
                    'token' => '006b372e23d8895d6bc419a042cfe0be05406b91f', //身份凭证
                    'consumer_key' => '0179030db72fac7e43cc', //游戏客户端consumer_key
                    'location' => '39.9834,116.3229', //经纬度字符串 如 39.9834,116.3229
                    'wid'   => 132 //战局ID
                ),
                'expect_result' => array(),
                'desc' => '请求对战用户',
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
    public function testCGIRequestUser( $str_target_cgi, $post_arr, $url, $expect_result, $desc = '' ){
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
