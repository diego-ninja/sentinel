<?php

namespace Ninja\Sentinel\Checkers;

use GuzzleHttp\ClientInterface;
use Ninja\Sentinel\Enums\Audience;
use Ninja\Sentinel\Enums\ContentType;
use Ninja\Sentinel\Exceptions\ClientException;
use Ninja\Sentinel\Result\Builder\ResultBuilder;
use Ninja\Sentinel\Result\Contracts\Result;
use Ninja\Sentinel\Services\Contracts\ServiceAdapter;
use Ninja\Sentinel\Services\Pipeline\TransformationPipeline;

final class TisaneAI extends AbstractProfanityChecker
{
    public function __construct(
        private readonly string $key,
        private readonly ServiceAdapter $adapter,
        private readonly TransformationPipeline $pipeline,
        protected ?ClientInterface $client = null,
    ) {
        parent::__construct($client);
    }

    /**
     * Check text for offensive content using Tisane API
     *
     * @param string $text Text to analyze
     * @param ContentType|null $contentType Optional content type for language
     * @param Audience|null $audience Optional audience type for threshold adjustment
     * @return Result Analysis result
     * @throws ClientException When API request fails
     */
    public function check(string $text, ?ContentType $contentType = null, ?Audience $audience = null): Result
    {
        /** @var string[] $languages */
        $languages = config('sentinel.languages', ['en']);

        // Build request settings based on content type and audience
        $settings = $this->getApiSettings($contentType, $audience);

        $response = $this->post(
            'parse',
            [
                'content' => $text,
                'language' => implode('|', $languages),
                'settings' => $settings,
            ],
            [
                'Content-Type' => 'application/json',
                'Ocp-Apim-Subscription-Key' => $this->key,
            ],
        );

        /**
         * @var array{
         *   text: string,
         *   sentiment: float,
         *   topics?: array<string>,
         *   abuse?: array<array{
         *     type: string,
         *     severity: string,
         *     text: string,
         *     offset: int,
         *     length: int,
         *     sentence_index: int,
         *     explanation?: string,
         *   }>,
         *   sentiment_expressions?: array<array{
         *     sentence_index: int,
         *     offset: int,
         *     length: int,
         *     text: string,
         *     polarity: string,
         *     targets: array<string>,
         *     reasons?: array<string>,
         *     explanation?: string
         *   }>
         * } $response
         */
        $result = $this->pipeline->process(
            $this->adapter->adapt($text, $response),
        );

        // If contextual parameters were provided, include them in the result
        if (null !== $contentType || null !== $audience) {
            // Create a new result with contextual information
            $builder = ResultBuilder::withResult($result);
            // Apply contextual thresholds to determine if offensive
            $isOffensive = $result->offensive($contentType, $audience);
            $builder = $builder->withOffensive($isOffensive);

            // Add content type and audience
            if (null !== $contentType) {
                $builder = $builder->withContentType($contentType);
            }

            if (null !== $audience) {
                $builder = $builder->withAudience($audience);
            }

            return $builder->build();
        }

        return $result;
    }

    protected function baseUri(): string
    {
        return 'https://api.tisane.ai/';
    }

    /**
     * Get API settings based on content type and audience
     *
     * @param ContentType|null $contentType Content type
     * @param Audience|null $audience Audience
     * @return array<string, bool|float> API settings
     */
    private function getApiSettings(?ContentType $contentType, ?Audience $audience): array
    {
        // Base settings to always include
        $settings = [
            'snippets' => true,
            'abuse' => true,
            'sentiment' => true,
            'document_sentiment' => true,
            'profanity' => true,
        ];

        // Adjust settings based on content type
        if (null !== $contentType) {
            switch ($contentType) {
                case ContentType::Educational:
                case ContentType::Research:
                case ContentType::Medical:
                case ContentType::Legal:
                    // For academic/professional content, request explanations
                    // to better understand language
                    $settings['explanations'] = true;
                    // Focus less on profanity in professional contexts
                    $settings['profanity_threshold'] = 0.7;
                    break;

                case ContentType::News:
                    // For news, focus more on sentiment and topics
                    $settings['topics'] = true;
                    $settings['explanations'] = true;
                    break;

                case ContentType::SocialMedia:
                case ContentType::Forum:
                case ContentType::Blog:
                    // For user-generated content, focus on abuse detection
                    $settings['abuse_threshold'] = 0.6;
                    $settings['topics'] = true;
                    break;

                case ContentType::Chat:
                    // For chat, focus on immediate abuse detection
                    $settings['abuse_threshold'] = 0.5;
                    break;

                default:
                    // Use default settings
                    break;
            }
        }

        // Adjust settings based on audience
        if (null !== $audience) {
            switch ($audience) {
                case Audience::Children:
                    // Strict settings for children's content
                    $settings['abuse_threshold'] = 0.3;
                    $settings['profanity_threshold'] = 0.3;
                    break;

                case Audience::Teen:
                    // Moderately strict settings for teen content
                    $settings['abuse_threshold'] = 0.4;
                    $settings['profanity_threshold'] = 0.5;
                    break;

                case Audience::Adult:
                    // Standard settings for adult content
                    $settings['abuse_threshold'] = 0.6;
                    break;

                case Audience::Professional:
                    // Professional language focuses more on appropriateness
                    $settings['profanity_threshold'] = 0.7;
                    break;

            }
        }

        return $settings;
    }
}
