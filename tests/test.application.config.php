<?php
return array(
    'modules' => array(
        'DoctrineModule',
        'DoctrineMongoODMModule',
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            'tests/test.module.config.php',
        ),
        'module_paths' => array(
            './vendor',
        ),
    ),
);