<?php

namespace Ninja\Sentinel\Checkers;

use GuzzleHttp\ClientInterface;
use Ninja\Sentinel\Exceptions\ClientException;
use Ninja\Sentinel\Result\Contracts\Result;
use Ninja\Sentinel\Services\Contracts\ServiceAdapter;
use Ninja\Sentinel\Services\Pipeline\TransformationPipeline;

final class PerspectiveAI extends AbstractProfanityChecker
{
    public function __construct(
        private readonly string $key,
        private readonly ServiceAdapter $adapter,
        private readonly TransformationPipeline $pipeline,
        protected ?ClientInterface $client = null,
    ) {
        parent::__construct($client);
    }

    /**
     * @throws ClientException
     */
    public function check(string $text): Result
    {
        $params = [
            'comment' => ['text' => $text],
            'languages' => config('sentinel.languages', ['en']),
            'requestedAttributes' => [
                'TOXICITY' => ['scoreType' => 'PROBABILITY', 'scoreThreshold' => 0],
                'SEVERE_TOXICITY' => ['scoreType' => 'PROBABILITY', 'scoreThreshold' => 0],
                'IDENTITY_ATTACK' => ['scoreType' => 'PROBABILITY', 'scoreThreshold' => 0],
                'INSULT' => ['scoreType' => 'PROBABILITY', 'scoreThreshold' => 0],
                'THREAT' => ['scoreType' => 'PROBABILITY', 'scoreThreshold' => 0],
                'PROFANITY' => ['scoreType' => 'PROBABILITY', 'scoreThreshold' => 0],
            ],
        ];

        $response = $this->post(sprintf('comments:analyze?key=%s', $this->key), $params);

        return $this->pipeline->process(
            $this->adapter->adapt($text, $response),
        );
    }

    protected function baseUri(): string
    {
        return 'https://commentanalyzer.googleapis.com/v1alpha1/';
    }
}
