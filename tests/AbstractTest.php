<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest;

use Doctrine\ODM\MongoDB\DocumentManager;
use Laminas\Mvc\Application;
use MongoDB\Driver\Exception\RuntimeException;
use MongoDB\Driver\WriteConcern;
use PHPUnit\Framework\TestCase;

abstract class AbstractTest extends TestCase
{
    protected mixed $application;

    protected mixed $serviceManager;

    protected function setUp(): void
    {
        $this->application    = Application::init(ServiceManagerFactory::getConfiguration());
        $this->serviceManager = $this->application->getServiceManager();
    }

    public function getDocumentManager(): DocumentManager
    {
        return $this->serviceManager->get('doctrine.documentmanager.odm_default');
    }

    protected function tearDown(): void
    {
        try {
            $connection   = $this->getDocumentManager()->getClient();
            $database     = $connection->selectDatabase('doctrineMongoODMModuleTest');
            $collections  = $database->listCollections();
            $writeConcern = new WriteConcern(1);     foreach ($collections as $collection) {
                $database->dropCollection($collection->getName(), ['writeConcern' => $writeConcern]);
            }
        } catch (RuntimeException) {
        }
    }
}
