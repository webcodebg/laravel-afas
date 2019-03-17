<?php

namespace tomlankhorst\LaravelAfas;

use Illuminate\Support\ServiceProvider;

class AfasServiceProvider extends ServiceProvider
{
    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->app->singleton(ConnectionManager::class, function ($app) {
            return new ConnectionManager($app['config']->get('afas'));
        });

        $this->app->bind(Connection::class);
        $this->app->bind(Connector::class);
    }

    /**
     * @inheritdoc
     */
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/afas.php',
            'afas'
        );
    }
}
