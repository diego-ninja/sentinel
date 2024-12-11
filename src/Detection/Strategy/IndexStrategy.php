<?php

namespace Ninja\Censor\Detection\Strategy;

use Ninja\Censor\Collections\MatchCollection;
use Ninja\Censor\Enums\MatchType;
use Ninja\Censor\Index\TrieIndex;
use Ninja\Censor\Support\Calculator;
use Ninja\Censor\ValueObject\Coincidence;

final class IndexStrategy extends AbstractStrategy
{
    public function __construct(private readonly TrieIndex $index) {}

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
                        $matches->addCoincidence(
                            new Coincidence(
                                word: $word,
                                type: MatchType::Trie,
                                score: Calculator::score($text, $word, MatchType::Trie),
                                confidence: Calculator::confidence($text, $word, MatchType::Trie),
                                context: ['original' => $text]
                            )
                        );
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
