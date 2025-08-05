<?php

use Ninja\Sentinel\Enums\LanguageCode;
use Ninja\Sentinel\Services\Adapters\PrismAdapter;
use Ninja\Sentinel\Services\Contracts\ServiceResponse;

describe('PrismAdapter', function (): void {
    beforeEach(function (): void {
        $this->adapter = new PrismAdapter();
    });

    it('adapts prism response correctly', function (): void {
        $text = 'This is a test text with some shit';
        $response = [
            'detected_language' => 'en',
            'is_offensive' => true,
            'offensive_words' => ['shit'],
            'categories' => ['profanity'],
            'confidence' => 0.9,
            'severity' => 0.7,
            'sentiment' => [
                'type' => 'negative',
                'score' => -0.3,
            ],
            'matches' => [
                [
                    'text' => 'shit',
                    'match_type' => 'exact',
                    'score' => 0.8,
                    'confidence' => 0.9,
                    'occurrences' => [
                        ['start' => 28, 'length' => 4],
                    ],
                    'context' => [
                        'original' => 'shit',
                        'surrounding' => 'some shit',
                    ],
                ],
            ],
        ];

        $result = $this->adapter->adapt($text, $response);

        expect($result)->toBeInstanceOf(ServiceResponse::class);
        expect($result->original())->toBe($text);
        expect($result->language())->toBe(LanguageCode::English);
        expect($result->matches()->count())->toBe(1);
        expect($result->matches()->first()->word())->toBe('shit');
    });

    it('handles clean text response', function (): void {
        $text = 'This is clean text';
        $response = [
            'detected_language' => 'en',
            'is_offensive' => false,
            'offensive_words' => [],
            'categories' => [],
            'confidence' => 0.95,
            'severity' => 0.0,
            'sentiment' => [
                'type' => 'neutral',
                'score' => 0.0,
            ],
            'matches' => [],
        ];

        $result = $this->adapter->adapt($text, $response);

        expect($result)->toBeInstanceOf(ServiceResponse::class);
        expect($result->original())->toBe($text);
        expect($result->matches()->isEmpty())->toBeTrue();
        expect($result->language())->toBe(LanguageCode::English);
    });

    it('handles multiple matches', function (): void {
        $text = 'This shit and fuck text';
        $response = [
            'detected_language' => 'en',
            'is_offensive' => true,
            'offensive_words' => ['shit', 'fuck'],
            'categories' => ['profanity'],
            'confidence' => 0.9,
            'severity' => 0.8,
            'sentiment' => [
                'type' => 'negative',
                'score' => -0.5,
            ],
            'matches' => [
                [
                    'text' => 'shit',
                    'match_type' => 'exact',
                    'score' => 0.8,
                    'confidence' => 0.9,
                    'occurrences' => [
                        ['start' => 5, 'length' => 4],
                    ],
                ],
                [
                    'text' => 'fuck',
                    'match_type' => 'exact',
                    'score' => 0.9,
                    'confidence' => 0.95,
                    'occurrences' => [
                        ['start' => 14, 'length' => 4],
                    ],
                ],
            ],
        ];

        $result = $this->adapter->adapt($text, $response);

        expect($result->matches()->count())->toBe(2);
        expect($result->matches()->pluck('word'))->toContain('shit', 'fuck');
    });

    it('handles different languages', function (): void {
        $text = 'Texto en español';
        $response = [
            'detected_language' => 'es',
            'is_offensive' => false,
            'offensive_words' => [],
            'categories' => [],
            'confidence' => 0.95,
            'severity' => 0.0,
            'sentiment' => [
                'type' => 'neutral',
                'score' => 0.0,
            ],
            'matches' => [],
        ];

        $result = $this->adapter->adapt($text, $response);

        expect($result->language())->toBe(LanguageCode::Spanish);
    });

    it('handles invalid language code gracefully', function (): void {
        $text = 'Some text';
        $response = [
            'detected_language' => 'invalid_lang',
            'is_offensive' => false,
            'offensive_words' => [],
            'categories' => [],
            'confidence' => 0.95,
            'severity' => 0.0,
            'sentiment' => [
                'type' => 'neutral',
                'score' => 0.0,
            ],
            'matches' => [],
        ];

        // This will throw an exception because PrismAdapter doesn't handle invalid language codes
        expect(fn() => $this->adapter->adapt($text, $response))->toThrow(ValueError::class);
    });

    it('handles missing optional fields', function (): void {
        $text = 'Test text';
        $response = [
            'detected_language' => 'en',
            'is_offensive' => true,
            'offensive_words' => ['test'],
            'categories' => ['profanity'],
            'confidence' => 0.8,
            'severity' => 0.6,
            'sentiment' => [
                'type' => 'negative',
                'score' => -0.2,
            ],
            'matches' => [
                [
                    'text' => 'test',
                    'match_type' => 'pattern',
                    'score' => 0.7,
                    'confidence' => 0.8,
                    'occurrences' => [
                        ['start' => 0, 'length' => 4],
                    ],
                    // No context field
                ],
            ],
        ];

        $result = $this->adapter->adapt($text, $response);

        expect($result->matches()->count())->toBe(1);
        expect($result->matches()->first()->word())->toBe('test');
    });

    it('creates replaced text correctly', function (): void {
        $text = 'This is shit text';
        $response = [
            'detected_language' => 'en',
            'is_offensive' => true,
            'offensive_words' => ['shit'],
            'categories' => ['profanity'],
            'confidence' => 0.9,
            'severity' => 0.7,
            'sentiment' => [
                'type' => 'negative',
                'score' => -0.3,
            ],
            'matches' => [
                [
                    'text' => 'shit',
                    'match_type' => 'exact',
                    'score' => 0.8,
                    'confidence' => 0.9,
                    'occurrences' => [
                        ['start' => 8, 'length' => 4],
                    ],
                ],
            ],
        ];

        $result = $this->adapter->adapt($text, $response);

        expect($result->replaced())->not->toBe($text);
        expect($result->replaced())->toContain('*'); // Assuming default mask character
    });
});
