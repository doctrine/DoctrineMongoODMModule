<?php

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModuleTest\AbstractTest;

class AnnotationTest extends AbstractTest
{
    public function testAnnotation(){

        $documentManager = $this->getDocumentManager();
        $metadata = $documentManager->getClassMetadata('DoctrineMongoODMModuleTest\Assets\Document\Annotation');
    }
}
