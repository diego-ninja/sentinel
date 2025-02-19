<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Ninja\Censor\Checkers\TisaneAI;

test('tisane detects abuse and profanity', function (): void {
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'sentiment' => -0.5,
            'abuse' => [
                [
                    'type' => 'bigotry',
                    'severity' => 'high',
                    'text' => 'offensive',
                ],
                [
                    'type' => 'profanity',
                    'severity' => 'high',
                    'text' => 'badword',
                ],
            ],
        ])),
    ]);

    $client = new Client(['handler' => HandlerStack::create($mock)]);
    $checker = new TisaneAI('fake-key', $client);

    $result = $checker->check('offensive content with badword');

    expect($result)
        ->toBeOffensive()
        ->and($result->categories())->toContain(Ninja\Censor\Enums\Category::HateSpeech)
        ->and($result->categories())->toContain(Ninja\Censor\Enums\Category::Profanity)
        ->and($result->words())->toContain('offensive', 'badword')
        ->and($result->sentiment()->value())->toBe(-0.5)
        ->and($result->sentiment()->type())->toBe(Ninja\Censor\Enums\SentimentType::Negative)
        ->and($result->score()->value())->toBeGreaterThan(0.7);
});

test('tisane handles clean content', function (): void {
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'sentiment' => 0.0,
            'abuse' => [],
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
