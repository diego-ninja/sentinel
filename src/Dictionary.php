<?php

namespace Ninja\Censor;

use Ninja\Censor\Exceptions\DictionaryFileNotFound;

final readonly class Dictionary
{
    /**
     * @param  string[]  $words
     */
    public function __construct(private array $words = []) {}

    /**
     * @return string[]
     */
    public function words(): array
    {
        return $this->words;
    }

    /**
     * @param  string[]  $words
     */
    public static function withWords(array $words): self
    {
        return new self($words);
    }

    /**
     * @param  string|string[]  $file
     */
    public static function fromFile(string|array $file): self
    {
        return new self(self::read($file));
    }

    public static function withLanguage(string $language): self
    {
        /** @var string $dictionaryPath */
        $dictionaryPath = config('censor.dictionary_path');

        return new self(self::read(sprintf('%s/%s.php', $dictionaryPath, $language)));
    }

    /**
     * @param  string|string[]  $source
     * @return string[]
     */
    private static function read(array|string $source): array
    {
        $words = [];

        if (is_array($source)) {
            foreach ($source as $dictionary_file) {
                $words = array_merge($words, self::read($dictionary_file));
            }
        }

        if (is_string($source)) {
            if (file_exists($source)) {
                $words = include $source;
            } else {
                throw DictionaryFileNotFound::withFile($source);
            }
        }

        /** @var array<int,string> $words */
        return array_keys(array_count_values($words));
    }
}
