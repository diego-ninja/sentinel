<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Ninja\Censor\Checkers\TisaneAI;

test('tisane detects abuse and profanity', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'abuse' => [
                [
                    'type' => 'hate_speech',
                    'severity' => 'high',
                    'text' => 'offensive',
                ],
            ],
            'profanity' => [
                [
                    'text' => 'badword',
                    'type' => 'curse',
                ],
            ],
        ])),
    ]);

    $client = new Client(['handler' => HandlerStack::create($mock)]);
    $checker = new TisaneAI('fake-key', $client);

    $result = $checker->check('offensive content with badword');

    expect($result)
        ->toBeOffensive()
        ->and($result->categories())->toContain('hate_speech', 'profanity')
        ->and($result->words())->toContain('offensive', 'badword')
        ->and($result->score()->value())->toBeGreaterThan(0.7);
});

test('tisane handles clean content', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'abuse' => [],
            'profanity' => [],
        ])),
    ]);

    $client = new Client(['handler' => HandlerStack::create($mock)]);
    $checker = new TisaneAI('fake-key', $client);

    $result = $checker->check('clean content');

    expect($result)
        ->toBeClean()
        ->and($result->categories())->toBeEmpty()
        ->and($result->words())->toBeEmpty()
        ->and($result->score()->value())->toBe(0.0);
});
