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

use Zend\ServiceManager\ServiceLocatorInterface;

use DoctrineMongoODMModule\Collector\MongoLoggerCollector;

use DoctrineMongoODMModule\Logging\DebugStack;
use DoctrineMongoODMModule\Logging\LoggerChain;

/**
 * Mongo Logger Configuration ServiceManager factory
 *
 * @license MIT
 * @link    http://www.doctrine-project.org/
 */
class MongoLoggerCollectorFactory extends AbstractFactory
{

    protected $mappingType = 'odm';
    
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var $options \DoctrineMongoODMModule\Options\MongoLoggerCollector */
        $options = $this->getOptions($serviceLocator, 'mongo_logger_collector');

        if ($options->getMongoLogger()) {
            $debugStackLogger = $serviceLocator->get($options->getMongoLogger());
        } else {
            $debugStackLogger = new DebugStack();
        }

        /** @var $options \Doctrine\ODM\MongoDB\Configuration */
        $configuration = $serviceLocator->get($options->getConfiguration());

        if (null !== $configuration->getLoggerCallable()) {
            $logger = new LoggerChain();
            $logger->addLogger($debugStackLogger);
            $callable = $configuration->getLoggerCallable();
            $logger->addLogger($callable[0]);
            $configuration->setLoggerCallable(array($logger, 'log'));
        } else {
            $configuration->setLoggerCallable(array($debugStackLogger, 'log'));
        }

        return new MongoLoggerCollector($debugStackLogger, $options->getName());
    }

    /**
     * {@inheritDoc}
     */
    public function getOptionsClass()
    {
        return 'DoctrineMongoODMModule\Options\MongoLoggerCollector';
    }
}
