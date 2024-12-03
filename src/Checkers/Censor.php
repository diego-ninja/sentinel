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
     * @var array<int,string>|null
     */
    private static ?array $checks = null;

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
    }

    public function setDictionary(Dictionary $dictionary): self
    {
        $this->words = $dictionary->words();

        return $this;
    }

    public function addDictionary(Dictionary $dictionary): self
    {
        $this->words = array_merge($this->words, $dictionary->words());

        return $this;
    }

    /**
     * @param  string[]  $words
     */
    public function addWords(array $words): self
    {
        $words = array_merge($this->words, $words);
        $this->words = array_keys(array_count_values($words));

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

    public function setReplaceChar(string $replacer): self
    {
        $this->replacer = $replacer;

        return $this;
    }

    /**
     *  Generates a random string.
     *
     * @param  string  $chars  Chars that can be used.
     * @param  int  $len  Length of the output string.
     */
    public function rand(string $chars, int $len): string
    {
        return str_shuffle(
            str_repeat($chars, (int) ($len / strlen($chars))).
            substr($chars, 0, $len % strlen($chars))
        );
    }

    private function generate(bool $fullWords = false): void
    {
        $badwords = $this->words;

        /** @var array<string, string> $replacements */
        $replacements = config('censor.replacements');

        $censorChecks = [];
        for ($x = 0, $xMax = count($badwords); $x < $xMax; $x++) {
            $censorChecks[$x] = $fullWords
                ? '/\b'.str_ireplace(array_keys($replacements), array_values($replacements), $badwords[$x]).'\b/i'
                : '/'.str_ireplace(array_keys($replacements), array_values($replacements), $badwords[$x]).'/i';
        }

        self::$checks = $censorChecks;
    }

    /**
     * @return array<string, mixed>
     */
    public function clean(string $string, bool $fullWords = false): array
    {
        if (self::$checks !== null) {
            $this->generate($fullWords);
        }

        $newstring = [
            'orig' => html_entity_decode($string),
            'clean' => '',
            'matched' => [],
        ];

        $original = $this->whitelist->replace($newstring['orig']);
        $counter = 0;

        $newstring['clean'] = preg_replace_callback(
            self::$checks ?? [],
            function ($matches) use (&$counter, &$newstring) {
                $newstring['matched'][$counter++] = $matches[0];

                return (strlen($this->replacer) === 1)
                    ? str_repeat($this->replacer, strlen($matches[0]))
                    : $this->rand($this->replacer, strlen($matches[0]));
            },
            $original
        );

        $newstring['clean'] = $this->whitelist->replace($newstring['clean'] ?? '', true);

        return $newstring;
    }

    public function check(string $text): Result
    {
        $result = $this->clean($text);

        return CensorResult::fromResponse($text, $result);
    }
}
