<?php

namespace Ninja\Censor\Checkers;

use GuzzleHttp\ClientInterface;
use Ninja\Censor\Exceptions\ClientException;
use Ninja\Censor\Result\Contracts\Result;
use Ninja\Censor\Result\PerspectiveResult;

final class PerspectiveAI extends AbstractProfanityChecker
{
    public function __construct(private readonly string $key, protected ?ClientInterface $client = null)
    {
        parent::__construct($client);
    }

    /**
     * @throws ClientException
     */
    public function check(string $text): Result
    {
        $params = [
            'comment' => ['text' => $text],
            'languages' => config('censor.languages', ['en']),
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

        return PerspectiveResult::fromResponse($text, $response);
    }

    protected function baseUri(): string
    {
        return 'https://commentanalyzer.googleapis.com/v1alpha1/';
    }
}
