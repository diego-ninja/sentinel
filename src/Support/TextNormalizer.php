<?php

namespace Ninja\Sentinel\Support;

use Normalizer;

final class TextNormalizer
{
    public static function normalize(string $text): string
    {
        // Remove zero-width characters
        $replaced = preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $text);

        if (null === $replaced) {
            return $text;
        }

        $normalized = normalizer_normalize($replaced, Normalizer::FORM_C);
        if (false === $normalized) {
            return $text;
        }

        return $normalized;
    }
}
