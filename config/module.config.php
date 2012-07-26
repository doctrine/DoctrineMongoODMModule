<?php
return array(
    'doctrine' => array(
        'odm_autoload_annotations' => true,

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
                'proxy_dir'          => 'data',
                'proxy_namespace'    => 'DoctrineMongoODMModule\Proxy',

                'generate_hydrators' => true,
                'hydrator_dir'       => 'data',
                'hydrator_namespace' => 'DoctrineMongoODMModule\Hydrator',

                'default_db'         => null,

                'annotations'        => array(), // array('Annotation\Namespace\' => '/../annotation/path')
                'filters'            => array()  // array('filterName' => 'BSON\Filter\Class')
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

        'authenticationadapter' => array(
            'odm_default' => array(
                'objectManager' => 'doctrine.documentmanager.odm_default',
                'identityClass' => 'Application\Model\User',
                'identityProperty' => 'username',
                'credentialProperty' => 'password',
                'credentialCallable' => 'Application\Model\User::hashPassword'
            ),
        ),
    ),
);