<?php
return array(
    'doctrine' => array(
        'configuration' => array(
            'odm_default' => array(
                'default_db' => 'doctrineMongoODMModuleTest',
                'retryConnect' => 123,
                'retryQuery' => 456
            )
        ),
        'driver' => array(
            'odm_default' => array(
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
