<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Ninja\Sentinel\Checkers\AzureAI;
use Ninja\Sentinel\Services\Adapters\AzureAdapter;
use Ninja\Sentinel\Services\Pipeline\TransformationPipeline;

test('azure detects harmful content', function (): void {
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
    $checker = new AzureAI(
        endpoint: 'endpoint',
        key: 'fake-key',
        version: '2024-09-01',
        adapter: new AzureAdapter(),
        pipeline: app(TransformationPipeline::class),
        httpClient: $client,
    );

    $result = $checker->check('offensive content');

    expect($result)
        ->toBeOffensive()
        ->and($result->categories())->toContain(Ninja\Sentinel\Enums\Category::HateSpeech, Ninja\Sentinel\Enums\Category::Violence)
        ->and($result->words())->toContain('offensive')
        ->and($result->confidence()->value())->toBeGreaterThan(0.8);
});

test('azure handles clean content', function (): void {
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
    $checker = new AzureAI(
        endpoint: 'endpoint',
        key: 'fake-key',
        version: '2024-09-01',
        adapter: new AzureAdapter(),
        pipeline: app(TransformationPipeline::class),
        httpClient: $client,
    );

    $result = $checker->check('clean content');

    expect($result)
        ->toBeClean()
        ->and($result->categories())->toBeEmpty()
        ->and($result->words())->toBeEmpty()
        ->and($result->confidence()->value())->toBeGreaterThan(0.8)
        ->and($result->score()->value())->toBeLessThan(0.7);

});
