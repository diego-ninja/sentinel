<?php

namespace Ninja\Sentinel\Cache\Contracts;

interface PatternCache
{
    public function get(string $key): ?string;

    public function set(string $key, string $pattern): void;
}
