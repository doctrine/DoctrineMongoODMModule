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

use DoctrineModule\Service as CommonService;
use DoctrineMongoODMModule\Service as ODMService;
use Zend\EventManager\Event;

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
     *
     * @param \Zend\EventManager\Event $event
     */
    public function onBootstrap(Event $event)
    {
        $app = $event->getTarget();
        $sharedManager = $app->getEventManager()->getSharedManager();

        // Attach to helper set event and load the document manager helper.
        $sharedManager->attach('doctrine', 'loadCli.post', array($this, 'loadCli'));
    }

    /**
     *
     * @param \Zend\EventManager\Event $event
     */
    public function loadCli(Event $event){
        $cli = $event->getTarget();
        $cli->addCommands(array(
            new \Doctrine\ODM\MongoDB\Tools\Console\Command\QueryCommand(),
            new \Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateDocumentsCommand(),
            new \Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateRepositoriesCommand(),
            new \Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateProxiesCommand(),
            new \Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateHydratorsCommand(),
            new \Doctrine\ODM\MongoDB\Tools\Console\Command\Schema\CreateCommand(),
            new \Doctrine\ODM\MongoDB\Tools\Console\Command\Schema\DropCommand(),
        ));

        $documentManager = $event->getParam('ServiceManager')->get('doctrine.documentmanager.odm_default');
        $documentHelper  = new \Doctrine\ODM\MongoDB\Tools\Console\Helper\DocumentManagerHelper($documentManager);
        $cli->getHelperSet()->set($documentHelper, 'dm');
    }

    /**
     *
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     *
     * @return array
     */
    public function getServiceConfig()
    {
        return array(
            'aliases' => array(
                'Doctrine\ODM\Mongo\DocumentManager' => 'doctrine.documentmanager.odm_default',
            ),
            'factories' => array(
                'doctrine.connection.odm_default'    => new ODMService\ConnectionFactory('odm_default'),
                'doctrine.configuration.odm_default' => new ODMService\ConfigurationFactory('odm_default'),
                'doctrine.driver.odm_default'        => new CommonService\DriverFactory('odm_default'),
                'doctrine.documentmanager.odm_default' => new ODMService\DocumentManagerFactory('odm_default'),
                'doctrine.eventmanager.odm_default'  => new CommonService\EventManagerFactory('odm_default'),
            )
        );
    }
}
