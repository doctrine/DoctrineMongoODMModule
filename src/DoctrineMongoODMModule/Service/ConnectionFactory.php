<?php

declare(strict_types=1);

namespace DoctrineMongoODMModule\Service;

use Doctrine\Common\EventManager;
use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\Configuration;
use DoctrineMongoODMModule\Options;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use function assert;
use function strpos;
use function substr;
use const PHP_INT_MAX;

/**
 * Factory creates a mongo connection
 *
 * @link    http://www.doctrine-project.org/
 */
class ConnectionFactory extends AbstractFactory
{
    /**
     * {@inheritDoc}
     *
     * @return Connection
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $options = $this->getOptions($container, 'connection');
        assert($options instanceof Options\Connection);

        $connectionString = $options->getConnectionString();
        $dbName           = null;

        if (empty($connectionString)) {
            $connectionString = 'mongodb://';

            $user     = $options->getUser();
            $password = $options->getPassword();
            $dbName   = $options->getDbName();

            if ($user && $password) {
                $connectionString .= $user . ':' . $password . '@';
            }

            $connectionString .= $options->getServer() . ':' . $options->getPort();

            if ($dbName) {
                $connectionString .= '/' . $dbName;
            }
        } else {
            // parse dbName from the connectionString
            $dbStart = strpos($connectionString, '/', 11);
            if ($dbStart !== false) {
                $dbEnd  = strpos($connectionString, '?');
                $dbName = substr(
                    $connectionString,
                    $dbStart + 1,
                    $dbEnd ? ($dbEnd - $dbStart - 1) : PHP_INT_MAX
                );
            }
        }

        $configuration = $container->get('doctrine.configuration.' . $this->getName());
        assert($configuration instanceof Configuration);

        // Set defaultDB to $dbName, if it's not defined in configuration
        if ($configuration->getDefaultDB() === null) {
            $configuration->setDefaultDB($dbName);
        }

        $eventManager = $container->get('doctrine.eventmanager.' . $this->getName());
        assert($eventManager instanceof EventManager);

        return new Connection($connectionString, $options->getOptions(), $configuration, $eventManager,$options->getDriverOptions());
    }

    /**
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $container)
    {
        return $this($container, Connection::class);
    }

    /**
     * Get the class name of the options associated with this factory.
     */
    public function getOptionsClass() : string
    {
        return Options\Connection::class;
    }
}
