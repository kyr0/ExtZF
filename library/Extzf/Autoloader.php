<?php

/**
 * Autoloader Class
 *
 * Implements module-independend autoloading.
 */
class Éxtzf_Autoloader extends Zend_Loader
{

    /**
     * Loads class from module directories
     *
     * @param string $class Name of the class
     * @param array  $dirs  Directories to search in
     *
     * @return void
     */
    public static function loadClass($class, $dirs = null)
    {
        $config = Zend_Registry::get('Config');
        if (is_null($dirs)) {
            $dirs = $config['app']['autoloadPaths'];
            if (! is_array($dirs) || sizeof($dirs) == 0) {
                $dirs = array();
            }
        }
        parent::loadClass($class, $dirs);
    }


    /**
     * Autoload-method to call by Zend Framework
     * autoload wrapper.
     *
     * @param string $class Name of the class
     *
     * @return boolean|string Boolean true / false or class name
     */
    public static function autoload($class)
    {
        try {
            self::loadClass($class);
            return $class;
        }
        catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
        return false;
    }
}