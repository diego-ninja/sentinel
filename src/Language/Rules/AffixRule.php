<?php

namespace Ninja\Sentinel\Language\Rules;

use Illuminate\Support\Collection;
use Ninja\Sentinel\Language\Contracts\Language;
use Ninja\Sentinel\Language\Contracts\Rule;

final readonly class AffixRule implements Rule
{
    public function __invoke(string $word, Language $language): Collection
    {
        $prefixes = $language->prefixes();
        $suffixes = $language->suffixes();

        /** @var Collection<int, string> $variants */
        $variants = collect();
        $this->addSuffixVariants($word, $suffixes, $variants);
        $variants = $this->addPrefixVariants($word, $prefixes, $variants);

        return $variants->unique();
    }

    public function name(): string
    {
        return 'affix';
    }

    /**
     * @param string $word
     * @param Collection<int, string> $suffixes
     * @param Collection<int, string> $variants
     */
    private function addSuffixVariants(string $word, Collection $suffixes, Collection $variants): void
    {
        foreach ($suffixes as $suffix) {
            $variants->push($word . $suffix);
        }
    }

    /**
     * @param Collection<int, string> $prefixes
     * @param Collection<int, string> $variants
     * @return Collection<int, string>
     */
    private function addPrefixVariants(string $word, Collection $prefixes, Collection $variants): Collection
    {
        $prefixedVariants = collect();

        foreach ($prefixes as $prefix) {
            $prefixedVariants->push($prefix . $word);
            foreach ($variants as $suffixVariant) {
                $prefixedVariants->push($prefix . $suffixVariant);
            }
        }

        return $variants->merge($prefixedVariants);
    }
}