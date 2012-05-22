<?php
return array(
    'doctrine_odm_connection' => array(      
        'server'  => 'mongodb://<user>:<password>@<server>:<port>',
        'options' => array()        
    ),

    'doctrine_odm_config' => array(
        'default_db' => null,
        
        'auto_generate_proxies'     => true,
        'proxy_dir'                 => 'data/DoctrineODMModule/Proxy',
        'proxy_namespace'           => 'DoctrineODMModule\Proxy',

        'auto_generate_hydrators'     => true,
        'hydrator_dir'                 => 'data/DoctrineODMModule/Hydrator',
        'hydrator_namespace'           => 'DoctrineODMModule\Hydrator',              
    ),    
);