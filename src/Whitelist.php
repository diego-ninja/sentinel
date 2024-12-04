<?php

namespace Ninja\Censor;

final class Whitelist
{
    private const PLACEHOLDER_PREFIX = '__WHITELIST_TERM_';

    private const PLACEHOLDER_SUFFIX = '__';

    /**
     * @var array<int, array<string, string>>
     */
    private array $whiteList = [];

    /**
     * @param  string[]  $list
     */
    public function add(array $list): self
    {
        foreach ($list as $value) {
            if (is_string($value)) {
                $this->whiteList[] = ['word' => $value];
            }
        }

        return $this;
    }

    public function replace(string $string, bool $reverse = false): string
    {
        foreach ($this->whiteList as $key => $list) {
            $placeHolder = self::PLACEHOLDER_PREFIX.$key.self::PLACEHOLDER_SUFFIX;
            if ($reverse) {
                $string = str_replace($placeHolder, $list['word'], $string);
            } else {
                $string = str_replace($list['word'], $placeHolder, $string);
            }
        }

        return $string;
    }
}
