<?php

class Form_Validators_LoginUsername extends Zend_Validate_Abstract
{
    const MINLENGTH      = 'minlength';
    const MAXLENGTH      = 'maxlength';
    const USERNAMEFORMAT = 'usernameformat';

    protected $_messageTemplates = array(
        self::MINLENGTH      => "'%value%' is less than 6 characters long",
        self::MAXLENGTH      => "'%value%' is more than 20 characters long",
        self::USERNAMEFORMAT => "'%value%' must contain only alphanumeric characters, \".\" and \"_\" and must start with an alphabetic character",
    );

    public function isValid($value)
    {
        $this->_setValue($value);

        $isValid = true;
        
        if (strlen($value) < 6) {
            $this->_error(self::MINLENGTH);
            $isValid = false;
        }

        if (strlen($value) > 20) {
            $this->_error(self::MAXLENGTH);
            $isValid = false;
        }
        
        if (!preg_match("/^[a-z]+[a-z0-9_.]+/", $value)) {
            $this->_error(self::USERNAMEFORMAT);
            $isValid = false;
        }

        return $isValid;
    }
}
