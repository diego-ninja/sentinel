<?php

namespace Ninja\Censor\Checkers;

use EchoLabs\Prism\Enums\Provider;
use EchoLabs\Prism\Prism;
use EchoLabs\Prism\Providers\Anthropic\Enums\AnthropicCacheType;
use EchoLabs\Prism\Structured\PendingRequest as StructuredPendingRequest;
use EchoLabs\Prism\Text\PendingRequest as UnstructuredPendingRequest;
use EchoLabs\Prism\ValueObjects\Messages\SystemMessage;
use EchoLabs\Prism\ValueObjects\Messages\UserMessage;
use InvalidArgumentException;
use JsonException;
use Ninja\Censor\Checkers\Contracts\ProfanityChecker;
use Ninja\Censor\Result\Result;
use Ninja\Censor\Schemas\CensorPrismSchema;
use Ninja\Censor\Services\Contracts\ServiceAdapter;
use Ninja\Censor\Services\Pipeline\TransformationPipeline;

/**
 * LLM-based profanity checker using Laravel Prism.
 */
final readonly class PrismAI implements ProfanityChecker
{
    public function __construct(
        private Prism $prism,
        private ServiceAdapter $adapter,
        private TransformationPipeline $pipeline,
    ) {}

    public function check(string $text): Result
    {
        /** @var Provider $provider */
        $provider = config('censor.services.prism.provider');

        /** @var string $model */
        $model = config('censor.services.prism.model');

        if ($this->supports_structured($provider)) {
            $response = $this->buildStructuredPrismRequest($provider, $model, $text)->generate();
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
             *         context?: array{original?: string, surrounding?: string}
             *     }>
             * } $data
             */
            $data = $response->structured;
        } else {
            $response = $this->buildUnstructuredPrismRequest($provider, $model, $text)->generate();
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
             *         context?: array{original?: string, surrounding?: string}
             *     }>
             * } $data
             */
            $data = $this->processUnstructuredResponse($response->text);
        }

        $serviceResponse = $this->adapter->adapt($text, $data);
        return $this->pipeline->process($serviceResponse);

    }

    private function buildStructuredPrismRequest(Provider $provider, string $model, string $message): StructuredPendingRequest
    {
        $instructions = file_get_contents(__DIR__ . '/../../resources/prompts/structured.txt');
        if (false === $instructions) {
            throw new InvalidArgumentException('Failed to read structured prompt file');
        }

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
                    'timeout' => config('censor.services.prism.timeout', 30),
                ])
                ->withSchema(new CensorPrismSchema());
        }

        return $this->prism->structured()
            ->using(
                provider: $provider,
                model: $model,
            )
            ->withSystemPrompt($instructions)
            ->withPrompt($message)
            ->withClientOptions([
                'timeout' => config('censor.services.prism.timeout', 30),
            ])
            ->withSchema(new CensorPrismSchema());
    }

    private function buildUnstructuredPrismRequest(Provider $provider, string $model, string $message): UnstructuredPendingRequest
    {
        $instructions = file_get_contents(__DIR__ . '/../../resources/prompts/unstructured.txt');
        if (false === $instructions) {
            throw new InvalidArgumentException('Failed to read unstructured prompt file');
        }

        return $this->prism->text()
            ->using(provider: $provider, model: $model)
            ->withSystemPrompt($instructions)
            ->withPrompt($message)
            ->withClientOptions([
                'timeout' => config('censor.services.prism.timeout', 30),
            ]);
    }

    /**
     * @param  array<string,mixed>  $data
     *
     * @throws InvalidArgumentException
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
     * @return array{is_offensive: bool, offensive_words: array<string>, categories: array<string>, confidence: float, severity: float}
     */
    private function processUnstructuredResponse(string $responseText): array
    {
        try {
            /** @var array{is_offensive: bool, offensive_words: array<string>, categories: array<string>, confidence: float, severity: float} $data */
            $data = json_decode($this->cleanResponseText($responseText), true, 512, JSON_THROW_ON_ERROR);
            $this->validateResponseStructure($data);

            return $data;
        } catch (JsonException|InvalidArgumentException $e) {
            throw new InvalidArgumentException('Invalid response format. Must be a valid JSON object.', 0, $e);
        }
    }

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

}
