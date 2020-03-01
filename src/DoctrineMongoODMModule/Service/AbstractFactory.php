<?php

declare(strict_types=1);

namespace DoctrineMongoODMModule\Service;

use DoctrineModule\Service\AbstractFactory as DoctrineModuleAbstractFactory;
use Interop\Container\ContainerInterface;
use Laminas\Stdlib\AbstractOptions;
use RuntimeException;
use function sprintf;

// phpcs:disable SlevomatCodingStandard.Classes.SuperfluousAbstractClassNaming
abstract class AbstractFactory extends DoctrineModuleAbstractFactory
{
// phpcs:enable SlevomatCodingStandard.Classes.SuperfluousAbstractClassNaming
    public function getOptions(ContainerInterface $container, string $key, ?string $name = null) : AbstractOptions
    {
        if ($name === null) {
            $name = $this->getName();
        }

        $options     = $container->get('config');
        $options     = $options['doctrine'];
        $mappingType = $this->getMappingType()

        if ($mappingType) {
            $options = $options[$mappingType];
        }

        $options = $options[$key][$name] ?? null;

        if ($options === null) {
            throw new RuntimeException(
                sprintf(
                    'Options with name "%s" could not be found in "doctrine.%s".',
                    $name,
                    $key
                )
            );
        }

        $optionsClass = $this->getOptionsClass();

        return new $optionsClass($options);
    }
}
