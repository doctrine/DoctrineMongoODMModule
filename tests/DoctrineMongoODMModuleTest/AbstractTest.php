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
use Zend\Mvc\Application;

abstract class AbstractTest extends PHPUnit_Framework_TestCase
{

    protected $application;
    protected $serviceManager;


    protected static $applicationConfig;

    public function setup(){

        $this->application = Application::init(self::$applicationConfig);
        $this->serviceManager = $this->application->getServiceManager();
    }

    public static function setApplicationConfig($applicationConfig)
    {
        self::$applicationConfig = $applicationConfig;
    }

    public function getDocumentManager()
    {
        return $this->serviceManager->get('doctrine.documentmanager.odm_default');
    }

    public function tearDown()
    {
        $collections = $this->getDocumentManager()->getConnection()->selectDatabase('doctrineMongoODMModuleTest')->listCollections();
        foreach ($collections as $collection) {
            $collection->remove(array(), array('w' => 1));
        }
    }
}
