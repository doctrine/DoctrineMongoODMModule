<?php
namespace DoctrineMongoODMModule\Service;

use Doctrine\MongoDB\Connection;
use DoctrineMongoODMModule\Options;
use DoctrineModule\Service\AbstractFactory;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory creates a mongo connection
 *
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @since   0.1.0
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class ConnectionFactory extends AbstractFactory
{
    /**
     * {@inheritDoc}
     *
     * @return Connection
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var $options Options\Connection */
        $options = $this->getOptions($container, 'connection');

        $connectionString = $options->getConnectionString();
        $dbName = null;

        if (empty($connectionString)) {
            $connectionString = 'mongodb://' . $options->getServer() . ':' . $options->getPort();

            $dbName = $options->getDbName();

            if ($dbName) {
                $connectionString .= '/' . $dbName;
            }
        } else {
            // parse dbName from the connectionString
            $dbStart = strpos($connectionString, '/', 11);
            if (false !== $dbStart) {
                $dbEnd = strpos($connectionString, '?');
                $dbName = substr(
                    $connectionString,
                    $dbStart + 1,
                    $dbEnd ? ($dbEnd - $dbStart - 1) : PHP_INT_MAX
                );
            }
        }

        /** @var $configuration \Doctrine\ODM\MongoDB\Configuration */
        $configuration = $container->get('doctrine.configuration.' . $this->getName());

        // Set defaultDB to $dbName, if it's not defined in configuration
        if (null === $configuration->getDefaultDB()) {
            $configuration->setDefaultDB($dbName);
        }

        /** @var $configuration \Doctrine\Common\EventManager */
        $eventManager = $container->get('doctrine.eventmanager.' . $this->getName());

        return new Connection($connectionString, $options->getOptions(), $configuration, $eventManager);
    }

    public function createService(ServiceLocatorInterface $container)
    {
        return $this($container, Connection::class);
    }

    /**
     * Get the class name of the options associated with this factory.
     *
     * @return string
     */
    public function getOptionsClass()
    {
        return Options\Connection::class;
    }
}
