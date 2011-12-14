<?php
return array(
    'di' => array(
        'definition' => array(
            'class' => array(
                'Memcache' => array(
                    'addServer' => array(
                        'host' => array('type' => false, 'required' => true),
                        'port' => array('type' => false, 'required' => true),
                    )
                ),
                'SpiffyDoctrineMongoODM\Factory\DocumentManager' => array(
                    'instantiator' => array('SpiffyDoctrineMongoODM\Factory\DocumentManager', 'get'),
                    'methods' => array(
                        'get' => array(
                            'conn' => array('type' => 'SpiffyDoctrineMongoODM\Doctrine\ODM\MongoDB\Connection', 'required' => true)
                        )
                    )
                ),
            ),
        ),
        'instance' => array(
            'alias' => array(
                // document manager
                'doctrine_mongo' => 'SpiffyDoctrineMongoODM\Factory\DocumentManager',
                
                // configuration
                'mongo_config'       => 'SpiffyDoctrineMongoODM\Doctrine\ODM\MongoDB\Configuration',
                'mongo_connection'   => 'SpiffyDoctrineMongoODM\Doctrine\ODM\MongoDB\Connection',
                'mongo_driver_chain' => 'SpiffyDoctrineMongoODM\Doctrine\ODM\MongoDB\DriverChain',
                'mongo_evm'          => 'SpiffyDoctrine\Doctrine\Common\EventManager',
            ),
            'mongo_config' => array(
                'parameters' => array(
                    'opts' => array(
                        'auto_generate_proxies'   => true,
                        'proxy_dir'               => __DIR__ . '/../../../data/SpiffyDoctrine/Proxy',
                        'proxy_namespace'         => 'SpiffyDoctrineMongoODM\Proxy',
                        'auto_generate_hydrators' => true,
                        'hydrator_dir'            => __DIR__ . '/../../../data/SpiffyDoctrine/Hydrators',
                        'hydrator_namespace'      => 'SpiffyDoctrineMongoODM\Hydrators',
                    ),
                    'metadataDriver' => 'mongo_driver_chain',
                    'metadataCache'  => 'doctrine_cache_array',
                    'logger'         => null,
                )
            ),
            'mongo_connection' => array(
                'parameters' => array(
                    'server'  => null,
                    'options' => array(),
                    'config'  => 'mongo_config',
                    'evm'     => 'mongo_evm',
                )
            ),
            'mongo_driver_chain' => array(
                'parameters' => array(
                    'drivers' => array(),
                    'cache' => 'doctrine_cache_array'
                )
            ),
            'mongo_evm' => array(
                'parameters' => array(
                    'opts' => array(
                        'subscribers' => array()
                    )
                )
            ),
            'doctrine_mongo' => array(
                'parameters' => array(
                    'conn' => 'mongo_connection',
                )
            ),
        )
    )
);