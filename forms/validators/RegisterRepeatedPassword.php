<?php

class Form_Validators_RegisterRepeatedPassword extends Zend_Validate_Abstract
{
    const UPPER     = 'upper';
    const LOWER     = 'lower';
    const DIGIT     = 'digit';
    const MINLENGTH = 'minlength';
    const MAXLENGTH = 'maxlength';
    const REPEATED  = 'repeated';

    protected $_messageTemplates = array(
        self::UPPER     => "Password must contain an uppercase letter",
        self::LOWER     => "Password must contain a lowercase letter",
        self::DIGIT     => "Password must contain a number",
        self::MINLENGTH => "Password is less than 8 characters long",
        self::MAXLENGTH => "Password is more than 50 characters long",
        self::REPEATED  => "The passwords are not the same",
    );

    public function isValid($value, $context = null)
    {
        $this->_setValue($value);

        $isValid = true;

        if (strlen($value) < 8) {
            $this->_error(self::MINLENGTH);
            $isValid = false;
        }

        if (strlen($value) > 50) {
            $this->_error(self::MAXLENGTH);
            $isValid = false;
        }

        if (!preg_match('/[A-Z]/', $value)) {
            $this->_error(self::UPPER);
            $isValid = false;
        }

        if (!preg_match('/[a-z]/', $value)) {
            $this->_error(self::LOWER);
            $isValid = false;
        }

        if (!preg_match('/\d/', $value)) {
            $this->_error(self::DIGIT);
            $isValid = false;
        }
        
        if ($value !== $context['password']) {
            $this->_error(self::REPEATED);
            $isValid = false;
        }

        return $isValid;
    }
}
