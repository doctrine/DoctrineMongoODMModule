 <?php
 /**
  * Doctrine MongoDB Configuration
  *
  * If you have a ./configs/autoload/ directory set up for your project, you can 
  * drop this config file in it and change the values as you wish. This file is intended
  * to be used with a standard Doctrine MongoDB setup. If you have something more advanced
  * you may override the Zend\Di configuration manually (see module.config.php).
  */
$settings = array(
    // if disabled will not register annotations
    'use_annotations' => true,
    
    // if use_annotations (above) is set to true this file will be registered
    'annotation_file' => __DIR__ . '/../../vendor/DoctrineMongoODMModule/vendor/mongodb-odm/lib/Doctrine/ODM/MongoDB/Mapping/Annotations/DoctrineAnnotations.php',
    
    // enables production mode by disabling generation of hydrators and proxies
    'production' => false,
   
    // sets the cache to use for metadata: one of 'array', 'apc', or 'memcache'
    'cache' => 'array',
   
    // only used if cache above is set to memcache
    'memcache' => array( 
        'host' => '127.0.0.1',
        'port' => '11211'
    ),

    'config' => array(
        // set the default database to use (or not)
        'default_db' => null
    ), 
   
    'connection' => array(
        'server'  => 'mongodb://<user>:<password>@<server>:<port>',
        'options' => array()
    ),
    
    'driver' => array(
        'class'     => 'Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver',
        'namespace' => 'Application\Document',
        'paths'     => array('module/Application/src/Application/Document'),
    ),
    
);

/**
 * YOU DO NOT NEED TO EDIT BELOW THIS LINE.
 */
$cache = array('array', 'memcache', 'apc');
if (!in_array($settings['cache'], $cache)) {
    throw new InvalidArgumentException(sprintf(
        'cache must be one of: %s',
        implode(', ', $cache)
    ));
}
$settings['cache'] = 'doctrine_cache_' . $settings['cache'];

return array(
    'doctrine_mongoodm_module' => array(
        'annotation_file' => $settings['annotation_file'],
        'use_annotations' => $settings['use_annotations'],
    ),
    'di' => array(
        'instance' => array(
            'doctrine_memcache' => array(
                'parameters' => $settings['memcache']
            ),
            'mongo_config' => array(
                'parameters' => array(
                    'opts' => array(
                        'auto_generate_proxies'   => !$settings['production'],
                        'auto_generate_hydrators' => !$settings['production'],
                        'default_db' => $settings['config']['default_db'],
                    ),
                    'metadataCache'  => $settings['cache'],
                )
            ),
            'mongo_connection' => array(
                'parameters' => $settings['connection']
            ),
            'mongo_driver_chain' => array(
                'parameters' => array(
                    'drivers' => array(
                        'application_annotation_driver' => $settings['driver']
                    )
                )
            ),
        ),
    ),
);