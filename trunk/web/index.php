<?php
//require 'setup.class.php';
//$smarty = new SmartyConnect();
//$smarty->assign('name','Surya');
//$smarty->assign('title', 'Family Tree');
//$smarty->display('index.tpl');	
//		
//Bootstrap file

//Error Reporting
error_reporting(E_ALL|E_ERROR);
ini_set('display_errors','on');

//Include includepath TODO: do something so its not user accessible
//ini_set('include_path',ini_get('include_path').PATH_SEPARATOR. 'lib' );

require_once('Zend/Loader.php');
require_once('Smarty/Smarty.class.php');

Zend_Loader::registerAutoload();

// load the application configuration (set in server/apache inside virtualhost tag)
// SetEnv APP_CONFIG_FILE "settings.ini"
// SetEnv APP_CONFIG_SECTION "development"
$configFile = '';
if (isset($_SERVER['APP_CONFIG_FILE']))
	$configFile = basename($_SERVER['APP_CONFIG_FILE']);
if (strlen($configFile) == 0)
	$configFile = 'settings.ini';

$configSection = '';

if (isset($_SERVER['APP_CONFIG_SECTION']))
	$configSection = basename($_SERVER['APP_CONFIG_SECTION']);
if (strlen($configSection) == 0)
	$configSection = 'production';
	
$config = new Zend_Config_Ini('../configs/' . $configFile, $configSection);
//$config = new Zend_Config_Ini('../configs/settings.ini', 'development');
Zend_Registry::set('config', $config);

// create the application logger
$logger = new Zend_Log(new Zend_Log_Writer_Stream($config->logging->file));
Zend_Registry::set('logger', $logger);//add logger in registry so can be accessed anywhere
//$logger->debug('Test');

// connect to the database
$params = array('host' => $config->database->hostname,
				'username' => $config->database->username,
				'password' => $config->database->password,
				'dbname' => $config->database->database);

$db = Zend_Db::factory($config->database->type, $params);
Zend_Registry::set('db', $db);
		
// setup application authentication
$auth = Zend_Auth::getInstance();
$auth->setStorage(new Zend_Auth_Storage_Session());

// handle the user request
$controller = Zend_Controller_Front::getInstance();
$controller->setControllerDirectory('../include/Controllers');
$controller->registerPlugin(new CustomControllerAclManager($auth));

$controller->throwExceptions(true);//if false error page will show

//$controller->setParam('noViewRenderer', true);//is no view is set
$vr = new Zend_Controller_Action_Helper_ViewRenderer();
$vr->setView(new Templater());
$vr->setViewSuffix('tpl');
Zend_Controller_Action_HelperBroker::addHelper($vr);
$controller->dispatch();

?>