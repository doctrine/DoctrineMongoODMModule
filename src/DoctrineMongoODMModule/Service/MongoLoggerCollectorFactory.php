<?php

declare(strict_types=1);

namespace DoctrineMongoODMModule\Service;

use Doctrine\ODM\MongoDB\Configuration;
use DoctrineMongoODMModule\Collector\MongoLoggerCollector;
use DoctrineMongoODMModule\Logging\DebugStack;
use DoctrineMongoODMModule\Logging\LoggerChain;
use DoctrineMongoODMModule\Options;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use function assert;

/**
 * Mongo Logger Configuration ServiceManager factory
 *
 * @link    http://www.doctrine-project.org/
 */
class MongoLoggerCollectorFactory extends AbstractFactory
{
    /** @var string */
    protected $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritDoc}
     *
     * @return MongoLoggerCollector
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $options = $this->getOptions($container, 'mongo_logger_collector');
        assert($options instanceof Options\MongoLoggerCollector);

        if ($options->getMongoLogger()) {
            $debugStackLogger = $container->get($options->getMongoLogger());
        } else {
            $debugStackLogger = new DebugStack();
        }

        $configuration = $container->get($options->getConfiguration());
        assert($configuration instanceof Configuration);

        if ($configuration->getLoggerCallable() !== null) {
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

    /**
     * @return mixed
     */
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
