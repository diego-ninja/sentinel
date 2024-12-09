<?php

namespace Ninja\Censor\Detection\Strategy;

use Ninja\Censor\Collections\MatchCollection;
use Ninja\Censor\Contracts\DetectionStrategy;
use Ninja\Censor\Enums\MatchType;
use Ninja\Censor\Index\TrieIndex;
use Ninja\Censor\ValueObject\Coincidence;

final readonly class IndexStrategy implements DetectionStrategy
{
    public function __construct(private TrieIndex $index) {}

    public function detect(string $text, iterable $words): MatchCollection
    {
        $matches = new MatchCollection;
        $textWords = explode(' ', mb_strtolower($text));

        foreach ($textWords as $word) {
            if ($this->index->search($word)) {
                $pos = mb_stripos($text, $word);
                if ($pos !== false) {
                    $originalWord = mb_substr($text, $pos, mb_strlen($word));
                    if ($originalWord === $word) {
                        $matches->addCoincidence(new Coincidence($word, MatchType::Trie));
                    }
                }
            }
        }

        return $matches;

    }

    public function weight(): float
    {
        return MatchType::Trie->weight();
    }
}
