<?php
return [
    'doctrine' => [
        'configuration' => [
            'odm_default' => [
                'default_db' => 'doctrineMongoODMModuleTest',
                'retryConnect' => 123,
                'retryQuery' => 456
            ]
        ],
        'connection' => [
            'odm_default' => [
                'server' => 'mongo',
            ],
        ],
        'driver' => [
            'odm_default' => [
                'drivers' => [
                    'DoctrineMongoODMModuleTest\Assets\Document' => 'test'
                ]
            ],
            'test' => [
                'class' => 'Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/Assets/Document'
                ]
            ]
        ]
    ]
];
