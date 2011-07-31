<?php

/**
 * View helper to translate text strings
 */
class Zend_View_Helper_Tr
{

    /**
     * Translates a given text or returns ident
     *
     * @access public
     * @param string $text Text to translate
     * @return string Translated text string
     */
    public function tr($text)
    {

        $translate = Zend_Registry::get('Translate');

        // Translate and return
        return $translate->_($text);
    }
}