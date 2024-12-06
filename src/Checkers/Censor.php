<?php

namespace Ninja\Censor\Checkers;

use Ninja\Censor\Contracts\ProfanityChecker;
use Ninja\Censor\Contracts\Result;
use Ninja\Censor\Detection\LevenshteinStrategy;
use Ninja\Censor\Detection\NGramStrategy;
use Ninja\Censor\Detection\PatternStrategy;
use Ninja\Censor\Detection\RepeatedCharStrategy;
use Ninja\Censor\Detection\VariationStrategy;
use Ninja\Censor\Dictionary;
use Ninja\Censor\Result\CensorResult;
use Ninja\Censor\Support\PatternGenerator;
use Ninja\Censor\Support\TextAnalyzer;
use Ninja\Censor\Support\TextNormalizer;
use Ninja\Censor\Whitelist;

final class Censor implements ProfanityChecker
{
    /**
     * @var string[]
     */
    private array $words = [];

    private string $replacer;

    /**
     * @var array<string>
     */
    private array $patterns = [];

    private Whitelist $whitelist;

    public function __construct(private readonly PatternGenerator $generator, private readonly int $levenshtein_threshold = 1)
    {
        /** @var string[] $whitelist */
        $whitelist = config('censor.whitelist', []);
        $this->whitelist = (new Whitelist)->add($whitelist);

        /** @var string $replaceChar */
        $replaceChar = config('censor.mask_char', '*');
        $this->replacer = $replaceChar;

        /** @var string[] $languages */
        $languages = config('censor.languages', [config('app.locale')]);
        foreach ($languages as $language) {
            $this->addDictionary(Dictionary::withLanguage($language));
        }

        $this->generatePatterns();
    }

    private function generatePatterns(bool $fullWords = false): void
    {
        $this->generator->setFullWords($fullWords);
        $this->patterns = $this->generator->forWords($this->words);
    }

    public function setDictionary(Dictionary $dictionary): self
    {
        $this->words = $dictionary->words();
        $this->generatePatterns();

        return $this;
    }

    public function addDictionary(Dictionary $dictionary): self
    {
        $this->words = array_merge($this->words, $dictionary->words());
        $this->words = array_unique($this->words);
        $this->generatePatterns();

        return $this;
    }

    /**
     * @param  string[]  $words
     */
    public function addWords(array $words): self
    {
        $this->words = array_unique(array_merge($this->words, $words));
        $this->generatePatterns();

        return $this;
    }

    /**
     * @param  string[]  $list
     */
    public function whitelist(array $list): self
    {
        $this->whitelist->add($list);

        return $this;
    }

    /**
     * @return array{orig: string, clean: string, matched: array<int, string>, score?: float}
     */
    public function clean(string $string, bool $fullWords = false): array
    {
        $currentPattern = $this->patterns[0] ?? '';
        $isCurrentlyFullWords = str_contains($currentPattern, '\b');

        if ($fullWords !== $isCurrentlyFullWords) {
            $this->generatePatterns($fullWords);
        }

        $newstring = [
            'orig' => html_entity_decode($string),
            'clean' => '',
            'matched' => [],
            'details' => [],
        ];

        $original = TextNormalizer::normalize($this->whitelist->replace($newstring['orig']));
        $processedWords = [];
        $allMatches = [];
        $finalText = $original;

        // Configure detection strategies
        $strategies = [
            new PatternStrategy($this->patterns, $this->replacer),
            new NGramStrategy($this->replacer),
            new VariationStrategy($this->replacer, $fullWords),
            new RepeatedCharStrategy($this->replacer),
            new LevenshteinStrategy($this->replacer, $this->levenshtein_threshold),
        ];

        // Apply each detection strategy
        foreach ($strategies as $strategy) {
            $result = $strategy->detect($original, $this->words);

            // Filter out already processed words and censored content
            $newMatches = array_filter(
                $result['matches'],
                function ($match) use ($processedWords) {
                    return ! in_array($match['word'], $processedWords, true) &&
                        ! str_contains($match['word'], $this->replacer);
                }
            );

            if (count($newMatches) > 0) {
                $allMatches = array_merge($allMatches, $newMatches);
                $processedWords = array_merge(
                    $processedWords,
                    array_column($newMatches, 'word')
                );

                foreach ($newMatches as $match) {
                    $finalText = str_replace(
                        $match['word'],
                        str_repeat($this->replacer, mb_strlen($match['word'])),
                        $finalText
                    );
                }
            }
        }

        $newstring['clean'] = $this->whitelist->replace($finalText, true);
        $newstring['matched'] = array_values(array_unique($processedWords));
        $newstring['details'] = $allMatches;
        $newstring['score'] = TextAnalyzer::calculateScore($allMatches, $newstring['orig']);

        return $newstring;
    }

    public function check(string $text): Result
    {
        $result = $this->clean($text);

        return CensorResult::fromResponse($text, $result);
    }
}
