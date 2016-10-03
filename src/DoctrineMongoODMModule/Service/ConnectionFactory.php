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

use Doctrine\MongoDB\Connection;
use DoctrineModule\Service\AbstractFactory;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory creates a mongo connection
 *
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @since   0.1.0
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class ConnectionFactory extends AbstractFactory
{
    /**
     * {@inheritDoc}
     *
     * @return Connection
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var $options \DoctrineMongoODMModule\Options\Connection */
        $options = $this->getOptions($container, 'connection');

        $connectionString = $options->getConnectionString();
        $dbName = null;

        if (empty($connectionString)) {
            $connectionString = 'mongodb://';

            $user     = $options->getUser();
            $password = $options->getPassword();
            $dbName   = $options->getDbName();

            if ($user && $password) {
                $connectionString .= $user . ':' . $password . '@';
            }

            $connectionString .= $options->getServer() . ':' . $options->getPort();

            if ($dbName) {
                $connectionString .= '/' . $dbName;
            }
        } else {
            // parse dbName from the connectionString
            $dbStart = strpos($connectionString, '/', 11);
            if (false !== $dbStart) {
                $dbEnd = strpos($connectionString, '?');
                $dbName = substr(
                    $connectionString,
                    $dbStart + 1,
                    $dbEnd ? ($dbEnd - $dbStart - 1) : PHP_INT_MAX
                );
            }
        }

        /** @var $configuration \Doctrine\ODM\MongoDB\Configuration */
        $configuration = $container->get('doctrine.configuration.' . $this->getName());

        // Set defaultDB to $dbName, if it's not defined in configuration
        if (null === $configuration->getDefaultDB()) {
            $configuration->setDefaultDB($dbName);
        }

        return new Connection($connectionString, $options->getOptions(), $configuration);
    }

    public function createService(ServiceLocatorInterface $container)
    {
        return $this($container, Connection::class);
    }

    /**
     * Get the class name of the options associated with this factory.
     *
     * @return string
     */
    public function getOptionsClass()
    {
        return 'DoctrineMongoODMModule\Options\Connection';
    }
}
