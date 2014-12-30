<?php
define("SRC_ROOT", '/var/www/austin/dgc/');
define("APP", SRC_ROOT . '/app/' );
define("DS", '/' );

class PUTestOrderModel extends PHPUnit_Framework_TestCase {
	/**
	 * @author austin
	 * @date	2013-06-25
	 *
	 * @description
	 */
	public function testOrderModel(){
		$obj_order = new OrderWorkflow();
		
		$db_saver = new UTDataBaseDebugger();
// 		$db_saver->back_trace = true;
		$obj_order->debugDbSaver = $db_saver;
			
		//²âÊÔÄ¿±êº¯Êý
		$obj_order->setOrderSuccess( 102 );
		
		$db_save_info = $db_saver->get();
		var_dump( $db_save_info );
	}
	
	protected function setUp()
	{
		//
		require_once '../utility/UTDataBaseDebugger.php';
		
		//include framework files
		require_once SRC_ROOT . '/lib/Cake/basics.php';
		require_once SRC_ROOT . '/lib/Cake/Core/App.php';
		require_once SRC_ROOT . '/lib/Cake/Core/Object.php';
		require_once SRC_ROOT . '/lib/Cake/Core/Configure.php';
		require_once SRC_ROOT . '/lib/Cake/Core/CakePlugin.php';
		
		require_once SRC_ROOT . '/lib/Cake/I18n/I18n.php';
		require_once SRC_ROOT . '/lib/Cake/I18n/L10n.php';
		
		require_once SRC_ROOT . '/lib/Cake/Cache/Cache.php';
		
		require_once SRC_ROOT . '/lib/Cake/Network/CakeRequest.php';
		 
		require_once SRC_ROOT . '/lib/Cake/Utility/Inflector.php';
		require_once SRC_ROOT . '/lib/Cake/Utility/ObjectCollection.php';
		require_once SRC_ROOT . '/lib/Cake/Utility/ClassRegistry.php';
		 
		require_once SRC_ROOT . '/lib/Cake/Model/Model.php';
		require_once SRC_ROOT . '/lib/Cake/Model/ConnectionManager.php';
		require_once SRC_ROOT . '/lib/Cake/Model/BehaviorCollection.php';
		
		require_once SRC_ROOT . '/lib/Cake/Error/exceptions.php';
		 
		require_once SRC_ROOT . '/lib/Cake/Controller/Controller.php';
		require_once SRC_ROOT . '/lib/Cake/Controller/ComponentCollection.php';
		 
		require_once APP . '/Controller/AppController.php';
		require_once APP . '/Config/define.php';
		 
		require_once APP . '/Model/AppModel.php';
		
		//include target source files
		require_once SRC_ROOT . '/app/Model/order_workflow.php';
		require_once SRC_ROOT . '/app/Model/FaPaymentOrder.php';
	}
	
	
}
