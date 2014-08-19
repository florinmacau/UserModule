<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initAutoload()
    {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $gastroAutoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => '',
            'basePath' => APPLICATION_PATH . '/modules/UserModule'
        ));
        $autoloader->pushAutoloader($gastroAutoloader);
        return $gastroAutoloader;
    }
}

