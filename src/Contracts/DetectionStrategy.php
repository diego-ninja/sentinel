<?php

namespace Ninja\Censor\Contracts;

interface DetectionStrategy
{
    /**
     * @param  array<string>  $words
     * @return array{
     *     clean: string,
     *     matches: array<int, array{word: string, type: string}>
     * }
     */
    public function detect(string $text, array $words): array;
}
