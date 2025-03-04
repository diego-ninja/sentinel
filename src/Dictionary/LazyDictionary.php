<?php

namespace Ninja\Sentinel\Dictionary;

use Exception;
use Generator;
use IteratorAggregate;
use Ninja\Sentinel\Exceptions\DictionaryFileNotFound;
use Ninja\Sentinel\Language\Collections\LanguageCollection;
use SplFixedArray;

/**
 * @implements IteratorAggregate<int, string>
 */
final class LazyDictionary implements IteratorAggregate
{
    private const int CHUNK_SIZE = 1000;

    /** @var array<string,SplFixedArray<string>> */
    private array $chunks = [];

    /** @var array<string> */
    private array $customWords = [];

    public function __construct(
        private readonly LanguageCollection $languages,
    ) {}

    /**
     * @param array<string> $words
     */
    public static function withWords(array $words): self
    {
        $dictionary = new self(new LanguageCollection());
        $dictionary->addWords($words);

        return $dictionary;
    }

    /**
     * @param array<string> $words
     */
    public function addWords(array $words): void
    {
        $filteredWords = array_filter($words, fn($word) => '' !== $word);
        $this->customWords = array_unique(array_merge($this->customWords, $filteredWords));
    }

    /**
     * @return Generator<int, string>
     */
    public function getIterator(): Generator
    {
        yield from $this->loadWordsLazily();
    }

    /**
     * @return array<int, string>
     */
    public function getWords(): array
    {
        return iterator_to_array($this->getIterator());
    }

    /**
     * @return Generator<int, string>
     */
    private function loadWordsLazily(): Generator
    {
        if ( ! empty($this->customWords)) {
            foreach ($this->customWords as $word) {
                if (is_string($word)) {
                    yield $word;
                }
            }

            return;
        }

        $seenWords = [];

        foreach ($this->languages as $language) {
            try {
                // Intenta obtener palabras ofensivas del archivo de contexto
                $words = iterator_to_array($language->words());
                $totalChunks = ceil(count($words) / self::CHUNK_SIZE);

                for ($i = 0; $i < $totalChunks; $i++) {
                    /** @var array<int,string> $chunk */
                    $chunk = array_values(array_slice($words, $i * self::CHUNK_SIZE, self::CHUNK_SIZE));
                    $chunkKey = sprintf('%s_%d', $language->code()->value, $i);

                    $fixedArray = SplFixedArray::fromArray($chunk);
                    $this->chunks[$chunkKey] = $fixedArray;

                    foreach ($this->chunks[$chunkKey] as $word) {
                        if (is_string($word) && ! isset($seenWords[$word])) {
                            $seenWords[$word] = true;
                            yield $word;
                        }
                    }

                    unset($this->chunks[$chunkKey]);
                }

                unset($words);
                gc_collect_cycles();
            } catch (Exception $e) {
                throw new DictionaryFileNotFound($e->getMessage());
            }
        }
    }
}
