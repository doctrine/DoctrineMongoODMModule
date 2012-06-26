<?php

namespace DoctrineMongoODMModule\Service;

use Doctrine\MongoDB,
    DoctrineModule\Service\AbstractFactory,
    Zend\ServiceManager\ServiceLocatorInterface;

class ConnectionFactory extends AbstractFactory
{
    public function createService(ServiceLocatorInterface $sl)
    {
        $options       = $this->getOptions($sl, 'connection');
        $configuration = $sl->get($options->getConfiguration());
        $eventManager  = $sl->get($options->getEventManager());

        return new \Doctrine\MongoDB\Connection(
            $options->getServer(),
            $options->getOptions(),
            $configuration, 
            $eventManager
        );
    }

    /**
     * Get the class name of the options associated with this factory.
     *
     * @return string
     */
    public function getOptionsClass()
    {
        return 'DoctrineMongoODMModule\Options\Connection';
    }
}