<?php
/**
 * @author buty.hu
 * @since 2014.10.20
 */
require_once dirname( __FILE__ ) . "/../config/config.php";
class PUTestMFMyGiftList extends PHPUnit_Framework_TestCase {
    public function dataCGI(){
        $target_domain = MoFang_DOMAIN;
        
        $test_arr = array();
        $test_arr[] = array(
                    'cgi' => "http://{$target_domain}/report/game_data",
                    'post' => array(
                            'game_packet_str'   => 'com.windplay.sjha,com.zx.mrj,2222',
                    ),
                    TOKEN, //应用oauth_token
                    '上报游戏信息'
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

        curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
        curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $obj_curl, CURLOPT_HTTPHEADER, $headers); 
        var_dump($headers, $post_arr);
        curl_setopt( $obj_curl, CURLOPT_POST, count($post_arr) );
        curl_setopt( $obj_curl, CURLOPT_POSTFIELDS,  $post_arr );
    
        $obj_ret_data = curl_exec( $obj_curl );
    
        var_dump( $obj_ret_data );
    }
}