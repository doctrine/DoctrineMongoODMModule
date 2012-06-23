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

use Doctrine\Common\Annotations\AnnotationRegistry;
use DoctrineModule\Service as CommonService;
use DoctrineMongoODMModule\Service as ODMService;
use Doctrine\ODM\MongoDB\Tools\Console\Command;

/**
 * Doctrine Module provider for Mongo DB ODM.
 *
 * @license MIT
 * @link    http://www.doctrine-project.org
 * @since   0.1.0
 * @author  Kyle Spraggs <theman@spiffyjr.me>
 * @author  Marco Pivetta <ocramius@gmail.com>
 */
class Module
{
    public function init($mm)
    {
        $mm->events()->attach('loadModules.post', function($e) {
            $config   = $e->getConfigListener()->getMergedConfig();
            $autoload = isset($config['doctrine']['odm_autoload_annotations']) ?
                $config['doctrine']['odm_autoload_annotations'] :
                false;

            if ($autoload) {
                $refl = new \ReflectionClass('Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver');
                $path = realpath(dirname($refl->getFileName()) . '/..') . '/Annotations/DoctrineAnnotations.php';

                AnnotationRegistry::registerFile($path);
            }
        });
    }

    public function onBootstrap($e)
    {
        $app    = $e->getTarget();
        $events = $app->events()->getSharedManager();

        // Attach to helper set event and load the entity manager helper.
        $events->attach('doctrine', 'loadCli.post', function($e) {
            $cli = $e->getTarget();

            $cli->addCommands(array(
                // DRM Commands
                new Command\GenerateHydratorsCommand(),
                new Command\GenerateProxiesCommand(),
                new Command\QueryCommand(),
                new Command\ClearCache\MetadataCommand(),
                new Command\GenerateDocumentsCommand(),
                new Command\GenerateRepositoriesCommand(),
                new Command\Schema\CreateCommand(),
                new Command\Schema\DropCommand(),
            ));

            $dm = $e->getParam('ServiceManager')->get('doctrine.documentmanager.odm_default');
            $eh = new \Doctrine\ODM\MongoDB\Tools\Console\Helper\DocumentManagerHelper($dm);

            $cli->getHelperSet()->set($eh, 'dm');
        });
    }

    public function getConfig($env = null)
    {
        return include __DIR__ . '/config/module.config.php';
    }


    /**
     * Expected to return \Zend\ServiceManager\Configuration object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Configuration
     */
    public function getServiceConfiguration()
    {
        #die('here');
        return array(
            'aliases' => array(
                'Doctrine\ODM\MongoDB\DocumentManager' => 'doctrine.documentmanager.odm_default',
            ),
            'factories' => array(
                'doctrine.connection.odm_default'      => new ODMService\ConnectionFactory('odm_default'),
                'doctrine.configuration.odm_default'   => new ODMService\ConfigurationFactory('odm_default'),
                'doctrine.driver.odm_default'          => new ODMService\DriverFactory('odm_default'),
                'doctrine.documentmanager.odm_default' => new ODMService\DocumentManagerFactory('odm_default'),
                'doctrine.eventmanager.odm_default'    => new CommonService\EventManagerFactory('odm_default'),
            )
        );
    }
}
