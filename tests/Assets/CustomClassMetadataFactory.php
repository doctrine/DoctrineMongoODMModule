<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Assets;

use Doctrine\ODM\MongoDB\Mapping\ClassMetadataFactoryInterface;
use Doctrine\Persistence\Mapping\ClassMetadata;

/**
 * @method list<ClassMetadata> getAllMetadata()
 * @method ClassMetadata[] getLoadedMetadata()
 * @method ClassMetadata getMetadataFor($className)
 */
abstract class CustomClassMetadataFactory implements ClassMetadataFactoryInterface
{
}
