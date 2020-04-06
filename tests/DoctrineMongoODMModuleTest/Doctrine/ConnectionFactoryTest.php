<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Service;

use DoctrineModule\Service\EventManagerFactory;
use DoctrineMongoODMModule\Service\ConnectionFactory;
use DoctrineMongoODMModuleTest\AbstractTest;

/**
 * @covers  \DoctrineMongoODMModule\Service\ConnectionFactory
 */
class ConnectionFactoryTest extends AbstractTest
{
    /** @var mixed[] $configuration */
    private $configuration = [];

    /** @var mixed[] $connectionFactory */
    private $connectionFactory = [];

    protected function setUp() : void
    {
        parent::setup();
        $this->serviceManager->setAllowOverride(true);
        $this->configuration     = $this->serviceManager->get('config');
        $this->connectionFactory = new ConnectionFactory('odm_default');
    }

    public function testConnectionStringOverwritesOtherConnectionSettings() : void
    {
        $connectionString = 'mongodb://localhost:27017';
        $connectionConfig = [
            'odm_default' => [
                'server'           => 'unreachable',
                'port'             => '10000',
                'connectionString' => $connectionString,
                'user'             => 'test fails if used',
                'password'         => 'test fails if used',
            ],
        ];

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('config', $this->configuration);

        $connection = $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($connectionString, $connection->getServer());
    }

    public function testConnectionStringShouldAllowMultipleHosts() : void
    {
        $unreachablePort  = 56000;
        $connectionString = 'mongodb://localhost:' . $unreachablePort . ',localhost:27017';
        $connectionConfig = [
            'odm_default' => ['connectionString' => $connectionString],
        ];

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('config', $this->configuration);

        $connection = $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($connectionString, $connection->getServer());
    }

    public function testConnectionStringShouldAllowUnixSockets() : void
    {
        $connectionString = 'mongodb:///tmp/mongodb-27017.sock';
        $connectionConfig = [
            'odm_default' => ['connectionString' => $connectionString],
        ];

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('config', $this->configuration);

        $connection = $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($connectionString, $connection->getServer());
    }

    public function testDbNameShouldSetDefaultDB() : void
    {
        $dbName           = 'foo_db';
        $connectionConfig = [
            'odm_default' => ['dbname' => $dbName],
        ];

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('config', $this->configuration);

        $configuration = $this->serviceManager->get('doctrine.configuration.odm_default');
        $configuration->setDefaultDB(null);
        $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($dbName, $configuration->getDefaultDB());
    }

    public function testDbNameShouldNotOverrideExplicitDefaultDB() : void
    {
        $defaultDB        = 'foo_db';
        $connectionConfig = [
            'odm_default' => ['dbname' => 'test fails if this is defaultDB'],
        ];

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('config', $this->configuration);

        $configuration = $this->serviceManager->get('doctrine.configuration.odm_default');
        $configuration->setDefaultDB($defaultDB);
        $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($defaultDB, $configuration->getDefaultDB());
    }

    public function testConnectionStringShouldSetDefaultDB() : void
    {
        $dbName           = 'foo_db';
        $connectionString = 'mongodb://localhost:27017/' . $dbName;
        $connectionConfig = [
            'odm_default' => ['connectionString' => $connectionString],
        ];

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('config', $this->configuration);

        $configuration = $this->serviceManager->get('doctrine.configuration.odm_default');
        $configuration->setDefaultDB(null);
        $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($dbName, $configuration->getDefaultDB());
    }

    public function testConnectionStringWithOptionsShouldSetDefaultDB() : void
    {
        $dbName           = 'foo_db';
        $connectionString = 'mongodb://localhost:27017/' . $dbName;
        $connectionConfig = [
            'odm_default' => ['connectionString' => $connectionString],
        ];

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('config', $this->configuration);

        $configuration = $this->serviceManager->get('doctrine.configuration.odm_default');
        $configuration->setDefaultDB(null);
        $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($dbName, $configuration->getDefaultDB());
    }

    public function testShouldSetEventManager() : void
    {
        $eventManagerConfig = [
            'odm_default' => [
                'subscribers' => [],
            ],
        ];

        $this->configuration['doctrine']['eventmanager'] = $eventManagerConfig;
        $this->serviceManager->setService('config', $this->configuration);

        $eventManagerFactory = new EventManagerFactory('odm_default');
        $eventManager        = $eventManagerFactory->createService($this->serviceManager);
        $this->serviceManager->setService('doctrine.eventmanager.odm_default', $eventManager);

        $connection = $this->connectionFactory->createService($this->serviceManager);

        self::assertSame($eventManager, $connection->getEventManager());
    }
}
