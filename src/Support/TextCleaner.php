<?php

namespace Ninja\Censor\Support;

use Ninja\Censor\Collections\MatchCollection;

final readonly class TextCleaner
{
    public static function clean(string $text, MatchCollection $matches): string
    {
        /** @var string $replacer */
        $replacer = config('censor.mask_char', '*');

        $clean = $text;
        foreach ($matches as $match) {
            $clean = str_replace(
                $match->word,
                str_repeat($replacer, mb_strlen($match->word)),
                $clean
            );
        }

        return $clean;
    }
}