<?php
return array(
    'doctrine' => array(

        'connection' => array(
            'odm_default' => array(
                'server'    => 'localhost',
                'port'      => '27017',
                'user'      => null,
                'password'  => null,
                'dbname'    => null,
                'options'   => array()
            ),
        ),

        'configuration' => array(
            'odm_default' => array(
                'metadata_cache'     => 'array',

                'driver'             => 'odm_default',

                'generate_proxies'   => true,
                'proxy_dir'          => 'data/DoctrineMongoODMModule/Proxy',
                'proxy_namespace'    => 'DoctrineMongoODMModule\Proxy',

                'generate_hydrators' => true,
                'hydrator_dir'       => 'data/DoctrineMongoODMModule/Hydrator',
                'hydrator_namespace' => 'DoctrineMongoODMModule\Hydrator',

                'default_db'         => null,

                'filters'            => array()  // array('filterName' => 'BSON\Filter\Class')
                
                //'classMetadataFactoryName' => 'ClassName'
            )
        ),

        'driver' => array(
            'odm_default' => array(
                'class'   => 'Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain',
                'drivers' => array()
            )
        ),

        'documentmanager' => array(
            'odm_default' => array(
                'connection'    => 'odm_default',
                'configuration' => 'odm_default',
                'eventmanager' => 'odm_default'
            )
        ),

        'eventmanager' => array(
            'odm_default' => array(
                'subscribers' => array()
            )
        ),

        'mongo_logger_collector' => array(
            'odm_default' => array(),
        ),

        'authentication' => array(
            'odm_default' => array(
                'objectManager' => 'doctrine.documentmanager.odm_default',
                'identityClass' => 'Application\Model\User',
                'identityProperty' => 'username',
                'credentialProperty' => 'password'
            ),
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
                'odm_default' => 'doctrine.mongo_logger_collector.odm_default',
            ),
        ),
        'toolbar' => array(
            'entries' => array(
                'odm_default' => 'zend-developer-tools/toolbar/doctrine-odm',
            ),
        ),
    ),
);