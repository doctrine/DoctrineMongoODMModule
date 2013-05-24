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
 * Document manager options for doctrine mongo
 *
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @since   0.1.0
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class DocumentManagerOptions extends AbstractOptions
{
    /**
     * Set the configuration key for the Configuration. Pulled from
     * service locator.
     *
     * @var string
     */
    protected $configuration = 'doctrine.odm.configuration.default';

    /**
     * Set the connection key for the Connection. Pulled from
     * service locator.
     *
     * @var string
     */
    protected $connection = 'doctrine.odm.connection.default';

    /**
     * Set the event manager key for the event manager. Pulled from
     * service locator.
     *
     * @var string
     */
    protected $eventManager = 'doctrine.eventmanager.default';

    /**
     * @param string $configuration
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
        return $this->configuration;
    }

    /**
     * @param string $connection
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
        return $this->connection;
    }

    /**
     *
     * @return string
     */
    public function getEventManager()
    {
        return $this->eventManager;
    }

    /**
     * @param string $eventManager
     * @return \DoctrineMongoODMModule\Options\DocumentManager
     */
    public function setEventManager($eventManager)
    {
        $this->eventManager = (string) $eventManager;
        return $this;
    }
}
