<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace DoctrineMongoODMModule;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Tools\Console\Command;
use DoctrineModule\Service as CommonService;
use DoctrineMongoODMModule\Service as ODMService;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputOption;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\InitProviderInterface;
use Zend\ModuleManager\ModuleManagerInterface;
use Zend\Loader\AutoloaderFactory;
use Zend\Loader\StandardAutoloader;

/**
 * Doctrine Module provider for Mongo DB ODM.
 *
 * @license MIT
 * @link    http://www.doctrine-project.org
 * @since   0.1.0
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class Module implements
    BootstrapListenerInterface,
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface,
    InitProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function init(ModuleManagerInterface $manager)
    {
        $events = $manager->getEventManager();
        // Initialize logger collector once the profiler is initialized itself
        $events->attach('profiler_init', function (EventInterface $e) use ($manager) {
            $manager->getEvent()->getParam('ServiceManager')->get('doctrine.mongo_logger_collector.odm_default');
        });
        $events->getSharedManager()->  attach('doctrine', 'loadCli.post', array($this, 'loadCli'));
    }

    /**
     * {@inheritDoc}
     */
    public function onBootstrap(EventInterface $event)
    {
    }

    /**
     * @param EventInterface $event
     */
    public function loadCli(EventInterface $event)
    {
        $commands = array(
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
        );

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
        $documentManagerName = !empty($documentManagerName) ? $documentManagerName : 'odm_default';

        $documentManager = $event->getParam('ServiceManager')->get('doctrine.documentmanager.' . $documentManagerName);
        $documentHelper  = new \Doctrine\ODM\MongoDB\Tools\Console\Helper\DocumentManagerHelper($documentManager);
        $cli->getHelperSet()->set($documentHelper, 'dm');
    }

    /**
     * {@inheritDoc}
     */
    public function getAutoloaderConfig()
    {
        return array(
            AutoloaderFactory::STANDARD_AUTOLOADER => array(
                StandardAutoloader::LOAD_NS => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * {@inheritDoc}
     */
    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                Logging\DebugStack::class  => Logging\DebugStack::class,
                Logging\LoggerChain::class => Logging\LoggerChain::class,
                Logging\EchoLogger::class  => Logging\EchoLogger::class,
            ),
            'aliases' => array(
                DocumentManager::class => 'doctrine.documentmanager.odm_default',
            ),
            'factories' => array(
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
            )
        );
    }
}
