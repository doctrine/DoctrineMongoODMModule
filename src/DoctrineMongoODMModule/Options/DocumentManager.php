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

use Zend\Stdlib\Options;

/**
 * Document manager options for doctrine mongo
 *
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @since   0.1.0
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class DocumentManager extends Options
{
    /**
     * Set the configuration key for the Configuration. Configuration key
     * is assembled as "doctrine.configuration.{key}" and pulled from
     * service locator.
     *
     * @var string
     */
    protected $configuration = 'odm_default';

    /**
     * Set the connection key for the Connection. Connection key
     * is assembled as "doctrine.connection.{key}" and pulled from
     * service locator.
     *
     * @var string
     */
    protected $connection = 'odm_default';

    /**
     * Set the event manager key for the event manager. Key
     * is assembled as "doctrine.eventManager.{key} and pulled from
     * service locator.
     *
     * @var string
     */
    protected $eventManager = 'odm_default';

    /**
     *
     * @param type $configuration
     * @return \DoctrineMongoODMModule\Options\DocumentManager
     */
    public function setConfiguration($configuration)
    {
        $this->configuration = (string) $configuration;
        return $this;
    }

    /**
     * @return string
     */
    public function getConfiguration()
    {
        return "doctrine.configuration.{$this->configuration}";
    }

    /**
     *
     * @param type $connection
     * @return \DoctrineMongoODMModule\Options\DocumentManager
     */
    public function setConnection($connection)
    {
        $this->connection = (string) $connection;
        return $this;
    }

    /**
     * @return string
     */
    public function getConnection()
    {
        return "doctrine.connection.{$this->connection}";
    }

    /**
     *
     * @return string
     */
    public function getEventManager() {
        return "doctrine.eventmanager.{$this->eventManager}";
    }

    /**
     *
     * @param type $eventManager
     * @return \DoctrineMongoODMModule\Options\DocumentManager
     */
    public function setEventManager($eventManager) {
        $this->eventManager = (string) $eventManager;
        return $this;
    }
}