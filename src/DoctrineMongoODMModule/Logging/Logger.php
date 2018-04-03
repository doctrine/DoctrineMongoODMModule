<?php
namespace DoctrineMongoODMModule\Logging;

/**
 * Interface for loggers.
 *
 * @license MIT
 * @link    www.doctrine-project.org
 */
interface Logger
{
    /**
     * Logs a SQL statement somewhere.
     *
     * @param array $logs The logs explaining the query
     * @return void
     */
    public function log(array $logs);
}
