<?php

namespace DoctrineMongoODMModuleTest\Assets\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
class Annotation {

    /**
     * @ODM\Id(strategy="UUID")
     * @DoctrineMongoODMModuleTest\Assets\ExtraAnnotation
     */
    protected $id;

    /**
     * @ODM\Field(type="string")
     */
    protected $name;

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = (string) $name;
    }
}
