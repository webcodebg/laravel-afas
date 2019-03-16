<?php

return [

    /**
     * Connections to independent Afas servers
     */
    'connections' => [

        'default' => [

            /**
             * The location URL of the profit service
             *
             * e.g. https://my.afas.net/ProfitServices/GetConnector.asmx
             */
            'location' => env('AFAS_LOCATION'),

            /**
             * Array of connectors
             */
            'connectors' => [

                /**
                 * Products connector, with ID, token and environment
                 */
                'products' => [
                    'id' => env('AFAS_PRODUCTS_CONNECTOR'),
                    'environment' => env('AFAS_ENVIRONMENT'),
                    'token' => env('AFAS_TOKEN'),
                ],
                'stock' => [
                    'id' => env('AFAS_STOCK_CONNECTOR'),
                    'environment' => env('AFAS_ENVIRONMENT'),
                    'token' => env('AFAS_TOKEN'),
                ]
            ]
        ],
    ],

];
