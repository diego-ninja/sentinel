<?php

namespace Ninja\Censor\Checkers;

use Ninja\Censor\Checkers\Contracts\ProfanityChecker;
use Ninja\Censor\Collections\MatchCollection;
use Ninja\Censor\Processors\Contracts\Processor;
use Ninja\Censor\Result\AbstractResult;
use Ninja\Censor\Result\Builder\ResultBuilder;
use Ninja\Censor\Result\Contracts\Result;

final class Censor implements ProfanityChecker
{
    private const CHUNK_SIZE = 1000;

    public function __construct(
        private readonly Processor $processor
    ) {}

    public function check(string $text): Result
    {
        if (mb_strlen($text) < self::CHUNK_SIZE) {
            return $this->processor->process([$text])[0];
        }

        $chunks = $this->split($text);
        $results = $this->processor->process($chunks);

        return $this->mergeResults($results, $text);
    }

    /**
     * @return array<string>
     */
    private function split(string $text): array
    {
        $sentences = preg_split('/(?<=[.!?])\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
        if (! $sentences) {
            return [$text];
        }

        $chunks = [];
        $currentChunk = '';

        foreach ($sentences as $sentence) {
            if (mb_strlen($currentChunk.$sentence) > self::CHUNK_SIZE) {
                $chunks[] = trim($currentChunk);
                $currentChunk = $sentence;
            } else {
                $currentChunk .= ' '.$sentence;
            }
        }

        if (! empty($currentChunk)) {
            $chunks[] = trim($currentChunk);
        }

        return $chunks;
    }

    /**
     * @param  array<AbstractResult>  $results
     */
    private function mergeResults(array $results, string $originalText): Result
    {
        $matches = new MatchCollection;
        $processedWords = [];

        foreach ($results as $result) {
            $matches = $matches->merge($result->matches() ?? new MatchCollection);
            $processedWords = array_merge($processedWords, $result->words());
        }

        return (new ResultBuilder)
            ->withOriginalText($originalText)
            ->withWords(array_unique($processedWords))
            ->withReplaced($matches->clean($originalText))
            ->withScore($matches->score($originalText))
            ->withOffensive($matches->offensive($originalText))
            ->withConfidence($matches->confidence())
            ->build();
    }
}
