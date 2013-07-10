<?php
return array(
    'doctrine' => array(
        'odm' => array(
            'configuration' => array(
                'default' => array(
                    'default_db' => 'doctrineMongoODMModuleTest'
                )
            ),
    ),
        'driver' => array(
            'default' => array(
                'drivers' => array(
                    'DoctrineMongoODMModuleTest\Assets\Document' => 'test'
                )
            ),
            'test' => array(
                'class' => 'Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/Assets/Document'
                )
            )
        )
    )
);
