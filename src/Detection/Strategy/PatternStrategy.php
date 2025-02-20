<?php

namespace Ninja\Sentinel\Detection\Strategy;

use InvalidArgumentException;
use Ninja\Sentinel\Cache\Contracts\PatternCache;
use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Support\Calculator;
use Ninja\Sentinel\Support\PatternGenerator;
use Ninja\Sentinel\ValueObject\Coincidence;
use Ninja\Sentinel\ValueObject\Position;

final class PatternStrategy extends AbstractStrategy
{
    /** @var array<string> */
    private array $patterns;

    public function __construct(
        private readonly PatternGenerator $generator,
        private readonly PatternCache $cache,
    ) {
        $this->patterns = $this->generator->getPatterns();

        foreach ($this->patterns as $pattern) {
            if (false === @preg_match($pattern, '')) {
                throw new InvalidArgumentException("Invalid regex pattern: {$pattern}");
            }

            $this->cache->set(md5($pattern), $pattern);
        }
    }

    public function detect(string $text, iterable $words): MatchCollection
    {
        $matches = new MatchCollection();

        foreach ($this->patterns as $pattern) {
            $cachedPattern = $this->cache->get(md5($pattern));
            if (null === $cachedPattern) {
                continue;
            }

            if (preg_match_all($cachedPattern, $text, $found, PREG_OFFSET_CAPTURE) > 0) {
                foreach ($found[0] as [$match, $offset]) {
                    $occurrences = new OccurrenceCollection([
                        new Position($offset, mb_strlen($match)),
                    ]);

                    $matches->addCoincidence(
                        new Coincidence(
                            word: $match,
                            type: MatchType::Pattern,
                            score: Calculator::score($text, $match, MatchType::Pattern, $occurrences),
                            confidence: Calculator::confidence($text, $match, MatchType::Pattern, $occurrences),
                            occurrences: $occurrences,
                            context: ['pattern' => $pattern],
                        ),
                    );
                }
            }
        }

        return $matches;
    }

    public function weight(): float
    {
        return MatchType::Pattern->weight();
    }
}
