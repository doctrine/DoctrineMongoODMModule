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
namespace DoctrineMongoODMModuleTest\Service;

use Doctrine\ODM\MongoDB\Configuration;
use DoctrineMongoODMModule\Service\ConfigurationFactory;
use DoctrineMongoODMModuleTest\AbstractTest;
use DoctrineMongoODMModuleTest\Assets\CustomRepositoryFactory;

class ConfigurationFactoryTest extends AbstractTest
{
    public function testRetryConnectValueIsSetFromConfigurationOptions()
    {
        $config = $this->getDocumentManager()->getConfiguration();

        $this->assertSame(123, $config->getRetryConnect());
    }

    public function testRetryQueryValueIsSetFromConfigurationOptions()
    {
        $config = $this->getDocumentManager()->getConfiguration();

        $this->assertSame(456, $config->getRetryQuery());
    }

    public function testCreation()
    {
        $logger        = $this->getMockForAbstractClass('DoctrineMongoODMModule\Logging\Logger');
        $metadataCache = $this->getMockForAbstractClass('Doctrine\Common\Cache\Cache');
        $mappingDriver = $this->getMockForAbstractClass('Doctrine\Common\Persistence\Mapping\Driver\MappingDriver');
        $repoFactory = new CustomRepositoryFactory();

        $serviceLocator = $this->getMockForAbstractClass('Zend\ServiceManager\ServiceLocatorInterface');
        $serviceLocator->expects($this->exactly(5))->method('get')->withConsecutive(
            array('Configuration'),
            array('stubbed_logger'),
            array('doctrine.cache.stubbed_metadatacache'),
            array('doctrine.driver.stubbed_driver'),
            array('DoctrineMongoODMModuleTest\Assets\CustomRepositoryFactory')
        )->willReturnOnConsecutiveCalls(
            array(
                'doctrine' => array(
                    'configuration' => array(
                        'odm_test' => array(
                            'logger'             => 'stubbed_logger',
                            'metadata_cache'     => 'stubbed_metadatacache',
                            'driver'             => 'stubbed_driver',
                            'generate_proxies'   => true,
                            'proxy_dir'          => 'data/DoctrineMongoODMModule/Proxy',
                            'proxy_namespace'    => 'DoctrineMongoODMModule\Proxy',
                            'generate_hydrators' => true,
                            'hydrator_dir'       => 'data/DoctrineMongoODMModule/Hydrator',
                            'hydrator_namespace' => 'DoctrineMongoODMModule\Hydrator',
                            'default_db'         => 'default_db',
                            'filters'            => array(),  // array('filterName' => 'BSON\Filter\Class')
                            // custom types
                            'types'              => array(
                                'CustomType' => 'DoctrineMongoODMModuleTest\Assets\CustomType'
                            ),
                            'classMetadataFactoryName' => 'stdClass',
                            'repositoryFactory' => 'DoctrineMongoODMModuleTest\Assets\CustomRepositoryFactory',
                        )
                    )
                )
            ),
            $logger,
            $metadataCache,
            $mappingDriver,
            $repoFactory
        );

        $factory = new ConfigurationFactory('odm_test');

        /** @var Configuration $config */
        $config = $factory->createService($serviceLocator);

        $this->assertInstanceOf('Doctrine\ODM\MongoDB\Configuration', $config);
        $this->assertNotNull($config->getLoggerCallable());
        $this->assertSame($metadataCache, $config->getMetadataCacheImpl());
        $this->assertSame($mappingDriver, $config->getMetadataDriverImpl());
        $this->assertInstanceOf(
            'DoctrineMongoODMModuleTest\Assets\CustomType',
            \Doctrine\ODM\MongoDB\Types\Type::getType('CustomType')
        );

        $this->assertInstanceOf(
            'DoctrineMongoODMModuleTest\Assets\CustomRepositoryFactory',
            $config->getRepositoryFactory()
        );
    }
}
