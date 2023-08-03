<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest;

use Laminas\ModuleManager\ModuleManager;
use Laminas\Mvc\Service\ServiceManagerConfig;
use Laminas\ServiceManager\ServiceManager;

use function assert;

/**
 * Utility used to retrieve a freshly bootstrapped application's service manager
 *
 * @link    http://www.doctrine-project.org/
 */
class ServiceManagerFactory
{
    /** @return mixed[] */
    public static function getConfiguration(): array
    {
        return include __DIR__ . '/TestConfiguration.php';
    }

    /**
     * Builds a new service manager
     *
     * @param  mixed[]|null $configuration
     */
    public static function getServiceManager(array|null $configuration = null): ServiceManager
    {
        $configuration        = $configuration ?: static::getConfiguration();
        $serviceManager       = new ServiceManager();
        $serviceManagerConfig = new ServiceManagerConfig(
            $configuration['service_manager'] ?? [],
        );
        $serviceManagerConfig->configureServiceManager($serviceManager);
        $serviceManager->setService('ApplicationConfig', $configuration);

        $moduleManager = $serviceManager->get('ModuleManager');
        assert($moduleManager instanceof ModuleManager);
        $moduleManager->loadModules();

        return $serviceManager;
    }
}
