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
     * @return array<array{word: string, distance: int}>
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

    private function uniLevenshtein(string $str1, string $str2): int
    {
        $s1 = mb_str_split($str1);
        $s2 = mb_str_split($str2);

        $m = count($s1);
        $n = count($s2);

        $d = array_fill(0, $m + 1, array_fill(0, $n + 1, 0));

        for ($i = 1; $i <= $m; $i++) {
            $d[$i][0] = $i;
        }
        for ($j = 1; $j <= $n; $j++) {
            $d[0][$j] = $j;
        }

        for ($i = 1; $i <= $m; $i++) {
            for ($j = 1; $j <= $n; $j++) {
                $cost = (mb_strtolower($s1[$i - 1]) === mb_strtolower($s2[$j - 1])) ? 0 : 1;
                $d[$i][$j] = min(
                    $d[$i - 1][$j] + 1,     // deletion
                    $d[$i][$j - 1] + 1,     // insertion
                    $d[$i - 1][$j - 1] + $cost // substitution
                );
            }
        }

        return $d[$m][$n];
    }

    public function distance(string $str1, string $str2): int
    {
        $key = $str1 < $str2 ? "$str1:$str2" : "$str2:$str1";

        if (! isset($this->cache[$key])) {
            $this->cache[$key] = $this->uniLevenshtein($str1, $str2);
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
