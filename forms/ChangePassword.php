<?php

class Form_ChangePassword extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');
        
        $this->setAttrib('class', 'form-horizontal col-sm-4');
        
        $this->addElement('password', 'currentPassword', array(
            'label'      => 'Current password',
            'class'      => 'form-control',
            'required'   => true,
            'validators' => array(
                new Form_Validators_ChangePasswordCurrentPassword()
                )
        ));

        $this->addElement('password', 'password', array(
            'label'      => 'New password',
            'class'      => 'form-control',
            'required'   => true,
            'validators' => array(
                new Form_Validators_RegisterPassword()
                )
        ));

        $this->addElement('password', 'repeatedPassword', array(
            'label'      => 'New password again',
            'class'      => 'form-control',
            'required'   => true,
            'validators' => array(
                new Form_Validators_RegisterRepeatedPassword(),
                )
        ));

        $this->addElement('submit', 'submit', array(
            'class'  => 'btn btn-default',
            'ignore' => true,
            'label'  => 'Submit'
        ));
    }
}
