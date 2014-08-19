<?php

class Form_Login extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');
        
        $this->setAttrib('class', 'form-horizontal col-sm-4');
        
        $this->addElement('text', 'username', array(
            'label'      => 'Username',
            'class'      => 'form-control',
            'required'   => true,
            'filter'     => array('StringTrim'),
            'validators' => array(
                new Form_Validators_LoginUsername()
                )
        ));
        
        $this->addElement('password', 'password', array(
            'label'    => 'Password',
            'class'    => 'form-control',
            'required' => true
        ));
        
        $this->addElement('captcha', 'captcha', array(
            'label'      => 'Enter the 4 letters below:',
            'class'      => 'form-control',
            'required'   => true,
            'captcha'    => array(
                'captcha' => 'Figlet',
                'wordLen' => 4,
                'timeout' => 300
            )
        ));

        $this->addElement('submit', 'submit', array(
            'class'  => 'btn btn-default',
            'ignore' => true,
            'label'  => 'Login'
        ));
    }
}
