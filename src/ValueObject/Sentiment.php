<?php

namespace Ninja\Censor\ValueObject;

use Ninja\Censor\Enums\SentimentType;

final readonly class Sentiment
{
    public function __construct(public SentimentType $type, public Score $score) {}

    public static function withScore(Score $score): self
    {
        $type = match (true) {
            $score->value() >= SentimentType::Positive->threshold() => SentimentType::Positive,
            $score->value() <= SentimentType::Negative->threshold() => SentimentType::Negative,
            default => SentimentType::Neutral,
        };

        return new self($type, $score);
    }

    public function value(): float
    {
        return $this->score->value();
    }

    public function type(): SentimentType
    {
        return $this->type;
    }

    public function isPositive(): bool
    {
        return $this->type->equals(SentimentType::Positive);
    }

    public function isNegative(): bool
    {
        return $this->type->equals(SentimentType::Negative);
    }

    public function isNeutral(): bool
    {
        return $this->type->equals(SentimentType::Neutral);
    }
}
