<?php

namespace tomlankhorst\LaravelAfas;

use GuzzleHttp\ClientInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use iPublications\Profit\AppConnectorGet;
use iPublications\Profit\Connector as DriverConnector;
use iPublications\Profit\GuzzleAdapterClient;

class Connector
{

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var DriverConnector
     */
    protected $connector;

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * Connector
     * @param Connection $connection
     * @param array $config
     */
    public function __construct(Connection $connection, array $config)
    {
        $this->connection = $connection;
        $this->config = $config;

        $this->filter = new Filter();

        $this->connector = new AppConnectorGet(clone $this->connection->getDriver());
        $this->connector->SetClient(
            new GuzzleAdapterClient($this->getClient())
        );
        $this->connector->SetToken($this->config['token']);
        $this->connector->SetConnectorId($this->config['id']);
    }

    /**
     * Get N records
     *
     * @param int $value
     * @return Connector
     */
    public function take(int $value) : self
    {
        $this->connector->SetTake($value);

        return $this;
    }

    /**
     * Skip N records
     *
     * @param int $value
     * @return Connector
     */
    public function skip(int $value) : self
    {
        $this->connector->SetSkip($value);

        return $this;
    }

    /**
     * Execute the request and return the result
     *
     * @return Collection
     * @throws \Exception
     */
    public function get() : Collection
    {
        if (!$this->filter->isEmpty()) {
            $this->connector->SetFilter($this->filter->getDriver());
        }

        $this->connector->Execute();

        $results = Collection::make(Arr::wrap($this->connector->GetResults()));

        foreach ($results as $key => $result) {
            $results[$key] = (array)$result;
        }

        return $results;
    }

    public function getClient() : ClientInterface
    {
        return $this->connection->getClient();
    }

    public function __call($name, $arguments)
    {
        /**
         * Proxy filters
         */
        if (in_array($name, ['where', 'orWhere'])) {
            $this->filter->$name(...$arguments);

            return $this;
        }

        return null;
    }
}
