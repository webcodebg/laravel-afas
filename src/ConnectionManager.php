<?php

namespace tomlankhorst\LaravelAfas;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class ConnectionManager
{
    protected $config;

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * ConnectionManager
     *
     * @param array $config configuration
     * @param ClientInterface $client
     */
    public function __construct(array $config, ClientInterface $client = null)
    {
        $this->config = $config;
        $this->client = $client ?? new Client;
    }

    /**
     * @param string $name of the connection
     * @return Connection
     */
    public function connection(string $name = 'default') : Connection
    {
        if (!array_key_exists($name, $this->config['connections'])) {
            throw new \InvalidArgumentException("Connection $name is not configured.");
        }

        $config = $this->config['connections'][$name];

        return new Connection($this, $config, $this->client);
    }

    /**
     * @param string $name of the connector
     * @param string $connection name of the connection
     * @return Connector
     */
    public function connector(string $name, string $connection = "default") : Connector
    {
        return $this->connection($connection)->connector($name);
    }
}
