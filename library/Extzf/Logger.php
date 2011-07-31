<?php

/**
 * Tiny file logger
 */
class Extzf_Logger
{

    /**
     * Log data to separate log file
     * @access public
     * @static
     * @param mixed $_data
     * @return void
     */
    public function log($_data)
    {
        if (is_array($_data) || is_object($_data)) {
            $_data = print_r($_data, true);
        }
        $_data .= PHP_EOL;
        error_log($_data, 3, realpath(APPLICATION_PATH . '/../logs/application.log'));
    }
}