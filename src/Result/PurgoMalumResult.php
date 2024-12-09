<?php

namespace Ninja\Censor\Result;

use Ninja\Censor\Result\Builder\ResultBuilder;

final class PurgoMalumResult extends AbstractResult
{
    public static function fromResponse(string $text, array $response): AbstractResult
    {
        /**
         * @var array{
         *     result: string
         * } $response
         */
        $builder = new ResultBuilder;

        return $builder
            ->withOriginalText($text)
            ->withOffensive($text !== $response['result'])
            ->withWords(self::extractWords($text, $response['result']))
            ->withReplaced($response['result'])
            ->build();
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
