<?php

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModuleTest\BaseTest;

class AnnotationTest extends BaseTest
{
    protected function alterConfig(array $config) {
        $config['doctrine']['driver']['test'] = array(
            'class' => 'Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver',
            'cache' => 'array',
            'paths' => array(
                __DIR__ . '/../Assets/Document'
            )
        );
        $config['doctrine']['driver']['odm_default']['drivers']['DoctrineMongoODMModuleTest\Assets\Document'] = 'test';
        $config['doctrine']['configuration']['odm_default']['default_db'] = self::DEFAULT_DB;
        return $config;
    }

    public function testPersist(){

        $documentManager = $this->getDocumentManager();
        $metadata = $documentManager->getClassMetadata('DoctrineMongoODMModuleTest\Assets\Document\Annotation');

    }
}
