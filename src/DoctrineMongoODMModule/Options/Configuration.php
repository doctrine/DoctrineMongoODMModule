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
namespace DoctrineMongoODMModule\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Configuration options for doctrine mongo
 *
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @since   0.1.0
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class Configuration extends AbstractOptions
{

    /**
     * Set the cache key for the metadata cache. Cache key
     * is assembled as "doctrine.cache.{key}" and pulled from
     * service locator.
     *
     * @var string
     */
    protected $metadataCache = 'array';

    /**
     * Automatic generation of proxies (disable for production!)
     *
     * @var bool
     */
    protected $generateProxies = true;

    /**
     * Proxy directory.
     *
     * @var string
     */
    protected $proxyDir = 'data';

    /**
     * Proxy namespace.
     *
     * @var string
     */
    protected $proxyNamespace = 'DoctrineMongoODMModule\Proxy';

    /**
     * Automatic generation of hydrators (disable for production!)
     *
     * @var boolean
     */
    protected $generateHydrators = true;

    /**
     * Hydrator directory
     *
     * @var string
     */
    protected $hydratorDir = 'data';

    /**
     * Hydrator namespace
     *
     * @var string
     */
    protected $hydratorNamespace = 'DoctrineMongoODMModule\Hydrator';

    /**
     *
     * @var string
     */
    protected $driver;

    /**
     *
     * @var string
     */
    protected $defaultDb;

    /**
     * An array of filters. Array should be in the form
     * array('filterName' => 'BSON\Filter\Class')
     *
     * @var array
     */
    protected $filters = array();

    /**
     *
     * @var \DoctrineMongoODMModule\Logging\Logger
     */
    protected $logger;

    /**
     *
     * @var string
     */
    protected $classMetadataFactoryName;

    /**
     * Number of times to attempt to connect if an exception is encountered
     *
     * @var int
     */
    protected $retryConnect = 0;

    /**
     * Number of times to attempt a query if an exception is encountered
     *
     * @var int
     */
    protected $retryQuery = 0;

    /**
     *
     * @param string $driver
     * @return \DoctrineMongoODMModule\Options\Configuration
     */
    public function setDriver($driver)
    {
        $this->driver = (string) $driver;
        return $this;
    }

    /**
     * @return string
     */
    public function getDriver()
    {
        return "doctrine.driver.{$this->driver}";
    }

    /**
     *
     * @param boolean $generateProxies
     * @return \DoctrineMongoODMModule\Options\Configuration
     */
    public function setGenerateProxies($generateProxies)
    {
        $this->generateProxies = (boolean) $generateProxies;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getGenerateProxies()
    {
        return $this->generateProxies;
    }

    /**
     *
     * @param string $metadataCache
     * @return \DoctrineMongoODMModule\Options\Configuration
     */
    public function setMetadataCache($metadataCache)
    {
        $this->metadataCache = (string) $metadataCache;
        return $this;
    }

    /**
     * @return string
     */
    public function getMetadataCache()
    {
        return "doctrine.cache.{$this->metadataCache}";
    }

    /**
     *
     * @param string $proxyDir
     * @return \DoctrineMongoODMModule\Options\Configuration
     */
    public function setProxyDir($proxyDir)
    {
        $this->proxyDir = (string) $proxyDir;
        return $this;
    }

    /**
     * @return string
     */
    public function getProxyDir()
    {
        return $this->proxyDir;
    }

    /**
     *
     * @param string $proxyNamespace
     * @return \DoctrineMongoODMModule\Options\Configuration
     */
    public function setProxyNamespace($proxyNamespace)
    {
        $this->proxyNamespace = (string) $proxyNamespace;
        return $this;
    }

    /**
     * @return string
     */
    public function getProxyNamespace()
    {
        return $this->proxyNamespace;
    }

    /**
     *
     * @return boolean
     */
    public function getGenerateHydrators() {
        return $this->generateHydrators;
    }

    /**
     *
     * @param boolean $generateHydrators
     * @return \DoctrineMongoODMModule\Options\Configuration
     */
    public function setGenerateHydrators($generateHydrators) {
        $this->generateHydrators = (boolean) $generateHydrators;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getHydratorDir() {
        return $this->hydratorDir;
    }

    /**
     *
     * @param string $hydratorDir
     * @return \DoctrineMongoODMModule\Options\Configuration
     */
    public function setHydratorDir($hydratorDir) {
        $this->hydratorDir = (string) $hydratorDir;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getHydratorNamespace() {
        return $this->hydratorNamespace;
    }

    /**
     *
     * @param string $hydratorNamespace
     * @return \DoctrineMongoODMModule\Options\Configuration
     */
    public function setHydratorNamespace($hydratorNamespace) {
        $this->hydratorNamespace = (string) $hydratorNamespace;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getDefaultDb() {
        return $this->defaultDb;
    }

    /**
     *
     * @param string $defaultDb
     * @return \DoctrineMongoODMModule\Options\Configuration
     */
    public function setDefaultDb($defaultDb) {
        $this->defaultDb = (string) $defaultDb;
        return $this;
    }

    /**
     *
     * @return array
     */
    public function getFilters() {
        return $this->filters;
    }

    /**
     *
     * @param array $filters
     * @return \DoctrineMongoODMModule\Options\Configuration
     */
    public function setFilters(array $filters) {
        $this->filters = $filters;
        return $this;
    }

    /**
     *
     * @param \DoctrineMongoODMModule\Logging\Logger $logger
     * @return \DoctrineMongoODMModule\Options\Configuration
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     *
     * @return \DoctrineMongoODMModule\Logging\Logger
     */
    public function getLogger()
    {
        return $this->logger;
    }
    
    /**
     * 
     * @return string
     */
    public function getClassMetadataFactoryName() {
        return $this->classMetadataFactoryName;
    }

    /**
     * 
     * @param string $classMetadataFactoryName
     */
    public function setClassMetadataFactoryName($classMetadataFactoryName) {
        $this->classMetadataFactoryName = (string) $classMetadataFactoryName;
    }

    /**
     * @param int $retryConnect
     * @return \DoctrineMongoODMModule\Options\Configuration
     */
    public function setRetryConnect($retryConnect)
    {
        $this->retryConnect = (int) $retryConnect;
        return $this;
    }

    /**
     * @return int
     */
    public function getRetryConnect()
    {
        return $this->retryConnect;
    }

    /**
     * @param int $retryQuery
     * @return \DoctrineMongoODMModule\Options\Configuration
     */
    public function setRetryQuery($retryQuery)
    {
        $this->retryQuery = (int) $retryQuery;
        return $this;
    }

    /**
     * @return int
     */
    public function getRetryQuery()
    {
        return $this->retryQuery;
    }
}
