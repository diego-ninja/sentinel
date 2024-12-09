<?php

namespace Ninja\Censor\Detection\Strategy;

use Exception;
use InvalidArgumentException;
use Ninja\Censor\Cache\PatternCache;
use Ninja\Censor\Collections\MatchCollection;
use Ninja\Censor\Contracts\DetectionStrategy;
use Ninja\Censor\Enums\MatchType;
use Ninja\Censor\ValueObject\Coincidence;

final readonly class PatternStrategy implements DetectionStrategy
{
    private PatternCache $cache;

    /**
     * @param  array<string>  $patterns
     */
    public function __construct(
        private array $patterns
    ) {
        $this->cache = new PatternCache;

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
                        $matches->add(new Coincidence($match, MatchType::Pattern));
                    }
                }
            }
        } catch (Exception $e) {
            return $matches;
        }

        return $matches;
    }
}
