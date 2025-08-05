<?php

namespace Ninja\Sentinel\ValueObject;

use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Enums\LanguageCode;
use Ninja\Sentinel\Enums\MatchType;

/**
 * @immutable
 */
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
        public OccurrenceCollection $occurrences,
        public LanguageCode $language,
        public ?array $context = null,
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

    public function occurrences(): OccurrenceCollection
    {
        return $this->occurrences;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function context(): ?array
    {
        return $this->context;
    }

    public function language(): LanguageCode
    {
        return $this->language;
    }

    public function clean(string $text): string
    {
        /** @var string $replacer */
        $replacer = config('sentinel.mask_char', '*');

        return $this->occurrences->apply($text, $replacer);
    }
}
