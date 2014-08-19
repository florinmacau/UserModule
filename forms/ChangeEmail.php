<?php

class Form_ChangeEmail extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');
        
        $this->setAttrib('class', 'form-horizontal col-sm-4');

        $this->addElement('text', 'email', array(
            'label'      => 'New email',
            'class'      => 'form-control',
            'required'   => true,
            'filter'     => array('StringTrim'),
            'validators' => array(
                new Form_Validators_RegisterEmail()
                )
        ));

        $this->addElement('text', 'repeatedEmail', array(
            'label'      => 'New email again',
            'class'      => 'form-control',
            'required'   => true,
            'filter'     => array('StringTrim'),
            'validators' => array(
                new Form_Validators_ChangeEmailRepeatedEmail()
                )
        ));

        $this->addElement('password', 'password', array(
            'label'      => 'Password',
            'class'      => 'form-control',
            'required'   => true,
            'validators' => array(
                new Form_Validators_ChangePasswordCurrentPassword()
            )
        ));

        $this->addElement('submit', 'submit', array(
            'class'  => 'btn btn-default',
            'ignore' => true,
            'label'  => 'Submit'
        ));
    }
}
