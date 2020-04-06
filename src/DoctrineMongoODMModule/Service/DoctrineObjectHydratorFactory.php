<?php

declare(strict_types=1);

namespace DoctrineMongoODMModule\Service;

use Doctrine\Laminas\Hydrator\DoctrineObject;
use Doctrine\ODM\MongoDB\DocumentManager;
use Psr\Container\ContainerInterface;
use function assert;

class DoctrineObjectHydratorFactory
{
    public function __invoke(ContainerInterface $container) : DoctrineObject
    {
        $documentManager = $container->get('doctrine.documentmanager.odm_default');
        assert($documentManager instanceof DocumentManager);

        return new DoctrineObject($documentManager);
    }
}
