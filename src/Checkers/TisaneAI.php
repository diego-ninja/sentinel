<?php

namespace Ninja\Censor\Checkers;

use GuzzleHttp\ClientInterface;
use Ninja\Censor\Contracts\Result;
use Ninja\Censor\Exceptions\ClientException;
use Ninja\Censor\Result\TisaneResult;

final class TisaneAI extends AbstractProfanityChecker
{
    public function __construct(private readonly string $key, protected ?ClientInterface $client = null)
    {
        parent::__construct($client);
    }

    protected function baseUri(): string
    {
        return 'https://api.tisane.ai/';
    }

    /**
     * @throws ClientException
     */
    public function check(string $text): Result
    {
        /** @var string[] $languages */
        $languages = config('censor.languages', ['en']);
        $response = $this->post(
            'parse',
            [
                'content' => $text,
                'language' => implode('|', $languages),
                'settings' => [
                    'snippets' => true,
                    'abuse' => true,
                    'sentiment' => true,
                    'profanity' => true,
                ],
            ],
            [
                'Content-Type' => 'application/json',
                'Ocp-Apim-Subscription-Key' => $this->key,
            ]
        );

        return TisaneResult::fromResponse($text, $response);
    }
}
