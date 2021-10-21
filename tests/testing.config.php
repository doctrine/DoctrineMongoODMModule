<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest;

use function getenv;

return [
    'doctrine' => [
        'configuration' => [
            'odm_default' => [
                'default_db' => 'doctrineMongoODMModuleTest',
                'default_document_repository_class_name' => Assets\DefaultDocumentRepository::class,
            ],
        ],
        'connection' => [
            // in Github actions MongoDB is available under 127.0.0.1, docker-compose needs mongodb
            'odm_default' => ['server' => getenv('GITHUB_ACTION') ? '127.0.0.1' : 'mongodb'],
        ],
        'driver' => [
            'odm_default' => [
                'drivers' => ['DoctrineMongoODMModuleTest\Assets\Document' => 'test'],
            ],
            'test' => [
                'class' => 'Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/DoctrineMongoODMModuleTest/Assets/Document'],
            ],
        ],
    ],
];
