<?php
namespace DoctrineMongoODMModule\Service;

use Doctrine\ODM\MongoDB\DocumentManager;
use DoctrineModule\Service\AbstractFactory;
use DoctrineMongoODMModule\Options;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory creates a mongo document manager
 *
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @since   0.1.0
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class DocumentManagerFactory extends AbstractFactory
{
    /**
     * {@inheritDoc}
     *
     * @return DocumentManager
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $options      = $this->getOptions($container, 'documentmanager');
        $connection   = $container->get($options->getConnection());
        $config       = $container->get($options->getConfiguration());
        $eventManager = $container->get($options->getEventManager());
        return DocumentManager::create($connection, $config, $eventManager);
    }

    public function createService(ServiceLocatorInterface $container)
    {
        return $this($container, DocumentManager::class);
    }

    /**
     * Get the class name of the options associated with this factory.
     *
     * @return string
     */
    public function getOptionsClass()
    {
        return Options\DocumentManager::class;
    }
}
