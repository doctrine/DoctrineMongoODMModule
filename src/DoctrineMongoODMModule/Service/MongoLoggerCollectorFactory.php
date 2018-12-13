<?php

namespace DoctrineMongoODMModule\Service;

use DoctrineMongoODMModule\Collector\MongoLoggerCollector;
use DoctrineMongoODMModule\Logging\DebugStack;
use DoctrineMongoODMModule\Logging\LoggerChain;
use DoctrineMongoODMModule\Options;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Mongo Logger Configuration ServiceManager factory
 *
 * @license MIT
 * @link    http://www.doctrine-project.org/
 */
class MongoLoggerCollectorFactory extends AbstractFactory
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritDoc}
     *
     * @return MongoLoggerCollector
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var $options Options\MongoLoggerCollector */
        $options = $this->getOptions($container, 'mongo_logger_collector');

        if ($options->getMongoLogger()) {
            $debugStackLogger = $container->get($options->getMongoLogger());
        } else {
            $debugStackLogger = new DebugStack();
        }

        /** @var $options \Doctrine\ODM\MongoDB\Configuration */
        $configuration = $container->get($options->getConfiguration());

        if (null !== $configuration->getLoggerCallable()) {
            $logger = new LoggerChain();
            $logger->addLogger($debugStackLogger);
            $callable = $configuration->getLoggerCallable();
            $logger->addLogger($callable[0]);
            $configuration->setLoggerCallable([$logger, 'log']);
        } else {
            $configuration->setLoggerCallable([$debugStackLogger, 'log']);
        }

        return new MongoLoggerCollector($debugStackLogger, $options->getName());
    }

    public function createService(ServiceLocatorInterface $container)
    {
        return $this($container, MongoLoggerCollector::class);
    }

    /**
     * {@inheritDoc}
     */
    public function getOptionsClass()
    {
        return Options\MongoLoggerCollector::class;
    }
}
