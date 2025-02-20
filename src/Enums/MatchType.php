<?php

namespace Ninja\Sentinel\Enums;

enum MatchType: string
{
    case Exact = 'exact';
    case Trie = 'trie';
    case Levenshtein = 'levenshtein';
    case Variation = 'variation';
    case Pattern = 'pattern';
    case Repeated = 'repeated';
    case NGram = 'ngram';

    public function weight(): float
    {
        return match ($this) {
            self::Exact,
            self::Trie => 1.0,
            self::Pattern,
            self::NGram => 0.9,
            self::Variation => 0.8,
            self::Levenshtein => 0.7,
            self::Repeated => 0.6,
        };
    }
}
