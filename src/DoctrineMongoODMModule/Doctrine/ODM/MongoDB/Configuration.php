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

namespace DoctrineMongoODMModule\Doctrine\ODM\MongoDB;

use Doctrine\Common\Cache\Cache,
    Doctrine\MongoDB\Loggable,
    Doctrine\ODM\MongoDB\Configuration as ODMConfiguration,
    DoctrineModule\Doctrine\Instance;

/**
 * Wrapper for MongoDB configuration that helps setup configuration without relying
 * entirely on Di.
 *
 * @license MIT
 * @link    http://www.doctrine-project.org
 * @since   0.1.0
 * @author  Kyle Spraggs <theman@spiffyjr.me>
 */
class Configuration extends Instance
{
    /**
     * Definition for configuration options.
     *
     * @var array
     */
    protected $definition = array(
        'required' => array(
            'auto_generate_proxies'   => 'boolean',
            'proxy_dir'               => 'string',
            'proxy_namespace'         => 'string',
            'auto_generate_hydrators' => 'boolean',
            'hydrator_dir'            => 'string',
            'hydrator_namespace'      => 'string',
        ),
        'optional' => array(
            'default_db' => 'string'
        )
    );

    /**
     * @var Doctrine\ORM\Mapping\Driver\Driver
     */
    protected $metadataDriver;

    /**
     * @var Doctrine\Common\Cache\Cache
     */
    protected $metadataCache;

    /**
     * @var Doctrine\DBAL\Logging\SQLLogger
     */
    protected $logger;

    /**
     * Constructor.
     *
     * @param array    $opts
     * @param Driver   $metadataDriver
     * @param Cache    $metadataCache
     * @param Loggable $logger
     */
    public function __construct(array $opts, $metadataDriver, Cache $metadataCache, Loggable $logger = null)
    {
    	if ($metadataDriver instanceof DriverChain) {
    		$metadataDriver = $metadataDriver->getInstance();
    	}

    	$this->metadataDriver = $metadataDriver;
        $this->metadataCache  = $metadataCache;
        $this->logger         = $logger;

        parent::__construct($opts);
    }

    protected function loadInstance()
    {
        $opts   = $this->opts;
        $config = new ODMConfiguration;

        // proxies
        $config->setAutoGenerateProxyClasses($opts['auto_generate_proxies']);
        $config->setProxyDir($opts['proxy_dir']);
        $config->setProxyNamespace($opts['proxy_namespace']);

        // hydrators
        $config->setAutoGenerateHydratorClasses($opts['auto_generate_hydrators']);
        $config->setHydratorDir($opts['hydrator_dir']);
        $config->setHydratorNamespace($opts['hydrator_namespace']);

        // default db
        $config->setDefaultDB($opts['default_db']);

        // caching
        $config->setMetadataCacheImpl($this->metadataCache);

        // logger
        $config->setLoggerCallable($this->logger);

        // finally, the driver
        $config->setMetadataDriverImpl($this->metadataDriver);

        $this->instance = $config;
    }
}