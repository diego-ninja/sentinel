<?php

namespace Ninja\Sentinel\Language\Collections;

use Illuminate\Support\Collection;
use Ninja\Sentinel\Language\Contracts\Rule;
use Ninja\Sentinel\Language\Language;

/**
 * Collection of language rules
 *
 * @extends Collection<int, Rule>
 */
class RuleCollection extends Collection
{
    /**
     * Apply all rules to a word and return variants
     * @param string[] $words
     * @param Language $language
     * @return Collection<int, string>
     */
    public function apply(array $words, Language $language): Collection
    {
        /** @var Collection<int, string> $variants */
        $variants = new Collection();

        foreach ($words as $word) {
            $this->each(function (Rule $rule) use (&$variants, $word, $language): void {
                /** @var Collection<int, string> $ruleVariants */
                $ruleVariants = $rule($word, $language);

                $variants = $variants->merge(collect($ruleVariants));
            });
        }

        return $variants;
    }

    public function findByName(string $name): ?Rule
    {
        return $this->first(fn(Rule $rule) => $rule->name() === $name);
    }
}
