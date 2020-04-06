<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest;

use Laminas\Mvc\Application;
use MongoException;
use PHPUnit\Framework\TestCase;

// phpcs:disable SlevomatCodingStandard.Classes.SuperfluousAbstractClassNaming
abstract class AbstractTest extends TestCase
{
// phpcs:enable SlevomatCodingStandard.Classes.SuperfluousAbstractClassNaming

    /** @var mixed $application */
    protected $application;

    /** @var mixed $serviceManager */
    protected $serviceManager;

    protected function setUp() : void
    {
        $this->application    = Application::init(ServiceManagerFactory::getConfiguration());
        $this->serviceManager = $this->application->getServiceManager();
    }

    /**
     * @return mixed
     */
    public function getDocumentManager()
    {
        return $this->serviceManager->get('doctrine.documentmanager.odm_default');
    }

    protected function tearDown() : void
    {
        try {
            $connection  = $this->getDocumentManager()->getConnection();
            $collections = $connection->selectDatabase('doctrineMongoODMModuleTest')->listCollections();
            foreach ($collections as $collection) {
                $collection->remove([], ['w' => 1]);
            }
        } catch (MongoException $e) {
        }
    }
}
