<?php

namespace tomlankhorst\LaravelAfas;

use iPublications\Profit\ConnectorFilter as DriverConnectorFilter;

class Filter
{
    /**
     * @var DriverConnectorFilter
     */
    protected $driver;

    public function __construct()
    {
        $this->driver = new DriverConnectorFilter();
    }

    public function getDriver() : DriverConnectorFilter
    {
        return $this->driver;
    }

    /**
     * Add an 'and' where clause
     *
     * @param $field
     * @param $operator
     * @param $value
     */
    public function where($field, $operator, $value)
    {
        $this->driver->add($field, $this->matchOperator($operator), $value);
    }

    /**
     * Add on 'or' level and add a 'where' in that new level
     *
     * @param $field
     * @param $operator
     * @param $value
     */
    public function orWhere($field, $operator, $value)
    {
        $this->driver->add_or();

        $this->where($field, $this->matchOperator($operator), $value);
    }

    /**
     * @return bool
     */
    public function isEmpty() : bool
    {
        return $this->getDriver()->get() === null;
    }

    /**
     * Translate operators '=' to their driver representations
     *
     * @param $operator
     * @return int
     */
    protected function matchOperator($operator)
    {
        $operator = trim(strtolower($operator));

        switch ($operator) {
            case '=':
                return DriverConnectorFilter::EQ;
            case 'like':
                return DriverConnectorFilter::LIKE;
            default:
                throw new \InvalidArgumentException("Operator '$operator' not supported.");
        }
    }
}
