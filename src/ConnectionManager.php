<?php

namespace tomlankhorst\LaravelAfas;

use Illuminate\Contracts\Container\Container;

class ConnectionManager
{
    protected $config;

    /**
     * @var Container
     */
    protected $app;

    /**
     * ConnectionManager
     *
     * @param Container $app
     * @param array $config configuration
     */
    public function __construct(Container $app, array $config)
    {
        $this->app = $app;
        $this->config = $config;
    }

    /**
     * @param string $name of the connection
     * @return Connection
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function connection(string $name = 'default') : Connection
    {
        if (!array_key_exists($name, $this->config['connections'])) {
            throw new \InvalidArgumentException("Connection $name is not configured.");
        }

        return $this->app->make(Connection::class, [
            'manager' => $this,
            'config' => $this->config['connections'][$name],
        ]);
    }

    /**
     * @param string $name of the connector
     * @param string $connection name of the connection
     * @return Connector
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function connector(string $name, string $connection = "default") : Connector
    {
        return $this->connection($connection)->connector($name);
    }

    /**
     * @return Container
     */
    public function getApp() : Container
    {
        return $this->app;
    }
}
