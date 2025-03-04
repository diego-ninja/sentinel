<?php

namespace Ninja\Sentinel\Detection\Strategy;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Index\TrieIndex;
use Ninja\Sentinel\Language\Collections\LanguageCollection;
use Ninja\Sentinel\Language\Language;
use Ninja\Sentinel\Support\Calculator;
use Ninja\Sentinel\ValueObject\Coincidence;
use Ninja\Sentinel\ValueObject\Position;

final class IndexStrategy extends AbstractStrategy
{
    public function __construct(
        protected LanguageCollection $languages,
        private readonly TrieIndex $index,
        private readonly bool $fullWords = true,
    ) {
        parent::__construct($languages);
    }

    public function detect(string $text, ?Language $language = null): MatchCollection
    {
        $language ??= $this->languages->bestFor($text);
        $matches = new MatchCollection();

        if (null === $language) {
            return $matches;
        }

        $textWords = $this->fullWords
            ? preg_split('/\b|\s+/', $text, -1, PREG_SPLIT_NO_EMPTY)
            : [$text];

        if ( ! $textWords) {
            return $matches;
        }

        foreach ($textWords as $textWord) {
            $word = mb_strtolower($textWord);
            if ($this->index->search($word)) {
                if ($this->fullWords) {
                    $this->detectFullWord($text, $textWord, $matches, $language);
                } else {
                    $this->detectPartial($text, $textWord, $matches, $language);
                }
            }
        }

        return $matches;
    }

    public function weight(): float
    {
        return MatchType::Trie->weight();
    }

    private function detectFullWord(string $text, string $word, MatchCollection $matches, Language $language): void
    {
        $positions = [];
        $pos = 0;

        while (($pos = mb_stripos($text, $word, $pos)) !== false) {
            $before = $pos > 0 ? mb_substr($text, $pos - 1, 1) : ' ';
            $after = $pos + mb_strlen($word) < mb_strlen($text)
                ? mb_substr($text, $pos + mb_strlen($word), 1)
                : ' ';

            if (preg_match('/\s/', $before) && preg_match('/\s/', $after)) {
                $positions[] = new Position($pos, mb_strlen($word));
            }
            $pos += mb_strlen($word);
        }

        if ( ! empty($positions)) {
            $occurrences = new OccurrenceCollection($positions);
            $matches->addCoincidence(
                new Coincidence(
                    word: $word,
                    type: MatchType::Trie,
                    score: Calculator::score($text, $word, MatchType::Trie, $occurrences, $language),
                    confidence: Calculator::confidence($text, $word, MatchType::Trie, $occurrences),
                    occurrences: $occurrences,
                    language: $language->code(),
                    context: ['method' => 'trie_index', 'full_word' => true],
                ),
            );
        }
    }

    private function detectPartial(string $text, string $word, MatchCollection $matches, Language $language): void
    {
        $positions = [];
        $pos = 0;

        while (($pos = mb_stripos($text, $word, $pos)) !== false) {
            $positions[] = new Position($pos, mb_strlen($word));
            $pos += mb_strlen($word);
        }

        if ( ! empty($positions)) {
            $occurrences = new OccurrenceCollection($positions);
            $matches->addCoincidence(
                new Coincidence(
                    word: $word,
                    type: MatchType::Trie,
                    score: Calculator::score($text, $word, MatchType::Trie, $occurrences, $language),
                    confidence: Calculator::confidence($text, $word, MatchType::Trie, $occurrences),
                    occurrences: $occurrences,
                    context: ['method' => 'trie_index', 'full_word' => false],
                ),
            );
        }
    }
}
