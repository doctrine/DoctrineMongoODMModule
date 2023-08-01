<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Assets\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
class Simple
{
    /** @ODM\Id(strategy="UUID") */
    protected mixed $id;

    /** @ODM\Field(type="string") */
    protected mixed $name;

    public function getId(): mixed
    {
        return $this->id;
    }

    public function getName(): mixed
    {
        return $this->name;
    }

    public function setName(mixed $name): void
    {
        $this->name = (string) $name;
    }
}
