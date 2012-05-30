<?php

namespace DoctrineMongoODMModule\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;

class CachedReaderFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sl)
    {
        $cache = $sl->get('doctrine_odm_metadata_cache');        
        return new CachedReader(new AnnotationReader, $cache);
    }
}
