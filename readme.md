<h1 align="center">Laravel Afas</h1>

<p align="center">
<a href="https://travis-ci.org/tomlankhorst/laravel-afas"><img src="https://travis-ci.org/tomlankhorst/laravel-afas.svg?branch=master" alt="Build Status"></a>
<a href="https://packagist.org/packages/tomlankhorst/laravel-afas"><img src="https://poser.pugx.org/tomlankhorst/laravel-afas/v/stable" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/tomlankhorst/laravel-afas"><img src="https://poser.pugx.org/tomlankhorst/laravel-afas/license" alt="License"></a>
<a href="https://packagist.org/packages/tomlankhorst/laravel-afas"><img src="https://poser.pugx.org/tomlankhorst/laravel-afas/downloads" alt="Total Downloads"></a>
</p>

**A module that integrates `tomlankhorst/afas-profit` with Laravel.**

Requirements
----

- PHP 7.2 + 
- Laravel 5.5, 5.7, 5.8 _(5.6 is EOL)_

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

Credits
---

Thanks to iPublications for developing [iPublications/AFAS-ProfitClass-PHP](https://github.com/iPublications/AFAS-ProfitClass-PHP).