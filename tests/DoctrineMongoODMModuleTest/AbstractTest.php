<?php
namespace DoctrineMongoODMModuleTest;

use Laminas\Mvc\Application;
use PHPUnit\Framework\TestCase;

abstract class AbstractTest extends TestCase
{
    protected $application;
    protected $serviceManager;

    protected function setUp() : void
    {
        $this->application = Application::init(ServiceManagerFactory::getConfiguration());
        $this->serviceManager = $this->application->getServiceManager();
    }

    public function getDocumentManager()
    {
        return $this->serviceManager->get('doctrine.documentmanager.odm_default');
    }

    protected function tearDown() : void
    {
        try {
            $connection = $this->getDocumentManager()->getConnection();
            $collections = $connection->selectDatabase('doctrineMongoODMModuleTest')->listCollections();
            foreach ($collections as $collection) {
                $collection->remove([], ['w' => 1]);
            }
        } catch (\MongoException $e) {
        }
    }
}
