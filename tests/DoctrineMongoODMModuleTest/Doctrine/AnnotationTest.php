<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModuleTest\AbstractTest;

class AnnotationTest extends AbstractTest
{
    public function testAnnotation() : void
    {
        self::markTestIncomplete();
        $documentManager = $this->getDocumentManager();
        $metadata        = $documentManager->getClassMetadata('DoctrineMongoODMModuleTest\Assets\Document\Annotation');
    }
}
