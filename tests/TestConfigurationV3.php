<?php

return array(
    'modules' => array(
        'Zend\Cache',
        'Zend\Form',
        'Zend\Hydrator',
        'Zend\Mvc\Console',
        'Zend\Paginator',
        'Zend\Router',
        'Zend\Validator',
        'DoctrineModule',
        'DoctrineMongoODMModule',
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            __DIR__ . '/testing.config.php',
        ),
        'module_paths' => array(
            '../vendor',
        ),
    ),
);
