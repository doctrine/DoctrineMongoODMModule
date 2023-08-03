<?php

declare(strict_types=1);

namespace DoctrineMongoODMModule\Service;

use Doctrine\Laminas\Hydrator\DoctrineObject;
use Doctrine\ODM\MongoDB\DocumentManager;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

use function assert;

final class DoctrineObjectHydratorFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName = null,
        array|null $options = null,
    ): DoctrineObject {
        $documentManager = $container->get('doctrine.documentmanager.odm_default');
        assert($documentManager instanceof DocumentManager);

        return new DoctrineObject($documentManager);
    }
}
