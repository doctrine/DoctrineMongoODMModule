<?php

namespace DoctrineMongoODMModuleTest\Doctrine;

use Doctrine\ODM\MongoDB\Configuration;
use PHPUnit_Framework_TestCase;

class ConfigurationTest extends PHPUnit_Framework_TestCase
{
    public function testDefaultRetryConnectIsZero()
    {
        $this->assertSame(0, $this->configuration->getRetryConnect());
    }

    public function testDefaultRetryQueryIsZero()
    {
        $this->assertSame(0, $this->configuration->getRetryQuery());
    }

    public function testSettingRetryConnectValue()
    {
        $this->configuration->setRetryConnect(111);
        $this->assertSame(111, $this->configuration->getRetryConnect());
    }

    public function testSettingRetryQueryValue()
    {
        $this->configuration->setRetryQuery(222);
        $this->assertSame(222, $this->configuration->getRetryQuery());
    }

    public function setUp()
    {
        $this->configuration = new Configuration();
    }

    protected $configuration = null;
}
