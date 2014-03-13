<?php

namespace DoctrineMongoODMModuleTest\Service;

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
    private $configuration = array();

    private $connectionFactory = array();

    public function setup()
    {
        parent::setup();
        $this->serviceManager->setAllowOverride(true);
        $this->configuration     = $this->serviceManager->get('Configuration');
        $this->connectionFactory = new ConnectionFactory('odm_default');
    }

    public function testConnectionStringOverwritesOtherConnectionSettings()
    {
        $connectionString = 'mongodb://localhost:27017';
        $connectionConfig = array(
            'odm_default' => array(
                'server'           => 'unreachable',
                'port'             => '10000',
                'connectionString' => $connectionString,
                'user'             => 'test fails if used',
                'password'         => 'test fails if used',
            )
        );

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('Configuration', $this->configuration);

        $connection = $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($connectionString, $connection->getServer());
    }

    public function testConnectionStringShouldAllowMultipleHosts()
    {
        $unreachablePort  = 56000;
        $connectionString = "mongodb://localhost:$unreachablePort,localhost:27017";
        $connectionConfig = array(
            'odm_default' => array(
                'connectionString' => $connectionString,
            )
        );

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('Configuration', $this->configuration);

        $connection = $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($connectionString, $connection->getServer());
    }

    public function testConnectionStringShouldAllowUnixSockets()
    {
        $connectionString = 'mongodb:///tmp/mongodb-27017.sock';
        $connectionConfig = array(
            'odm_default' => array(
                'connectionString' => $connectionString,
            )
        );

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('Configuration', $this->configuration);

        $connection = $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($connectionString, $connection->getServer());
    }

    public function testDbNameShouldSetDefaultDB()
    {
        $dbName  = 'foo_db';
        $connectionConfig = array(
            'odm_default' => array(
                'dbname' => $dbName,
            )
        );

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
        $connectionConfig = array(
            'odm_default' => array(
                'dbname' => 'test fails if this is defaultDB',
            )
        );

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
        $connectionConfig = array(
            'odm_default' => array(
                'connectionString' => $connectionString,
            )
        );

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
        $connectionString = "mongodb://localhost:27017/$dbName?bar=baz";
        $connectionConfig = array(
            'odm_default' => array(
                'connectionString' => $connectionString,
            )
        );

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('Configuration', $this->configuration);

        $configuration = $this->serviceManager->get('doctrine.configuration.odm_default');
        $configuration->setDefaultDB(null);
        $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($dbName, $configuration->getDefaultDB());
    }
}
