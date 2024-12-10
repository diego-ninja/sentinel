<?php

namespace Ninja\Censor\Checkers;

use Ninja\Censor\Result\Contracts\Result;
use Ninja\Censor\Result\PurgoMalumResult;

final class PurgoMalum extends AbstractProfanityChecker
{
    protected function baseUri(): string
    {
        return 'https://www.purgomalum.com/service/';
    }

    public function check(string $text): Result
    {
        $response = $this->get('json', [
            'text' => $text,
            'fill_char' => config('censor.mask_char'),
        ]);

        return PurgoMalumResult::fromResponse($text, $response);
    }
}
