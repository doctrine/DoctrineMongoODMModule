<?php
namespace DoctrineMongoODMModule\Logging;

/**
 * A logger that logs to the standard output using echo/var_dump.
 *
 * @license MIT
 * @link    www.doctrine-project.org
 */
class EchoLogger implements Logger
{
    /**
     * {@inheritdoc}
     */
    public function log(array $logs)
    {
        if ($logs) {
            var_dump($logs);
        }
    }
}
