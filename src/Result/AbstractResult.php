<?php

namespace Ninja\Censor\Result;

use Ninja\Censor\Collections\MatchCollection;
use Ninja\Censor\Result\Contracts\Result;
use Ninja\Censor\ValueObject\Confidence;
use Ninja\Censor\ValueObject\Score;

abstract class AbstractResult implements Result
{
    /**
     * @param  array<string>  $words
     * @param  array<string>|null  $categories
     */
    public function __construct(
        public bool $offensive,
        public array $words,
        public string $replaced,
        public string $original,
        public ?MatchCollection $matches,
        public ?Score $score = null,
        public ?Confidence $confidence = null,
        public ?array $categories = null,
    ) {}

    /**
     * @param  array<string, mixed>  $response
     */
    abstract public static function fromResponse(string $text, array $response): self;

    public function offensive(): bool
    {
        return $this->offensive;
    }

    public function words(): array
    {
        return $this->words;
    }

    public function replaced(): string
    {
        return $this->replaced;
    }

    public function original(): string
    {
        return $this->original;
    }

    public function score(): ?Score
    {
        return $this->score;
    }

    public function confidence(): ?Confidence
    {
        return $this->confidence;
    }

    public function categories(): array
    {
        return $this->categories ?? [];
    }

    public function matches(): ?MatchCollection
    {
        return $this->matches;
    }

    /**
     * @param  array<string>  $words
     */
    protected static function clean(string $text, array $words): string
    {
        /** @var string $replaceChar */
        $replaceChar = config('censor.mask_char', '*');

        foreach ($words as $word) {
            $text = str_replace($word, str_repeat($replaceChar, strlen($word)), $text);
        }

        return $text;
    }
}
