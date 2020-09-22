<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest;

return [
    'doctrine' => [
        'configuration' => [
            'odm_default' => [
                'default_db' => 'doctrineMongoODMModuleTest',
                'default_document_repository_class_name' => Assets\DefaultDocumentRepository::class,
            ],
        ],
        'connection' => [
            'odm_default' => ['server' => 'mongo'],
        ],
        'driver' => [
            'odm_default' => [
                'drivers' => ['DoctrineMongoODMModuleTest\Assets\Document' => 'test'],
            ],
            'test' => [
                'class' => 'Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/Assets/Document'],
            ],
        ],
    ],
];
