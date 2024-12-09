<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Ninja\Censor\Checkers\AzureAI;

test('azure detects harmful content', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'categoriesAnalysis' => [
                [
                    'category' => 'Hate',
                    'severity' => 'High',
                    'confidence' => 0.95,
                ],
                [
                    'category' => 'Violence',
                    'severity' => 'Medium',
                    'confidence' => 0.85,
                ],
            ],
            'blocklistsMatch' => [
                ['text' => 'offensive'],
            ],
        ])),
    ]);

    $client = new Client(['handler' => HandlerStack::create($mock)]);
    $checker = new AzureAI('endpoint', 'fake-key', '2024-09-01', $client);

    $result = $checker->check('offensive content');

    expect($result)
        ->toBeOffensive()
        ->and($result->categories())->toContain('hate_speech', 'violence')
        ->and($result->words())->toContain('offensive')
        ->and($result->confidence()->value())->toBeGreaterThan(0.8);
});

test('azure handles clean content', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'categoriesAnalysis' => [
                [
                    'category' => 'Hate',
                    'severity' => 'Low',
                    'confidence' => 0.95,
                ],
            ],
            'blocklistsMatch' => [],
        ])),
    ]);

    $client = new Client(['handler' => HandlerStack::create($mock)]);
    $checker = new AzureAI('endpoint', 'fake-key', '2024-09-01', $client);

    $result = $checker->check('clean content');

    expect($result)
        ->toBeClean()
        ->and($result->categories())->toBeEmpty()
        ->and($result->words())->toBeEmpty()
        ->and($result->confidence()->value())->toBeGreaterThan(0.8)
        ->and($result->score()->value())->toBeLessThan(0.7);

});
