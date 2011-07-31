<?php

/**
 * Wrapper class that is able to translate from different
 * backends at once.
 */
class Extzf_Translate
{

    /**
     * Translates a string
     * @access public
     * @return string
     */
    public function _($text)
    {
        $zfTranslate = Zend_Registry::get('Zend_Translate');

        // Rely to Zend_Translate
        return $zfTranslate->_($text);
    }
}