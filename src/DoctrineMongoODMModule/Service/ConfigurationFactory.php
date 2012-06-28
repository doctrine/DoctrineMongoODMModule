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

use DoctrineModule\Service\AbstractFactory;
use Doctrine\ODM\MongoDB\Mapping\Driver\DriverChain;
use Zend\ServiceManager\ServiceLocatorInterface;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\Common\Annotations\AnnotationRegistry;

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
     * @var \Doctrine\ODM\MongoDB\Mapping\Driver\DriverChain
     */
    protected $chain;

    /**
     * @var array
     */
    protected $filters;

    /**
     * @var array
     */
    protected $annotations;

    protected function getIdentifier(){
        return Events::IDENTIFIER;
    }

    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return \Doctrine\ODM\MongoDB\Configuration
     * @throws \Exception
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var $options \DoctrineMongoODMModule\Options\Configuration */
        $options = $this->getOptions($serviceLocator);

        if ($options->getAutoloadAnnotations())
        {
            $annotationReflection = new \ReflectionClass('Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver');
            $annotationsFile = realpath(
                dirname($annotationReflection->getFileName()) . '/../Annotations/DoctrineAnnotations.php'
            );

            AnnotationRegistry::registerFile($annotationsFile);

            //Also register any other annotations provided by modules
            AnnotationRegistry::registerAutoloadNamespaces($this->getAnnotations($serviceLocator));
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

        //filters
        $filters = $this->getFilters($serviceLocator, $config);
        foreach($filters as $alias => $class){
            $config->addFilter($alias, $class);
        }

        // finally, the driver
        $config->setMetadataDriverImpl($this->getDriverChain($serviceLocator, $config));

        return $config;
    }

    /**
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param array $config
     * @return \Doctrine\ODM\MongoDB\Mapping\Driver\DriverChain
     */
    protected function getDriverChain(ServiceLocatorInterface $serviceLocator, $config)
    {

        if (!null === $this->chain) {
            return $this->chain;
        }
        $chain  = new DriverChain;

        $reader = $serviceLocator->get('Doctrine\Common\Annotations\CachedReader');
        $driverConfig = $serviceLocator->get('Configuration');
        $driverConfig = $driverConfig['doctrine']['drivers']['odm'];

        foreach($driverConfig as $params){
            $chain->addDriver(new $params['class']($reader, $params['paths']), $params['namespace']);
        }

        $events = $this->events($serviceLocator);

        $collection = $events->trigger(Events::LOAD_DRIVERS, $serviceLocator, array('config' => $config));
        foreach($collection as $response) {
            foreach($response as $namespace => $driver) {
                $chain->addDriver($driver, $namespace);
            }
        }

        $this->chain = $chain;
        return $this->chain;
    }

    /**
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param array $config
     * @return array
     */
    protected function getFilters(ServiceLocatorInterface $serviceLocator, $config)
    {
        if (!null == $this->filters){
            return $this->filters;
        }

        $filters  = array();

        $filterConfig = $serviceLocator->get('Configuration');
        $filterConfig = $filterConfig['doctrine']['filters']['odm'];
        $filters = $filterConfig;

        $events = $this->events($serviceLocator);

        $collection = $events->trigger(Events::LOAD_FILTERS, $serviceLocator, array('config' => $config));
        foreach($collection as $response) {
            $filters = array_merge($filters, $response);
        }
        $this->filters = $filters;
        return $this->filters;
    }

    /**
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return type
     */
    protected function getAnnotations(ServiceLocatorInterface $serviceLocator)
    {
        if (!null == $this->annotations){
            return $this->annotations;
        }

        $annotations  = array();

        $annotationsConfig = $serviceLocator->get('Configuration');
        $annotationsConfig = $annotationsConfig['doctrine']['annotations']['odm'];
        $annotations = $annotationsConfig;

        $events = $this->events($serviceLocator);

        $collection = $events->trigger(Events::LOAD_ANNOTATONS, $serviceLocator);
        foreach($collection as $response) {
            $annotations = array_merge($annotations, $response);
        }
        $this->annotations = $annotations;
        return $this->annotations;
    }

    public function getOptionsClass()
    {
        return 'DoctrineMongoODMModule\Options\Configuration';
    }
}