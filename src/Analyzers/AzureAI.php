<?php

namespace Ninja\Sentinel\Analyzers;

use GuzzleHttp\ClientInterface;
use Ninja\Sentinel\Enums\Audience;
use Ninja\Sentinel\Enums\ContentType;
use Ninja\Sentinel\Enums\LanguageCode;
use Ninja\Sentinel\Exceptions\ClientException;
use Ninja\Sentinel\Language\Collections\LanguageCollection;
use Ninja\Sentinel\Language\Language;
use Ninja\Sentinel\Result\Builder\ResultBuilder;
use Ninja\Sentinel\Result\Contracts\Result;
use Ninja\Sentinel\Services\Contracts\ServiceAdapter;
use Ninja\Sentinel\Services\Pipeline\TransformationPipeline;

final class AzureAI extends AbstractAnalyzer
{
    public const string DEFAULT_API_VERSION = '2024-09-01';

    public function __construct(
        private readonly string $endpoint,
        private readonly string $key,
        private readonly string $version,
        private readonly ServiceAdapter $adapter,
        private readonly TransformationPipeline $pipeline,
        ?ClientInterface $httpClient = null,
    ) {
        parent::__construct($httpClient);
    }

    /**
     * Check text for offensive content using Azure AI Content Safety
     *
     * @param string $text Text to analyze
     * @param ContentType|null $contentType Optional content type to adjust analysis
     * @param Audience|null $audience Optional audience type to adjust thresholds
     * @return Result Analysis result
     * @throws ClientException
     */
    public function analyze(string $text, ?Language $language = null, ?ContentType $contentType = null, ?Audience $audience = null): Result
    {
        $endpoint = sprintf('/content/safety/text:analyze?api-version=%s', $this->version);

        $language ??= app(LanguageCollection::class)->bestFor($text);

        // Adjust Azure request based on content type and audience
        $data = [
            'text' => $text,
            'categories' => [
                'Hate',
                'SelfHarm',
                'Sexual',
                'Violence',
            ],
            'outputType' => 'FourSeverityLevels',
            'blocklistsEnabled' => true,
        ];

        // Customize request parameters based on content type
        if (null !== $contentType) {
            // For educational or research content, adjust analysis parameters
            if (ContentType::Educational === $contentType || ContentType::Research === $contentType) {
                // We might want to be more permissive with certain categories
                $data['threshold'] = [
                    'Hate' => $this->getAdjustedThreshold('Hate', $contentType),
                    'SelfHarm' => $this->getAdjustedThreshold('SelfHarm', $contentType),
                    'Sexual' => $this->getAdjustedThreshold('Sexual', $contentType),
                    'Violence' => $this->getAdjustedThreshold('Violence', $contentType),
                ];
            }

            // For medical content, adjust sensitivity for medical terminology
            if (ContentType::Medical === $contentType) {
                $data['allowedTerms'] = $this->getMedicalAllowedTerms();
            }
        }

        // Make the API request
        $response = $this->post($endpoint, $data, [
            'Ocp-Apim-Subscription-Key' => $this->key,
            'Content-Type' => 'application/json',
        ]);

        // Process the response through the pipeline
        $result = $this->pipeline->process(
            $this->adapter->adapt($text, $response),
        );

        // If audience or content type were provided, include them in the result
        if (null !== $contentType || null !== $audience) {
            // Create a new builder with all the data from the existing result
            $builder = new ResultBuilder();
            $builder = $builder
                ->withLanguage($language?->code() ?? LanguageCode::English)
                ->withOriginalText($result->original())
                ->withReplaced($result->replaced())
                ->withWords($result->words())
                ->withScore($result->score())
                ->withConfidence($result->confidence())
                ->withSentiment($result->sentiment())
                ->withCategories($result->categories());

            if (null !== $result->matches()) {
                $builder = $builder->withMatches($result->matches());
            }

            // Apply appropriate thresholds based on content/audience
            $isOffensive = $result->offensive($contentType, $audience);
            $builder = $builder->withOffensive($isOffensive);

            // Add content type and audience to the result
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
        return mb_rtrim($this->endpoint, '/');
    }

    /**
     * Get adjusted threshold for a specific category based on content type
     *
     * @param string $category The Azure category name
     * @param ContentType $contentType The content type
     * @return float The adjusted threshold
     */
    private function getAdjustedThreshold(string $category, ContentType $contentType): float
    {
        // Default thresholds per category
        $defaultThresholds = [
            'Hate' => 0.5,
            'SelfHarm' => 0.5,
            'Sexual' => 0.5,
            'Violence' => 0.5,
        ];

        // Threshold adjustments for educational content - more permissive
        $educationalModifiers = [
            'Hate' => 0.3,      // 0.3 higher threshold (more permissive)
            'SelfHarm' => 0.2,  // 0.2 higher threshold (more permissive)
            'Sexual' => 0.3,    // 0.3 higher threshold (more permissive)
            'Violence' => 0.2,  // 0.2 higher threshold (more permissive)
        ];

        // Threshold adjustments for research content - more permissive
        $researchModifiers = [
            'Hate' => 0.4,      // 0.4 higher threshold (more permissive)
            'SelfHarm' => 0.3,  // 0.3 higher threshold (more permissive)
            'Sexual' => 0.4,    // 0.4 higher threshold (more permissive)
            'Violence' => 0.3,  // 0.3 higher threshold (more permissive)
        ];

        if (isset($defaultThresholds[$category])) {
            $baseThreshold = $defaultThresholds[$category];

            if (ContentType::Educational === $contentType && isset($educationalModifiers[$category])) {
                return min(0.9, $baseThreshold + $educationalModifiers[$category]);
            }

            if (ContentType::Research === $contentType && isset($researchModifiers[$category])) {
                return min(0.9, $baseThreshold + $researchModifiers[$category]);
            }

            return $baseThreshold;
        }

        return 0.5; // Default threshold if category not found
    }

    /**
     * Get a list of medical terms that should be allowed in medical content
     *
     * @return array<string> List of allowed medical terms
     */
    private function getMedicalAllowedTerms(): array
    {
        // This would normally be a much more comprehensive list
        // For now, just a small sample of medical terms that might otherwise be flagged
        return [
            'anal', 'penis', 'vagina', 'breast', 'rectum', 'testicle',
            'scrotum', 'urethra', 'ejaculation', 'erection', 'menstruation',
            'coitus', 'intercourse', 'sexual dysfunction',
        ];
    }
}
