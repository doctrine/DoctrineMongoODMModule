<?php

declare(strict_types=1);

namespace DoctrineMongoODMModule\Service;

use Doctrine\Common\EventManager;
use Doctrine\ODM\MongoDB\Configuration;
use DoctrineMongoODMModule\Options;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use MongoDB\Client;

use function assert;
use function strpos;
use function substr;

use const PHP_INT_MAX;

/**
 * Factory creates a mongo connection
 */
final class ConnectionFactory extends AbstractFactory
{
    /**
     * {@inheritDoc}
     *
     * @return Client
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $connectionOptions = $this->getOptions($container, 'connection');
        assert($connectionOptions instanceof Options\Connection);

        $connectionString = $connectionOptions->getConnectionString();
        $dbName           = null;

        if (empty($connectionString)) {
            $connectionString = 'mongodb://';

            $user     = $connectionOptions->getUser();
            $password = $connectionOptions->getPassword();
            $dbName   = $connectionOptions->getDbName();

            if ($user && $password) {
                $connectionString .= $user . ':' . $password . '@';
            }

            $connectionString .= $connectionOptions->getServer() . ':' . $connectionOptions->getPort();

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
        if ($configuration->getDefaultDB() === null && $dbName !== null) {
            $configuration->setDefaultDB($dbName);
        }

        $eventManager = $container->get('doctrine.eventmanager.' . $this->getName());
        assert($eventManager instanceof EventManager);

        $driverOptions            = $connectionOptions->getDriverOptions();
        $driverOptions['typeMap'] = ['root' => 'array', 'document' => 'array'];

        return new Client($connectionString, $connectionOptions->getOptions(), $driverOptions);
    }

    /**
     * @deprecated 3.1.0 With laminas-servicemanager v3 this method is obsolete and will be removed in 4.0.0.
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $container)
    {
        return $this($container, Client::class);
    }

    /**
     * Get the class name of the options associated with this factory.
     */
    public function getOptionsClass(): string
    {
        return Options\Connection::class;
    }
}
