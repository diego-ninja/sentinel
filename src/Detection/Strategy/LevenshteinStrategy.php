<?php

namespace Ninja\Censor\Detection\Strategy;

use Ninja\Censor\Collections\MatchCollection;
use Ninja\Censor\Detection\Contracts\DetectionStrategy;
use Ninja\Censor\Detection\OptimizedLevenshtein;
use Ninja\Censor\Enums\MatchType;
use Ninja\Censor\ValueObject\Coincidence;

final readonly class LevenshteinStrategy implements DetectionStrategy
{
    private int $threshold;

    public function __construct()
    {

        /** @var int $threshold */
        $threshold = config('censor.services.local.levenshtein_threshold', 1);
        $this->threshold = $threshold;
    }

    public function detect(string $text, iterable $words): MatchCollection
    {
        $matches = new MatchCollection;

        $dictionary = is_array($words) ? $words : iterator_to_array($words);
        $levenshtein = new OptimizedLevenshtein($dictionary);

        $textWords = preg_split('/\s+/', $text);
        if ($textWords === false) {
            return $matches;
        }

        foreach ($textWords as $textWord) {
            $similarWords = $levenshtein->findSimilar($textWord, $this->threshold);
            if (! empty($similarWords)) {
                $matches->addCoincidence(new Coincidence($textWord, MatchType::Levenshtein));
            }

        }

        return $matches;
    }

    public function weight(): float
    {
        return MatchType::Levenshtein->weight();
    }
}
