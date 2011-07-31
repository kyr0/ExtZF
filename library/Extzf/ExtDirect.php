<?php

/**
 * Helper class for global ExtDirect behaviours
 */
class Extzf_ExtDirect
{


    /**
     * Returns true if request is direct request
     * @return boolean
     */
    public static function isDirectRequest()
    {
        try {
            $directRequest = Zend_Registry::get("DirectRequest");
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}