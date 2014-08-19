<?php

class Form_Validators_ChangeEmailRepeatedEmail extends Zend_Validate_Abstract
{
    const MAXLENGTH   = 'maxlength';
    const EMAILFORMAT = 'emailformat';
    const EXISTS      = 'exists';
    const REPEATED    = 'repeated';

    protected $_messageTemplates = array(
        self::MAXLENGTH   => "'%value%' is more than 50 characters long",
        self::EMAILFORMAT => "'%value%' is not respecting the e-mail format",
        self::EXISTS      => "Choose another email because it is taken",
        self::REPEATED    => "The emails are not the same",
    );

    public function isValid($value, $context = null)
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

        if ($value !== $context['email']) {
            $this->_error(self::REPEATED);
            $isValid = false;
        }

        return $isValid;
    }
}
