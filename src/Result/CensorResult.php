<?php

namespace Ninja\Censor\Result;

final readonly class CensorResult extends AbstractResult
{
    public static function fromResponse(string $text, array $response): AbstractResult
    {
        /** @var string[] $matched */
        $matched = $response['matched'] ?? [];

        /** @var string $replaced */
        $replaced = $response['clean'] ?? $text;

        return new self(
            offensive: count($matched) > 0,
            words: $matched,
            replaced: $replaced,
            original: $text
        );
    }
}
