<?php

class Form_Validators_RegisterDisplayName extends Zend_Validate_Abstract
{
    const MINLENGTH         = 'minlength';
    const MAXLENGTH         = 'maxlength';
    const DISPLAYNAMEFORMAT = 'displaynameformat';

    protected $_messageTemplates = array(
        self::MINLENGTH         => "'%value%' is less than 6 characters long",
        self::MAXLENGTH         => "'%value%' is more than 50 characters long",
        self::DISPLAYNAMEFORMAT => "'%value%' must contain only alphabetic characters, \"'\" and \"-\"",
    );

    public function isValid($value)
    {
        $this->_setValue($value);

        $isValid = true;
        
        if (strlen($value) < 6) {
            $this->_error(self::MINLENGTH);
            $isValid = false;
        }

        if (strlen($value) > 50) {
            $this->_error(self::MAXLENGTH);
            $isValid = false;
        }
        
        if (!preg_match("/^[a-zA-Z-' ]+$/", $value)) {
            $this->_error(self::DISPLAYNAMEFORMAT);
            $isValid = false;
        }

        return $isValid;
    }
}
