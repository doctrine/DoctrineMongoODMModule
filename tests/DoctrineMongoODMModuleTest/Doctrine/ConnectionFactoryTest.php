<?php
namespace DoctrineMongoODMModuleTest\Service;

use DoctrineModule\Service\EventManagerFactory;
use DoctrineMongoODMModule\Service\ConnectionFactory;
use DoctrineMongoODMModuleTest\AbstractTest;

/**
 * Class ConnectionFactoryTest
 *
 * @author  Hennadiy Verkh <hv@verkh.de>
 * @covers  \DoctrineMongoODMModule\Service\ConnectionFactory
 */
class ConnectionFactoryTest extends AbstractTest
{
    private $configuration = [];

    private $connectionFactory = [];

    public function setup()
    {
        parent::setup();
        $this->serviceManager->setAllowOverride(true);
        $this->configuration     = $this->serviceManager->get('Configuration');
        $this->connectionFactory = new ConnectionFactory('odm_default');
    }

    public function testConnectionStringOverwritesOtherConnectionSettings()
    {
	$mongoHost = getenv('MONGO_HOST') ?: 'localhost';
	$mongoPort = getenv('MONGO_PORT') ?? '27017';
        $connectionString = 'mongodb://' . $mongoHost . ':' . $mongoPort;
        $connectionConfig = [
            'odm_default' => [
                'server'           => 'unreachable',
                'port'             => '10000',
                'connectionString' => $connectionString,
                'user'             => 'test fails if used',
                'password'         => 'test fails if used',
            ]
        ];

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('Configuration', $this->configuration);

        $connection = $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($connectionString, $connection->getServer());
    }

    public function testConnectionStringShouldAllowMultipleHosts()
    {
        $unreachablePort  = 56000;
        $connectionString = "mongodb://localhost:$unreachablePort,localhost:27017";
        $connectionConfig = [
            'odm_default' => [
                'connectionString' => $connectionString,
            ]
        ];

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('Configuration', $this->configuration);

        $connection = $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($connectionString, $connection->getServer());
    }

    public function testConnectionStringShouldAllowUnixSockets()
    {
        $connectionString = 'mongodb:///tmp/mongodb-27017.sock';
        $connectionConfig = [
            'odm_default' => [
                'connectionString' => $connectionString,
            ]
        ];

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('Configuration', $this->configuration);

        $connection = $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($connectionString, $connection->getServer());
    }

    public function testDbNameShouldSetDefaultDB()
    {
        $dbName  = 'foo_db';
        $connectionConfig = [
            'odm_default' => [
                'dbname' => $dbName,
            ]
        ];

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('Configuration', $this->configuration);

        $configuration = $this->serviceManager->get('doctrine.configuration.odm_default');
        $configuration->setDefaultDB(null);
        $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($dbName, $configuration->getDefaultDB());
    }

    public function testDbNameShouldNotOverrideExplicitDefaultDB()
    {
        $defaultDB  = 'foo_db';
        $connectionConfig = [
            'odm_default' => [
                'dbname' => 'test fails if this is defaultDB',
            ]
        ];

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('Configuration', $this->configuration);

        $configuration = $this->serviceManager->get('doctrine.configuration.odm_default');
        $configuration->setDefaultDB($defaultDB);
        $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($defaultDB, $configuration->getDefaultDB());
    }

    public function testConnectionStringShouldSetDefaultDB()
    {
        $dbName  = 'foo_db';
        $connectionString = "mongodb://localhost:27017/$dbName";
        $connectionConfig = [
            'odm_default' => [
                'connectionString' => $connectionString,
            ]
        ];

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('Configuration', $this->configuration);

        $configuration = $this->serviceManager->get('doctrine.configuration.odm_default');
        $configuration->setDefaultDB(null);
        $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($dbName, $configuration->getDefaultDB());
    }

    public function testConnectionStringWithOptionsShouldSetDefaultDB()
    {
        $dbName  = 'foo_db';
        $connectionString = "mongodb://localhost:27017/$dbName";
        $connectionConfig = [
            'odm_default' => [
                'connectionString' => $connectionString,
            ]
        ];

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('Configuration', $this->configuration);

        $configuration = $this->serviceManager->get('doctrine.configuration.odm_default');
        $configuration->setDefaultDB(null);
        $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($dbName, $configuration->getDefaultDB());
    }

    public function testShouldSetEventManager()
    {
        $eventManagerConfig = [
            'odm_default' => [
                'subscribers' => [
                ],
            ]
        ];

        $this->configuration['doctrine']['eventmanager'] = $eventManagerConfig;
        $this->serviceManager->setService('Configuration', $this->configuration);

        $eventManagerFactory = new EventManagerFactory('odm_default');
        $eventManager = $eventManagerFactory->createService($this->serviceManager);
        $this->serviceManager->setService('doctrine.eventmanager.odm_default', $eventManager);

        $connection = $this->connectionFactory->createService($this->serviceManager);

        self::assertSame($eventManager, $connection->getEventManager());
    }
}
