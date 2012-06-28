<?php
return array(
    'doctrine' => array(
        'odm_autoload_annotations' => true,

        'annotations' => array(
            'odm_default' => array()
        ),
        
        'connection' => array(
            'odm_default' => array(
                'configuration' => 'odm_default',
                'eventManager' => 'odm_default',

                'params' => array(
                    'server'    => 'localhost',
                    'port'      => '27017',
                    'user'      => null,
                    'password'  => null,
                    'dbname'    => 'database'
                )
            ),
        ),

        'configuration' => array(
            'odm_default' => array(
                'metadata_cache'     => 'array',

                'driver'             => 'odm_default',

                'generate_proxies'   => true,
                'proxy_dir'          => 'data',
                'proxy_namespace'    => 'DoctrineMongoODMModule\Proxy',

                'generate_hydrators' => true,
                'hydrator_dir'       => 'data',
                'hydrator_namespace' => 'DoctrineMongoODMModule\Hydrator',

                'default_db'         => null,
                
                'filters'            => array()
            )
        ),

        'driver' => array(
            'odm_default' => array(
                'class'   => 'Doctrine\ODM\MongoDB\DriverChain',
                'drivers' => array()
            )
        ),

        'documentManager' => array(
            'odm_default' => array(
                'connection'    => 'odm_default',
                'configuration' => 'odm_default'
            )
        ),

        'eventmanager' => array(
            'odm_default' => array(
                'subscribers' => array()
            )
        ),
    ),
);