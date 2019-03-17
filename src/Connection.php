<?php

namespace tomlankhorst\LaravelAfas;

use GuzzleHttp\ClientInterface;
use iPublications\Profit\Connection as DriverConnection;

class Connection
{

    /**
     * @var ConnectionManager
     */
    protected $manager;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var DriverConnection
     */
    protected $connection;

    /**
     * Connection
     *
     * @param ConnectionManager $manager
     * @param array $config
     * @param ClientInterface $client HTTP Client
     */
    public function __construct(ConnectionManager $manager, array $config, ClientInterface $client)
    {
        $this->manager = $manager;
        $this->config = $config;
        $this->client = $client;

        $this->connection = new DriverConnection;

        $this->connection->SetTargetURL($config['location']);
    }

    /**
     * Get connector
     *
     * @param string $name of the connector
     * @return Connector
     */
    public function connector(string $name) : Connector
    {
        if (!array_key_exists($name, $this->config['connectors'])) {
            throw new \InvalidArgumentException("Connector $name is not configured.");
        }

        $config = $this->config['connectors'][$name];

        return new Connector($this, $config);
    }

    public function getManager() : ConnectionManager
    {
        return $this->manager;
    }

    public function getClient() : ClientInterface
    {
        return $this->client;
    }

    public function getDriver() : DriverConnection
    {
        return $this->connection;
    }
}
