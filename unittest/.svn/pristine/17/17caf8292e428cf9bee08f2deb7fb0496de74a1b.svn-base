<?php
define("SRC_ROOT", '/var/www/austin/dgc/');
define("APP", SRC_ROOT . '/app/' );
define("DS", '/' );

class PUTestGame extends PHPUnit_Framework_TestCase {
	public function dataGameTestAbc(){
		return array(
				array( 'http://dgc.austin.com/games/testabc', 'testfun' ),
		);
	}
	
	/**
	 * @dataProvider dataGameTestAbc
	 */
    public function _testGameTestAbc($str_target_cgi, $str_expect_http_result ){
    	$obj_curl = curl_init();
    	curl_setopt( $obj_curl, CURLOPT_URL, $str_target_cgi );
    	curl_setopt( $obj_curl, CURLOPT_RETURNTRANSFER, 1 );
    	$obj_ret_data = curl_exec( $obj_curl );
    }
    
    public function testGameTestAbcControllor(){
	   	$obj_game = new GamesController();
	   	$str_result = $obj_game->testabc();
	   	
    	$this->assertEquals( $str_result, 'testfun' );
    }
    
    public function testAustinModel(){
	  	$obj_austin_model = new AustinTestModel();
	  	
	  	$i_var = 12;
	  	$i_result_var = $obj_austin_model->test_version( $i_var );

    	$this->assertEquals( $i_var + 1, $i_result_var );	
    }
    
    protected function setUp()
    {	
    	//include framework files
    	require_once SRC_ROOT . '/lib/Cake/basics.php';
    	require_once SRC_ROOT . '/lib/Cake/Core/App.php';
    	require_once SRC_ROOT . '/lib/Cake/Core/Object.php';
    	
    	require_once SRC_ROOT . '/lib/Cake/Utility/Inflector.php';
    	require_once SRC_ROOT . '/lib/Cake/Utility/ObjectCollection.php';
    	require_once SRC_ROOT . '/lib/Cake/Utility/ClassRegistry.php';
    	
    	require_once SRC_ROOT . '/lib/Cake/Model/Model.php';
    	require_once SRC_ROOT . '/lib/Cake/Model/BehaviorCollection.php';
    	
    	require_once SRC_ROOT . 'lib/Cake/Error/exceptions.php';
    	
    	require_once SRC_ROOT . 'lib/Cake/Controller/Controller.php';
    	require_once SRC_ROOT . 'lib/Cake/Controller/ComponentCollection.php';
    	
    	require_once APP . '/Controller/AppController.php';
    	require_once APP . '/Config/define.php';
    	
    	require_once APP . '/Model/AppModel.php';
    	
    	//include target source files
	   	require_once SRC_ROOT . '/app/Controller/games_controller.php';
	   	
	   	require_once SRC_ROOT . '/app/Model/AustinTestModel.php';
    }
}