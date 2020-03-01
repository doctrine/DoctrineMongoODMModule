<?php

declare(strict_types=1);

namespace DoctrineMongoODMModule\Options;

use Laminas\Stdlib\AbstractOptions;

/**
 * Connection options for doctrine mongo
 *
 * @link    http://www.doctrine-project.org/
 */
class Connection extends AbstractOptions
{
    /**
     * The server with the mongo instance you want to connect to
     *
     * @var string
     */
    protected $server = 'localhost';

    /**
     * Port to connect over
     *
     * @var string
     */
    protected $port = '27017';

    /**
     * Username if using mongo auth
     *
     * @var string
     */
    protected $user = null;

    /**
     * Password if using mongo auth
     *
     * @var string
     */
    protected $password = null;

    /**
     * If you want to connect to a specific database
     *
     * @var string
     */
    protected $dbname = null;

    /**
     * If you want to provide a custom connection string
     *
     * @var string
     */
    protected $connectionString = null;

    /**
     * Further connection options defined by mongodb-odm
     *
     * @var mixed[]
     */
    protected $options = [];

    public function getServer() : string
    {
        return $this->server;
    }

    public function setServer(?string $server) : Connection
    {
        $this->server = (string) $server;

        return $this;
    }

    public function getPort() : string
    {
        return $this->port;
    }

    public function setPort(?string $port) : Connection
    {
        $this->port = (string) $port;

        return $this;
    }

    public function getUser() : ?string
    {
        return $this->user;
    }

    public function setUser(?string $user) : Connection
    {
        $this->user = (string) $user;

        return $this;
    }

    public function getPassword() : ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password) : self
    {
        $this->password = (string) $password;

        return $this;
    }

    public function getDbname() : string
    {
        return $this->dbname;
    }

    public function setDbname(?string $dbname) : Connection
    {
        $this->dbname = (string) $dbname;

        return $this;
    }

    public function getConnectionString() : ?string
    {
        return $this->connectionString;
    }

    public function setConnectionString(?string $connectionString) : Connection
    {
        $this->connectionString = (string) $connectionString;

        return $this;
    }

    /**
     * @return mixed[]
     */
    public function getOptions() : array
    {
        return $this->options;
    }

    /**
     * @param mixed[] $options
     */
    public function setOptions(array $options) : Connection
    {
        $this->options = $options;

        return $this;
    }
}
