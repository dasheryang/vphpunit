<?php

require_once dirname(dirname( __FILE__ )) . "/config/config.php";

class PUTestUploadAvatar extends PHPUnit_Framework_TestCase {
    public function dataCGI(){
        $target_domain = TARGET_DOMAIN;
        $test_case_set = array();
        
        //MM 支付测试
        $test_case = array(
                'cgi' => "http://{$target_domain}/upload_avatar",
                'get' => array(
                    'token' => '006b372e23d8895d6bc419a042cfe0be05406b91f', //身份凭证
                    'image' => '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'  //phone 手机号
                ),
                'expect_result' => array(),
                'desc' => '上传用户头像',
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
    public function testCGIUploadAvatar( $str_target_cgi, $post_arr, $url, $expect_result, $desc = '' ){
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
