<?php
namespace DoctrineMongoODMModuleTest;

use PHPUnit\Framework\TestCase;
use Zend\Mvc\Application;

abstract class AbstractTest extends TestCase
{
    protected $application;
    protected $serviceManager;

    public function setUp()
    {
        $this->application = Application::init(ServiceManagerFactory::getConfiguration());
        $this->serviceManager = $this->application->getServiceManager();
    }

    public function getDocumentManager()
    {
        return $this->serviceManager->get('doctrine.documentmanager.odm_default');
    }

    public function tearDown()
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
