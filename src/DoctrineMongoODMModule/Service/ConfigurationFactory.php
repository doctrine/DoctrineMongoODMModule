<?php

namespace DoctrineMongoODMModule\Service;

use Doctrine\ODM\MongoDB\Mapping\Driver\DriverChain;
use Zend\EventManager\EventManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\Common\Annotations\AnnotationRegistry;
    
class ConfigurationFactory implements FactoryInterface
{
    /**
     * @var \Zend\EventManager\EventManager
     */
    protected $events;

    /**
     * @var \Doctrine\ODM\MongoDB\Mapping\Driver\DriverChain
     */
    protected $chain;

    protected $filters;
    
    protected $annotations;
    
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $userConfig = $serviceLocator->get('Configuration')->doctrine_odm_config;         
        
        if ($userConfig->use_annotations) {

            // Trying to load DoctrineAnnotations.php without knowing its location
            $annotationReflection = new \ReflectionClass('Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver');
            $libfile = dirname($annotationReflection->getFileName()) . '/../Annotations/DoctrineAnnotations.php';

            AnnotationRegistry::registerFile($libfile);
            
            foreach($this->getAnnotations($serviceLocator) as $annotationFile){
                AnnotationRegistry::registerFile($annotationFile);                
            }
        }

        if (!class_exists('Doctrine\ODM\MongoDB\Mapping\Annotations\Document', true)) {
            throw new \Exception('Doctrine could not be autoloaded - ensure it is in the correct path.');
        }     
               
        $config = new Configuration;

        // proxies
        $config->setAutoGenerateProxyClasses($userConfig->auto_generate_proxies);
        $config->setProxyDir($userConfig->proxy_dir);
        $config->setProxyNamespace($userConfig->proxy_namespace);
        
        // hydrators
        $config->setAutoGenerateHydratorClasses($userConfig->auto_generate_hydrators);
        $config->setHydratorDir($userConfig->hydrator_dir);
        $config->setHydratorNamespace($userConfig->hydrator_namespace);
        
        // default db
        $config->setDefaultDB($userConfig->default_db);
        
        // caching
        $config->setMetadataCacheImpl($serviceLocator->get('doctrine_odm_metadata_cache'));
        
        //filters
        $filters = $this->getFilters($serviceLocator, $config);      
        foreach($filters as $alias => $class){
            $config->addFilter($alias, $class);
        }
        
        // finally, the driver
        $config->setMetadataDriverImpl($this->getDriverChain($serviceLocator, $config));        
        
        return $config;
    }

    protected function events()
    {
        if (null === $this->events) {
            $events = new EventManager;
            $events->setIdentifiers(array(
                'DoctrineMongoODMModule'
            ));

            $this->events = $events;
        }
        return $this->events;
    }

    protected function getDriverChain(ServiceLocatorInterface $sl, $config)
    {
        if (null === $this->chain) {
            $events = $this->events();
            $chain  = new DriverChain;

            // TODO: Temporary workaround for EventManagerFactory. Remove when file is patched.
            $events->setSharedManager($sl->get('ModuleManager')->events()->getSharedManager());

            $collection = $events->trigger('loadDrivers', $sl, array('config' => $config));
            foreach($collection as $response) {
                foreach($response as $namespace => $driver) {
                    $chain->addDriver($driver, $namespace);
                }
            }
            $this->chain = $chain;            
        }
        return $this->chain;
    }
    
    protected function getFilters(ServiceLocatorInterface $sl, $config)
    {
        if (null == $this->filters){
            $events = $this->events();
            $filters  = array();

            // TODO: Temporary workaround for EventManagerFactory. Remove when file is patched.
            $events->setSharedManager($sl->get('ModuleManager')->events()->getSharedManager());
            
            $collection = $events->trigger('loadFilters', $sl, array('config' => $config));
            foreach($collection as $response) {
                $filters = array_merge($filters, $response);
            }
            $this->filters = $filters;
        }
        return $this->filters;                     
    }
    
    protected function getAnnotations(ServiceLocatorInterface $serviceLocator)
    {
        if (null == $this->annotations){
            $events = $this->events();
            $annotations  = array();

            // TODO: Temporary workaround for EventManagerFactory. Remove when file is patched.
            $events->setSharedManager($serviceLocator->get('ModuleManager')->events()->getSharedManager());
            
            $collection = $events->trigger('loadAnnotations', $serviceLocator);
            foreach($collection as $response) {
                $annotations = array_merge($annotations, $response);
            }
            $this->annotations = $annotations;
        }
        return $this->annotations;          
    }
}