<?php
class PUTest extends PHPUnit_Framework_TestCase {
	public function dataGameTestAbc(){
		return array(
				array( 'http://dgc.austin.com/games/testabc', 'testfun' ),
				array( 'http://dgc.austin.com/games/testabc', 'testfun' ),
				array( 'http://dgc.austin.com/games/testabc', 'testfun' ),
		);
	}
	
	
	
	/**
	 * @dataProvider dataGameTestAbc
	 */
    public function testGameTestAbc($str_target_cgi, $str_expect_http_result ){
    	    	
    	$obj_curl = curl_init();
    	curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
    	curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
    	$obj_ret_data = curl_exec( $obj_curl );
    	
    	var_dump( $obj_ret_data );
    	$this->assertEquals( 1 , 1 );
    	
    	
    }
}