<?php

namespace DoctrineMongoODMModuleTest\Service;

use DoctrineMongoODMModuleTest\AbstractTest;

class ConnectionFactoryTest extends AbstractTest
{
    private $configuration = array();

    private $connectionFactory = array();

    public function setup()
    {
        parent::setup();
        $this->serviceManager->setAllowOverride(true);
        $this->configuration     = $this->serviceManager->get('Configuration');
        $this->connectionFactory = new \DoctrineMongoODMModule\Service\ConnectionFactory('odm_default');
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
}
