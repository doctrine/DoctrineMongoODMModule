<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Doctrine;

use Doctrine\ODM\MongoDB\DocumentManager;
use DoctrineMongoODMModuleTest\AbstractTest;

final class DocumentManagerTest extends AbstractTest
{
    /** @var mixed[] $configuration */
    private array $configuration = [];

    protected function setUp(): void
    {
        parent::setup();
        $this->serviceManager->setAllowOverride(true);
        $this->configuration = $this->serviceManager->get('config');
        $this->serviceManager->setService('doctrine.configuration.odm_default', null);
        $this->serviceManager->setService('doctrine.connection.odm_default', null);
        $this->serviceManager->setService('doctrine.documentmanager.odm_default', null);
        $this->serviceManager->setService('doctrine.eventmanager.odm_default', null);
    }

    public function testDocumentManager(): void
    {
        $documentManager = $this->getDocumentManager();

        $this->assertInstanceOf(DocumentManager::class, $documentManager);
    }

    public function testShouldSetEventManager(): void
    {
        $eventManagerConfig = [
            'odm_default' => [
                'subscribers' => [],
            ],
        ];

        $this->configuration['doctrine']['eventmanager'] = $eventManagerConfig;
        $this->serviceManager->setService('config', $this->configuration);
        $eventManager    = $this->serviceManager->get('doctrine.eventmanager.odm_default');
        $documentManager = $this->getDocumentManager();

        $this->assertSame($eventManager, $documentManager->getEventManager());
    }
}
