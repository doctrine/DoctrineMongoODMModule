<?php

declare(strict_types=1);

namespace DoctrineMongoODMModule\Service;

use Doctrine\ODM\MongoDB\DocumentManager;
use DoctrineMongoODMModule\Options;
use Interop\Container\ContainerInterface;

use function assert;

/**
 * Factory creates a mongo document manager
 */
final class DocumentManagerFactory extends AbstractFactory
{
    /**
     * {@inheritDoc}
     *
     * @return DocumentManager
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $options = $this->getOptions($container, 'documentmanager');
        assert($options instanceof Options\DocumentManager);
        $connection   = $container->get($options->getConnection());
        $config       = $container->get($options->getConfiguration());
        $eventManager = $container->get($options->getEventManager());

        return DocumentManager::create($connection, $config, $eventManager);
    }

    /**
     * Get the class name of the options associated with this factory.
     */
    public function getOptionsClass(): string
    {
        return Options\DocumentManager::class;
    }
}
