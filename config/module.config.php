<?php
return array(
    'doctrine_odm_connection' => array(      
        'server'  => 'mongodb://<user>:<password>@<server>:<port>',
        'options' => array()        
    ),

    'doctrine_odm_config' => array(
        'default_db' => null,
        
        'use_annotations' => true,
        
        'auto_generate_proxies'     => true,
        'proxy_dir'                 => 'data/DoctrineMongoODMModule/Proxy',
        'proxy_namespace'           => 'DoctrineMongoODMModule\Proxy',

        'auto_generate_hydrators'   => true,
        'hydrator_dir'              => 'data/DoctrineMongoODMModule/Hydrator',
        'hydrator_namespace'        => 'DoctrineMongoODMModule\Hydrator',              
    ),   
    
    'di' => array(    
        'instance' => array(
            'DoctrineModule\Authentication\Adapter\DoctrineObject' => array(
                'parameters' => array(
                    'objectManager' => 'Doctrine\ODM\MongoDB\DocumentManager',
                ),
            ),    
        ),
    ),
);