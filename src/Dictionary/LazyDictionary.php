<?php

namespace Ninja\Censor\Dictionary;

use Generator;
use Ninja\Censor\Exceptions\DictionaryFileNotFound;

final class LazyDictionary
{
    /**
     * @var string[]|null
     */
    private ?array $words = null;

    /**
     * @param  string[]  $languages
     */
    public function __construct(
        private readonly array $languages,
        private ?string $dictionaryPath = null
    ) {
        /** @var string $path */
        $path = config('censor.dictionary_path');
        $this->dictionaryPath = $dictionaryPath ?? $path;
    }

    /**+
     * @return Generator<string>
     */
    public function getWords(): Generator
    {
        if ($this->words === null) {
            yield from $this->loadDictionaries();
        } else {
            yield from $this->words;
        }
    }

    /**
     * @param  string[]  $words
     */
    public static function withWords(array $words): self
    {
        $instance = new self(['custom']);
        $instance->words = $words;

        return $instance;
    }

    /**
     * @return Generator<string>
     */
    private function loadDictionaries(): Generator
    {
        $loadedWords = [];

        foreach ($this->languages as $language) {
            $dictionaryFile = sprintf('%s/%s.php', $this->dictionaryPath, $language);

            if (! file_exists($dictionaryFile)) {
                throw DictionaryFileNotFound::withFile($dictionaryFile);
            }

            /** @var array<string> $words */
            $words = include $dictionaryFile;

            foreach ($words as $word) {
                if (! in_array($word, $loadedWords, true)) {
                    $loadedWords[] = $word;
                    $this->words[] = $word;
                    yield $word;
                }
            }
        }
    }

    /**
     * @param  string[]  $languages
     */
    public static function withLanguages(array $languages): self
    {
        return new self($languages);
    }

    /**
     * @param  string|string[]  $file
     */
    public static function fromFile(string|array $file): self
    {
        $path = is_array($file) ? implode(DIRECTORY_SEPARATOR, $file) : $file;

        if (! file_exists($path)) {
            throw DictionaryFileNotFound::withFile($path);
        }

        return new self(['custom'], dirname($path), basename($path));
    }
}
