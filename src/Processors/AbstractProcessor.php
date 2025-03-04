<?php

namespace Ninja\Sentinel\Processors;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\CircularDependencyException;
use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Collections\StrategyCollection;
use Ninja\Sentinel\Detection\Contracts\DetectionStrategy;
use Ninja\Sentinel\Language\Collections\LanguageCollection;
use Ninja\Sentinel\Processors\Contracts\Processor;
use Ninja\Sentinel\Result\Builder\ResultBuilder;
use Ninja\Sentinel\Result\Result;
use Ninja\Sentinel\Support\Calculator;
use Ninja\Sentinel\Support\TextNormalizer;
use Ninja\Sentinel\ValueObject\Coincidence;
use Ninja\Sentinel\ValueObject\Position;
use Ninja\Sentinel\Whitelist;

abstract class AbstractProcessor implements Processor
{
    protected StrategyCollection $strategies;

    protected string $replacer;

    /**
     * @throws CircularDependencyException
     * @throws BindingResolutionException
     */
    public function __construct(
        private readonly LanguageCollection $languages,
        private readonly Whitelist $whitelist,
    ) {
        /** @var string $replaceChar */
        $replaceChar = config('sentinel.mask_char', '*');
        $this->replacer = $replaceChar;

        $this->initializeStrategies();
    }

    /**
     * Process multiple chunks of a text.
     *
     * @param  array<string>  $chunks
     * @return array<Result>
     */
    abstract public function process(array $chunks): array;

    /**
     * @throws CircularDependencyException
     * @throws BindingResolutionException
     */
    protected function initializeStrategies(): void
    {
        /** @var array<class-string<DetectionStrategy>> $strategies */
        $strategies = config('sentinel.services.local.strategies', []);

        $this->strategies = new StrategyCollection();
        foreach ($strategies as $strategy) {
            /** @var DetectionStrategy $class */
            $class = app()->build($strategy);
            $this->strategies->addStrategy($class);
        }

        /** @var array<string, mixed> $earlyTermination */
        $earlyTermination = config('sentinel.services.local.early_termination', []);

        /** @var bool $enabled */
        $enabled = $earlyTermination['enabled'] ?? true;

        /** @var float $threshold */
        $threshold = $earlyTermination['threshold'] ?? 0.8;

        /** @var int $batchSize */
        $batchSize = $earlyTermination['batch_size'] ?? 3;

        $this->strategies
            ->useEarlyTermination($enabled, $threshold)
            ->setBatchSize($batchSize);
    }

    protected function processChunk(string $chunk): Result
    {
        $whitelisted = $this->whitelist->prepare($chunk);
        $normalized = TextNormalizer::normalize($whitelisted);

        $language = $this->languages->bestFor($normalized);
        $matches = $this->strategies->detect($normalized, $language);

        if ($matches->isEmpty()) {
            return $this->buildResult($chunk, $normalized, $matches);
        }

        $cleaned = $matches->clean($normalized);
        $finalText = $this->whitelist->restore($cleaned);

        return $this->buildResult($chunk, $finalText, $matches);
    }

    /**
     * @param  array<Result>  $results
     */
    protected function merge(array $results): Result
    {
        $matches = new MatchCollection();
        $replaced = '';
        $original = implode('', array_map(fn($r) => $r->original(), $results));

        if (1 === count($results)) {
            return $results[0];
        }

        foreach ($results as $result) {
            foreach ($result->matches() ?? new MatchCollection() as $match) {
                $positions = [];
                $pos = 0;
                while (($pos = mb_stripos($original, $match->word(), $pos)) !== false) {
                    $positions[] = new Position($pos, mb_strlen($match->word()));
                    $pos += mb_strlen($match->word());
                }

                if ( ! empty($positions)) {
                    $occurrences = new OccurrenceCollection($positions);
                    $matches->addCoincidence(
                        new Coincidence(
                            word: $match->word(),
                            type: $match->type(),
                            score: Calculator::score($original, $match->word(), $match->type(), $occurrences, $this->languages->findByCode($match->language())),
                            confidence: Calculator::confidence($original, $match->word(), $match->type(), $occurrences),
                            occurrences: $occurrences,
                            language: $match->language(),
                            context: $match->context(),
                        ),
                    );
                }
            }
            $replaced .= $result->replaced();
        }

        return $this->buildResult($original, $replaced, $matches);
    }

    private function buildResult(
        string $original,
        string $finalText,
        MatchCollection $matches,
    ): Result {
        return (new ResultBuilder())
            ->withOriginalText($original)
            ->withReplaced($finalText)
            ->withWords(array_unique($matches->words()))
            ->withScore($matches->score())
            ->withOffensive($matches->offensive())
            ->withConfidence($matches->confidence())
            ->withMatches($matches)
            ->build();
    }
}
