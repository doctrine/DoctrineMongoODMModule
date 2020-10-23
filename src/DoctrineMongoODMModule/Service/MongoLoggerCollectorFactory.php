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
use function MongoDB\Driver\Monitoring\addSubscriber;

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
        parent::__construct($name);
        $this->name = $name;
    }

    /**
     * {@inheritDoc}
     *
     * @return MongoLoggerCollector
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $settings = $this->getOptions($container, 'mongo_logger_collector');
        assert($settings instanceof Options\MongoLoggerCollector);

        if ($settings->getMongoLogger()) {
            $debugStackLogger = $container->get($settings->getMongoLogger());
        } else {
            $debugStackLogger = new DebugStack();
        }

        return new MongoLoggerCollector($debugStackLogger, $settings->getName());
    }

    /**
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $container)
    {
        return $this($container, MongoLoggerCollector::class);
    }

    public function getOptionsClass() : string
    {
        return Options\MongoLoggerCollector::class;
    }
}
