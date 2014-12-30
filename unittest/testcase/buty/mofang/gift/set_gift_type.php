<?php
/**
 * @target http://sdkpay.uu.cc/get_player_payment_group
 * 
 * 
 * @author buty.hu
 * @since 2014.10.13
 */
require_once dirname( __FILE__ ) . "/../config/config.php";
class PUTestMFSetGiftType extends PHPUnit_Framework_TestCase {
    public function dataCGI(){
        $target_domain = MoFang_DOMAIN;
        
        $test_arr = array();
        $test_arr[] = array(
                    'cgi' => "http://{$target_domain}/groupGift/setType",
                    'post' => array(
                            'gid'   => 10010,
                            'group_gift_id'  => 4,
                            'type'  => 'common'
                    ),
                    TOKEN, //应用oauth_token
                    '设置公会礼包类型'
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