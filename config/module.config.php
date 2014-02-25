<?php
return array(
    'doctrine' => array(
        'odm' => array(
            'connection' => array(
                'default' => array(
                    'server'    => 'localhost',
                    'port'      => '27017',
                    'user'      => null,
                    'password'  => null,
                    'dbname'    => null,
                    'options'   => array()
                ),
            ),
            'configuration' => array(
                'default' => array(
                    'metadata_cache'     => 'doctrine.cache.array',

                    'driver'             => 'doctrine.driver.default',

                    'generate_proxies'   => true,
                    'proxy_dir'          => 'data/DoctrineMongoODMModule/Proxy',
                    'proxy_namespace'    => 'DoctrineMongoODMModule\Proxy',

                    'generate_hydrators' => true,
                    'hydrator_dir'       => 'data/DoctrineMongoODMModule/Hydrator',
                    'hydrator_namespace' => 'DoctrineMongoODMModule\Hydrator',

                    'default_db'         => null,

                    'filters'            => array()  // array('filterName' => 'BSON\Filter\Class')

                    //'classMetadataFactoryName' => 'ClassName'
                ),
            ),
            'documentmanager' => array(
                'default' => array(
                    'connection'    => 'doctrine.odm.connection.default',
                    'configuration' => 'doctrine.odm.configuration.default',
                    'eventmanager'  => 'doctrine.eventmanager.default'
                )
            ),
            'mongologgercollector' => array(
                'default' => array(),
            ),
        ),

        'driver' => array(
            'default' => array(
                'class'   => 'Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain',
                'drivers' => array()
            )
        ),

        'eventmanager' => array(
            'default' => array(
                'subscribers' => array()
            )
        ),

        'authentication' => array(
            'adapter' => array(
                'default' => array(
                    'object_manager' => 'doctrine.odm.documentmanager.default',
                    'identity_class' => 'Application\Model\User',
                    'identity_property' => 'username',
                    'credential_property' => 'password'
                )
            ),
            'storage' => array(
                'default' => array(
                    'object_manager' => 'doctrine.odm.documentmanager.default',
                    'identity_class' => 'Application\Model\User',
                )
            ),
        )
    ),

    'service_manager' => array(
        'alias' => array(
            'doctrine.objectmanager.default' => 'doctrine.odm.documentmanager.default'
        ),
        'invokables' => array(
            'DoctrineMongoODMModule\Logging\DebugStack'   => 'DoctrineMongoODMModule\Logging\DebugStack',
            'DoctrineMongoODMModule\Logging\LoggerChain'  => 'DoctrineMongoODMModule\Logging\LoggerChain',
            'DoctrineMongoODMModule\Logging\EchoLogger'   => 'DoctrineMongoODMModule\Logging\EchoLogger',

            'doctrine.builder.odm.connection'             => 'DoctrineMongoODMModule\Builder\ConnectionBuilder',
            'doctrine.builder.odm.configuration'          => 'DoctrineMongoODMModule\Builder\ConfigurationBuilder',
            'doctrine.builder.odm.documentmanager'        => 'DoctrineMongoODMModule\Builder\DocumentManagerBuilder',
            'doctrine.builder.odm.mongologgercollector'   => 'DoctrineMongoODMModule\Builder\MongoLoggerCollectorBuilder',

            // ODM commands
            'doctrine.odm.query_command' => 'Doctrine\ODM\MongoDB\Tools\Console\Command\QueryCommand',
            'doctrine.odm.generate_documents_command' => 'Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateDocumentsCommand',
            'doctrine.odm.generate_repositories_command' => 'Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateRepositoriesCommand',
            'doctrine.odm.generate_proxies_command' => 'Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateProxiesCommand',
            'doctrine.odm.generate_hydrators_command' => 'Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateHydratorsCommand',
            'doctrine.odm.create_command' => 'Doctrine\ODM\MongoDB\Tools\Console\Command\Schema\CreateCommand',
            'doctrine.odm.update_command' => 'Doctrine\ODM\MongoDB\Tools\Console\Command\Schema\UpdateCommand',
            'doctrine.odm.drop_command' => 'Doctrine\ODM\MongoDB\Tools\Console\Command\Schema\DropCommand',
            'doctrine.odm.clear_cache_metadata' => 'Doctrine\ODM\MongoDB\Tools\Console\Command\ClearCache\MetadataCommand',
        ),
    ),

    // zendframework/zend-developer-tools specific settings

    'view_manager' => array(
        'template_map' => array(
            'zend-developer-tools/toolbar/doctrine-odm' => __DIR__ . '/../view/zend-developer-tools/toolbar/doctrine-odm.phtml',
        ),
    ),

    'zenddevelopertools' => array(
        'profiler' => array(
            'collectors' => array(
                'odm.default' => 'doctrine.odm.mongologgercollector.default',
            ),
        ),
        'toolbar' => array(
            'entries' => array(
                'odm.default' => 'zend-developer-tools/toolbar/doctrine-odm',
            ),
        ),
    ),
);