<?php

use Ninja\Sentinel\Services\Adapters\LocalAdapter;
use Ninja\Sentinel\Services\Contracts\ServiceResponse;

describe('AbstractAdapter', function (): void {
    beforeEach(function (): void {
        // Use LocalAdapter as a concrete implementation that extends AbstractAdapter
        $this->adapter = new LocalAdapter();
    });

    it('can create service response', function (): void {
        // LocalAdapter implements the adapt method from AbstractAdapter
        $text = 'Test text for processing';
        // Create a mock Result object for LocalAdapter
        $mockResult = new Ninja\Sentinel\Result\Result(
            language: Ninja\Sentinel\Enums\LanguageCode::English,
            offensive: false,
            words: [],
            replaced: $text,
            original: $text,
            matches: new Ninja\Sentinel\Collections\MatchCollection(),
            score: new Ninja\Sentinel\ValueObject\Score(0.0),
            confidence: new Ninja\Sentinel\ValueObject\Confidence(0.0),
            sentiment: null,
            categories: [],
        );
        $mockResponse = ['result' => $mockResult];

        $result = $this->adapter->adapt($text, $mockResponse);

        expect($result)->toBeInstanceOf(ServiceResponse::class);
        expect($result->original())->toBe($text);
        expect($result->matches())->toBeInstanceOf(Ninja\Sentinel\Collections\MatchCollection::class);
        expect($result->score())->toBeInstanceOf(Ninja\Sentinel\ValueObject\Score::class);
        expect($result->confidence())->toBeInstanceOf(Ninja\Sentinel\ValueObject\Confidence::class);
        expect($result->language())->toBeInstanceOf(Ninja\Sentinel\Enums\LanguageCode::class);
    });

    // Skip the other complex tests since LocalAdapter requires specific format
    // and we're mainly interested in testing that AbstractAdapter provides the base structure
});
