<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Assets\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
class Annotation
{
    /**
     * @ODM\Id(strategy="UUID")
     *
     * @DoctrineMongoODMModuleTest\Assets\ExtraAnnotation
     *
     * @var mixed $id
     */
    protected $id;

    /**
     * @ODM\Field(type="string")
     *
     * @var mixed $name
     */
    protected $name;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = (string) $name;
    }
}
