<?php

namespace Ninja\Censor\Detection;

use Exception;
use InvalidArgumentException;
use Ninja\Censor\Contracts\DetectionStrategy;
use RuntimeException;

final readonly class PatternStrategy implements DetectionStrategy
{
    /**
     * @param  array<string>  $patterns
     */
    public function __construct(
        private array $patterns,
        private string $replacer
    ) {
        foreach ($this->patterns as $pattern) {
            if (@preg_match($pattern, '') === false) {
                throw new InvalidArgumentException("Invalid regex pattern: $pattern");
            }
        }
    }

    public function detect(string $text, array $words): array
    {
        if (count($this->patterns) === 0) {
            return [
                'clean' => $text,
                'matches' => [],
            ];
        }

        $matches = [];
        $clean = $text;

        try {
            $clean = preg_replace_callback(
                $this->patterns,
                function ($match) use (&$matches) {
                    $matches[] = ['word' => $match[0], 'type' => 'exact'];

                    return str_repeat($this->replacer, mb_strlen($match[0]));
                },
                $text
            );

            if ($clean === null) {
                throw new RuntimeException('Pattern matching failed');
            }
        } catch (Exception $e) {
            return [
                'clean' => $text,
                'matches' => [],
            ];
        }

        return [
            'clean' => $clean,
            'matches' => $matches,
        ];
    }
}
