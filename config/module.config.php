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
                    'metadata_cache'     => 'array',

                    'driver'             => 'default',

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
                    'connection'    => 'default',
                    'configuration' => 'default',
                    'eventmanager' => 'default'
                )
            ),
            'mongo_logger_collector' => array(
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
            'default' => array(
                'objectManager' => 'doctrine.odm.documentmanager.default',
                'identityClass' => 'Application\Model\User',
                'identityProperty' => 'username',
                'credentialProperty' => 'password'
            ),
        ),
    ),

    // Factory mappings - used to define which factory to use to instantiate a particular doctrine
    // service type
    'doctrine_factories' => array(
        'odm' => array(
            'connection'             => 'DoctrineMongoODMModule\Service\ConnectionFactory',
            'configuration'          => 'DoctrineMongoODMModule\Service\ConfigurationFactory',
            'documentmanager'        => 'DoctrineMongoODMModule\Service\DocumentManagerFactory',
            'mongo_logger_collector' => 'DoctrineMongoODMModule\Service\MongoLoggerCollectorFactory',
        )
    ),

    'service_manager' => array(
        'invokables' => array(
            'DoctrineMongoODMModule\Logging\DebugStack'   => 'DoctrineMongoODMModule\Logging\DebugStack',
            'DoctrineMongoODMModule\Logging\LoggerChain'  => 'DoctrineMongoODMModule\Logging\LoggerChain',
            'DoctrineMongoODMModule\Logging\EchoLogger'   => 'DoctrineMongoODMModule\Logging\EchoLogger',

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
        'factories' => array(
            'Doctrine\ODM\Mongo\DocumentManager'          => 'DoctrineMongoODMModule\Service\DocumentManagerAliasCompatFactory',
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
                'odm.default' => 'doctrine.odm.mongo_logger_collector.default',
            ),
        ),
        'toolbar' => array(
            'entries' => array(
                'odm.default' => 'zend-developer-tools/toolbar/doctrine-odm',
            ),
        ),
    ),
);