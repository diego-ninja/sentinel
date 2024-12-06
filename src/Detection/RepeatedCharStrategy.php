<?php

namespace Ninja\Censor\Detection;

use Ninja\Censor\Contracts\DetectionStrategy;

final readonly class RepeatedCharStrategy implements DetectionStrategy
{
    public function __construct(private string $replacer) {}

    public function detect(string $text, array $words): array
    {
        $matches = [];
        $clean = $text;

        foreach ($words as $badWord) {
            if (! $this->hasRepeatedChars($text)) {
                continue;
            }

            $pattern = '/\b';
            foreach (str_split($badWord) as $char) {
                $pattern .= preg_quote($char, '/').'+';
            }
            $pattern .= '\b/iu';

            if (preg_match_all($pattern, $text, $found) !== false) {
                foreach ($found[0] as $match) {
                    if ($this->hasRepeatedChars($match)) {
                        $matches[] = [
                            'word' => $match,
                            'type' => 'repeated',
                        ];
                        $clean = str_replace(
                            $match,
                            str_repeat($this->replacer, mb_strlen($match)),
                            $clean
                        );
                    }
                }
            }
        }

        return [
            'clean' => $clean,
            'matches' => $matches,
        ];
    }

    private function hasRepeatedChars(string $text): bool
    {
        return (bool) preg_match('/(.)\1+/u', $text);
    }
}
