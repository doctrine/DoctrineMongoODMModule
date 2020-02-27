<?php

namespace DoctrineMongoODMModule;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Tools\Console\Command;
use DoctrineModule\Service as CommonService;
use DoctrineMongoODMModule\Service as ODMService;
use Laminas\EventManager\EventInterface;
use Laminas\ModuleManager\ModuleManagerInterface;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputOption;

/**
 * Doctrine Module provider for Mongo DB ODM.
 *
 * @license MIT
 * @link    http://www.doctrine-project.org
 * @since   0.1.0
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class Module
{
    /**
     * {@inheritDoc}
     */
    public function init(ModuleManagerInterface $manager): void
    {
        $events = $manager->getEventManager();
        // Initialize logger collector once the profiler is initialized itself
        $events->attach('profiler_init', static function (EventInterface $e) use ($manager) {
            $manager->getEvent()->getParam('ServiceManager')->get('doctrine.mongo_logger_collector.odm_default');
        });
        $events->getSharedManager()->attach('doctrine', 'loadCli.post', [$this, 'loadCli']);
    }

    /**
     * @param EventInterface $event
     */
    public function loadCli(EventInterface $event): void
    {
        $commands = [
            new Command\QueryCommand(),
            new Command\GenerateDocumentsCommand(),
            new Command\GenerateRepositoriesCommand(),
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
        $cli->addCommands($commands);

        $arguments = new ArgvInput();
        $documentManagerName = $arguments->getParameterOption('--documentmanager');
        $documentManagerName = ! empty($documentManagerName) ? $documentManagerName : 'odm_default';

        $documentManager = $event->getParam('ServiceManager')->get('doctrine.documentmanager.' . $documentManagerName);
        $documentHelper  = new \Doctrine\ODM\MongoDB\Tools\Console\Helper\DocumentManagerHelper($documentManager);
        $cli->getHelperSet()->set($documentHelper, 'dm');
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig(): array
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * {@inheritDoc}
     */
    public function getServiceConfig(): array
    {
        return [
            'invokables' => [
                Logging\DebugStack::class  => Logging\DebugStack::class,
                Logging\LoggerChain::class => Logging\LoggerChain::class,
                Logging\EchoLogger::class  => Logging\EchoLogger::class,
            ],
            'aliases' => [
                DocumentManager::class => 'doctrine.documentmanager.odm_default',
            ],
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
            ]
        ];
    }
}
