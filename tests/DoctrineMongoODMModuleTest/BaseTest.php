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

namespace DoctrineMongoODMModuleTest;

use PHPUnit_Framework_TestCase;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;

abstract class BaseTest extends PHPUnit_Framework_TestCase
{

    const DEFAULT_DB = 'doctrineMongoODMModuleTest';

    protected $serviceManager;

    protected static $mvcConfig;

    public function setup()
    {
        $mvcConfig = $this->getMvcConfig();

        // $config is loaded from TestConfiguration.php (or .dist)
        $serviceManager = new ServiceManager(new ServiceManagerConfig($mvcConfig['service_manager']));
        $serviceManager->setService('ApplicationConfig', $mvcConfig);
        $serviceManager->setAllowOverride(true);

        $this->serviceManager = $serviceManager;

        /** @var $moduleManager \Zend\ModuleManager\ModuleManager */
        $moduleManager = $serviceManager->get('ModuleManager');
        $moduleManager->loadModules();

        $serviceManager->setService('Config', $this->alterConfig($serviceManager->get('Config')));
    }

    /**
     * @var array $config
     * @return array
     */
    abstract protected function alterConfig(array $config);

    public static function setMvcConfig(array $mvcConfig)
    {
        self::$mvcConfig = $mvcConfig;
    }

    /**
     * @return ServiceManager
     */
    public function getMvcConfig()
    {
    	return self::$mvcConfig;
    }

    public function getDocumentManager()
    {
        return $this->serviceManager->get('doctrine.documentmanager.odm_default');
    }

    public function tearDown()
    {
        $collections = $this->getDocumentManager()->getConnection()->selectDatabase(self::DEFAULT_DB)->listCollections();
        foreach ($collections as $collection) {
            $collection->remove(array(), array('safe' => true));
        }
    }
}
