<?php

return [
    'modules' => [
        'Zend\Cache',
        'Zend\Form',
        'Zend\Hydrator',
        'Zend\Mvc\Console',
        'Zend\Paginator',
        'Zend\Router',
        'Zend\Validator',
        'DoctrineModule',
        'DoctrineMongoODMModule',
    ],
    'module_listener_options' => [
        'config_glob_paths'    => [
            __DIR__ . '/testing.config.php',
        ],
        'module_paths' => [
            '../vendor',
        ],
    ],
];
