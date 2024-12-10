<?php

namespace Ninja\Censor\Detection\Strategy;

use Exception;
use InvalidArgumentException;
use Ninja\Censor\Cache\Contracts\PatternCache;
use Ninja\Censor\Collections\MatchCollection;
use Ninja\Censor\Detection\Contracts\DetectionStrategy;
use Ninja\Censor\Enums\MatchType;
use Ninja\Censor\Support\PatternGenerator;
use Ninja\Censor\ValueObject\Coincidence;

final readonly class PatternStrategy implements DetectionStrategy
{
    /** @var array<string> */
    private array $patterns;

    public function __construct(
        private PatternGenerator $generator,
        private PatternCache $cache
    ) {
        $this->patterns = $this->generator->getPatterns();

        foreach ($this->patterns as $pattern) {
            if (@preg_match($pattern, '') === false) {
                throw new InvalidArgumentException("Invalid regex pattern: $pattern");
            }

            $this->cache->set(md5($pattern), $pattern);
        }
    }

    public function detect(string $text, iterable $words): MatchCollection
    {

        $matches = new MatchCollection;

        if (count($this->patterns) === 0) {
            return $matches;
        }

        try {
            foreach ($this->patterns as $pattern) {
                $cachedPattern = $this->cache->get(md5($pattern));
                if ($cachedPattern === null) {
                    continue;
                }

                if (preg_match_all($cachedPattern, $text, $found) > 0) {
                    foreach ($found[0] as $match) {
                        $matches->addCoincidence(new Coincidence($match, MatchType::Pattern));
                    }
                }
            }
        } catch (Exception $e) {
            return $matches;
        }

        return $matches;
    }

    public function weight(): float
    {
        return MatchType::Pattern->weight();
    }
}
