<?php

namespace tomlankhorst\LaravelAfas;

use Illuminate\Support\Facades\Facade;

class AfasFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ConnectionManager::class;
    }
}
