<?php

namespace Ninja\Sentinel\Result;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Enums\Category;
use Ninja\Sentinel\Result\Contracts\Result as ResultContract;
use Ninja\Sentinel\ValueObject\Confidence;
use Ninja\Sentinel\ValueObject\Score;
use Ninja\Sentinel\ValueObject\Sentiment;

readonly class Result implements ResultContract
{
    /**
     * @param  array<string>  $words
     * @param  array<Category>|null  $categories
     */
    public function __construct(
        public bool $offensive,
        public array $words,
        public string $replaced,
        public string $original,
        public ?MatchCollection $matches,
        public ?Score $score = null,
        public ?Confidence $confidence = null,
        public ?Sentiment $sentiment = null,
        public ?array $categories = null,
    ) {}

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

    public function sentiment(): ?Sentiment
    {
        return $this->sentiment;
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
        $replaceChar = config('sentinel.mask_char', '*');

        foreach ($words as $word) {
            $text = str_replace($word, str_repeat($replaceChar, mb_strlen($word)), $text);
        }

        return $text;
    }
}
