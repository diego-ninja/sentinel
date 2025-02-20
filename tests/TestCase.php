<?php

namespace Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Ninja\Sentinel\SentinelServiceProvider;
use Ninja\Sentinel\Processors\DefaultProcessor;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            SentinelServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        // Base configuration
        $app['config']->set('sentinel.mask_char', '*');
        $app['config']->set('sentinel.whitelist', []);
        $app['config']->set('sentinel.languages', ['en']);
        $app['config']->set('sentinel.dictionary_path', __DIR__ . '/../resources/dict');
        $app['config']->set('sentinel.default_service', 'local');
        $app['config']->set('sentinel.cache.enabled', false);
        $app['config']->set('sentinel.replacements', [
            'a' => '(a|a\.|a\-|4|@|Á|á|À|Â|à|Â|â|Ä|ä|Ã|ã|Å|å|α|Δ|Λ|λ)',
            'b' => '(b|b\.|b\-|8|\|3|ß|Β|β)',
            'c' => '(c|c\.|c\-|Ç|ç|¢|€|<|\(|{|©)',
            'd' => '(d|d\.|d\-|&part;|\|\)|Þ|��|Ð|ð)',
            'e' => '(e|e\.|e\-|3|€|È|è|É|é|Ê|ê|∑|ë|Ë)',
            'f' => '(f|f\.|f\-|ƒ)',
            'g' => '(g|g\.|g\-|6|9)',
            'h' => '(h|h\.|h\-|Η)',
            'i' => '(i|i\.|i\-|!|\||\]\[|]|1|∫|Ì|Í|Î|Ï|ì|í|î|ï)',
            'j' => '(j|j\.|j\-)',
            'k' => '(k|k\.|k\-|Κ|κ)',
            'l' => '(l|1\.|l\-|!|\||\]\[|]|£|∫|Ì|Í|Î|Ï)',
            'm' => '(m|m\.|m\-)',
            'n' => '(n|n\.|n\-|η|Ν|Π)',
            'o' => '(o|o\.|o\-|0|Ο|ο|Φ|¤|°|ø|ô|ö|ò|ó|õ)',
            'p' => '(p|p\.|p\-|ρ|Ρ|¶|þ)',
            'q' => '(q|q\.|q\-)',
            'r' => '(r|r\.|r\-|®)',
            's' => '(s|s\.|s\-|5|\$|§)',
            't' => '(t|t\.|t\-|Τ|τ|7)',
            'u' => '(u|u\.|u\-|υ|µ|û|ü|ù|ú|ū|ů|v|Ú|Ù|Û|Ü)',
            'v' => '(v|v\.|v\-|υ|ν)',
            'w' => '(w|w\.|w\-|ω|ψ|Ψ)',
            'x' => '(x|x\.|x\-|Χ|χ)',
            'y' => '(y|y\.|y\-|¥|γ|ÿ|ý|Ÿ|Ý)',
            'z' => '(z|z\.|z\-|Ζ)',
        ]);

        // Services configuration
        $app['config']->set('sentinel.services', [
            'perspective_ai' => ['key' => 'test-key'],
            'tisane_ai' => ['key' => 'test-key'],
            'azure_ai' => [
                'key' => 'test-key',
                'endpoint' => 'test-endpoint',
                'version' => '2024-09-01',
            ],
            'purgomalum' => [],
            'local' => [
                'levenshtein_threshold' => 1,
                'processor' => DefaultProcessor::class,
                'strategies' => [
                    \Ninja\Sentinel\Detection\Strategy\IndexStrategy::class,
                    \Ninja\Sentinel\Detection\Strategy\PatternStrategy::class,
                    \Ninja\Sentinel\Detection\Strategy\NGramStrategy::class,
                    \Ninja\Sentinel\Detection\Strategy\AffixStrategy::class,
                    \Ninja\Sentinel\Detection\Strategy\VariationStrategy::class,
                    \Ninja\Sentinel\Detection\Strategy\RepeatedCharStrategy::class,
                    \Ninja\Sentinel\Detection\Strategy\LevenshteinStrategy::class,
                ],
            ],
        ]);
    }

    protected function getMockedHttpClient(array $responses = []): Client
    {
        $mock = new MockHandler(
            array_map(
                fn($response) => new Response(200, [], json_encode($response)),
                $responses,
            ),
        );

        return new Client(['handler' => HandlerStack::create($mock)]);
    }
}
