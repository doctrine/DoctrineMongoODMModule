<?php

declare(strict_types=1);

namespace DoctrineMongoODMModule\Logging;

/**
 * Includes executed queries in a Debug Stack
 *
 * @link    www.doctrine-project.org
 */
class DebugStack implements Logger
{
    /** @var mixed[] $queries Executed queries. */
    public $queries = [];

    /** @var bool $enabled If Debug Stack is enabled (log queries) or not. */
    public $enabled = true;

    /** @var mixed $currentQuery */
    protected $currentQuery = 0;

    /**
     * {@inheritdoc}
     */
    public function log(array $logs):void
    {
        if (! $this->enabled) {
            return;
        }

        $this->queries[++$this->currentQuery] = $logs;
    }
}
