<?php

namespace DoctrineMongoODMModule\Service;

use DoctrineModule\Service\ConfigurationFactory as DoctrineConfigurationFactory;
use Zend\ServiceManager\ServiceLocatorInterface;

class ConfigurationFactory extends DoctrineConfigurationFactory
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var $options \DoctrineORMModule\Options\Configuration */
        $options = $this->getOptions($serviceLocator);
        $config  = new \Doctrine\ODM\MongoDB\Configuration;

        $config->setAutoGenerateProxyClasses($options->getGenerateProxies());
        $config->setProxyDir($options->getProxyDir());
        $config->setProxyNamespace($options->getProxyNamespace());

        $config->setHydratorDir($options->getHydratorDir());
        $config->setHydratorNamespace($options->getHydratorNamespace());

        $config->setDocumentNamespaces($options->getDocumentNamespaces());
        $config->setMetadataDriverImpl($serviceLocator->get($options->getDriver()));

        return $config;
    }

    protected function getOptionsClass()
    {
        return 'DoctrineMongoODMModule\Options\Configuration';
    }
}