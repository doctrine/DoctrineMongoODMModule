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
namespace DoctrineMongoODMModule\Builder;

use DoctrineModule\Builder\BuilderInterface;
use DoctrineModule\Exception;
use DoctrineMongoODMModule\Options\ConfigurationOptions;
use Doctrine\ODM\MongoDB\Configuration;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Builder to create MongoDB configuration object.
 *
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @since   0.1.0
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class ConfigurationBuilder implements BuilderInterface, ServiceLocatorAwareInterface
{
    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * {@inheritDoc}
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * {@inheritDoc}
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function build($options)
    {
        if (is_array($options) || $options instanceof \Traversable) {
            $options = new ConfigurationOptions($options);
        } elseif (! $options instanceof ConfigurationOptions) {
            throw new Exception\InvalidArgumentException();
        }

        $config = new Configuration;

        // logger
        if ($options->getLogger()) {
            $logger = $this->serviceLocator->get($options->getLogger());
            $config->setLoggerCallable(array($logger, 'log'));
        }

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
        $config->setMetadataCacheImpl($this->serviceLocator->get($options->getMetadataCache()));

        // retries
        $config->setRetryConnect($options->getRetryConnect());
        $config->setRetryQuery($options->getRetryQuery());

        // Register filters
        foreach ($options->getFilters() as $alias => $class) {
            $config->addFilter($alias, $class);
        }

        // the driver
        $config->setMetadataDriverImpl($this->serviceLocator->get($options->getDriver()));

        // metadataFactory, if set
        if ($factoryName = $options->getClassMetadataFactoryName()) {
            $config->setClassMetadataFactoryName($factoryName);
        }

        return $config;
    }
}
