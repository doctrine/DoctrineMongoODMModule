<?php

namespace DoctrineMongoODMModuleTest\Doctrine;

use Doctrine\ODM\MongoDB\DocumentManager;
use DoctrineMongoODMModuleTest\BaseTest;

class DocumentManagerTest extends BaseTest{

    protected function alterConfig(array $config) {
        return $config;
    }

    public function testDocumentManager(){

        $documentManager = $this->getDocumentManager();

        $this->assertTrue($documentManager instanceof DocumentManager);
    }
}
