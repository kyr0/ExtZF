<?php

/**
 * Languages class
 * 
 * Handles languages and locales.
 */
class Extzf_Languages
{

    /**
     * Default language name
     *
     * @var String $_defaultLocale
     */
    protected $_defaultLocale = "de_DE";


    /**
     * Returns the default locale
     *
     * @access public
     * @return string Default ISO locale
     */
    public function getDefaultLocale()
    {
        return $this->_defaultLocale;
    }
}