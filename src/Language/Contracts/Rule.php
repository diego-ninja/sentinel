<?php

namespace Ninja\Sentinel\Language\Contracts;

use Illuminate\Support\Collection;

interface Rule
{
    /**
     * Apply rule to a word and return variants
     * @param string $word
     * @param Language $language
     * @return Collection<int, string>
     */
    public function __invoke(string $word, Language $language): Collection;

    public function name(): string;
}
