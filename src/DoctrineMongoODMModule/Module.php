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

use Doctrine\ODM\MongoDB\Tools\Console\Helper\DocumentManagerHelper;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\DependencyIndicatorInterface;
use Zend\ModuleManager\Feature\InitProviderInterface;
use Zend\ModuleManager\ModuleManagerInterface;

/**
 * Doctrine Module provider for Mongo DB ODM.
 *
 * @license MIT
 * @link    http://www.doctrine-project.org
 * @author  Marco Pivetta <ocramius@gmail.com>
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class Module implements
    ConfigProviderInterface,
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
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * {@inheritDoc}
     */
    public function getModuleDependencies()
    {
        return array('DoctrineModule');
    }

    /**
     * Initializes the console with additional commands from the ODM
     *
     * @param \Zend\EventManager\EventInterface $event
     *
     * @return void
     */
    public function initializeConsole(EventInterface $event)
    {
        /* @var $cli \Symfony\Component\Console\Application */
        $cli = $event->getTarget();
        /* @var $serviceLocator \Zend\ServiceManager\ServiceLocatorInterface */
        $serviceLocator = $event->getParam('ServiceManager');

        $commands = array(
            'doctrine.odm.query_command',
            'doctrine.odm.generate_documents_command',
            'doctrine.odm.generate_repositories_command',
            'doctrine.odm.generate_proxies_command',
            'doctrine.odm.generate_hydrators_command',
            'doctrine.odm.create_command',
            'doctrine.odm.update_command',
            'doctrine.odm.drop_command',
            'doctrine.odm.clear_cache_metadata'
        );

        $cli->addCommands(array_map(array($serviceLocator, 'get'), $commands));

        /* @var $documentManager \Doctrine\ODM\MongoDB\DocumentManager */
        $documentManager = $serviceLocator->get('doctrine.documentmanager.odm_default');
        $documentHelper  = new DocumentManagerHelper($documentManager);
        $cli->getHelperSet()->set($documentHelper, 'dm');
    }
}
