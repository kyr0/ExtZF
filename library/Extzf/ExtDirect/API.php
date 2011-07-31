<?php

/**
 * Extends the standard Provider API class by a
 * method to return the fully generated API code
 * without echoing it.
 */
class Extzf_ExtDirect_API extends ExtDirect_API
{

    /**
     * Does the same like _print() but responds the javascript
     * code rather than echoing it to the output stream.
     *
     * @param array $api MVC mapped provider api
     * @return string
     */
    public function sprint($api)
    {
        $code = "";
        $code .= ($this->_namespace ?
             'Ext.ns(\'' . substr($this->_descriptor, 0, strrpos($this->_descriptor, '.')) . '\'); ' . $this->_descriptor:
             'Ext.ns(\'Direct\'); ' . 'Direct.REMOTING_API'
        );
        $code .= ' = ';
        $code .= json_encode($api);
        $code .= ';';

        return $code;
    }
}