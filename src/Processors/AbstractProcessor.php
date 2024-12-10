<?php

namespace Ninja\Censor\Processors;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\CircularDependencyException;
use Ninja\Censor\Collections\MatchCollection;
use Ninja\Censor\Collections\StrategyCollection;
use Ninja\Censor\Detection\Contracts\DetectionStrategy;
use Ninja\Censor\Dictionary\LazyDictionary;
use Ninja\Censor\Processors\Contracts\Processor;
use Ninja\Censor\Result\AbstractResult;
use Ninja\Censor\Result\Builder\ResultBuilder;
use Ninja\Censor\Support\TextNormalizer;
use Ninja\Censor\Whitelist;

abstract class AbstractProcessor implements Processor
{
    protected StrategyCollection $strategies;

    protected string $replacer;

    /**
     * @throws CircularDependencyException
     * @throws BindingResolutionException
     */
    public function __construct(
        private readonly Whitelist $whitelist,
        private readonly LazyDictionary $dictionary
    ) {
        /** @var string $replaceChar */
        $replaceChar = config('censor.mask_char', '*');
        $this->replacer = $replaceChar;

        $this->initializeStrategies();
    }

    /**
     * @throws CircularDependencyException
     * @throws BindingResolutionException
     */
    protected function initializeStrategies(): void
    {

        /** @var array<class-string<DetectionStrategy>> $strategies */
        $strategies = config('censor.services.local.strategies', []);

        $this->strategies = new StrategyCollection;
        foreach ($strategies as $strategy) {
            /** @var DetectionStrategy $class */
            $class = app()->build($strategy);
            $this->strategies->addStrategy($class);
        }
    }

    protected function processChunk(string $chunk): AbstractResult
    {
        $whitelisted = $this->whitelist->prepare($chunk);
        $normalized = TextNormalizer::normalize($whitelisted);

        /** @var string[] $words */
        $words = iterator_to_array($this->dictionary->getWords());
        $matches = $this->strategies->detect($normalized, $words);

        $cleaned = $matches->isEmpty() ? $normalized : $matches->clean($normalized);
        $finalText = $this->whitelist->restore($cleaned);

        return $this->buildResult($chunk, $finalText, $matches);
    }

    private function buildResult(
        string $original,
        string $finalText,
        MatchCollection $matches
    ): AbstractResult {
        return (new ResultBuilder)
            ->withOriginalText($original)
            ->withReplaced($finalText)
            ->withWords(array_unique($matches->words()))
            ->withScore($matches->score($original))
            ->withOffensive($matches->offensive($original))
            ->withConfidence($matches->confidence())
            ->withMatches($matches)
            ->build();
    }

    /**
     * Process multiple chunks of text.
     *
     * @param  array<string>  $chunks
     * @return array<AbstractResult>
     */
    abstract public function process(array $chunks): array;
}
