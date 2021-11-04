<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Assets;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
final class ExtraAnnotation extends Annotation
{
}
