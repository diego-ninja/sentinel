<?php

use Ninja\Sentinel\Enums\LanguageCode;
use Ninja\Sentinel\Language\Language;

test('language detection deduplicates evidence and preserves numeric counters', function (): void {
    $language = new Language([
        'words' => [
            'offensive' => [],
            'intensifiers' => ['signal', 'clue'],
            'modifiers' => ['negative' => ['signal', 'clue'], 'positive' => []],
            'quote' => ['signal', 'clue'],
            'excuse' => ['signal', 'clue'],
        ],
        'pronouns' => ['signal', 'clue'],
        'prefixes' => [],
        'suffixes' => [],
        'markers' => ['signal', 'clue'],
        'contexts' => [],
        'patterns' => ['word_specific' => []],
        'rules' => [],
    ], LanguageCode::English);

    $result = $language->detect('signal signal clue unknown');

    foreach (['pronouns', 'markers', 'intensifiers', 'modifiers', 'quotes', 'excuses', 'common_words'] as $key) {
        expect($result->details[$key])->toBe(['signal', 'clue']);
        expect(json_encode($result->details[$key], JSON_THROW_ON_ERROR))->toBe('["signal","clue"]');
    }

    expect($result->details['word_count'])->toBe(4);
    expect($result->details['unique_word_count'])->toBe(3);
    expect($result->details['total_language_elements'])->toBe(14);
    expect($result->details['percentage_of_language_elements'])->toBe(14 / 4 * 100);
    expect($result->details['raw_score'])->toBe(75);
    expect($result->score->value())->toBe(0.7);
    expect($result->confidence->value())->toEqualWithDelta(0.47, 0.0000000001);
});
