<?php

/**
 * Module bootstrap class implementation to inherit from.
 */
class Extzf_Application_Module_Bootstrap extends Zend_Application_Module_Bootstrap
{

    /**
     * Initializator method which initializes the autoloading
     * for module classes of the given module name.
     *
     * @param string $moduleName Name of the module
     *
     * @return Zend_Application_Module_Autoloader
     */
    protected function _initModuleAutoload ($moduleName = "")
    {
        // Add current module to autoloader
        $autoloader = new Zend_Application_Module_Autoloader(
            array('namespace' => $moduleName, 'basePath' => APPLICATION_PATH . '/modules/' . strtolower($moduleName))
        );
        return $autoloader;
    }
}