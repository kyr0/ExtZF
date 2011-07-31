<?php

/**
 * Application bootstrap file which contains initializator
 * methods to prepare the runtime essentials of this module.
 */
class Extzf_Controller_Action_Helper_LayoutLoader extends Zend_Controller_Action_Helper_Abstract
{

    /**
     * Zend Dispatcher predispatch hook to apply the correct
     * view layout to Controller/Actions while dispatching a
     * HTTP request.
     *
     * @see library/Zend/Controller/Action/Helper/Zend_Controller_Action_Helper_Abstract#preDispatch()
     */
    public function preDispatch ()
    {
        $bootstrap = $this->getActionController()->getInvokeArg('bootstrap');
        $config = $bootstrap->getOptions();
        $module = $this->getRequest()->getModuleName();
        
        if (isset($config[$module]['resources']['layout']['layout'])) {
            
            $layoutScript = $config[$module]['resources']['layout']['layout'];
            $this->getActionController()->getHelper('layout')->setLayout($layoutScript);
        }
    }
}