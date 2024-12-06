<?php

namespace Ninja\Censor\Detection;

use Ninja\Censor\Contracts\DetectionStrategy;

final readonly class NGramStrategy implements DetectionStrategy
{
    public function __construct(private string $replacer) {}

    public function detect(string $text, array $words): array
    {
        $matches = [];
        $clean = $text;

        $phrases = array_filter($words, fn ($word) => str_contains($word, ' '));

        foreach ($phrases as $phrase) {
            $phrasePattern = preg_quote(mb_strtolower($phrase), '/');
            $pattern = '/\b'.$phrasePattern.'\b/iu';

            if (preg_match_all($pattern, mb_strtolower($text), $found, PREG_OFFSET_CAPTURE) !== false) {
                foreach ($found[0] as $match) {
                    $originalText = substr($text, $match[1], strlen($match[0]));
                    $matches[] = [
                        'word' => $originalText,
                        'type' => 'ngram',
                    ];

                    $clean = substr_replace(
                        $clean,
                        str_repeat($this->replacer, mb_strlen($originalText)),
                        $match[1],
                        strlen($match[0])
                    );
                }
            }
        }

        return [
            'clean' => $clean,
            'matches' => $matches,
        ];
    }
}
