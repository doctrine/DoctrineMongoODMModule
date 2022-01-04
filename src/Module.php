<?php

declare(strict_types=1);

namespace DoctrineMongoODMModule;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Tools\Console\Command;
use Doctrine\ODM\MongoDB\Tools\Console\Helper\DocumentManagerHelper;
use DoctrineModule\Service as CommonService;
use DoctrineMongoODMModule\Service as ODMService;
use InvalidArgumentException;
use Laminas\EventManager\EventInterface;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ModuleManager\Feature\InitProviderInterface;
use Laminas\ModuleManager\Feature\ServiceProviderInterface;
use Laminas\ModuleManager\ModuleManager;
use Laminas\ModuleManager\ModuleManagerInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputOption;

use function get_class;
use function sprintf;

/**
 * Doctrine Module provider for Mongo DB ODM.
 */
final class Module implements InitProviderInterface, ConfigProviderInterface, ServiceProviderInterface
{
    public function init(ModuleManagerInterface $manager): void
    {
        if (! $manager instanceof ModuleManager) {
            throw new InvalidArgumentException(sprintf(
                'Expected %s, but received %s.',
                ModuleManager::class,
                get_class($manager)
            ));
        }

        $events = $manager->getEventManager();
        // Initialize logger collector once the profiler is initialized itself
        $events->attach('profiler_init', static function (EventInterface $e) use ($manager): void {
            $manager->getEvent()->getParam('ServiceManager')->get('doctrine.mongo_logger_collector.odm_default');
        });
        $events->getSharedManager()->attach('doctrine', 'loadCli.post', [$this, 'loadCli']);
    }

    public function loadCli(EventInterface $event): void
    {
        $commands = [
            new Command\QueryCommand(),
            new Command\GenerateProxiesCommand(),
            new Command\GenerateHydratorsCommand(),
            new Command\GeneratePersistentCollectionsCommand(),
            new Command\ClearCache\MetadataCommand(),
            new Command\Schema\CreateCommand(),
            new Command\Schema\UpdateCommand(),
            new Command\Schema\DropCommand(),
        ];

        foreach ($commands as $command) {
            $command->getDefinition()->addOption(
                new InputOption(
                    'documentmanager',
                    null,
                    InputOption::VALUE_OPTIONAL,
                    'The name of the documentmanager to use. If none is provided, it will use odm_default.'
                )
            );
        }

        $cli = $event->getTarget();
        if (! $cli instanceof Application) {
            throw new InvalidArgumentException(sprintf(
                'Expected %s as event target, received %s.',
                Application::class,
                get_class($cli)
            ));
        }

        $cli->addCommands($commands);

        $arguments           = new ArgvInput();
        $documentManagerName = $arguments->getParameterOption('--documentmanager');
        $documentManagerName = ! empty($documentManagerName) ? $documentManagerName : 'odm_default';

        $documentManager = $event->getParam('ServiceManager')->get('doctrine.documentmanager.' . $documentManagerName);
        $documentHelper  = new DocumentManagerHelper($documentManager);
        $cli->getHelperSet()->set($documentHelper, 'dm');
    }

    /**
     * @return array<array-key,mixed>
     */
    public function getConfig(): array
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * @return array<array-key,mixed>
     */
    public function getServiceConfig(): array
    {
        return [
            'invokables' => [
                Logging\DebugStack::class  => Logging\DebugStack::class,
                Logging\EchoLogger::class  => Logging\EchoLogger::class,
            ],
            'aliases' => [DocumentManager::class => 'doctrine.documentmanager.odm_default'],
            'factories' => [
                // @codingStandardsIgnoreStart
                'doctrine.authenticationadapter.odm_default'  => new CommonService\Authentication\AdapterFactory('odm_default'),
                'doctrine.authenticationstorage.odm_default'  => new CommonService\Authentication\StorageFactory('odm_default'),
                'doctrine.authenticationservice.odm_default'  => new CommonService\Authentication\AuthenticationServiceFactory('odm_default'),
                'doctrine.connection.odm_default'      => new ODMService\ConnectionFactory('odm_default'),
                'doctrine.configuration.odm_default'   => new ODMService\ConfigurationFactory('odm_default'),
                'doctrine.driver.odm_default'          => new CommonService\DriverFactory('odm_default'),
                'doctrine.documentmanager.odm_default' => new ODMService\DocumentManagerFactory('odm_default'),
                'doctrine.eventmanager.odm_default'    => new CommonService\EventManagerFactory('odm_default'),
                'doctrine.mongo_logger_collector.odm_default' => new ODMService\MongoLoggerCollectorFactory('odm_default'),
                // @codingStandardsIgnoreEnd
            ],
        ];
    }
}
