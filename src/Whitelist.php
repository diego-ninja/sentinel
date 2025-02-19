<?php

namespace Ninja\Censor;

final class Whitelist
{
    private const PLACEHOLDER_PREFIX = '__WHITELIST_TERM_';

    private const PLACEHOLDER_SUFFIX = '__';

    /**
     * @var array<string, string>
     */
    private array $whiteList = [];

    /**
     * @var array<string, array{start: int, end: int, word: string}>
     */
    private array $positions = [];

    /**
     * @param  string[]  $list
     */
    public function add(array $list): self
    {
        foreach ($list as $word) {
            if (is_string($word)) {
                $this->whiteList[$word] = $word;
            }
        }

        return $this;
    }

    public function prepare(string $text): string
    {
        $this->positions = [];
        $processed = $text;

        foreach ($this->whiteList as $word) {
            $pos = 0;
            while (($pos = mb_stripos($processed, $word, $pos)) !== false) {
                $before = $pos > 0 ? mb_substr($processed, $pos - 1, 1) : ' ';
                $after = $pos + mb_strlen($word) < mb_strlen($processed)
                    ? mb_substr($processed, $pos + mb_strlen($word), 1)
                    : ' ';

                if (preg_match('/\s/', $before) && preg_match('/\s/', $after)) {
                    $placeholder = $this->createPlaceholder($word, $pos);
                    $this->positions[$placeholder] = [
                        'start' => $pos,
                        'end' => $pos + mb_strlen($word),
                        'word' => $word,
                    ];

                    $processed = mb_substr($processed, 0, $pos) .
                        $placeholder .
                        mb_substr($processed, $pos + mb_strlen($word));

                    $pos += mb_strlen($placeholder);
                } else {
                    $pos++;
                }
            }
        }

        return $processed;
    }

    public function restore(string $text): string
    {
        $result = $text;

        foreach ($this->positions as $placeholder => $info) {
            $result = str_replace($placeholder, $info['word'], $result);
        }

        return $result;
    }

    /**
     * Get all protected word positions.
     *
     * @return array<string, array{start: int, end: int, word: string}>
     */
    public function positions(): array
    {
        return $this->positions;
    }

    public function protected(int $start, int $length): bool
    {
        foreach ($this->positions as $info) {
            if ($this->overlaps($start, $length, $info['start'], $info['end'] - $info['start'])) {
                return true;
            }
        }

        return false;
    }

    private function createPlaceholder(string $word, int $position): string
    {
        return sprintf('%s%s%s', self::PLACEHOLDER_PREFIX, md5($word . $position), self::PLACEHOLDER_SUFFIX);
    }

    private function overlaps(int $start1, int $length1, int $start2, int $length2): bool
    {
        $end1 = $start1 + $length1;
        $end2 = $start2 + $length2;

        return $start1 < $end2 && $start2 < $end1;
    }
}
