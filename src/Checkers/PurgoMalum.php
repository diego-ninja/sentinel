<?php

namespace Ninja\Sentinel\Checkers;

use GuzzleHttp\ClientInterface;
use Ninja\Sentinel\Result\Contracts\Result;
use Ninja\Sentinel\Services\Contracts\ServiceAdapter;
use Ninja\Sentinel\Services\Pipeline\TransformationPipeline;

final class PurgoMalum extends AbstractProfanityChecker
{
    public function __construct(
        private readonly ServiceAdapter $adapter,
        private readonly TransformationPipeline $pipeline,
        protected ?ClientInterface $client = null,
    ) {
        parent::__construct($client);
    }

    public function check(string $text): Result
    {
        $response = $this->get('json', [
            'text' => $text,
            'fill_char' => config('sentinel.mask_char'),
        ]);

        return $this->pipeline->process(
            $this->adapter->adapt($text, $response),
        );
    }

    protected function baseUri(): string
    {
        return 'https://www.purgomalum.com/service/';
    }
}
