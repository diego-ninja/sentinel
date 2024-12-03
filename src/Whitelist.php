<?php

namespace Ninja\Censor;

final class Whitelist
{
    /**
     * @var array<int, array<string, string>>
     */
    private array $whiteList = [];

    private string $whiteListPlaceHolder = ' {whiteList[i]} ';

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
            $placeHolder = str_replace('[i]', (string) $key, $this->whiteListPlaceHolder);
            if ($reverse) {
                $string = str_replace($placeHolder, $list['word'], $string);
            } else {
                $string = str_replace($list['word'], $placeHolder, $string);
            }
        }

        return $string;
    }
}
