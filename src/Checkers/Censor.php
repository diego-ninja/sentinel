<?php

namespace Ninja\Censor\Checkers;

use Ninja\Censor\Contracts\ProfanityChecker;
use Ninja\Censor\Contracts\Result;
use Ninja\Censor\Dictionary;
use Ninja\Censor\Result\CensorResult;
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

    public function __construct()
    {
        /** @var string[] $whitelist */
        $whitelist = config('censor.whitelist', []);
        $this->whitelist = (new Whitelist)->add($whitelist);

        /** @var string $replaceChar */
        $replaceChar = config('censor.replace_char', '*');
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
        /** @var array<string, string> $replacements */
        $replacements = config('censor.replacements', []);

        $this->patterns = array_map(function ($word) use ($replacements, $fullWords) {
            $escaped = preg_quote($word, '/');
            $pattern = str_ireplace(
                array_map(fn ($key) => preg_quote($key, '/'), array_keys($replacements)),
                array_values($replacements),
                $escaped
            );

            return $fullWords ? '/\b'.$pattern.'\b/iu' : '/'.$pattern.'/iu';
        }, $this->words);
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
     * @return array<string, mixed>
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
        ];

        $original = $this->whitelist->replace($newstring['orig']);
        $counter = 0;

        $newstring['clean'] = preg_replace_callback(
            $this->patterns,
            function ($matches) use (&$counter, &$newstring) {
                $newstring['matched'][$counter++] = $matches[0];

                return str_repeat($this->replacer, mb_strlen($matches[0]));
            },
            $original
        );

        $newstring['clean'] = $this->whitelist->replace($newstring['clean'] ?? '', true);
        $newstring['matched'] = array_unique($newstring['matched']);

        return $newstring;
    }

    public function check(string $text): Result
    {
        $result = $this->clean($text);

        return CensorResult::fromResponse($text, $result);
    }

    public function setReplaceChar(string $replacer): self
    {
        $this->replacer = $replacer;

        return $this;
    }
}
