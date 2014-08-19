<?php

class Form_Validators_RegisterEmail extends Zend_Validate_Abstract
{
    const MAXLENGTH   = 'maxlength';
    const EMAILFORMAT = 'emailformat';
    const EXISTS      = 'exists';

    protected $_messageTemplates = array(
        self::MAXLENGTH   => "'%value%' is more than 50 characters long",
        self::EMAILFORMAT => "'%value%' is not respecting the e-mail format",
        self::EXISTS      => "Choose another email because it is taken",
    );

    public function isValid($value)
    {
        $this->_setValue($value);

        $isValid = true;

        if (strlen($value) > 50) {
            $this->_error(self::MAXLENGTH);
            $isValid = false;
        }

        if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $value)) {
            $this->_error(self::EMAILFORMAT);
            $isValid = false;
        }
        $userMapper = new Model_UserMapper();
        if (count($userMapper->getUserByEmail($value)) != 0) {
            $this->_error(self::EXISTS);
            $isValid = false;
        }

        return $isValid;
    }
}
