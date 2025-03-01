<?php

namespace Ninja\Sentinel\Checkers;

use GuzzleHttp\ClientInterface;
use Ninja\Sentinel\Enums\Audience;
use Ninja\Sentinel\Enums\ContentType;
use Ninja\Sentinel\Result\Builder\ResultBuilder;
use Ninja\Sentinel\Result\Contracts\Result;
use Ninja\Sentinel\Services\Contracts\ServiceAdapter;
use Ninja\Sentinel\Services\Pipeline\TransformationPipeline;

final class PurgoMalum extends AbstractProfanityChecker
{
    public function __construct(
        private readonly ServiceAdapter $adapter,
        private readonly TransformationPipeline $pipeline,
        protected ?ClientInterface $client = null,
    ) {
        parent::__construct($client);
    }

    /**
     * Check text for offensive content using PurgoMalum API
     *
     * @param string $text Text to analyze
     * @param ContentType|null $contentType Optional content type for context
     * @param Audience|null $audience Optional audience type for threshold adjustment
     * @return Result Analysis result
     */
    public function check(string $text, ?ContentType $contentType = null, ?Audience $audience = null): Result
    {
        // PurgoMalum is a simple service that doesn't support many parameters
        // We'll use the default API call and then interpret the results based on context
        $response = $this->get('json', [
            'text' => $text,
            'fill_char' => config('sentinel.mask_char'),
        ]);

        // Process the result through adapter and pipeline
        $result = $this->pipeline->process(
            $this->adapter->adapt($text, $response),
        );

        // For PurgoMalum, we need to handle context mainly on the result interpretation
        // since the API itself doesn't have many customization options
        if (null !== $contentType || null !== $audience) {
            // Create a new result with contextual information
            $builder = new ResultBuilder();
            $builder = $builder->withOriginalText($result->original())
                ->withReplaced($result->replaced())
                ->withWords($result->words())
                ->withScore($result->score())
                ->withConfidence($result->confidence())
                ->withSentiment($result->sentiment())
                ->withCategories($result->categories());

            if (null !== $result->matches()) {
                $builder = $builder->withMatches($result->matches());
            }

            // Apply contextual thresholds
            $isOffensive = $result->offensive($contentType, $audience);
            $builder = $builder->withOffensive($isOffensive);

            // Add content type and audience
            if (null !== $contentType) {
                $builder = $builder->withContentType($contentType);
            }

            if (null !== $audience) {
                $builder = $builder->withAudience($audience);
            }

            // For educational/medical content, we might want to adjust the result
            // by checking if the detected words are commonly used in these contexts
            if ((ContentType::Educational === $contentType ||
                    ContentType::Medical === $contentType ||
                    ContentType::Research === $contentType) &&
                ! empty($result->words())) {

                // Check if the detected words are common in educational/medical contexts
                // This is a simple version - a more complete one would check against a dictionary
                $potentiallyAllowed = $this->potentiallyAllowedTerms($contentType);
                $wordsToCheck = array_map('strtolower', $result->words());

                // If all detected words are potentially allowed in this context, adjust the offensive flag
                $allWordsAllowed = empty(array_diff($wordsToCheck, $potentiallyAllowed));

                if ($allWordsAllowed) {
                    $builder = $builder->withOffensive(false);
                }
            }

            return $builder->build();
        }

        return $result;
    }

    protected function baseUri(): string
    {
        return 'https://www.purgomalum.com/service/';
    }

    /**
     * Get potentially allowed terms for specific content types
     *
     * @param ContentType $contentType The content type
     * @return array<string> List of potentially allowed terms
     */
    private function potentiallyAllowedTerms(ContentType $contentType): array
    {
        return match ($contentType) {
            ContentType::Medical => [
                'anal', 'penis', 'vagina', 'breast', 'rectum', 'testicle',
                'scrotum', 'urethra', 'ejaculation', 'erection', 'menstruation',
                'coitus', 'intercourse', 'sexual dysfunction',
            ],
            ContentType::Educational, ContentType::Research => [
                'anal', 'penis', 'vagina', 'breast', 'sex', 'sexual',
                'homosexual', 'heterosexual', 'transgender', 'sexuality',
            ],
            default => [],
        };
    }
}
