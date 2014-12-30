<?php
/**
 * @author buty.hu
 * @since 2014.10.17
 */
require_once dirname( __FILE__ ) . "/../config/config.php";
class PUTestMFRefuseGroupGiftApply extends PHPUnit_Framework_TestCase {
    public function dataCGI(){
        $target_domain = MoFang_DOMAIN;
        
        $test_arr = array();
        $test_arr[] = array(
                    'cgi' => "http://{$target_domain}/groupGift/refuse",
                    'post' => array(
                            'apply_ids' => '71',
                    ),
                    TOKEN, //应用oauth_token
                    '拒绝礼包申请'
            );
        
        return $test_arr;
    }
    
    /**
     * @dataProvider dataCGI
     *
     * @param unknown $str_target_cgi
     * @param unknown $expect_result
     */
    public function testCGIcreate( $str_target_cgi, $post_arr, $oauth_token){
        $obj_curl = curl_init();
        $headers = array('app-token: ' . $oauth_token);
        //$str_target_cgi .= '?' . http_build_query($get_arr);
        curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
        curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $obj_curl, CURLOPT_HTTPHEADER, $headers); 
        
        curl_setopt( $obj_curl, CURLOPT_POST, count($post_arr) );
        curl_setopt( $obj_curl, CURLOPT_POSTFIELDS,  $post_arr );
    
        $obj_ret_data = curl_exec( $obj_curl );
    
        var_dump( $obj_ret_data );
    }
}