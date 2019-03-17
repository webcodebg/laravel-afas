<?php

namespace Tests\Feature\Afas;

use tomlankhorst\LaravelAfas\Connection;
use tomlankhorst\LaravelAfas\ConnectionManager;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use tomlankhorst\LaravelAfas\Tests\TestCase;

class SmokeTest extends TestCase
{
    protected $config = [
        'connections' => [
            'default' => [
                'location' => 'http://some.afas.endpoint.net/ProfitServices/GetConnector.asmx',
                'connectors' => [
                    'stock' => [
                        'id' => 'MyStockConnector',
                        'environment' => 'MyAfasEnvironment',
                        'token' => '<token><version>1</version><data>HARTENTINGTHENTIONTYLIAKLICRUENTHWHOLAITCHEMANSELIVERCERSASTILOCI</data></token>'
                    ]
                ]
            ],
        ],
    ];

    public function testGetDataWithOptions()
    {
        $mock = new MockHandler([
            new Response(200, [], $this->getAsset('GetDataWithOptionsResponse.xml'))
        ]);
        $handler = HandlerStack::create($mock);
        $client = new \GuzzleHttp\Client(compact('handler'));

        $connector = $this->makeConnection($client)->connector('stock');

        $result = $connector->skip(0)->take(10)->get();

        $this->assertCount(10, $result);

        $this->assertEquals([
            'Code' => 'Art',
            'Itemcode' => 'XYS407',
            'Magazijn' => 'LVB',
            'Op_voorraad' => '1'
        ], (array)$result[0]);
    }

    protected function makeConnection(\GuzzleHttp\Client $client = null) : Connection
    {
        $manager = new ConnectionManager($this->config, $client);

        return $manager->connection('default');
    }
}
