<?php

declare(strict_types=1);

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Ninja\Sentinel\Analyzers\PrismAI;
use Ninja\Sentinel\Services\Adapters\PrismAdapter;
use Ninja\Sentinel\Services\Pipeline\TransformationPipeline;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Facades\Prism as PrismFacade;
use Prism\Prism\Prism;
use Prism\Prism\Testing\StructuredResponseFake;
use Prism\Prism\Testing\TextResponseFake;

test('Prism provider analyzes responses using the current SDK', function (Provider $provider): void {
    $data = [
        'detected_language' => 'en',
        'is_offensive' => false,
        'offensive_words' => [],
        'categories' => [],
        'confidence' => 1.0,
        'severity' => 0.0,
        'sentiment' => ['type' => 'neutral', 'score' => 0.0],
        'matches' => [],
    ];

    config(['sentinel.services.prism_ai.provider' => $provider, 'sentinel.services.prism_ai.model' => 'test-model']);
    PrismFacade::fake([
        Provider::Gemini === $provider
            ? TextResponseFake::make()->withText(json_encode($data, JSON_THROW_ON_ERROR))
            : StructuredResponseFake::make()->withStructured($data),
    ]);

    $analyzer = new PrismAI(
        new Prism(),
        new PrismAdapter(),
        app(TransformationPipeline::class),
    );

    expect($analyzer->analyze('A useful game review')->offensive())->toBeFalse();
})->with([
    'Anthropic' => Provider::Anthropic,
    'OpenAI' => Provider::OpenAI,
    'Gemini' => Provider::Gemini,
]);

test('Anthropic sends cached system prompts separately from user messages', function (): void {
    config([
        'sentinel.services.prism_ai.provider' => Provider::Anthropic,
        'sentinel.services.prism_ai.model' => 'claude-sonnet-4-5',
        'prism.providers.anthropic.api_key' => 'test-key',
        'prism.providers.anthropic.version' => '2023-06-01',
    ]);
    Http::preventStrayRequests();
    Http::fake([
        'api.anthropic.com/*' => Http::response([
            'id' => 'msg_test',
            'model' => 'claude-sonnet-4-5',
            'type' => 'message',
            'role' => 'assistant',
            'content' => [[
                'type' => 'text',
                'text' => json_encode([
                    'detected_language' => 'en',
                    'is_offensive' => false,
                    'offensive_words' => [],
                    'categories' => [],
                    'confidence' => 1.0,
                    'severity' => 0.0,
                    'sentiment' => ['type' => 'neutral', 'score' => 0.0],
                    'matches' => [],
                ], JSON_THROW_ON_ERROR),
            ]],
            'stop_reason' => 'end_turn',
            'usage' => ['input_tokens' => 10, 'output_tokens' => 10],
        ]),
    ]);

    $analyzer = new PrismAI(
        new Prism(),
        new PrismAdapter(),
        app(TransformationPipeline::class),
    );

    expect($analyzer->analyze('A useful game review')->offensive())->toBeFalse();

    Http::assertSent(function (Request $request): bool {
        expect($request['system'][0]['text'])->toBe(file_get_contents(__DIR__ . '/../../resources/prompts/structured.txt'));
        expect($request['system'][0]['cache_control'])->toBe(['type' => 'ephemeral']);
        expect($request['messages'][0]['role'])->toBe('user');
        expect($request['messages'][0]['content'][0]['text'])->toBe('A useful game review');
        expect($request['messages'][0]['content'][0]['cache_control'])->toBe(['type' => 'ephemeral']);
        expect(array_column($request['messages'], 'role'))->not->toContain('system');

        return true;
    });
    Http::assertSentCount(1);
});
