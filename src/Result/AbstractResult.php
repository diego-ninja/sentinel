<?php

namespace Ninja\Censor\Result;

use Ninja\Censor\Contracts\Result;

abstract readonly class AbstractResult implements Result
{
    /**
     * @param  array<string>  $words
     * @param  array<string>|null  $categories
     */
    protected function __construct(
        public bool $offensive,
        public array $words,
        public string $replaced,
        public string $original,
        public ?float $score = null,
        public ?float $confidence = null,
        public ?array $categories = null
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

    public function score(): ?float
    {
        return $this->score;
    }

    public function confidence(): ?float
    {
        return $this->confidence;
    }

    public function categories(): ?array
    {
        return $this->categories;
    }

    /**
     * @param  array<string>  $words
     */
    protected static function clean(string $text, array $words): string
    {
        foreach ($words as $word) {
            $text = str_replace($word, str_repeat('*', strlen($word)), $text);
        }

        return $text;
    }
}
