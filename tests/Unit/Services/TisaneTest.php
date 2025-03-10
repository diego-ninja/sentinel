<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Ninja\Sentinel\Analyzers\TisaneAI;
use Ninja\Sentinel\Services\Adapters\TisaneAdapter;
use Ninja\Sentinel\Services\Pipeline\TransformationPipeline;

test('tisane detects abuse and profanity', function (): void {
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'sentiment' => -0.5,
            'abuse' => [
                [
                    'offset' => 0,
                    'length' => 9,
                    'type' => 'bigotry',
                    'severity' => 'high',
                    'text' => 'offensive',
                ],
                [
                    'offset' => 24,
                    'length' => 7,
                    'type' => 'profanity',
                    'severity' => 'high',
                    'text' => 'badword',
                ],
            ],
        ])),
    ]);

    $client = new Client(['handler' => HandlerStack::create($mock)]);
    $checker = new TisaneAI(
        key: 'fake-key',
        adapter: new TisaneAdapter(),
        pipeline: app(TransformationPipeline::class),
        client: $client,
    );

    $result = $checker->analyze('offensive content with badword');

    expect($result)
        ->toBeOffensive()
        ->and($result->categories())->toContain(Ninja\Sentinel\Enums\Category::HateSpeech)
        ->and($result->categories())->toContain(Ninja\Sentinel\Enums\Category::Profanity)
        ->and($result->words())->toContain('offensive', 'badword')
        ->and($result->sentiment()->value())->toBe(-0.5)
        ->and($result->sentiment()->type())->toBe(Ninja\Sentinel\Enums\SentimentType::Negative)
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
    $checker = new TisaneAI(
        key: 'fake-key',
        adapter: new TisaneAdapter(),
        pipeline: app(TransformationPipeline::class),
        client: $client,
    );

    $result = $checker->analyze('clean content');

    expect($result)
        ->toBeClean()
        ->and($result->categories())->toBeEmpty()
        ->and($result->words())->toBeEmpty()
        ->and($result->score()->value())->toBe(0.0);
});
