<?php

namespace tomlankhorst\LaravelAfas;

use iPublications\Profit\ConnectorFilter as DriverConnectorFilter;
use iPublications\Profit\ConnectorFilter as DriverOp;

class Filter
{
    /**
     * @var DriverConnectorFilter
     */
    protected $driver;

    /**
     * @var array Mapping of filter operators to driver constants
     */
    protected $operatorMap = [
        '=' => DriverOp::EQ,
        '>' => DriverOp::GT,
        '>=' => DriverOp::GT_OR_EQ,
        '<' => DriverOp::LT,
        '<=' => DriverOp::LT_OR_EQ,
        'like' => DriverOp::LIKE,
    ];

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

        $this->where($field, $operator, $value);
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

        if (!array_key_exists($operator, $this->operatorMap)) {
            throw new \InvalidArgumentException("Operator '$operator' not supported.");
        }

        return $this->operatorMap[$operator];
    }
}
