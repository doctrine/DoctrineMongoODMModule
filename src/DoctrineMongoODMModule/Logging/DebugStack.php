<?php
namespace DoctrineMongoODMModule\Logging;

/**
 * Includes executed queries in a Debug Stack
 *
 * @license MIT
 * @link    www.doctrine-project.org
 */
class DebugStack implements Logger
{
    /** @var array $queries Executed queries. */
    public $queries = [];

    /** @var boolean $enabled If Debug Stack is enabled (log queries) or not. */
    public $enabled = true;

    protected $currentQuery = 0;

    /**
     * {@inheritdoc}
     */
    public function log(array $logs)
    {
        if ($this->enabled) {
            $this->queries[++$this->currentQuery] = $logs;
        }
    }
}
