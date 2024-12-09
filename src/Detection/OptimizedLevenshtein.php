<?php

namespace Ninja\Censor\Detection;

final class OptimizedLevenshtein
{
    /**
     * @var array<string, int>
     */
    private array $cache = [];

    /**
     * @var array<int, array<string>>
     */
    private array $lengthGroups = [];

    /**
     * @param  array<string>  $dictionary
     */
    public function __construct(array $dictionary = [])
    {
        $this->groupWordsByLength($dictionary);
    }

    /**
     * @return array<string>
     */
    public function findSimilar(string $word, int $threshold): array
    {
        $len = mb_strlen($word);
        $searchLengths = range(
            max(3, $len - $threshold),
            $len + $threshold
        );

        $matches = [];
        $lowerWord = mb_strtolower($word);

        foreach ($searchLengths as $searchLen) {
            if (! isset($this->lengthGroups[$searchLen])) {
                continue;
            }

            foreach ($this->lengthGroups[$searchLen] as $dictWord) {
                $distance = $this->distance($lowerWord, mb_strtolower($dictWord));
                if ($distance <= $threshold) {
                    $matches[] = [
                        'word' => $dictWord,
                        'distance' => $distance,
                    ];
                }
            }
        }

        return $matches;
    }

    public function distance(string $str1, string $str2): int
    {
        $key = $str1 < $str2 ? "$str1:$str2" : "$str2:$str1";

        if (! isset($this->cache[$key])) {
            $lenDiff = abs(mb_strlen($str1) - mb_strlen($str2));
            if ($lenDiff > 3) {
                return $lenDiff;
            }

            $this->cache[$key] = levenshtein($str1, $str2);
        }

        return $this->cache[$key];
    }

    /**
     * @param  array<string>  $dictionary
     */
    private function groupWordsByLength(array $dictionary): void
    {
        $this->lengthGroups = [];
        foreach ($dictionary as $word) {
            $len = mb_strlen($word);
            $this->lengthGroups[$len][] = $word;
        }
    }
}
