<?php

declare(strict_types=1);

namespace DoctrineMongoODMModule\Logging;

use function var_dump;

/**
 * A logger that logs to the standard output using echo/var_dump.
 *
 * @link    www.doctrine-project.org
 */
class EchoLogger implements Logger
{
    /**
     * {@inheritdoc}
     */
    public function log(array $logs)
    {
        if (! $logs) {
            return;
        }

        var_dump($logs);
    }
}
