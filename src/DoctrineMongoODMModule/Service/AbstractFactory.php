<?php

namespace DoctrineMongoODMModule\Service;

use DoctrineModule\Service\AbstractFactory as DoctrineModuleAbstractFactory;
use Interop\Container\ContainerInterface;
use RuntimeException;

abstract class AbstractFactory extends DoctrineModuleAbstractFactory
{
    public function getOptions(ContainerInterface $container, $key, $name = null)
    {
        if ($name === null) {
            $name = $this->getName();
        }

        $options = $container->get('config');
        $options = $options['doctrine'];
        if ($mappingType = $this->getMappingType()) {
            $options = $options[$mappingType];
        }
        $options = isset($options[$key][$name]) ? $options[$key][$name] : null;

        if (null === $options) {
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
