<?php

namespace Ninja\Censor\Support;

use Ninja\Censor\Enums\MatchType;
use Ninja\Censor\ValueObject\Confidence;
use Ninja\Censor\ValueObject\Score;

final readonly class Calculator
{
    public static function score(string $text, string $word, MatchType $type): Score
    {
        $words = explode(' ', $word);
        $total = count(explode(' ', $text));
        $typeWeight = match ($type) {
            MatchType::Exact => 2.0,
            MatchType::Trie => 1.8,
            MatchType::Pattern => 1.5,
            MatchType::NGram => 1.3,
            default => $type->weight()
        };

        $lengthMultiplier = count($words) > 1 ? 1.5 : 1.2;
        $densityMultiplier = min(2.0, 1 + (count($words) / max($total, 1)));

        $baseScore = ($typeWeight * $lengthMultiplier * count($words)) / max($total, 1);

        return new Score(min(1.0, $baseScore * $densityMultiplier));

    }

    public static function confidence(string $text, string $word, MatchType $type): Confidence
    {
        return new Confidence($type->weight());
    }
}
