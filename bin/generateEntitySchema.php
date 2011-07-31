<?php

# DONT FORGET TO CREATE THE DATABSE NAMED IN
# /application/config/db.ini (!)

# Call this script to create Entity SQL schema:
# php generateEntitySchema.php Extzf\Model\News

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

// Bootstrap
$application->bootstrap();

$em = Zend_Registry::get('EntityManager');

// Auto-create schema for entity classes automatically
try {
	$tool = new \Doctrine\ORM\Tools\SchemaTool($em);
	$classes = array(
	    $em->getClassMetadata($argv[1])
	);
	$tool->createSchema($classes);
} catch(Exception $e) {
	echo PHP_EOL . "An error happened:" . PHP_EOL;
	echo $e->getMessage();
	echo PHP_EOL;
}