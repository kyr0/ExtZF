<?php

# Execute this script to generate the Direct provider file
# containing the Ext.Direct JSON-RPC descriptor of your
# Zend Framework MVC structure
#
# php generateDirectProvider.php
#
# Proove the file is generated correctly by checking out
# /release/public/javascript/Provider.js

// Define path to application directory
defined('APPLICATION_PATH')
|| define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

define('BASE_PATH', realpath(APPLICATION_PATH . '/../'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

require_once 'Zend/Loader/Autoloader.php';
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->registerNamespace('Extzf_');

if (isset($argv[1])) {
    define('APPLICATION_ENV', $argv[1]);
} else {
    define('APPLICATION_ENV', 'base');
}

require_once 'Zend/Config/Ini.php';
require_once 'Zend/Controller/Action.php';
require_once 'Zend/Json.php';

require_once BASE_PATH . '/thirdparty/ExtDirect/API.php';
require_once BASE_PATH . '/thirdparty/ExtDirect/CacheProvider.php';
require_once BASE_PATH . '/library/Extzf/Controller.php';
require_once BASE_PATH . '/library/Extzf/ExtDirect/ProviderGenerator.php';
require_once BASE_PATH . '/library/Extzf/ExtDirect/API.php';


if(false === file_exists(APPLICATION_PATH . '/data'))
{
    mkdir(APPLICATION_PATH . '/data');
}
// --- Regenerate /application/public/javascripts/Provider.js
$providers = Extzf_ExtDirect_ProviderGenerator::generateMVCProviders();
$rawCode = Extzf_ExtDirect_ProviderGenerator::providersToJson($providers);


// Create the provider directories if not present.
$provider_path = BASE_PATH . '/release/public/javascript/';
if(false === file_exists($provider_path))
{
    mkdir($provider_path, 0755,true);
}

@file_put_contents($provider_path . "Provider.js", $rawCode);

if(file_exists($provider_path. "Provider.js"))
{
    echo "Ext JS direct provider generator:\n";
    echo "Generated new Ext JS direct provider {$provider_path}Provider.js - Controllers: \n";
    echo implode(",\n", array_map(create_function('$a','return implode(", ",$a);'), Extzf_ExtDirect_ProviderGenerator::getModules()));
}
