<?php

namespace Ninja\Sentinel\Checkers;

use Ninja\Sentinel\Checkers\Contracts\ProfanityChecker;
use Ninja\Sentinel\Enums\Audience;
use Ninja\Sentinel\Enums\ContentType;
use Ninja\Sentinel\Processors\Contracts\Processor;
use Ninja\Sentinel\Result\Builder\ResultBuilder;
use Ninja\Sentinel\Result\Contracts\Result;
use Ninja\Sentinel\Services\Contracts\ServiceAdapter;
use Ninja\Sentinel\Services\Pipeline\TransformationPipeline;
use Ninja\Sentinel\Support\ThresholdManager;

final class Local implements ProfanityChecker
{
    private const int CHUNK_SIZE = 500;

    public function __construct(
        private readonly Processor $processor,
        private readonly ServiceAdapter $adapter,
        private readonly TransformationPipeline $pipeline,
    ) {}

    /**
     * Check text for offensive content
     *
     * @param string $text The text to analyze
     * @param ContentType|null $contentType Optional content type for threshold adjustment
     * @param Audience|null $audience Optional audience type for threshold adjustment
     * @return Result The analysis result
     */
    public function check(string $text, ?ContentType $contentType = null, ?Audience $audience = null): Result
    {
        // Process the text
        if (mb_strlen($text) < self::CHUNK_SIZE) {
            $processorResult = $this->processor->process([$text])[0];
            $adaptedResult = $this->adapter->adapt($text, [
                'result' => $processorResult,
            ]);
        } else {
            $chunks = $this->split($text);
            $results = $this->processor->process($chunks);
            $adaptedResult = $this->adapter->adapt($text, [
                'result' => $results[0],
            ]);
        }
        $result = $this->pipeline->process($adaptedResult);

        // If contextual parameters are provided, we need to:
        // 1. Adjust strategy weights based on content type if applicable
        // 2. Apply audience-specific thresholds
        // 3. Create a new result with the contextual info
        if (null !== $contentType || null !== $audience) {
            // Apply the threshold to determine if offensive
            $threshold = ThresholdManager::getThreshold(
                $result->categories(),
                $contentType,
                $audience,
            );

            $isOffensive = null !== $result->score() && $result->score()->value() >= $threshold;

            // Create a new result with the contextual parameters
            $builder = new ResultBuilder();
            return $builder
                ->withOriginalText($result->original())
                ->withReplaced($result->replaced())
                ->withWords($result->words())
                ->withScore($result->score())
                ->withConfidence($result->confidence())
                ->withSentiment($result->sentiment())
                ->withCategories($result->categories())
                ->withMatches($result->matches())
                ->withOffensive($isOffensive)
                ->withContentType($contentType)
                ->withAudience($audience)
                ->build();
        }

        return $result;
    }

    /**
     * @return array<string>
     */
    private function split(string $text): array
    {
        $sentences = preg_split('/(?<=[.!?])\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
        if ( ! $sentences) {
            return [$text];
        }

        $chunks = [];
        $currentChunk = '';

        foreach ($sentences as $sentence) {
            if (mb_strlen($currentChunk . $sentence) > self::CHUNK_SIZE) {
                $chunks[] = mb_trim($currentChunk);
                $currentChunk = $sentence;
            } else {
                $currentChunk .= ' ' . $sentence;
            }
        }

        if ( ! empty($currentChunk)) {
            $chunks[] = mb_trim($currentChunk);
        }

        return $chunks;
    }
}
