<?php

namespace Ninja\Censor\Processors;

use Ninja\Censor\Collections\MatchCollection;
use Ninja\Censor\Collections\StrategyCollection;
use Ninja\Censor\Contracts\Processor;
use Ninja\Censor\Detection\Strategy\AffixStrategy;
use Ninja\Censor\Detection\Strategy\IndexStrategy;
use Ninja\Censor\Detection\Strategy\LevenshteinStrategy;
use Ninja\Censor\Detection\Strategy\NGramStrategy;
use Ninja\Censor\Detection\Strategy\PatternStrategy;
use Ninja\Censor\Detection\Strategy\RepeatedCharStrategy;
use Ninja\Censor\Detection\Strategy\VariationStrategy;
use Ninja\Censor\Dictionary\LazyDictionary;
use Ninja\Censor\Index\TrieIndex;
use Ninja\Censor\Result\AbstractResult;
use Ninja\Censor\Result\Builder\ResultBuilder;
use Ninja\Censor\Support\PatternGenerator;
use Ninja\Censor\Support\TextNormalizer;
use Ninja\Censor\Whitelist;

abstract class AbstractProcessor implements Processor
{
    protected StrategyCollection $strategies;

    protected string $replacer;

    public function __construct(
        private readonly PatternGenerator $generator,
        private readonly Whitelist $whitelist,
        private readonly LazyDictionary $dictionary
    ) {
        /** @var string $replaceChar */
        $replaceChar = config('censor.mask_char', '*');
        $this->replacer = $replaceChar;

        $this->initializeStrategies();
    }

    protected function initializeStrategies(): void
    {
        /** @var array<string> $words */
        $words = iterator_to_array($this->dictionary->getWords());
        $patterns = $this->generator->forWords($words);

        /** @var array<string> $prefixes */
        $prefixes = config('censor.prefixes', []);

        /** @var array<string> $suffixes */
        $suffixes = config('censor.suffixes', []);

        $this->strategies = new StrategyCollection;
        $this->strategies->addStrategy(new IndexStrategy(app(TrieIndex::class)));
        $this->strategies->addStrategy(new PatternStrategy($patterns));
        $this->strategies->addStrategy(new NGramStrategy);
        $this->strategies->addStrategy(new VariationStrategy(fullWords: true));
        $this->strategies->addStrategy(new AffixStrategy($prefixes, $suffixes));
        $this->strategies->addStrategy(new RepeatedCharStrategy);
        $this->strategies->addStrategy(new LevenshteinStrategy);
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
