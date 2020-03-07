<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Doctrine;

use Doctrine\ODM\MongoDB\DocumentManager;
use DoctrineMongoODMModuleTest\AbstractTest;

final class DocumentManagerTest extends AbstractTest
{
    public function testDocumentManager() : void
    {
        $documentManager = $this->getDocumentManager();

        self::assertInstanceOf(DocumentManager::class, $documentManager);
    }
}
