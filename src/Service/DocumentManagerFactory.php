<?php

declare(strict_types=1);

namespace DoctrineMongoODMModule\Service;

use Doctrine\ODM\MongoDB\DocumentManager;
use DoctrineMongoODMModule\Options;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

use function assert;

/**
 * Factory creates a mongo document manager
 *
 * @link    http://www.doctrine-project.org/
 */
class DocumentManagerFactory extends AbstractFactory
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
     * @deprecated 3.1.0 With laminas-servicemanager v3 this method is obsolete and will be removed in 4.0.0.
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $container)
    {
        return $this($container, DocumentManager::class);
    }

    /**
     * Get the class name of the options associated with this factory.
     */
    public function getOptionsClass(): string
    {
        return Options\DocumentManager::class;
    }
}
