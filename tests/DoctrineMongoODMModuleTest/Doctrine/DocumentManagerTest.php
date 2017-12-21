<?php
namespace DoctrineMongoODMModuleTest\Doctrine;

use Doctrine\ODM\MongoDB\DocumentManager;
use DoctrineMongoODMModuleTest\AbstractTest;

final class DocumentManagerTest extends AbstractTest
{
    public function testDocumentManager()
    {
        $documentManager = $this->getDocumentManager();

        self::assertInstanceOf(DocumentManager::class, $documentManager);
    }
}
