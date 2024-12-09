<?php

namespace Ninja\Censor\ValueObject;

use Ninja\Censor\Enums\MatchType;

final readonly class Coincidence
{
    public function __construct(
        public string $word,
        public MatchType $type,
    ) {}

    public function word(): string
    {
        return $this->word;
    }

    public function type(): MatchType
    {
        return $this->type;
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
