<?php

/**
 * Compatibility Class
 *
 * Implements functions and classes for php 5.2 compatibility.
 */
class Extzf_Compatibility
{

    /**
     * Directly calls all compatibility functions
     *
     * @access public
     * @return void
     */
    public function __construct ()
    {
        // Add get_called_class() compatibility
        $this->_get_called_class();
        // I want forward_static_call_array
        $this->_get_forward_static_call_array();
    }


    /**
     * Method to add get_called_class() function in php 5.2.x
     * @access protected
     * @return void
     */
    protected function _get_called_class()
    {
        if (!function_exists('get_called_class')) {

            function get_called_class () {
                $b = debug_backtrace();
                return get_class($b[1]['object']);
            }
        }
    }


    /**
     * Add forward_static_call_array for PHP < 5.3
     * @access protected
     * @return void
     */
    protected function _get_forward_static_call_array()
    {
        if (!function_exists('forward_static_call_array')) {

            function forward_static_call_array (array $_class_func, array $_args = array()) {
                call_user_func_array($_class_func, $_args);
            }
        }
    }
}


