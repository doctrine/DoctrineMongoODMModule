<?php
namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModule\Options\Configuration;
use PHPUnit\Framework\TestCase;

final class ConfigurationTest extends TestCase
{
    /** @var Configuration */
    private $configuration;

    protected function setUp()
    {
        $this->configuration = new Configuration;
    }

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
}
