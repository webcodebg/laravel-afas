<?php

namespace tomlankhorst\LaravelAfas\Tests;

use Orchestra\Testbench\TestCase as BenchTestCase;

class TestCase extends BenchTestCase
{
    /**
     * @inheritdoc
     */
    protected function getPackageProviders($app)
    {
        return ['tomlankhorst\LaravelAfas\AfasServiceProvider'];
    }

    /**
     * @inheritdoc
     */
    protected function getPackageAliases($app)
    {
        return [
            'Afas' => 'tomlankhorst\LaravelAfas\AfasFacade',
        ];
    }

    /**
     * @param string $filename
     * @return string
     */
    public function getAsset(string $filename) : string
    {
        return file_get_contents(__DIR__."/assets/$filename");
    }
}
