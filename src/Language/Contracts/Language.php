<?php

namespace Ninja\Sentinel\Language\Contracts;

use Illuminate\Support\Collection;
use Ninja\Sentinel\Dictionary\LazyDictionary;
use Ninja\Sentinel\Enums\LanguageCode;
use Ninja\Sentinel\Language\DTO\DetectionResult;

interface Language
{
    public function detect(string $text): DetectionResult;

    public function words(): LazyDictionary;

    /**
     * @return Collection<int, string>
     */
    public function intensifiers(): Collection;

    /**
     * @return Collection<int, string>
     */
    public function modifiers(string $type): Collection;

    /**
     * @return Collection<int, string>
     */
    public function prefixes(): Collection;

    /**
     * @return Collection<int, string>
     */
    public function suffixes(): Collection;

    /**
     * @return Collection<int, Context>
     */
    public function contexts(): Collection;

    /**
     * @return LanguageCode
     */
    public function code(): LanguageCode;
}