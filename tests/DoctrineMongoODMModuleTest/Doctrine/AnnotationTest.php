<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModuleTest\AbstractTest;

class AnnotationTest extends AbstractTest
{
    public function testAnnotation() : void
    {
        $documentManager = $this->getDocumentManager();
        $metadata        = $documentManager->getClassMetadata('DoctrineMongoODMModuleTest\Assets\Document\Annotation');
    }
}
