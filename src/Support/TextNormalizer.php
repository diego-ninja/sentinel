<?php

namespace Ninja\Censor\Support;

use Normalizer;

final class TextNormalizer
{
    public static function normalize(string $text): string
    {
        // Remove zero-width characters
        $replaced = preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $text);

        if ($replaced === null) {
            return $text;
        }

        $normalized = normalizer_normalize($replaced, Normalizer::FORM_C);
        if ($normalized === false) {
            return $text;
        }

        return $normalized;
    }

    public static function removeInvisibleCharacters(string $text): ?string
    {
        return preg_replace('/\p{C}/u', '', $text);
    }
}
