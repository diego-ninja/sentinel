<?php

namespace Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Ninja\Sentinel\Processors\DefaultProcessor;
use Ninja\Sentinel\SentinelServiceProvider;
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
            // Vowels
            'a' => '(a|a\.|a\-|4|@|Á|á|À|Â|à|Â|â|Ä|ä|Ã|ã|Å|å|α|Δ|Λ|λ|Д|∆|ª|Ā|ā|Ă|ă|Ą|ą|Ǎ|ǎ|Ǟ|ǟ|Ǡ|ǡ|Ǻ|ǻ|Ȁ|ȁ|Ȃ|ȃ|ạ|Ạ|ả|Ả|Ấ|ấ|Ầ|ầ|Ẩ|ẩ|Ẫ|ẫ|Ậ|ậ|Ắ|ắ|Ằ|ằ|Ẳ|ẳ|Ẵ|ẵ|Ặ|ặ|ά|Ά|έ|Έ|Α|А)',
            'e' => '(e|e\.|e\-|3|€|È|è|É|é|Ê|ê|∑|ë|Ë|Σ|Ē|ē|Ĕ|ĕ|Ė|ė|Ę|ę|Ě|ě|Ȅ|ȅ|Ȇ|ȇ|Ẹ|ẹ|Ẻ|ẻ|Ẽ|ẽ|Ế|ế|Ề|ề|Ể|ể|Ễ|ễ|Ệ|ệ|Е|Э|Ε|έ|Έ)',
            'i' => '(i|i\.|i\-|!|\||\]\[|]|1|∫|Ì|Í|Î|Ï|ì|í|î|ï|Ī|ī|Ĭ|ĭ|Į|į|İ|ı|Ǐ|ǐ|Ȉ|ȉ|Ȋ|ȋ|Ḭ|ḭ|Ḯ|ḯ|Ỉ|ỉ|Ị|ị|Ι|Í|Ì|Ĩ|Ī|ι|í|ì|ĩ|ī|И|Й|1|!|¡|∣|ﺍ)',
            'o' => '(o|o\.|o\-|0|Ο|ο|Φ|¤|°|ø|ô|ö|ò|ó|õ|Ō|ō|Ŏ|ŏ|Ő|ő|Œ|œ|Ơ|ơ|Ǒ|ǒ|Ǫ|ǫ|Ǭ|ǭ|Ȍ|ȍ|Ȏ|ȏ|Ọ|ọ|Ỏ|ỏ|Ố|ố|Ồ|ồ|Ổ|ổ|Ỗ|ỗ|Ộ|ộ|Ớ|ớ|Ờ|ờ|Ở|ở|Ỡ|ỡ|Ợ|ợ|О|Θ|Ο|ό|Ό|0|°|º|⊕|☺|☻)',
            'u' => '(u|u\.|u\-|υ|µ|û|ü|ù|ú|ū|ů|Ū|ū|Ŭ|ŭ|Ů|ů|Ű|ű|Ų|ų|Ư|ư|Ǔ|ǔ|Ǖ|ǖ|Ǘ|ǘ|Ǚ|ǚ|Ǜ|ǜ|Ȕ|ȕ|Ȗ|ȗ|Ụ|ụ|Ủ|ủ|Ứ|ứ|Ừ|ừ|Ử|ử|Ữ|ữ|Ự|ự|Ũ|ũ|У|Υ|Ц|v|V)',
            'y' => '(y|y\.|y\-|¥|γ|ÿ|ý|Ÿ|Ý|Ŷ|ŷ|Ÿ|Ƴ|ƴ|Ȳ|ȳ|Ẏ|ẏ|ʏ|Ỳ|ỳ|Ỵ|ỵ|Ỷ|ỷ|Ỹ|ỹ|Υ|γ|У|￥)',

            // Consonants
            'b' => '(b|b\.|b\-|8|\|3|ß|Β|β|в|В|Ь|Б|₿|ƀ|Ɓ|ƃ|Ƃ|Ƅ|ƅ|ℬ|Ḃ|ḃ|Ḅ|ḅ|Ḇ|ḇ|Ƀ)',
            'c' => '(c|c\.|c\-|Ç|ç|¢|€|<|\(|{|©|ć|Ć|ċ|Ċ|č|Č|ĉ|Ĉ|Ƈ|ƈ|ℂ|Ḉ|ḉ|С|с|Ϲ|Ͻ|¢|￠)',
            'd' => '(d|d\.|d\-|&part;|\|\)|Þ|Ð|ð|Ď|ď|Đ|đ|Ɖ|ɖ|Ɗ|ɗ|Ḋ|ḋ|Ḍ|ḍ|Ḏ|ḏ|Ḑ|ḑ|Ḓ|ḓ|Д|д)',
            'f' => '(f|f\.|f\-|ƒ|Ḟ|ḟ|Ƒ|ƒ|ℱ|Ḟ|ḟ|Ф|ф)',
            'g' => '(g|g\.|g\-|6|9|Ģ|ģ|Ğ|ğ|Ġ|ġ|Ĝ|ĝ|Ǧ|ǧ|Ǥ|ǥ|Ḡ|ḡ|Г|г|Ѓ|ѓ|Ģ|Ğ|₲)',
            'h' => '(h|h\.|h\-|Η|ℌ|Ĥ|ĥ|Ħ|ħ|Ḣ|ḣ|Ḥ|ḥ|Ḧ|ḧ|Ḩ|ḩ|Ḫ|ḫ|Ή|Н|н|Ң|ң)',
            'j' => '(j|j\.|j\-|ĵ|Ĵ|ǰ|ʝ|Ĵ|ĵ|Ɉ|ɉ|ǰ|Ј|ј)',
            'k' => '(k|k\.|k\-|Κ|κ|Ķ|ķ|ĸ|Ǩ|ǩ|Ḱ|ḱ|Ḳ|ḳ|Ḵ|ḵ|К|к|Ќ|ќ)',
            'l' => '(l|1\.|l\-|!|\||\]\[|]|£|∫|Ì|Í|Î|Ï|Ĺ|ĺ|Ļ|ļ|Ľ|ľ|Ŀ|ŀ|Ł|ł|ℒ|Ḷ|ḷ|Ḹ|ḹ|Ḻ|ḻ|Ḽ|ḽ|Л|л)',
            'm' => '(m|m\.|m\-|Ɯ|ɯ|Ḿ|ḿ|Ṁ|ṁ|Ṃ|ṃ|М|м)',
            'n' => '(n|n\.|n\-|η|Ν|Π|ñ|Ñ|ń|Ń|Ņ|ņ|Ň|ň|Ǹ|ǹ|Ṅ|ṅ|Ṇ|ṇ|Ṉ|ṉ|Ṋ|ṋ|Н|н)',
            'p' => '(p|p\.|p\-|ρ|Ρ|¶|þ|Ƥ|ƥ|Ṕ|ṕ|Ṗ|ṗ|П|п)',
            'q' => '(q|q\.|q\-|℺|Ԛ|ԛ|Ǫ|Ꝗ|ꝗ|Ｑ|ｑ)',
            'r' => '(r|r\.|r\-|®|Ŕ|ŕ|Ŗ|ŗ|Ř|ř|Ȓ|ȓ|Ṙ|ṙ|Ṛ|ṛ|Ṝ|ṝ|Ṟ|ṟ|Я|я|Р|р)',
            's' => '(s|s\.|s\-|5|\$|§|Ś|ś|Ŝ|ŝ|Ş|ş|Š|š|Ș|ș|ȿ|Ṡ|ṡ|Ṣ|ṣ|Ṥ|ṥ|Ṧ|ṧ|Ṩ|ṩ|С|с)',
            't' => '(t|t\.|t\-|Τ|τ|7|Ť|ť|Ţ|ţ|Ṫ|ṫ|Ṭ|ṭ|Ṯ|ṯ|Ṱ|ṱ|Ț|ț|Т|т)',
            'v' => '(v|v\.|v\-|υ|ν|Ѵ|ѵ|Ṽ|ṽ|Ṿ|ṿ|В|в)',
            'w' => '(w|w\.|w\-|ω|ψ|Ψ|Ŵ|ŵ|Ẁ|ẁ|Ẃ|ẃ|Ẅ|ẅ|Ẇ|ẇ|Ẉ|ẉ|Ш|ш|Щ|щ)',
            'x' => '(x|x\.|x\-|Χ|χ|Ẋ|ẋ|Ẍ|ẍ|⨯|᙭|Х|х)',
            'z' => '(z|z\.|z\-|Ζ|Ź|ź|Ż|ż|Ž|ž|Ẑ|ẑ|Ẓ|ẓ|Ẕ|ẕ|З|з)',

            // Special Characters for Substitutions
            'ph' => '(ph|ƒ)',
            'th' => '(th|þ|Þ)',
            'ck' => '(ck|q)',
            'cc' => '(cc|к)',
            'ks' => '(ks|x)',
            'oo' => '(oo|u)',
            'aa' => '(aa|а)',
            'ss' => '(ss|ß)',
            'ch' => '(ch|ч)',
            'sh' => '(sh|ш)',

            // Special Combinations
            'ae' => '(ae|æ|Æ)',
            'oe' => '(oe|œ|Œ)',

            // Numbers and Symbols
            '0' => '(0|o|О|○|◯|⚪|☉|⭕)',
            '1' => '(1|i|l|\||¡|∣)',
            '2' => '(2|Z|z|ƻ)',
            '3' => '(3|E|e|є|Ʒ|ʒ|ɜ|ε)',
            '4' => '(4|A|a|Λ)',
            '5' => '(5|S|s|§)',
            '6' => '(6|b|G|g)',
            '7' => '(7|T|t|†)',
            '8' => '(8|B|b)',
            '9' => '(9|g|q)',
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
                    \Ninja\Sentinel\Detection\Strategy\AlphanumericVariationStrategy::class,
                    \Ninja\Sentinel\Detection\Strategy\ReversedWordsStrategy::class,
                    \Ninja\Sentinel\Detection\Strategy\ZeroWidthStrategy::class,
                    \Ninja\Sentinel\Detection\Strategy\SafeContextStrategy::class,
                ],
            ],
        ]);

        createContextFiles();
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
