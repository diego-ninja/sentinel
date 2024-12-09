<?php

namespace Ninja\Censor\Processors;

use Ninja\Censor\Collections\MatchCollection;
use Ninja\Censor\Contracts\DetectionStrategy;
use Ninja\Censor\Contracts\Processor;
use Ninja\Censor\Detection\Strategy\LevenshteinStrategy;
use Ninja\Censor\Detection\Strategy\NGramStrategy;
use Ninja\Censor\Detection\Strategy\PatternStrategy;
use Ninja\Censor\Detection\Strategy\RepeatedCharStrategy;
use Ninja\Censor\Detection\Strategy\VariationStrategy;
use Ninja\Censor\Detection\Strategy\AffixStrategy;
use Ninja\Censor\Dictionary\LazyDictionary;
use Ninja\Censor\Enums\MatchType;
use Ninja\Censor\Index\TrieIndex;
use Ninja\Censor\Result\AbstractResult;
use Ninja\Censor\Result\Builder\ResultBuilder;
use Ninja\Censor\Support\PatternGenerator;
use Ninja\Censor\Support\TextNormalizer;
use Ninja\Censor\ValueObject\Coincidence;
use Ninja\Censor\Whitelist;

abstract class AbstractProcessor implements Processor
{
    /** @var array<DetectionStrategy> */
    protected array $strategies = [];

    protected string $replacer;

    public function __construct(
        private readonly PatternGenerator $generator,
        private readonly Whitelist $whitelist,
        private readonly LazyDictionary $dictionary,
        private readonly TrieIndex $index,
    ) {
        /** @var string $replaceChar */
        $replaceChar = config('censor.mask_char', '*');
        $this->replacer = $replaceChar;

        $this->initializeStrategies();
    }

    protected function processChunk(string $chunk): AbstractResult
    {
        $original = TextNormalizer::normalize($this->whitelist->replace($chunk));

        $processedWords = [];
        $allMatches = new MatchCollection;
        $final = $original;

        $textWords = explode(' ', mb_strtolower($chunk));
        foreach ($textWords as $word) {
            if ($this->index->search($word)) {
                $allMatches->add(new Coincidence($word, MatchType::Trie));
                $processedWords[] = $word;
            }
        }

        /** @var array<string> $words */
        $words = iterator_to_array($this->dictionary->getWords());

        foreach ($this->strategies as $strategy) {
            $result = $strategy->detect($original, $words);
            if (! $result->isEmpty()) {
                foreach ($result as $match) {
                    if (! in_array($match->word, $processedWords, true)) {
                        $allMatches->add($match);
                        $processedWords[] = $match->word;
                    }
                }
            }
        }

        $builder = new ResultBuilder;

        return $builder
            ->withOriginalText($chunk)
            ->withReplaced($allMatches->clean($final))
            ->withWords(array_unique($processedWords))
            ->withScore($allMatches->score($chunk))
            ->withOffensive($allMatches->offensive($chunk))
            ->withConfidence($allMatches->confidence())
            ->withMatches($allMatches)
            ->build();

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


        $this->strategies = [
            new PatternStrategy($patterns),
            new NGramStrategy,
            new VariationStrategy(fullWords: true),
            new AffixStrategy($prefixes, $suffixes),
            new RepeatedCharStrategy,
            new LevenshteinStrategy,
        ];
    }
}
