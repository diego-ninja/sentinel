<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Ninja\Sentinel\Analyzers\PerspectiveAI;
use Ninja\Sentinel\Services\Adapters\PerspectiveAdapter;
use Ninja\Sentinel\Services\Pipeline\TransformationPipeline;

test('perspective detects toxic content', function (): void {
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'attributeScores' => [
                'TOXICITY' => [
                    'summaryScore' => [
                        'value' => 0.9,
                        'confidence' => 0.8,
                    ],
                ],
                'SEVERE_TOXICITY' => [
                    'summaryScore' => [
                        'value' => 0.85,
                        'confidence' => 0.75,
                    ],
                ],
            ],
        ])),
    ]);

    $client = new Client(['handler' => HandlerStack::create($mock)]);
    $checker = new PerspectiveAI(
        key: 'fake-key',
        adapter: new PerspectiveAdapter(),
        pipeline: app(TransformationPipeline::class),
        client: $client,
    );

    $result = $checker->analyze('toxic content');

    expect($result)
        ->toBeOffensive()
        ->and($result->score()->value())->toBeGreaterThan(0.7)
        ->and($result->confidence()->value())->toBeGreaterThan(0.7)
        ->and($result->categories())->toContain(Ninja\Sentinel\Enums\Category::Toxicity);
});

test('perspective handles clean content', function (): void {
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'attributeScores' => [
                'TOXICITY' => [
                    'summaryScore' => [
                        'value' => 0.1,
                        'confidence' => 0.9,
                    ],
                ],
            ],
        ])),
    ]);

    $client = new Client(['handler' => HandlerStack::create($mock)]);
    $checker = new PerspectiveAI(
        key: 'fake-key',
        adapter: new PerspectiveAdapter(),
        pipeline: app(TransformationPipeline::class),
        client: $client,
    );

    $result = $checker->analyze('clean content');

    expect($result)
        ->toBeClean()
        ->and($result->score()->value())->toBeLessThan(0.1)
        ->and($result->confidence()->value())->toBeGreaterThan(0.7)
        ->and($result->categories())->toBeEmpty()
        ->and($result->replaced())->toBe('clean content')
        ->and($result->original())->toBe('clean content')
        ->and($result->words())->toBeEmpty();

});
