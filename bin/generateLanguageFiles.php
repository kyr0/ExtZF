<?php

# Generates JavaScript translation files
# out of a global /application/javascript/i18n.js file and the
# Zend_Tr translation files in /application/i18n
# Bundels the application centric translation files per language
# with the Ext JS native ones.
#
# php generateLanguageFiles.php
#
# Proove the files are existing by checking out
# /release/public/javascript/extzf-lang-*.js

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

// Define environment
if (isset($argv[1]) && strlen($argv[1]) > 0) {
    define('APPLICATION_ENV', $argv[1]);
} else {
    define('APPLICATION_ENV', 'base');
}

// Require libs
require_once 'Zend/Config/Ini.php';
require_once 'Zend/View.php';
require_once 'Zend/Locale.php';
require_once 'Zend/Controller/Action/HelperBroker.php';
require_once 'Zend/Translate.php';
require_once 'Zend/Registry.php';

$i18nConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/i18n.ini', APPLICATION_ENV);
$appConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);

// --- VIEW

// Initialize view
$view = new Zend_View();
$view->env = APPLICATION_ENV;
$view->setHelperPath(APPLICATION_PATH . '/layouts/helpers');

// Add it to the ViewRenderer
$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
$viewRenderer->setView($view);


// Language mapping ExtJS -> Zend
$langMapping = array(
    "en_US" => "ext-lang-en.js",
    "de_DE" => "ext-lang-de.js"
);


// --- TRANSLATE

echo "Language file generator: " . PHP_EOL;

// Walk each language and generate
foreach ($i18nConfig->i18n->languages as $language) {

    // Reset script path
    $view->setScriptPath(APPLICATION_PATH . '/javascript');

    // translate global language files
    try {
        //get translation file dir
        $dir = APPLICATION_PATH . '/' . $appConfig->translate->dirname;
        $data = sprintf("%s/%s.csv", $dir, $language);

        $translation = new Zend_Translate("csv", $dir, substr($language, 0, 2));
        $translation->addTranslation($data, substr($language, 0, 2));

        Zend_Registry::set('Translate', $translation);

        $iaLangContent = $view->render("i18n.js");
        $extLangContent = file_get_contents(APPLICATION_PATH . '/../' .
                                            $i18nConfig->i18n->extLocalePath . '/' .
                                            $langMapping[$language]);

        // Generate combined language output
        $genLangContent = $extLangContent . $iaLangContent;

        // Save generated language overrides
        $file = APPLICATION_PATH . '/../release/public/javascript/extzf-lang-' . substr($language, 0, 2) . '.js';
        file_put_contents($file, $genLangContent);

        echo "Generated file: " . $file . PHP_EOL;

    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}
echo PHP_EOL;
