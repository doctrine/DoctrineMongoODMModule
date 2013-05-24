<?php
return array(
    'doctrine' => array(
        'odm' => array(
            'configuration' => array(
                'default' => array(
                    'default_db'   => 'doctrineMongoODMModuleTest',
                    'proxy_dir'    => __DIR__ . '/proxy',
                    'hydrator_dir' => __DIR__ . '/hydrator',
                )
            ),
        ),
        'driver' => array(
            'default' => array(
                'drivers' => array(
                    'DoctrineMongoODMModuleTest\Assets\Document' => 'doctrine.driver.test'
                )
            ),
            'test' => array(
                'class' => 'Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver',
                'cache' => 'doctrine.cache.array',
                'paths' => array(
                    __DIR__ . '/Assets/Document'
                )
            )
        )
    )
);
