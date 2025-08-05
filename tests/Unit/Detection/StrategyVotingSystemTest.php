<?php

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Collections\StrategyCollection;
use Ninja\Sentinel\Detection\Contracts\DetectionStrategy;
use Ninja\Sentinel\Detection\StrategyVotingSystem;
use Ninja\Sentinel\Enums\LanguageCode;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Language\Language;
use Ninja\Sentinel\ValueObject\Coincidence;
use Ninja\Sentinel\ValueObject\Confidence;
use Ninja\Sentinel\ValueObject\Position;
use Ninja\Sentinel\ValueObject\Score;

describe('StrategyVotingSystem', function (): void {
    beforeEach(function (): void {
        $this->language = new Language([
            'words' => [
                'offensive' => ['fuck', 'shit', 'damn'],
                'intensifiers' => ['very', 'extremely'],
                'modifiers' => ['negative' => ['not'], 'positive' => ['really']],
                'quote' => ['"', "'"],
                'excuse' => ['sorry', 'excuse'],
            ],
            'pronouns' => ['i', 'you', 'he', 'she'],
            'prefixes' => ['un', 're'],
            'suffixes' => ['ing', 'ed', 'er'],
            'markers' => ['the', 'and', 'or'],
            'contexts' => [],
            'patterns' => ['word_specific' => []],
            'rules' => [],
        ], LanguageCode::English);
    });

    it('handles empty strategy collection', function (): void {
        $emptyStrategies = new StrategyCollection();
        $votingSystem = new StrategyVotingSystem($emptyStrategies);

        $result = $votingSystem->detect('This is fuck text', $this->language);

        expect($result)->toBeInstanceOf(MatchCollection::class);
        expect($result->isEmpty())->toBeTrue();
    });

    it('works with mock strategy that returns matches', function (): void {
        // Create a mock strategy that always returns a match for 'fuck'
        $mockStrategy = new class () implements DetectionStrategy {
            public function detect(string $text, ?Language $language = null): MatchCollection
            {
                $matches = new MatchCollection();

                if (str_contains(mb_strtolower($text), 'fuck')) {
                    $position = mb_strpos(mb_strtolower($text), 'fuck');
                    $matches->addCoincidence(new Coincidence(
                        word: 'fuck',
                        type: MatchType::Exact,
                        score: new Score(0.8),
                        confidence: new Confidence(0.9),
                        occurrences: new OccurrenceCollection([new Position($position, 4)]),
                        language: $language?->code() ?? LanguageCode::English,
                    ));
                }

                return $matches;
            }

            public function weight(): float
            {
                return 1.0;
            }

            public function efficiency(): float
            {
                return 1.0;
            }

            public function name(): string
            {
                return 'mock_strategy';
            }
        };

        $strategies = new StrategyCollection();
        $strategies->add($mockStrategy);
        $votingSystem = new StrategyVotingSystem($strategies);

        $result = $votingSystem->detect('This is fuck text', $this->language);

        expect($result)->toBeInstanceOf(MatchCollection::class);
        expect($result->isEmpty())->toBeFalse();
        expect($result->count())->toBe(1);
        expect($result->first()->word())->toBe('fuck');
    });

    it('works with clean text and mock strategy', function (): void {
        $mockStrategy = new class () implements DetectionStrategy {
            public function detect(string $text, ?Language $language = null): MatchCollection
            {
                return new MatchCollection(); // Always return empty for clean text
            }

            public function weight(): float
            {
                return 1.0;
            }

            public function efficiency(): float
            {
                return 1.0;
            }

            public function name(): string
            {
                return 'mock_strategy';
            }
        };

        $strategies = new StrategyCollection();
        $strategies->add($mockStrategy);
        $votingSystem = new StrategyVotingSystem($strategies);

        $result = $votingSystem->detect('This is clean text', $this->language);

        expect($result)->toBeInstanceOf(MatchCollection::class);
        expect($result->isEmpty())->toBeTrue();
    });

    it('handles multiple strategies with voting', function (): void {
        // First strategy that detects 'fuck'
        $strategy1 = new class () implements DetectionStrategy {
            public function detect(string $text, ?Language $language = null): MatchCollection
            {
                $matches = new MatchCollection();

                if (str_contains(mb_strtolower($text), 'fuck')) {
                    $position = mb_strpos(mb_strtolower($text), 'fuck');
                    $matches->addCoincidence(new Coincidence(
                        word: 'fuck',
                        type: MatchType::Exact,
                        score: new Score(0.8),
                        confidence: new Confidence(0.9),
                        occurrences: new OccurrenceCollection([new Position($position, 4)]),
                        language: $language?->code() ?? LanguageCode::English,
                    ));
                }

                return $matches;
            }

            public function weight(): float
            {
                return 1.0;
            }
            public function efficiency(): float
            {
                return 1.0;
            }
            public function name(): string
            {
                return 'strategy1';
            }
        };

        // Second strategy that detects 'shit'
        $strategy2 = new class () implements DetectionStrategy {
            public function detect(string $text, ?Language $language = null): MatchCollection
            {
                $matches = new MatchCollection();

                if (str_contains(mb_strtolower($text), 'shit')) {
                    $position = mb_strpos(mb_strtolower($text), 'shit');
                    $matches->addCoincidence(new Coincidence(
                        word: 'shit',
                        type: MatchType::Exact,
                        score: new Score(0.7),
                        confidence: new Confidence(0.8),
                        occurrences: new OccurrenceCollection([new Position($position, 4)]),
                        language: $language?->code() ?? LanguageCode::English,
                    ));
                }

                return $matches;
            }

            public function weight(): float
            {
                return 1.0;
            }
            public function efficiency(): float
            {
                return 1.0;
            }
            public function name(): string
            {
                return 'strategy2';
            }
        };

        $strategies = new StrategyCollection();
        $strategies->add($strategy1);
        $strategies->add($strategy2);
        $votingSystem = new StrategyVotingSystem($strategies);

        $result = $votingSystem->detect('This fuck and shit text', $this->language);

        expect($result)->toBeInstanceOf(MatchCollection::class);
        expect($result->isEmpty())->toBeFalse();
        expect($result->count())->toBe(2);
    });

    it('works without language parameter', function (): void {
        $mockStrategy = new class () implements DetectionStrategy {
            public function detect(string $text, ?Language $language = null): MatchCollection
            {
                $matches = new MatchCollection();

                if (str_contains(mb_strtolower($text), 'fuck')) {
                    $position = mb_strpos(mb_strtolower($text), 'fuck');
                    $matches->addCoincidence(new Coincidence(
                        word: 'fuck',
                        type: MatchType::Exact,
                        score: new Score(0.8),
                        confidence: new Confidence(0.9),
                        occurrences: new OccurrenceCollection([new Position($position, 4)]),
                        language: LanguageCode::English,
                    ));
                }

                return $matches;
            }

            public function weight(): float
            {
                return 1.0;
            }
            public function efficiency(): float
            {
                return 1.0;
            }
            public function name(): string
            {
                return 'mock_strategy';
            }
        };

        $strategies = new StrategyCollection();
        $strategies->add($mockStrategy);
        $votingSystem = new StrategyVotingSystem($strategies);

        $result = $votingSystem->detect('This is fuck text');

        expect($result)->toBeInstanceOf(MatchCollection::class);
        // Should still work without explicit language parameter
    });

    it('handles empty text', function (): void {
        $mockStrategy = new class () implements DetectionStrategy {
            public function detect(string $text, ?Language $language = null): MatchCollection
            {
                return new MatchCollection();
            }

            public function weight(): float
            {
                return 1.0;
            }
            public function efficiency(): float
            {
                return 1.0;
            }
            public function name(): string
            {
                return 'mock_strategy';
            }
        };

        $strategies = new StrategyCollection();
        $strategies->add($mockStrategy);
        $votingSystem = new StrategyVotingSystem($strategies);

        $result = $votingSystem->detect('', $this->language);

        expect($result)->toBeInstanceOf(MatchCollection::class);
        expect($result->isEmpty())->toBeTrue();
    });
});
