<?php

namespace DoctrineMongoODMModule\Service;

use Doctrine\ODM\MongoDB\Mapping\Driver\DriverChain;
use Zend\EventManager\EventManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Doctrine\ODM\MongoDB\Configuration;

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
    
    public function createService(ServiceLocatorInterface $sl)
    {
        $userConfig = $sl->get('Configuration')->doctrine_odm_config;        
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
        $config->setMetadataCacheImpl($sl->get('doctrine_odm_metadata_cache'));
        
        //filters
        $filters = $this->getFilters($sl, $config);      
        foreach($filters as $alias => $class){
            $config->addFilter($alias, $class);
        }
        
        // finally, the driver
        $config->setMetadataDriverImpl($this->getDriverChain($sl, $config));        
        
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
}