<?php

namespace DoctrineMongoODMModule\Service;

use Doctrine\Laminas\Hydrator\DoctrineObject;
use Doctrine\ODM\MongoDB\DocumentManager;
use Psr\Container\ContainerInterface;

class DoctrineObjectHydratorFactory
{
    public function __invoke(ContainerInterface $container): DoctrineObject
    {
        /** @var DocumentManager $documentManager */
        $documentManager = $container->get('doctrine.documentmanager.odm_default');

        return new DoctrineObject($documentManager);
    }
}
