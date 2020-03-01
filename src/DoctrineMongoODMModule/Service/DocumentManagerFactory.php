<?php

declare(strict_types=1);

namespace DoctrineMongoODMModule\Service;

use Doctrine\ODM\MongoDB\DocumentManager;
use DoctrineMongoODMModule\Options;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

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
        $options      = $this->getOptions($container, 'documentmanager');
        $connection   = $container->get($options->getConnection());
        $config       = $container->get($options->getConfiguration());
        $eventManager = $container->get($options->getEventManager());

        return DocumentManager::create($connection, $config, $eventManager);
    }

    /**
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $container)
    {
        return $this($container, DocumentManager::class);
    }

    /**
     * Get the class name of the options associated with this factory.
     */
    public function getOptionsClass() : string
    {
        return Options\DocumentManager::class;
    }
}
