<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest;

use Doctrine\ODM\MongoDB\DocumentManager;
use Laminas\Mvc\Application;
use MongoDB\Driver\Exception\RuntimeException;
use MongoDB\Driver\WriteConcern;
use PHPUnit\Framework\TestCase;

// phpcs:disable SlevomatCodingStandard.Classes.SuperfluousAbstractClassNaming
abstract class AbstractTest extends TestCase
{
// phpcs:enable SlevomatCodingStandard.Classes.SuperfluousAbstractClassNaming

    /** @var mixed $application */
    protected $application;

    /** @var mixed $serviceManager */
    protected $serviceManager;

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
        } catch (RuntimeException $e) {
        }
    }
}
