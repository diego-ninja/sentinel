<?php

namespace Ninja\Sentinel\Analyzers;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\ClientTrait;
use GuzzleHttp\Exception\GuzzleException;
use Ninja\Sentinel\Analyzers\Contracts\Analyzer;
use Ninja\Sentinel\Enums\Audience;
use Ninja\Sentinel\Enums\ContentType;
use Ninja\Sentinel\Exceptions\ClientException;
use Ninja\Sentinel\Result\Contracts\Result;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractAnalyzer implements Analyzer
{
    public function __construct(protected ?ClientInterface $client = null)
    {
        /** @mixin ClientTrait */
        $this->client = $client ?? new Client([
            'timeout' => 5,
            'connect_timeout' => 5,
            'http_errors' => false,
        ]);
    }

    abstract protected function baseUri(): string;

    /**
     * Check text for offensive content
     *
     * @param string $text The text to analyze
     * @param ContentType|null $contentType Optional content type for threshold adjustment
     * @param Audience|null $audience Optional audience type for threshold adjustment
     * @return Result The analysis result
     */
    abstract public function analyze(string $text, ?ContentType $contentType = null, ?Audience $audience = null): Result;

    /**
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     *
     * @throws ClientException
     */
    protected function get(string $endpoint, array $query = []): array
    {
        try {
            /** @var ResponseInterface $response */
            $response = $this->client?->request('GET', $this->baseUri() . $endpoint, [
                'query' => $query,
            ]);

            return $this->response($response);
        } catch (GuzzleException $e) {
            throw new ClientException(
                'HTTP request failed: ' . $e->getMessage(),
                $e->getCode(),
                $e,
            );
        }
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  array<string, mixed>  $headers
     * @return array<string, mixed>
     *
     * @throws ClientException
     */
    protected function post(string $endpoint, array $data = [], array $headers = []): array
    {
        try {
            /** @var ResponseInterface $response */
            $response = $this->client?->request('POST', $this->baseUri() . $endpoint, [
                'headers' => array_merge(['Content-Type' => 'application/json'], $headers),
                'json' => $data,
            ]);

            return $this->response($response);
        } catch (GuzzleException $e) {
            throw new ClientException(
                'HTTP request failed: ' . $e->getMessage(),
                $e->getCode(),
                $e,
            );
        }
    }

    /**
     * @return array<string, mixed>
     *
     * @throws ClientException
     */
    protected function response(ResponseInterface $response): array
    {
        $statusCode = $response->getStatusCode();
        $content = $response->getBody()->getContents();

        if ($statusCode >= 400) {
            throw new ClientException(
                "API request failed with status {$statusCode}: {$content}",
            );
        }

        $data = json_decode($content, true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new ClientException(
                'Failed to parse JSON response: ' . json_last_error_msg(),
            );
        }

        /** @var array<string, mixed> */
        return $data;
    }
}
