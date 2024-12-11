<?php

namespace Ninja\Censor\ValueObject;

use Ninja\Censor\Enums\MatchType;

final readonly class Coincidence
{
    /**
     * @param  array<string, mixed>|null  $context
     */
    public function __construct(
        public string $word,
        public MatchType $type,
        public Score $score,
        public Confidence $confidence,
        public ?array $context,
    ) {}

    public function word(): string
    {
        return $this->word;
    }

    public function type(): MatchType
    {
        return $this->type;
    }

    public function score(): Score
    {
        return $this->score;
    }

    public function confidence(): Confidence
    {
        return $this->confidence;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function context(): ?array
    {
        return $this->context;
    }

    public function clean(string $text): string
    {
        /** @var string $replacer */
        $replacer = config('censor.mask_char', '*');

        $clean = $text;

        return str_replace(
            $this->word,
            str_repeat($replacer, mb_strlen($this->word)),
            $clean
        );
    }
}
