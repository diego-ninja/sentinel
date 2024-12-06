<?php

namespace Ninja\Censor\Detection;

use Ninja\Censor\Contracts\DetectionStrategy;

final readonly class LevenshteinStrategy implements DetectionStrategy
{
    public function __construct(
        private string $replacer,
        private int $threshold
    ) {}

    public function detect(string $text, array $words): array
    {
        $matches = [];
        $clean = $text;

        $textWords = preg_split('/\s+/', $text);

        if ($textWords === false) {
            return [
                'clean' => $clean,
                'matches' => $matches,
            ];
        }

        foreach ($textWords as $textWord) {
            $bestMatch = null;
            $shortestDistance = PHP_INT_MAX;

            foreach ($words as $badWord) {
                if (mb_strtolower($textWord) === mb_strtolower($badWord) ||
                    str_contains($badWord, ' ')) {
                    continue;
                }

                $distance = levenshtein(
                    mb_strtolower($textWord),
                    mb_strtolower($badWord)
                );

                if ($distance <= $this->threshold && $distance < $shortestDistance) {
                    $shortestDistance = $distance;
                    $bestMatch = [
                        'word' => $textWord,
                        'type' => 'levenshtein',
                        'distance' => $distance,
                    ];
                }
            }

            if ($bestMatch !== null) {
                $matches[] = [
                    'word' => $bestMatch['word'],
                    'type' => $bestMatch['type'],
                ];
                $clean = str_replace(
                    $bestMatch['word'],
                    str_repeat($this->replacer, mb_strlen($bestMatch['word'])),
                    $clean
                );
            }
        }

        return [
            'clean' => $clean,
            'matches' => $matches,
        ];
    }
}
