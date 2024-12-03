<?php

namespace Ninja\Censor\Result;

final readonly class PurgoMalumResult extends AbstractResult
{
    public static function fromResponse(string $text, array $response): self
    {
        /**
         * @var array{
         *     result: string
         * } $response
         */
        return new self(
            offensive: $text !== $response['result'],
            words: self::extractWords($text, $response['result']),
            replaced: $response['result'],
            original: $text,
            score: null,
            confidence: null,
            categories: null
        );
    }

    /**
     * @return string[]
     */
    private static function extractWords(string $original, string $replaced): array
    {
        $matches = [];
        $originalWords = explode(' ', $original);
        $replacedWords = explode(' ', $replaced);

        foreach ($originalWords as $i => $word) {
            if (isset($replacedWords[$i]) && $word !== $replacedWords[$i]) {
                $matches[] = $word;
            }
        }

        return array_unique($matches);
    }
}
