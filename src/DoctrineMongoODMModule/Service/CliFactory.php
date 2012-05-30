<?php

namespace DoctrineMongoODMModule\Service;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\HelperSet;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CliFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $documentManager = $serviceLocator->get('mongo_dm');
        $documentHelper  = new \Doctrine\ODM\MongoDB\Tools\Console\Helper\DocumentManagerHelper($documentManager);
        $helperSet     = new HelperSet;
        $helperSet->set($documentHelper, 'dm');

        $cli = new Application;
        $cli->setName('DoctrineMongoODMModule Command Line Interface');
        $cli->setVersion('dev-master');
        $cli->setHelperSet($helperSet);

        $cli->addCommands(array(           
            new \Doctrine\ODM\MongoDB\Tools\Console\Command\QueryCommand(),
            new \Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateDocumentsCommand(),
            new \Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateRepositoriesCommand(),
            new \Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateProxiesCommand(),
            new \Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateHydratorsCommand(),
            new \Doctrine\ODM\MongoDB\Tools\Console\Command\Schema\CreateCommand(),
            new \Doctrine\ODM\MongoDB\Tools\Console\Command\Schema\DropCommand(),            
        ));

        return $cli;
    }
}