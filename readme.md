Laravel Afas
=======

[![Build Status](https://travis-ci.org/tomlankhorst/laravel-afas.svg?branch=master)](https://travis-ci.org/tomlankhorst/laravel-afas)

A module that integrates `tomlankhorst/afas-profit` with Laravel.

Configuration
----

    composer require tomlankhorst/laravel-afas ^1.0
    
Add an `afas.php` configuration file.

```php
<?php

return [
    'connections' => [
        'default' => [
            'location' => env('AFAS_LOCATION'),
            'connectors' => [
                'products' => [
                    'id' => env('AFAS_PRODUCTS_CONNECTOR'),
                    'environment' => env('AFAS_ENVIRONMENT'),
                    'token' => env('AFAS_TOKEN'),
                ],
            ]
        ],
    ],
];
```

Usage
---

As a facade

```php
$results = Afas::connector('products')
    ->where('sku', 'LIKE', 'XY%')
    ->orWhere('sku', 'LIKE', 'XXY%')
    ->take(10)
    ->skip(10)
    ->get();
```