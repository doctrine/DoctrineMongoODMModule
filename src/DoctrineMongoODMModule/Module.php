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

use Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateDocumentsCommand;
use Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateHydratorsCommand;
use Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateProxiesCommand;
use Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateRepositoriesCommand;
use Doctrine\ODM\MongoDB\Tools\Console\Command\QueryCommand;
use Doctrine\ODM\MongoDB\Tools\Console\Command\Schema\CreateCommand;
use Doctrine\ODM\MongoDB\Tools\Console\Command\Schema\DropCommand;
use Doctrine\ODM\MongoDB\Tools\Console\Helper\DocumentManagerHelper;

use DoctrineModule\Service\Authentication\AdapterFactory;
use DoctrineModule\Service\Authentication\AuthenticationServiceFactory;
use DoctrineModule\Service\Authentication\StorageFactory;

use DoctrineModule\Service\DriverFactory;
use DoctrineModule\Service\EventManagerFactory;
use DoctrineMongoODMModule\Service\ConfigurationFactory;
use DoctrineMongoODMModule\Service\ConnectionFactory;
use DoctrineMongoODMModule\Service\DocumentManagerFactory;
use DoctrineMongoODMModule\Service\MongoLoggerCollectorFactory;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\DependencyIndicatorInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\InitProviderInterface;
use Zend\ModuleManager\ModuleManagerInterface;
use Zend\Loader\StandardAutoloader;

/**
 * Doctrine Module provider for Mongo DB ODM.
 *
 * @license MIT
 * @link    http://www.doctrine-project.org
 * @author  Marco Pivetta <ocramius@gmail.com>
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class Module implements
    BootstrapListenerInterface,
    ConfigProviderInterface,
    ServiceProviderInterface,
    InitProviderInterface,
    DependencyIndicatorInterface
{
    /**
     * {@inheritDoc}
     */
    public function init(ModuleManagerInterface $manager)
    {
        $events = $manager->getEventManager();

        // Initialize logger collector once the profiler is initialized itself
        $events->attach(
            'profiler_init',
            function () use ($manager) {
                $manager->getEvent()->getParam('ServiceManager')->get('doctrine.mongo_logger_collector.odm_default');
            }
        );
    }

    /**
     * {@inheritDoc}
     */
    public function onBootstrap(EventInterface $event)
    {
        /* @var $app \Zend\Mvc\ApplicationInterface */
        $app           = $event->getTarget();
        $sharedManager = $app->getEventManager()->getSharedManager();

        // Attach to helper set event and load the document manager helper.
        $sharedManager->attach('doctrine', 'loadCli.post', array($this, 'loadCli'));
    }

    /**
     * @param \Zend\EventManager\EventInterface $event
     */
    public function loadCli(EventInterface $event)
    {
        /* @var $cli \Symfony\Component\Console\Application */
        $cli             = $event->getTarget();
        /* @var $documentManager \Doctrine\ODM\MongoDB\DocumentManager */
        $documentManager = $event->getParam('ServiceManager')->get('doctrine.documentmanager.odm_default');
        $documentHelper  = new DocumentManagerHelper($documentManager);

        $cli->getHelperSet()->set($documentHelper, 'dm');
        $cli->addCommands(
            array(
                new QueryCommand(),
                new GenerateDocumentsCommand(),
                new GenerateRepositoriesCommand(),
                new GenerateProxiesCommand(),
                new GenerateHydratorsCommand(),
                new CreateCommand(),
                new DropCommand(),
            )
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
                'DoctrineMongoODMModule\Logging\DebugStack'   => 'DoctrineMongoODMModule\Logging\DebugStack',
                'DoctrineMongoODMModule\Logging\LoggerChain'  => 'DoctrineMongoODMModule\Logging\LoggerChain',
                'DoctrineMongoODMModule\Logging\EchoLogger'   => 'DoctrineMongoODMModule\Logging\EchoLogger',
            ),
            'aliases' => array(
                'Doctrine\ODM\Mongo\DocumentManager'          => 'doctrine.documentmanager.odm_default',
            ),
            'factories' => array(
                'doctrine.authenticationadapter.odm_default'  => new AdapterFactory('odm_default'),
                'doctrine.authenticationstorage.odm_default'  => new StorageFactory('odm_default'),
                'doctrine.authenticationservice.odm_default'  => new AuthenticationServiceFactory('odm_default'),
                'doctrine.connection.odm_default'             => new ConnectionFactory('odm_default'),
                'doctrine.configuration.odm_default'          => new ConfigurationFactory('odm_default'),
                'doctrine.driver.odm_default'                 => new DriverFactory('odm_default'),
                'doctrine.documentmanager.odm_default'        => new DocumentManagerFactory('odm_default'),
                'doctrine.eventmanager.odm_default'           => new EventManagerFactory('odm_default'),
                'doctrine.mongo_logger_collector.odm_default' => new MongoLoggerCollectorFactory('odm_default'),
            )
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getModuleDependencies()
    {
        return array('DoctrineModule');
    }
}
