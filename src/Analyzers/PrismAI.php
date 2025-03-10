<?php

namespace Ninja\Sentinel\Analyzers;

use EchoLabs\Prism\Enums\Provider;
use EchoLabs\Prism\Prism;
use EchoLabs\Prism\Providers\Anthropic\Enums\AnthropicCacheType;
use EchoLabs\Prism\Structured\PendingRequest as StructuredPendingRequest;
use EchoLabs\Prism\Text\PendingRequest as UnstructuredPendingRequest;
use EchoLabs\Prism\ValueObjects\Messages\SystemMessage;
use EchoLabs\Prism\ValueObjects\Messages\UserMessage;
use InvalidArgumentException;
use JsonException;
use Ninja\Sentinel\Analyzers\Contracts\Analyzer;
use Ninja\Sentinel\Enums\Audience;
use Ninja\Sentinel\Enums\ContentType;
use Ninja\Sentinel\Result\Builder\ResultBuilder;
use Ninja\Sentinel\Result\Contracts\Result;
use Ninja\Sentinel\Schemas\SentinelPrismSchema;
use Ninja\Sentinel\Services\Contracts\ServiceAdapter;
use Ninja\Sentinel\Services\Pipeline\TransformationPipeline;

/**
 * LLM-based profanity checker using Laravel Prism.
 */
final readonly class PrismAI implements Analyzer
{
    public function __construct(
        private Prism $prism,
        private ServiceAdapter $adapter,
        private TransformationPipeline $pipeline,
    ) {}

    /**
     * Check text for offensive content using LLM analysis
     *
     * @param string $text Text to analyze
     * @param ContentType|null $contentType Optional content type for language-aware analysis
     * @param Audience|null $audience Optional audience type for appropriate thresholds
     * @return Result Analysis result
     */
    public function analyze(string $text, ?ContentType $contentType = null, ?Audience $audience = null): Result
    {
        /** @var Provider $provider */
        $provider = config('sentinel.services.prism_ai.provider');

        /** @var string $model */
        $model = config('sentinel.services.prism_ai.model');

        // Generate response from the LLM
        if ($this->supports_structured($provider)) {
            $response = $this->buildStructuredPrismRequest($provider, $model, $text, $contentType, $audience)->generate();
            /** @var array{
             *     is_offensive: bool,
             *     offensive_words: array<string>,
             *     categories: array<string>,
             *     confidence: float,
             *     severity: float,
             *     sentiment: array{type: string, score: float},
             *     matches: array<int, array{
             *         text: string,
             *         match_type: string,
             *         score: float,
             *         confidence: float,
             *         occurrences: array<int, array{start: int, length: int}>,
             *         language?: array{original?: string, surrounding?: string}
             *     }>
             * } $data
             */
            $data = $response->structured;
        } else {
            $response = $this->buildUnstructuredPrismRequest($provider, $model, $text, $contentType, $audience)->generate();
            /** @var array{
             *     is_offensive: bool,
             *     offensive_words: array<string>,
             *     categories: array<string>,
             *     confidence: float,
             *     severity: float,
             *     sentiment: array{type: string, score: float},
             *     matches: array<int, array{
             *         text: string,
             *         match_type: string,
             *         score: float,
             *         confidence: float,
             *         occurrences: array<int, array{start: int, length: int}>,
             *         language?: array{original?: string, surrounding?: string}
             *     }>
             * } $data
             */
            $data = $this->processUnstructuredResponse($response->text);
        }

        // Process response through adapter and pipeline
        $serviceResponse = $this->adapter->adapt($text, $data);
        $result = $this->pipeline->process($serviceResponse);

        // If audience or content type were provided, include them in the result
        if (null !== $contentType || null !== $audience) {
            // Create builder and add the language parameters
            $builder = ResultBuilder::withResult($result);

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

    /**
     * Build a structured request to Prism with language-aware instructions
     *
     * @param Provider $provider The LLM provider
     * @param string $model The model to use
     * @param string $message The text to analyze
     * @param ContentType|null $contentType Optional content type for language
     * @param Audience|null $audience Optional audience type for language
     * @return StructuredPendingRequest The pending request
     */
    private function buildStructuredPrismRequest(
        Provider $provider,
        string $model,
        string $message,
        ?ContentType $contentType = null,
        ?Audience $audience = null,
    ): StructuredPendingRequest {
        $instructions = file_get_contents(__DIR__ . '/../../resources/prompts/structured.txt');
        if (false === $instructions) {
            throw new InvalidArgumentException('Failed to read structured prompt file');
        }

        $instructions = $this->addContextInstructions($instructions, $audience, $contentType);

        if (Provider::Anthropic === $provider) {
            return $this->prism->structured()
                ->using(
                    provider: $provider,
                    model: $model,
                )
                ->withMessages([
                    (new SystemMessage($instructions))->withProviderMeta(Provider::Anthropic, ['cacheType' => AnthropicCacheType::Ephemeral]),
                    (new UserMessage($message))->withProviderMeta(Provider::Anthropic, ['cacheType' => AnthropicCacheType::Ephemeral]),
                ])
                ->withClientOptions([
                    'timeout' => config('sentinel.services.prism.timeout', 30),
                ])
                ->withSchema(new SentinelPrismSchema());
        }

        return $this->prism->structured()
            ->using(
                provider: $provider,
                model: $model,
            )
            ->withSystemPrompt($instructions)
            ->withPrompt($message)
            ->withClientOptions([
                'timeout' => config('sentinel.services.prism.timeout', 30),
            ])
            ->withSchema(new SentinelPrismSchema());
    }

    /**
     * Build an unstructured request to Prism with language-aware instructions
     *
     * @param Provider $provider The LLM provider
     * @param string $model The model to use
     * @param string $message The text to analyze
     * @param ContentType|null $contentType Optional content type for language
     * @param Audience|null $audience Optional audience type for language
     * @return UnstructuredPendingRequest The pending request
     */
    private function buildUnstructuredPrismRequest(
        Provider $provider,
        string $model,
        string $message,
        ?ContentType $contentType = null,
        ?Audience $audience = null,
    ): UnstructuredPendingRequest {
        $instructions = file_get_contents(__DIR__ . '/../../resources/prompts/unstructured.txt');
        if (false === $instructions) {
            throw new InvalidArgumentException('Failed to read unstructured prompt file');
        }

        $instructions = $this->addContextInstructions($instructions, $audience, $contentType);

        return $this->prism->text()
            ->using(provider: $provider, model: $model)
            ->withSystemPrompt($instructions)
            ->withPrompt($message)
            ->withClientOptions([
                'timeout' => config('sentinel.services.prism.timeout', 30),
            ]);
    }

    /**
     * Check if the provider supports structured responses
     *
     * @param Provider $provider The provider to check
     * @return bool True if structured responses are supported
     */
    private function supports_structured(Provider $provider): bool
    {
        return in_array($provider, [
            Provider::Anthropic,
            Provider::DeepSeek,
            Provider::OpenAI,
            Provider::Groq,
            Provider::Ollama,
        ]);
    }

    /**
     * Process unstructured response text into structured data
     *
     * @param string $responseText The response text
     * @return array{is_offensive: bool, offensive_words: array<string>, categories: array<string>, confidence: float, severity: float, sentiment: array{type: string, score: float}, matches: array<int, array{text: string, match_type: string, score: float, confidence: float, occurrences: array<int, array{start: int, length: int}>, language?: array{original?: string, surrounding?: string}}>}
     */
    private function processUnstructuredResponse(string $responseText): array
    {
        try {
            /** @var array{is_offensive: bool, offensive_words: array<string>, categories: array<string>, confidence: float, severity: float, sentiment: array{type: string, score: float}, matches: array<int, array{text: string, match_type: string, score: float, confidence: float, occurrences: array<int, array{start: int, length: int}>, language?: array{original?: string, surrounding?: string}}>} $data */
            $data = json_decode($this->cleanResponseText($responseText), true, 512, JSON_THROW_ON_ERROR);
            $this->validateResponseStructure($data);

            return $data;
        } catch (JsonException|InvalidArgumentException $e) {
            throw new InvalidArgumentException('Invalid response format. Must be a valid JSON object.', 0, $e);
        }
    }

    /**
     * Validate the response structure
     *
     * @param array<string,mixed> $data The data to validate
     * @throws InvalidArgumentException If the data structure is invalid
     */
    private function validateResponseStructure(array $data): void
    {
        $required = ['is_offensive', 'offensive_words', 'categories', 'confidence', 'severity'];

        foreach ($required as $field) {
            if ( ! isset($data[$field])) {
                throw new InvalidArgumentException("Missing required field: {$field}");
            }
        }

        if ( ! is_bool($data['is_offensive'])) {
            throw new InvalidArgumentException('is_offensive must be a boolean');
        }

        if ( ! is_array($data['offensive_words'])) {
            throw new InvalidArgumentException('offensive_words must be an array');
        }

        if ( ! is_array($data['categories'])) {
            throw new InvalidArgumentException('categories must be an array');
        }

        if ( ! is_numeric($data['confidence']) || $data['confidence'] < 0 || $data['confidence'] > 1) {
            throw new InvalidArgumentException('confidence must be a number between 0 and 1');
        }

        if ( ! is_numeric($data['severity']) || $data['severity'] < 0 || $data['severity'] > 1) {
            throw new InvalidArgumentException('severity must be a number between 0 and 1');
        }
    }

    /**
     * Clean the response text to extract JSON
     *
     * @param string $responseText The raw response text
     * @return string Clean JSON string
     */
    private function cleanResponseText(string $responseText): string
    {
        $start = mb_strpos($responseText, '{');
        $end = mb_strrpos($responseText, '}');

        if (false === $start || false === $end) {
            return $responseText;
        }

        $jsonPart = mb_substr($responseText, $start, $end - $start + 1);
        $jsonPart = preg_replace('/```json\s*|\s*```/', '', $jsonPart);

        return mb_trim($jsonPart ?? $responseText);
    }

    private function addContextInstructions(string $instructions, ?Audience $audience, ?ContentType $contentType): string
    {
        if (null !== $contentType || null !== $audience) {
            $contextInfo = "\n\nAdditional Context:\n";

            if (null !== $contentType) {
                $contextInfo .= "- Content Type: " . $contentType->value . "\n";
                $contextInfo .= $contentType->prompt();
            }

            if (null !== $audience) {
                $contextInfo .= "- Target Audience: " . $audience->value . "\n";
                $contextInfo .= $audience->prompt();
            }

            $instructions .= $contextInfo;
        }

        return $instructions;
    }
}
