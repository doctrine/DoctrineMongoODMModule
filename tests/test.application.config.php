<?php

return [
    'modules' => [
        'DoctrineModule',
        'DoctrineMongoODMModule',
    ],
    'module_listener_options' => [
        'config_glob_paths'    => [
            __DIR__ . '/test.module.config.php',
        ],
        'module_paths' => [
            '../vendor',
        ],
    ],
];
