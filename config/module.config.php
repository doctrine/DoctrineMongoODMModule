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
                'DoctrineMongoODMModule\Factory\DocumentManager' => array(
                    'instantiator' => array('DoctrineMongoODMModule\Factory\DocumentManager', 'get'),
                    'methods' => array(
                        'get' => array(
                            'conn' => array('type' => 'DoctrineMongoODMModule\Doctrine\ODM\MongoDB\Connection', 'required' => true)
                        )
                    )
                ),                
                'DoctrineMongoODMModule\Authentication\Adapter\DoctrineDocument' => array(
                    'methods' => array(
                        'setDocument' => array(
                            'document' => array('type' => false, 'required' => true)
                        )
                    )
                )                
            ),
        ),
        'instance' => array(
            'alias' => array(
                // document manager
                'mongo_dm' => 'DoctrineMongoODMModule\Factory\DocumentManager',
                
                // configuration
                'mongo_config'       => 'DoctrineMongoODMModule\Doctrine\ODM\MongoDB\Configuration',
                'mongo_connection'   => 'DoctrineMongoODMModule\Doctrine\ODM\MongoDB\Connection',
                'mongo_driver_chain' => 'DoctrineMongoODMModule\Doctrine\ODM\MongoDB\DriverChain',
                'mongo_evm'          => 'DoctrineModule\Doctrine\Common\EventManager',
            ),
            'mongo_config' => array(
                'parameters' => array(
                    'opts' => array(
                        'auto_generate_proxies'   => true,
                        'proxy_dir'               => __DIR__ . '/../../../data/DoctrineMongoODMModule/Proxy',
                        'proxy_namespace'         => 'DoctrineMongoODMModule\Proxy',
                        'auto_generate_hydrators' => true,
                        'hydrator_dir'            => __DIR__ . '/../../../data/DoctrineMongoODMModule/Hydrators',
                        'hydrator_namespace'      => 'DoctrineMongoODMModule\Hydrators',
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
            'mongo_dm' => array(
                'parameters' => array(
                    'conn' => 'mongo_connection',
                )
            ),
        )
    )
);