<?php

declare(strict_types=1);

namespace DoctrineMongoODMModule\Service;

use Doctrine\Laminas\Hydrator\DoctrineObject;
use Doctrine\ODM\MongoDB\DocumentManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

use function assert;

class DoctrineObjectHydratorFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName = null,
        ?array $options = null
    ): DoctrineObject {
        $documentManager = $container->get('doctrine.documentmanager.odm_default');
        assert($documentManager instanceof DocumentManager);

        return new DoctrineObject($documentManager);
    }
}
