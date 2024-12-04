<?php

namespace Tests\Unit\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class TestResponse
{
    public static function mockClient(array $responses): Client
    {
        $mock = new MockHandler(
            array_map(
                fn ($response) => new Response(
                    200,
                    [],
                    json_encode($response)
                ),
                $responses
            )
        );

        return new Client(['handler' => HandlerStack::create($mock)]);
    }
}
