<?php

namespace Ninja\Sentinel\Analyzers;

use GuzzleHttp\ClientInterface;
use Ninja\Sentinel\Enums\Audience;
use Ninja\Sentinel\Enums\ContentType;
use Ninja\Sentinel\Exceptions\ClientException;
use Ninja\Sentinel\Result\Builder\ResultBuilder;
use Ninja\Sentinel\Result\Contracts\Result;
use Ninja\Sentinel\Services\Contracts\ServiceAdapter;
use Ninja\Sentinel\Services\Pipeline\TransformationPipeline;

final class PerspectiveAI extends AbstractAnalyzer
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
     * Check text for offensive content using Perspective API
     *
     * @param string $text Text to analyze
     * @param ContentType|null $contentType Optional content type for language
     * @param Audience|null $audience Optional audience type for threshold adjustment
     * @return Result Analysis result
     * @throws ClientException When API request fails
     */
    public function analyze(string $text, ?ContentType $contentType = null, ?Audience $audience = null): Result
    {
        // Build the request parameters based on content type and audience
        $requestedAttributes = $this->getRequestedAttributes($contentType, $audience);

        $params = [
            'comment' => ['text' => $text],
            'languages' => config('sentinel.languages', ['en']),
            'requestedAttributes' => $requestedAttributes,
        ];

        // Add additional language-specific parameters
        if (null !== $contentType) {
            $params['language'] = [
                'entries' => [
                    [
                        'text' => $this->getContentTypeContext($contentType),
                    ],
                ],
            ];
        }

        // If we have an audience type, we might want to adjust analysis
        if (null !== $audience) {
            // Perspective doesn't directly support audience parameters,
            // but we can modify our later interpretation of the results
        }

        // Make the API request
        $response = $this->post(sprintf('comments:analyze?key=%s', $this->key), $params);

        // Process through adapter and pipeline
        $result = $this->pipeline->process(
            $this->adapter->adapt($text, $response),
        );

        // If contextual parameters were provided, include them in the result
        if (null !== $contentType || null !== $audience) {
            // The result already contains all analysis data, but we need to
            // add content type and audience information, and potentially
            // adjust the offensive flag based on contextual thresholds

            $builder = ResultBuilder::withResult($result);

            // Determine if content is offensive based on contextual thresholds
            $isOffensive = $result->offensive($contentType, $audience);
            $builder = $builder->withOffensive($isOffensive);

            // Set content type and audience
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
        return 'https://commentanalyzer.googleapis.com/v1alpha1/';
    }

    /**
     * Get requested attributes based on content type and audience
     *
     * @param ContentType|null $contentType Content type
     * @param Audience|null $audience Audience
     * @return array<string, array<string, mixed>> Requested attributes
     */
    private function getRequestedAttributes(?ContentType $contentType, ?Audience $audience): array
    {
        // Base attributes to always request
        $attributes = [
            'TOXICITY' => ['scoreType' => 'PROBABILITY', 'scoreThreshold' => 0],
            'SEVERE_TOXICITY' => ['scoreType' => 'PROBABILITY', 'scoreThreshold' => 0],
            'IDENTITY_ATTACK' => ['scoreType' => 'PROBABILITY', 'scoreThreshold' => 0],
            'INSULT' => ['scoreType' => 'PROBABILITY', 'scoreThreshold' => 0],
            'THREAT' => ['scoreType' => 'PROBABILITY', 'scoreThreshold' => 0],
            'PROFANITY' => ['scoreType' => 'PROBABILITY', 'scoreThreshold' => 0],
        ];

        // Adjust thresholds based on content type
        if (null !== $contentType) {
            switch ($contentType) {
                case ContentType::Educational:
                case ContentType::Research:
                case ContentType::Medical:
                    // More permissive for educational/research/medical content
                    $attributes['PROFANITY']['scoreThreshold'] = 0.7;
                    break;

                case ContentType::Legal:
                    // More permissive for legal content
                    $attributes['PROFANITY']['scoreThreshold'] = 0.6;
                    break;

                case ContentType::News:
                    // News might contain quotes of offensive content
                    $attributes['TOXICITY']['scoreThreshold'] = 0.6;
                    break;

                case ContentType::Chat:
                    // More strict for chat content
                    $attributes['TOXICITY']['scoreThreshold'] = 0.4;
                    $attributes['PROFANITY']['scoreThreshold'] = 0.4;
                    break;

                default:
                    // Use default thresholds
                    break;
            }
        }

        // Adjust thresholds based on audience
        if (null !== $audience) {
            switch ($audience) {
                case Audience::Children:
                    // Much stricter for children's content
                    $attributes['TOXICITY']['scoreThreshold'] = 0.3;
                    $attributes['PROFANITY']['scoreThreshold'] = 0.3;
                    $attributes['SEXUALLY_EXPLICIT'] = ['scoreType' => 'PROBABILITY', 'scoreThreshold' => 0.3];
                    break;

                case Audience::Teen:
                    // Moderately strict
                    $attributes['TOXICITY']['scoreThreshold'] = 0.5;
                    $attributes['PROFANITY']['scoreThreshold'] = 0.5;
                    break;

                case Audience::Adult:
                    // Standard thresholds
                    break;

                case Audience::Professional:
                    // Focus on professional contexts
                    $attributes['TOXICITY']['scoreThreshold'] = 0.6;
                    $attributes['PROFANITY']['scoreThreshold'] = 0.6;
                    break;

            }
        }

        // Add additional attributes if appropriate for content type
        if (ContentType::SocialMedia === $contentType) {
            $attributes['FLIRTATION'] = ['scoreType' => 'PROBABILITY', 'scoreThreshold' => 0];
        }

        return $attributes;
    }

    /**
     * Get language description for content type
     *
     * @param ContentType $contentType The content type
     * @return string Context description
     */
    private function getContentTypeContext(ContentType $contentType): string
    {
        return match ($contentType) {
            ContentType::Educational => "This is educational content, which may include terms used in an academic language.",
            ContentType::Research => "This is research content, which may include discussion of sensitive topics in a scholarly language.",
            ContentType::Medical => "This is medical content, which may include clinical terminology and discussions of the human body.",
            ContentType::Legal => "This is legal content, which may include quotations or case discussions with potentially offensive language.",
            ContentType::Blog => "This is blog content, which represents personal opinion.",
            ContentType::News => "This is news content, which may include quotes and reporting on sensitive topics.",
            ContentType::Forum => "This is forum content from an online discussion.",
            ContentType::SocialMedia => "This is social media content.",
            ContentType::Gaming => "This is gaming-related content.",
            ContentType::Chat => "This is from a chat or messaging conversation.",
        };
    }
}
