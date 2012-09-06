<?php

namespace DoctrineMongoODMModuleTest\Doctrine;

use Doctrine\ODM\MongoDB\DocumentManager;
use DoctrineMongoODMModuleTest\AbstractTest;

class DocumentManagerTest extends AbstractTest{

    public function testDocumentManager(){

        $documentManager = $this->getDocumentManager();

        $this->assertTrue($documentManager instanceof DocumentManager);
    }
}
