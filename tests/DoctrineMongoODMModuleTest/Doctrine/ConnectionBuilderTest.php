<?php

namespace DoctrineMongoODMModuleTest\Service;

use DoctrineMongoODMModule\Builder\ConnectionBuilder;
use DoctrineMongoODMModule\Options\ConnectionOptions;
use DoctrineMongoODMModuleTest\AbstractTest;

/**
 * Class ConnectionFactoryTest
 *
 * @author  Hennadiy Verkh <hv@verkh.de>
 * @covers  \DoctrineMongoODMModule\Builder\ConnectionBuilder
 */
class ConnectionBuilderTest extends AbstractTest
{
    public function testConnectionStringOverwritesOtherConnectionSettings()
    {
        $connectionString = 'mongodb://localhost:27017';
        $connectionOptions = new ConnectionOptions(
            array(
                'connection_string' => $connectionString,
                'server'           => 'unreachable',
                'port'             => '10000',
                'user'             => 'test fails if used',
                'password'         => 'test fails if used'
            )
        );

        $builder = new ConnectionBuilder;
        $connection = $builder->build($connectionOptions);

        $this->assertEquals($connectionString, $connection->getServer());
    }

    public function testConnectionStringShouldAllowMultipleHosts()
    {
        $unreachablePort  = 56000;
        $connectionString = "mongodb://localhost:$unreachablePort,localhost:27017";
        $connectionOptions = new ConnectionOptions(
            array(
                'connection_string' => $connectionString,
            )
        );

        $builder = new ConnectionBuilder;
        $connection = $builder->build($connectionOptions);

        $this->assertEquals($connectionString, $connection->getServer());
    }

    public function testConnectionStringShouldAllowUnixSockets()
    {
        $connectionString = 'mongodb:///tmp/mongodb-27017.sock';
        $connectionOptions = new ConnectionOptions(
            array(
                'connection_string' => $connectionString,
            )
        );

        $builder = new ConnectionBuilder;
        $connection = $builder->build($connectionOptions);

        $this->assertEquals($connectionString, $connection->getServer());
    }
}
