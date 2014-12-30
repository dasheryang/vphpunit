<?php
define("SRC_ROOT", '/var/www/ids_test/source_code/');
define("APP", SRC_ROOT . '/app/' );
define("DS", '/' );

define('APP_DIR', 'app');
define('ROOT', dirname(__FILE__));
define('WEBROOT_DIR', 'webroot');
define('WWW_ROOT', ROOT . DS . APP_DIR . DS . WEBROOT_DIR . DS);

//include framework files

require_once SRC_ROOT . '/lib/Cake/bootstrap.php';

require_once SRC_ROOT . '/lib/Cake/basics.php';
require_once SRC_ROOT . '/lib/Cake/Core/App.php';
require_once SRC_ROOT . '/lib/Cake/Core/Object.php';
require_once SRC_ROOT . '/lib/Cake/Core/Configure.php';
require_once SRC_ROOT . '/lib/Cake/Core/CakePlugin.php';

require_once SRC_ROOT . '/lib/Cake/I18n/I18n.php';
require_once SRC_ROOT . '/lib/Cake/I18n/L10n.php';

require_once SRC_ROOT . '/lib/Cake/Cache/Cache.php';

require_once SRC_ROOT . '/lib/Cake/Network/CakeRequest.php';

require_once SRC_ROOT . '/lib/Cake/Configure/PhpReader.php';
	
require_once SRC_ROOT . '/lib/Cake/Utility/Set.php';
require_once SRC_ROOT . '/lib/Cake/Utility/Inflector.php';
require_once SRC_ROOT . '/lib/Cake/Utility/ObjectCollection.php';
require_once SRC_ROOT . '/lib/Cake/Utility/ClassRegistry.php';
	
require_once SRC_ROOT . '/lib/Cake/Model/Model.php';
require_once SRC_ROOT . '/lib/Cake/Model/ConnectionManager.php';
require_once SRC_ROOT . '/lib/Cake/Model/BehaviorCollection.php';

require_once SRC_ROOT . '/lib/Cake/Model/Datasource/DataSource.php';
require_once SRC_ROOT . '/lib/Cake/Model/Datasource/DboSource.php';
require_once SRC_ROOT . '/lib/Cake/Model/Datasource/Database/Mysql.php';

require_once SRC_ROOT . '/lib/Cake/Log/CakeLog.php';
require_once SRC_ROOT . '/lib/Cake/Log/CakeLogInterface.php';

require_once SRC_ROOT . '/lib/Cake/Log/Engine/FileLog.php';

require_once SRC_ROOT . '/lib/Cake/Error/exceptions.php';
	
require_once SRC_ROOT . '/lib/Cake/Controller/Controller.php';
require_once SRC_ROOT . '/lib/Cake/Controller/ComponentCollection.php';
	
require_once APP . '/Controller/AppController.php';
require_once APP . '/Config/define.php';
	
require_once APP . '/Model/AppModel.php';

//		\Model\Datasource\Database\Mysql.php
	
//include target source files