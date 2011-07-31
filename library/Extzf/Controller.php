<?php

class Extzf_Controller extends Zend_Controller_Action
{


    /**
     * References the current bootstrap instance
     * for accessing e.g. config by using:
     * $this->bootstrap->getOptions()
     * @var Zend_Application_Bootstrap $boostrap Bootstrap instance reference
     */
    protected $bootstrap = null;


    /**
     * Session object instance
     * @var Zend_Session_Namespace $session Session namespace reference
     */
    protected $session = null;


    /**
     * Configuration object instance
     * @var array $config Application configuration array
     */
    protected $config = null;


    /**
     * Files not to cache
     * @var array $noCacheFiles
     */
    protected $noCacheFiles = array();


    /**
     * Parameters given to the controller (POST, GET, ...)
     * @var Zend_Controller_Request_Abstract $params
     */
    protected $params = null;


    /**
     * Translation class instance reference
     * @var Zend_Translate
     */
    protected $tr = null;


    /**
     * Entity manager
     * @var EntityManager
     */
    protected $entityManager = null;
    

    /**
     * Class constructor
     *
     * The request and response objects should be registered with the
     * controller, as should be any additional optional arguments; these will be
     * available via {@link getRequest()}, {@link getResponse()}, and
     * {@link getInvokeArgs()}, respectively.
     *
     * When overriding the constructor, please consider this usage as a best
     * practice and ensure that each is registered appropriately; the easiest
     * way to do so is to simply call parent::__construct($request, $response,
     * $invokeArgs).
     *
     * After the request, response, and invokeArgs are set, the
     * {@link $_helper helper broker} is initialized.
     *
     * Finally, {@link init()} is called as the final action of
     * instantiation, and may be safely overridden to perform initialization
     * tasks; as a general rule, override {@link init()} instead of the
     * constructor to customize an action controller's instantiation.
     *
     * @param Zend_Controller_Request_Abstract $request
     * @param Zend_Controller_Response_Abstract $response
     * @param array $invokeArgs Any additional invocation arguments
     * @return void
     */
    public function __construct(Zend_Controller_Request_Abstract $request,
                                Zend_Controller_Response_Abstract $response,
                                array $invokeArgs = array())
    {
        if (!Extzf_ExtDirect::isDirectRequest()) {

            $this->setRequest($request)
                 ->setResponse($response)
                 ->_setInvokeArgs($invokeArgs);

            $this->_helper = new Zend_Controller_Action_HelperBroker($this);
        }
        $this->init();
    }


    /**
     * Initializer method which will be called on each
     * request before the specific named action method
     * will be called.
     *
     * Calls pre-hook methods for special application code
     * to be executed before.
     *
     * @see library/Zend/Controller/Zend_Controller_Action#init()
     * @return void
     */
    public function init()
    {
        $this->bootstrap = $this->getInvokeArg('bootstrap');
        $this->params = $this->getParams();

        // Config, Session, Uac, Translation
        $this->_getConfig();
        $this->_getSession();
        $this->tr = Zend_Registry::get('Translate');
        $this->entityManager = Zend_Registry::get('EntityManager');

        // Zend_View / Zend_Layout only when not called by Ext.Direct
        if (!Extzf_ExtDirect::isDirectRequest()) {

            // Initialize view
            $this->_initView();
        }
    }


    /**
     * Initializes the view and sets initial global
     * parameters like request etc.
     *
     * @return void
     */
    protected function _initView()
    {
        // Preset request parameters in view
        $this->view->moduleName = $this->params["module"];
        $this->view->controllerName = $this->params["controller"];
        $this->view->actionName = $this->params["action"];

        // Do global registering of helper path
        $this->view->setHelperPath(APPLICATION_PATH . '/layouts/helpers');

        // Sets the initial JavaScript action call parameters
        $this->_setJsParams(array());
    }


    /**
     * Sets JavaScript Controller Action call parameters
     *
     * @param array $params JavaScript call parameters
     * @return void
     */
    protected function _setJsParams($params)
    {
        $this->view->jsParams = Zend_Json::encode($params);
    }


    /**
     * Translates a string
     * @param string $text Text to translate
     * @return string
     */
    protected function tr($text)
    {
        return $this->tr->_($text);
    }


    /**
     * Returns a session instance
     *
     * @return Zend_Session_Namespace Default session instance
     */
    protected function _getSession ()
    {
        if (is_null($this->session)) {
            $this->session = Zend_Registry::get('Session');
        }
        return $this->session;
    }


    /**
     * Returns the application config as array
     *
     * @return array Application configuration
     */
    protected function _getConfig ()
    {
        if (is_null($this->config)) {
            $this->config = Zend_Registry::get('Config');
        }
        return $this->config;
    }


    /**
     * Disables rendering of view and layouting
     *
     * @access protected
     * @return void
     */
    protected function _disableRenderingAndLayout()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
    }


    /**
     * Disables the rendering only
     *
     * @return void
     */
    protected function _disableRendering()
    {
        $this->getFrontController()->setParam('noViewRenderer', true);
    }


    /**
     * Enable the rendering
     *
     * @return void
     */
    protected function _enableRendering()
    {
        $this->getFrontController()->setParam('noViewRenderer', false);
    }


    /**
     * Tries to load from file cache.
     *
     * @param string $ident Cache ident hash
     *
     * @return mixed Boolean false or content
     */
    protected function _loadFromCache($ident)
    {
        $cache = Zend_Registry::get('Cache');

        // Try loading from cache
        if (! ($code = $cache->load($ident))) {
            return false;
        }
        return $code;
    }


    /**
     * Saves to cache
     *
     * @param string $content Content to store
     * @param string $ident   Cache ident hash
     *
     * @return void
     */
    protected function _saveToCache($content, $ident)
    {
        $cache = Zend_Registry::get('Cache');

        // Store in cache
        $cache->save($content, $ident);
    }


    /**
     * Index action which just shows the default page view
     *
     * @return void
     */
    public function indexAction()
    {
        $this->_forward("index", "index", "core");
    }


    /**
     * Returns the request object parameters
     * @return Zend_Controller_Request_Abstract Response object
     */
    public function getParams()
    {
        if (!Extzf_ExtDirect::isDirectRequest()) {
            return $this->getRequest()->getParams();
        } else {
            return array();
        }
    }
}