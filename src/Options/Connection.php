<?php

declare(strict_types=1);

namespace DoctrineMongoODMModule\Options;

use Laminas\Stdlib\AbstractOptions;

/**
 * Connection options for doctrine mongo
 *
 * @extends AbstractOptions<int|string|array|null>
 */
final class Connection extends AbstractOptions
{
    /**
     * The server with the mongo instance you want to connect to
     */
    protected string $server = 'localhost';

    /**
     * Port to connect over
     */
    protected string $port = '27017';

    /**
     * Username if using mongo auth
     */
    protected string|null $user = null;

    /**
     * Password if using mongo auth
     */
    protected string|null $password = null;

    /**
     * If you want to connect to a specific database
     */
    protected string|null $dbname = null;

    /**
     * If you want to provide a custom connection string
     */
    protected string|null $connectionString = null;

    /**
     * Further connection options defined by mongodb-odm
     *
     * @var mixed[]
     */
    protected array $options = [];

    /**
     * Driver specific connection options defined by mongodb-odm
     *
     * @var mixed[]
     */
    protected array $driverOptions = [];

    public function getServer(): string
    {
        return $this->server;
    }

    public function setServer(string|null $server): self
    {
        $this->server = (string) $server;

        return $this;
    }

    public function getPort(): string
    {
        return $this->port;
    }

    public function setPort(string|null $port): self
    {
        $this->port = (string) $port;

        return $this;
    }

    public function getUser(): string|null
    {
        return $this->user;
    }

    public function setUser(string|null $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPassword(): string|null
    {
        return $this->password;
    }

    public function setPassword(string|null $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getDbname(): string|null
    {
        return $this->dbname;
    }

    public function setDbname(string|null $dbname): self
    {
        $this->dbname = (string) $dbname;

        return $this;
    }

    public function getConnectionString(): string|null
    {
        return $this->connectionString;
    }

    public function setConnectionString(string|null $connectionString): self
    {
        $this->connectionString = (string) $connectionString;

        return $this;
    }

    /** @return mixed[] */
    public function getOptions(): array
    {
        return $this->options;
    }

    /** @param mixed[] $options */
    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    /** @return mixed[] */
    public function getDriverOptions(): array
    {
        return $this->driverOptions;
    }

    /** @param mixed[] $driverOptions */
    public function setDriverOptions(array $driverOptions): self
    {
        $this->driverOptions = $driverOptions;

        return $this;
    }
}
