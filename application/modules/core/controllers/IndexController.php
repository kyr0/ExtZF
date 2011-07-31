<?php

/**
 * Index controller for core.
 */
class IndexController extends Extzf_Controller
{

    /**
     * Index action
     * 
     * @return void
     */
    public function indexAction()
    {
        // Push PHP data natively into JavaScript
        // Available in JavaScript via:
        //
        // Extzf.FrontController.params.foo
        //
        $this->_setJsParams(array(
            "foo" => "bar"
        ));

        // Do not render any view script
        $this->_helper->viewRenderer->setNoRender();
    }
    
}
