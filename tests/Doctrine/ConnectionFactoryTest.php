<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Doctrine;

use Doctrine\ODM\MongoDB\Configuration;
use DoctrineMongoODMModule\Service\ConnectionFactory;
use DoctrineMongoODMModuleTest\AbstractTest;
use MongoDB\Client;

/**
 * @covers  \DoctrineMongoODMModule\Service\ConnectionFactory
 */
class ConnectionFactoryTest extends AbstractTest
{
    /** @var mixed[] $configuration */
    private array $configuration;

    private ConnectionFactory $connectionFactory;

    protected function setUp(): void
    {
        parent::setup();
        $this->serviceManager->setAllowOverride(true);
        $this->serviceManager->setService('doctrine.configuration.odm_default', null);
        $this->serviceManager->setService('doctrine.connection.odm_default', null);
        $this->configuration     = $this->serviceManager->get('config');
        $this->connectionFactory = new ConnectionFactory('odm_default');
    }

    public function testConnectionStringOverwritesOtherConnectionSettings(): void
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

        $connection = ($this->connectionFactory)($this->serviceManager, Client::class);

        $this->assertEquals($connectionString, (string) $connection);
    }

    public function testConnectionStringShouldAllowMultipleHosts(): void
    {
        $unreachablePort  = 56000;
        $connectionString = 'mongodb://localhost:' . $unreachablePort . ',localhost:27017';
        $connectionConfig = [
            'odm_default' => ['connectionString' => $connectionString],
        ];

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('config', $this->configuration);

        $connection = ($this->connectionFactory)($this->serviceManager, Client::class);

        $this->assertEquals($connectionString, (string) $connection);
    }

    public function testConnectionStringShouldAllowUnixSockets(): void
    {
        $connectionString = 'mongodb://%2Ftmp%2Fmongodb-27017.sock';
        $connectionConfig = [
            'odm_default' => ['connectionString' => $connectionString],
        ];

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('config', $this->configuration);

        $connection = ($this->connectionFactory)($this->serviceManager, Client::class);

        $this->assertEquals($connectionString, (string) $connection);
    }

    public function testDbNameShouldSetDefaultDB(): void
    {
        $dbName              = 'foo_db';
        $connectionConfig    = [
            'odm_default' => ['dbname' => $dbName],
        ];
        $configurationConfig = ['odm_default' => ['default_db' => null, 'driver' => 'odm_default']];

        $this->configuration['doctrine']['connection']    = $connectionConfig;
        $this->configuration['doctrine']['configuration'] = $configurationConfig;
        $this->serviceManager->setService('config', $this->configuration);

        ($this->connectionFactory)($this->serviceManager, Client::class);
        $configuration = $this->getConfiguration();

        $this->assertEquals($dbName, $configuration->getDefaultDB());
    }

    public function testDbNameShouldNotOverrideExplicitDefaultDB(): void
    {
        $defaultDB        = 'foo_db';
        $connectionConfig = [
            'odm_default' => ['dbname' => 'test-fails-if-this-is-defaultDB'],
        ];

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('config', $this->configuration);

        $configuration = $this->getConfiguration();
        $configuration->setDefaultDB($defaultDB);
        ($this->connectionFactory)($this->serviceManager, Client::class);

        $this->assertEquals($defaultDB, $configuration->getDefaultDB());
    }

    public function testConnectionStringShouldSetDefaultDB(): void
    {
        $dbName              = 'foo_db';
        $connectionString    = 'mongodb://localhost:27017/' . $dbName;
        $connectionConfig    = [
            'odm_default' => ['connectionString' => $connectionString],
        ];
        $configurationConfig = ['odm_default' => ['default_db' => null, 'driver' => 'odm_default']];

        $this->configuration['doctrine']['connection']    = $connectionConfig;
        $this->configuration['doctrine']['configuration'] = $configurationConfig;
        $this->serviceManager->setService('config', $this->configuration);

        $configuration = $this->getConfiguration();
        ($this->connectionFactory)($this->serviceManager, Client::class);

        $this->assertEquals($dbName, $configuration->getDefaultDB());
    }

    public function testConnectionStringWithOptionsShouldSetDefaultDB(): void
    {
        $dbName              = 'foo_db';
        $connectionString    = 'mongodb://localhost:27017/' . $dbName;
        $connectionConfig    = [
            'odm_default' => ['connectionString' => $connectionString],
        ];
        $configurationConfig = ['odm_default' => ['default_db' => null, 'driver' => 'odm_default']];

        $this->configuration['doctrine']['connection']    = $connectionConfig;
        $this->configuration['doctrine']['configuration'] = $configurationConfig;
        $this->serviceManager->setService('config', $this->configuration);

        $configuration = $this->getConfiguration();
        ($this->connectionFactory)($this->serviceManager, Client::class);

        $this->assertEquals($dbName, $configuration->getDefaultDB());
    }

    private function getConfiguration(): Configuration
    {
        return $this->serviceManager->get('doctrine.configuration.odm_default');
    }
}
