<?php
return array(

    'doctrine_mongoodm_module' => array(
        // Use following setting if you know where your 'DoctrineAnnotations.php' is
        //'annotation_file' => __DIR__ . '/../vendor/mongodb-odm/lib/Doctrine/ODM/MongoDB/Mapping/Annotations/DoctrineAnnotations.php',
        'use_annotations' => true,
    ),

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
                        ),
                    ),
                ),               
            ),
        ),
        'instance' => array(
            'alias' => array(
                // document manager
                'mongo_dm'           => 'Doctrine\ODM\MongoDB\DocumentManager',

                // configuration
                'mongo_config'       => 'DoctrineMongoODMModule\Doctrine\ODM\MongoDB\Configuration',
                'mongo_connection'   => 'DoctrineMongoODMModule\Doctrine\ODM\MongoDB\Connection',
                'mongo_driver_chain' => 'DoctrineMongoODMModule\Doctrine\ODM\MongoDB\DriverChain',
                'mongo_evm'          => 'DoctrineModule\Doctrine\Common\EventManager',
            ),

            // Setting defaults: allows implicit injection of mongo_dm and mongo_connection when their types
            // are requested
            'preference' => array(
                'Doctrine\ODM\MongoDB\DocumentManager' => 'mongo_dm',
                'DoctrineMongoODMModule\Doctrine\ODM\MongoDB\Connection' => 'mongo_connection',
            ),

            'mongo_dm' => array(
                'parameters' => array(
                    'conn' => 'mongo_connection',
                ),
            ),

            'mongo_evm' => array(
                'parameters' => array(
                    'opts' => array(
                        'subscribers' => array(),
                    ),
                ),
            ),

            'mongo_driver_chain' => array(
                'parameters' => array(
                    'drivers' => array(),
                    'cache' => 'doctrine_cache_array',
                ),
            ),

            'mongo_connection' => array(
                'parameters' => array(
                    'server'  => null,
                    'options' => array(),
                    'config'  => 'mongo_config',
                    'evm'     => 'mongo_evm',
                )
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
                ),
            ),

            'DoctrineModule\Authentication\Adapter\DoctrineObject' => array(
                'parameters' => array(
                    'objectManager' => 'Doctrine\ODM\MongoDB\DocumentManager',
                ),
            ), 
                        
            // Commands to be attached to CLI tools
            'Symfony\Component\Console\Application' => array(
                'injections' => array(
                    'add' => array(
                        // MongoDB ODM
                        array('command' => 'Doctrine\ODM\MongoDB\Tools\Console\Command\QueryCommand'),
                        array('command' => 'Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateDocumentsCommand'),
                        array('command' => 'Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateRepositoriesCommand'),
                        array('command' => 'Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateProxiesCommand'),
                        array('command' => 'Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateHydratorsCommand'),
                        array('command' => 'Doctrine\ODM\MongoDB\Tools\Console\Command\Schema\CreateCommand'),
                        array('command' => 'Doctrine\ODM\MongoDB\Tools\Console\Command\Schema\DropCommand'),
                    )
                ),
            ),

            // CLI helpers            
            'Symfony\Component\Console\Helper\HelperSet' => array(
                'injections' => array(
                    'set' => array(
                        array(
                            'helper' => 'Doctrine\ODM\MongoDB\Tools\Console\Helper\DocumentManagerHelper',
                            'alias' => 'dm'
                        ),
                    ),
                ),
            ),
        ),

        'definition' => array(
            'class' => array(
                'Memcache' => array(
                    'addServer' => array(
                        'host' => array(
                            'type' => false,
                            'required' => true,
                        ),
                        'port' => array(
                            'type' => false,
                            'required' => true,
                        ),
                    )
                ),
                'Doctrine\ODM\MongoDB\DocumentManager' => array(
                    'instantiator' => array(
                        'DoctrineMongoODMModule\Factory\DocumentManager',
                        'get'
                    ),
                ),
                'DoctrineMongoODMModule\Factory\DocumentManager' => array(
                    'methods' => array(
                        'get' => array(
                            'conn' => array(
                                'type' => 'DoctrineMongoODMModule\Doctrine\ODM\MongoDB\Connection',
                                'required' => true,
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);