<?php

namespace tomlankhorst\LaravelAfas\Tests;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Arr;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * @var array
     */
    protected $history = [];

    /**
     * @param $responses
     * @return HandlerStack
     */
    protected function makeMockStack($responses)
    {
        $responses = Arr::wrap($responses);

        foreach ($responses as &$response) {
            if (!$response instanceof Response && !$response instanceof RequestException) {
                $response = new Response(200, [], $response);
            }
        }

        $stack = HandlerStack::create(new MockHandler($responses));
        $stack->push(Middleware::history($this->history));

        return $stack;
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
