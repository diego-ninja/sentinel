<?php

namespace Ninja\Sentinel\Decorators;

use Illuminate\Support\Facades\Cache;
use Ninja\Sentinel\Analyzers\Contracts\Analyzer;
use Ninja\Sentinel\Enums\Audience;
use Ninja\Sentinel\Enums\ContentType;
use Ninja\Sentinel\Enums\LanguageCode;
use Ninja\Sentinel\Language\Language;
use Ninja\Sentinel\Result\Contracts\Result;

final readonly class CachedAnalyzer implements Analyzer
{
    public function __construct(
        private Analyzer $analyzer,
        private int      $ttl = 3600, // 1 hour by default
    ) {}

    public function analyze(string $text, ?Language $language = null, ?ContentType $contentType = null, ?Audience $audience = null): Result
    {
        $cacheKey = sprintf(
            'sentinel:%s:%s:%s:%s:%s',
            class_basename($this->analyzer),
            md5($text),
            $contentType->value ?? 'null',
            $audience->value ?? 'null',
            $language?->code()->value ?? LanguageCode::English->value,
        );

        /** @var string $store */
        $store = config('sentinel.cache.store', 'default');

        /** @var Result $result */
        $result = Cache::store($store)->remember($cacheKey, $this->ttl, fn(): Result => $this->analyzer->analyze(
            text: $text,
            language: $language,
            contentType: $contentType,
            audience: $audience,
        ));

        return $result;
    }
}
