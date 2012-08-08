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
namespace DoctrineMongoODMModule\Service;

use Doctrine\Common\Annotations\AnnotationRegistry;
use DoctrineModule\Service\AbstractFactory;
use Doctrine\ODM\MongoDB\Configuration;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory to create MongoDB configuration object.
 *
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @since   0.1.0
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class ConfigurationFactory extends AbstractFactory
{

    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return \Doctrine\ODM\MongoDB\Configuration
     * @throws \Exception
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var $options \DoctrineMongoODMModule\Options\Configuration */
        $options = $this->getOptions($serviceLocator, 'configuration');

        // Register annotations
        if ($options->getAutoloadAnnotations())
        {
            $annotationReflection = new \ReflectionClass('Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver');
            $annotationsFile = realpath(
                dirname($annotationReflection->getFileName()) . '/../Annotations/DoctrineAnnotations.php'
            );

            AnnotationRegistry::registerFile($annotationsFile);
        }

        $config = new Configuration;

        // proxies
        $config->setAutoGenerateProxyClasses($options->getGenerateProxies());
        $config->setProxyDir($options->getProxyDir());
        $config->setProxyNamespace($options->getProxyNamespace());

        // hydrators
        $config->setAutoGenerateHydratorClasses($options->getGenerateHydrators());
        $config->setHydratorDir($options->getHydratorDir());
        $config->setHydratorNamespace($options->getHydratorNamespace());

        // default db
        $config->setDefaultDB($options->getDefaultDb());

        // caching
        $config->setMetadataCacheImpl($serviceLocator->get($options->getMetadataCache()));

        // Register filters
        foreach($options->getFilters() as $alias => $class){
            $config->addFilter($alias, $class);
        }

        // finally, the driver
        $config->setMetadataDriverImpl($serviceLocator->get($options->getDriver()));

        return $config;
    }

    public function getOptionsClass()
    {
        return 'DoctrineMongoODMModule\Options\Configuration';
    }
}