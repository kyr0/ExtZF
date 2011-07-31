<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define(
        'APPLICATION_PATH',
        realpath(dirname(__FILE__) . '/../application')
    );

// Define application environment
defined('APPLICATION_ENV')
    || define(
        'APPLICATION_ENV',
        (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production')
    );

// Ensure library/ is on include_path
set_include_path(
    implode(
        PATH_SEPARATOR,
        array(
            realpath(dirname(__FILE__) . '/../library'),
            get_include_path(),
        )
    )
);

// Frontend NG base path
define("BASE_PATH", realpath(dirname(__FILE__)) . '/..');

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
Zend_Registry::set("Application", $application);

// Switch execution stack (Ext.Direct or ZF HTTP dispatcher)
if (isset($_GET['direct'])) {

    // Set direct request mode
    Zend_Registry::set("DirectRequest", true);

    // Bootstrap and execute Ext.Direct stack dispatcher
    $application->bootstrap();
    
    $session = Zend_Registry::get('Session');

    require_once BASE_PATH . '/thirdparty/ExtDirect/API.php';
    require_once BASE_PATH . '/thirdparty/ExtDirect/Router.php';
    require_once BASE_PATH . '/thirdparty/ExtDirect/CacheProvider.php';
    require_once 'Extzf/ExtDirect/Router.php';

    $api = new ExtDirect_API();

    if (isset($session->extDirectState)) {
        $api->setState($session->extDirectState);
    }

    // Initialize translation etc. module based
    // This would normally happen in Bootstrap,
    // but since bootstrap has already been executed
    // and we know the requested module after $router
    // has been instanciated, this goes here.
    $rawPostData = file_get_contents("php://input");
    if (sizeof($rawPostData) > 0) {

        // Custom implemented high-performance call stack
        $request = json_decode($rawPostData);
        $i18nPlugin = Zend_Registry::get('i18nPlugin');

        // Static, no module dependency
        $i18nPlugin->externInitTranslation("core");
    }
    
    // Parses the request etc.
    $router = new Extzf_ExtDirect_Router($api);

    // Dispatch request
    $router->dispatch();
    $router->getResponse(true);

} else {

    // Bootstrap and execute HTTP stack dispatcher
    try {
    	$application->bootstrap();
    	$application->run();
    } catch (Exception $e) {
    	print_r($e);
    	exit();
    }
}