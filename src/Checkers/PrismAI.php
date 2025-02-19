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
use Ninja\Censor\Enums\Category;
use Ninja\Censor\Result\Contracts\Result;
use Ninja\Censor\Result\PrismResult;
use Ninja\Censor\Schemas\CensorPrismSchema;
use Ninja\Censor\ValueObject\Confidence;
use Ninja\Censor\ValueObject\Score;

/**
 * LLM-based profanity checker using Laravel Prism.
 */
final readonly class PrismAI implements ProfanityChecker
{
    public function __construct(
        private Prism $prism,
    ) {}

    public function check(string $text): Result
    {
        /** @var Provider $provider */
        $provider = config('censor.services.prism.provider');

        /** @var string $model */
        $model = config('censor.services.prism.model');

        if ($this->supports_structured($provider)) {
            $response = $this->buildStructuredPrismRequest($provider, $model, $this->buildInstructions(), $text)->generate();
            /** @var array{is_offensive: bool, offensive_words: array<string>, categories: array<string>, confidence: float, severity: float} $data */
            $data = $response->structured;
        } else {
            $response = $this->buildUnstructuredPrismRequest($provider, $model, $this->buildInstructions(), $text)->generate();
            /** @var array{is_offensive: bool, offensive_words: array<string>, categories: array<string>, confidence: float, severity: float} $data */
            $data = $this->processUnstructuredResponse($response->text);
        }

        return new PrismResult(
            offensive: $data['is_offensive'],
            words: $data['offensive_words'],
            replaced: $this->replaceWords($text, $data['offensive_words']),
            original: $text,
            matches: null,
            score: new Score($data['severity']),
            confidence: new Confidence($data['confidence']),
            categories: $this->mapCategories($data['categories']),
        );
    }

    /**
     * Replace offensive words with asterisks
     *
     * @param  string  $text  Original text
     * @param  array<string>  $words  List of words to replace
     * @return string Text with offensive words replaced
     */
    private function replaceWords(string $text, array $words): string
    {
        $replaced = $text;
        foreach ($words as $word) {
            $replaced = str_replace(
                $word,
                str_repeat('*', mb_strlen($word)),
                $replaced,
            );
        }

        return $replaced;
    }

    private function buildStructuredPrismRequest(Provider $provider, string $model, string $instructions, string $message): StructuredPendingRequest
    {
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

    private function buildUnstructuredPrismRequest(Provider $provider, string $model, string $instructions, string $message): UnstructuredPendingRequest
    {
        return $this->prism->text()
            ->using(provider: $provider, model: $model)
            ->withSystemPrompt($instructions)
            ->withPrompt($this->buildPromptForUnstructuredProvider($message))
            ->withClientOptions([
                'timeout' => config('censor.services.prism.timeout', 30),
            ]);
    }

    private function buildPromptForUnstructuredProvider(string $message): string
    {
        return <<<PROMPT
    Analyze this text for inappropriate or offensive content: {$message}

    You must respond with ONLY a valid JSON object using this exact structure, with no additional text before or after, and no markup formatting:
    {
        "is_offensive": boolean,
        "offensive_words": string[],
        "categories": string[],
        "confidence": number between 0 and 1,
        "severity": number between 0 and 1
    }
    PROMPT;
    }

    /**
     * @param  array<string>  $categories
     * @return array<Category>
     */
    private function mapCategories(array $categories): array
    {
        return array_map(
            function (string $category) {
                return match (mb_strtolower($category)) {
                    'hate_speech', 'hate' => Category::HateSpeech,
                    'harassment' => Category::Harassment,
                    'sexual', 'adult' => Category::Sexual,
                    'violence' => Category::Violence,
                    'threat' => Category::Threat,
                    'toxicity' => Category::Toxicity,
                    default => Category::Profanity,
                };
            },
            array_unique($categories),
        );
    }

    private function buildInstructions(): string
    {


        return 'Analyze the following text for inappropriate content, profanity, and offensive language. ' .
            'Consider the context and provide detailed detection results. ' .
            'Pay attention to attempted obfuscation or creative spelling of offensive words. ' .
            'Only mark content as offensive if it would be inappropriate in a professional context. ' .
            'Use any of the following categories: hate_speech, harassment, sexual, violence, adult, threat, toxicity, or profanity. ' .
            'Use the following languages: ' . implode(', ', (array) config('censor.languages', ['en']));
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
