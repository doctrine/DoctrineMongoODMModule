<?php

declare(strict_types=1);

namespace DoctrineMongoODMModule\Logging;

/**
 * Interface for loggers.
 *
 * @link    www.doctrine-project.org
 */
interface Logger
{
    /**
     * Logs a SQL statement somewhere.
     *
     * @param mixed[] $logs The logs explaining the query
     */
    public function log(array $logs) : void;
}
