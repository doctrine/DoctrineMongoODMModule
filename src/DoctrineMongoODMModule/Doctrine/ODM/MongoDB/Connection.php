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

use Doctrine\MongoDB\Connection as MongoConnection,
    DoctrineModule\Doctrine\Common\EventManager,
    DoctrineModule\Doctrine\Instance;

/**
 * Wrapper for MongoDB connection that helps setup configuration without relying
 * entirely on Di.
 *
 * @license MIT
 * @link    http://www.doctrine-project.org
 * @since   0.1.0
 * @author  Kyle Spraggs <theman@spiffyjr.me>
 */
class Connection extends Instance
{
	/**
	 * @var Doctrine\ORM\Configuration
	 */
	protected $config;

	/**
	 * @var Doctrine\Common\EventManager
	 */
	protected $evm;

    /**
     * @var null|Mongo
     */
    protected $server;

    /**
     * @var array
     */
    protected $options = array();

	/**
	 * Constructor
	 *
	 * @param null|Mongo 	$server
     * @param array         $options
	 * @param Configuration $config
	 * @param EventManager  $evm
	 */
	public function __construct(
	   $server = null,
	   array $options = array(),
	   Configuration $config = null,
	   EventManager $evm = null
    ) {
	    $this->server  = $server;
        $this->options = $options ? $options : array();
		$this->config  = $config ? $config->getInstance() : null;
		$this->evm     = $evm ? $evm->getInstance() : null;

		parent::__construct(array());
	}

	protected function loadInstance()
	{
        $this->instance = new MongoConnection(
            $this->server,
            $this->options,
            $this->config,
            $this->evm
        );
	}
}