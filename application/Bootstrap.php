<?php

/**
 * Application bootstrap file which contains initializator
 * methods to prepare the runtime essentials.
 *
 * @author Aron Homberg <info@aron-homberg.de>
 * @SuppressWarnings("PMD")
 * @SuppressWarnings("checkstyle:*")
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{


    /**
     * Local reference to the application configuration array
     * @var array $config Local configuration array
     */
    protected $_config = null;


    /**
     * Local session instance reference, set by _initSession()
     * @var Zend_Session_Namespace
     */
    protected $_session = null;


    /**
     * Adjust FrontController reference
     */
    public function __construct($application)
    {
        $frontController = Zend_Controller_Front::getInstance();
        Zend_Registry::set("FrontController", $frontController);

        // Setup paths
        define('LIBRARY_PATH', realpath(BASE_PATH . '/library'));
        parent::__construct($application);
    }

    
    /**
     * Initializes the php 5.2.x compatibility
     *
     * @access protected
     * @return void
     */
    protected function _initCompatibility()
    {
        new Extzf_Compatibility();
    }


    /**
     * Initializes the bootstrapping process and
     * stores the instance in registry.
     * @access protected
     * @return void
     */
    protected function _initBootstrap()
    {
        // Set singleton instance of Bootstrap in registry
        Zend_Registry::set('Bootstrap', $this);

        // Set application config
        $this->_config = $this->getOptions();
        Zend_Registry::set('Config', $this->_config);
    }


    /**
     * Initializes the logger
     * @return void
     */
    protected function _initLogger()
    {
        Zend_Registry::set('Logger', new Extzf_Logger());
    }


    /**
     * Setup configuration
     * @access protected
     * @return void
     */
    protected function _initConfig()
    {
        $config = new Zend_Config(array(), true);
        $config->merge(new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV));
        Zend_Registry::set('config', $config);

        // Define base url
        define('BASE_URL', $config->app->baseUrl);
    }


    /**
     * Handles routing issues
     * @access protected
     * @return void
     */
    protected function _initRouting()
    {
        if (!Extzf_ExtDirect::isDirectRequest()) {
            $frontController = Zend_Registry::get("FrontController");
            $frontController->setBaseUrl($this->_config['app']['basePath']);
        }
    }


    /**
     * Plugin loader plugin for front controller
     * @return void
     */
    protected function _initPluginLoader()
    {
        $loader = new Zend_Loader_PluginLoader();
        $loader->addPrefixPath('Extzf_Controller_Plugin', LIBRARY_PATH . '/Extzf/Controller/Plugin');
        Zend_Registry::set('PluginLoader', $loader);
    }


    /**
     * Initialized the caching
     * @access protected
     * @return void
     */
    protected function _initCaching()
    {
        // Initialize cache reference instance
        $cache = Zend_Cache::factory(
            'Core', $this->_config['cache']['backendType'],
            $this->_config['cache'],
            $this->_config['cache'][$this->_config['cache']['backendType']]
        );
    	
        // Make cache object instance accessbile globally
        Zend_Registry::set('Cache', $cache);
        
        // Browser caching information; Change revision in config
        // to let static files reload
        Zend_Registry::set('CurrentRevision', $this->_config['app']['currentRevision']);
    }


    /**
     * Initializes the module-independend autoloading
     * @access protected
     * @return Zend_Loader_Autoloader
     */
    protected function _initAutoload()
    {
        $loader = new Zend_Application_Module_Autoloader(
            array('namespace' => 'Extzf',
                  'basePath' => APPLICATION_PATH)
        );

        if (isset($this->_application)) {
            $this->_application->setAutoloaderNamespaces(array("Extzf"));
        }
        return $loader;
    }


    /**
     * Initializes internationalization of the application.
     * Currently static german.
     * @access protected
     * @return void
     */
    protected function _initInternationalization()
    {
        // set new locale
        $locale = "de";
        if (isset($_REQUEST['locale']) &&
            in_array($_REQUEST['locale'], array('de', 'en'))) {

            $locale = $_REQUEST['locale'];
        }

        switch ($locale) {
            case 'de':
                $locale = 'de_DE';

                // Standard timezone
                date_default_timezone_set('Europe/Berlin');
                break;

            case 'en':
                $locale = 'en_US';
                break;
        }

        // Lots of functions check for this default key
        Zend_Registry::set('Locale', new Zend_Locale($locale));
    }
    
    
    /**
     * Init Translation Adapter after Caching
     * @access protected
     * @return void
     */
    protected function _initTranslation()
    {
        //load I18n Plugin
        $frontController = Zend_Registry::get('FrontController');

        // @codingStandardsIgnoreStart
        $i18nPlugin = Zend_Registry::get('PluginLoader')->load('I18n');
        // @codingStandardsIgnoreEnd

        $i18nPlugin = new $i18nPlugin();
        Zend_Registry::set('i18nPlugin', $i18nPlugin);
        
        $frontController->registerPlugin($i18nPlugin);
    }


    /**
     * Initializes the database resource loader
     * @access protected
     * @return void
     * @throws Exception
     */
    protected function _initDatabase()
    {
        $config = Zend_Registry::get('config');
        $config->merge(new Zend_Config_Ini(APPLICATION_PATH . '/configs/db.ini', APPLICATION_ENV));
        Zend_Registry::set('config', $config);
        
        require_once('Doctrine/Common/ClassLoader.php');
 
        $doctrineConfig = $config->doctrine;
 
        $classLoader = new \Doctrine\Common\ClassLoader('Doctrine', APPLICATION_PATH . '/../library/');
        $classLoader->register();
        
        $config = new \Doctrine\ORM\Configuration();
        
 		// Should be Memcache or APC instead
        $cache = new \Doctrine\Common\Cache\ArrayCache();
        
        // Model association
 		$driver = $config->newDefaultAnnotationDriver(APPLICATION_PATH . '/../library/Model');
        $config->setMetadataDriverImpl($driver);
        
        // Meta cache, query cache
        $config->setMetadataCacheImpl($cache);
        $config->setQueryCacheImpl($cache);
        
        // Proxies
        $config->setProxyDir(APPLICATION_PATH . '/proxies');
        $config->setProxyNamespace('Extzf\Proxies');
        
        // Only in development mode, in production instead: false
        $config->setAutoGenerateProxyClasses(true);
 
        // Driver config mapping
        $connectionOptions = array(
            'driver'    => $doctrineConfig->driver,
            'user'      => $doctrineConfig->user,
            'password'  => $doctrineConfig->password,
            'dbname'    => $doctrineConfig->dbname,
            'host'      => $doctrineConfig->host
        );
 
        // EntityManager instance
        $em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config);
        $conn = $em->getConnection();
 
        Zend_Registry::set('EntityManager', $em);
        Zend_Registry::set('DbConnection', $conn);
    }
    
    
	/**
     * Initialize the Zend Session
     * @access protected
     * @return void
     */
    protected function _initUserSession() 
    {
    	$session = new Zend_Session_Namespace();
    	Zend_Registry::set('Session', $session);
    }
}
