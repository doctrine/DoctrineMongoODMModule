<?php

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModuleTest\AbstractTest;

class AnnotationTest extends AbstractTest
{
    public function testAnnotation()
    {
        $documentManager = $this->getDocumentManager();

        $this->assertInstanceOf(
            'Doctrine\Common\Persistence\Mapping\ClassMetadata',
            $documentManager->getClassMetadata('DoctrineMongoODMModuleTest\Assets\Document\Annotation')
        );
    }
}
