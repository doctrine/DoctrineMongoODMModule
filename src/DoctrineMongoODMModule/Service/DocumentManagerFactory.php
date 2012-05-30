<?php

namespace DoctrineMongoODMModule\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DocumentManagerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sl)
    {
        $odmConn = $sl->get('Doctrine\MongoDB\Connection');
        $odmConfig  = $sl->get('Doctrine\ODM\MongoDB\Configuration');
        $odmEm  = $sl->get('Doctrine\Common\EventManager');
        
        return \Doctrine\ODM\MongoDB\DocumentManager::create($odmConn, $odmConfig, $odmEm);
    }
}