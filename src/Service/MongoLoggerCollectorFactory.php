<?php

declare(strict_types=1);

namespace DoctrineMongoODMModule\Service;

use DoctrineMongoODMModule\Collector\MongoLoggerCollector;
use DoctrineMongoODMModule\Logging\DebugStack;
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
     * @deprecated 3.1.0 With laminas-servicemanager v3 this method is obsolete and will be removed in 4.0.0.
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $container)
    {
        return $this($container, MongoLoggerCollector::class);
    }

    public function getOptionsClass(): string
    {
        return Options\MongoLoggerCollector::class;
    }
}
