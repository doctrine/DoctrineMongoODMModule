<?php

namespace DoctrineMongoODMModule\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ConnectionFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sl)
    {
        $config = $sl->get('Configuration');
        $config = $config['doctrine_odm_connection'];       
        
        return new \Doctrine\MongoDB\Connection(
            $config['server'],
            $config['options']
        );
    }
}
