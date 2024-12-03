<?php

namespace Tests\Unit;

use Ninja\Censor\Checkers\Censor;
use Ninja\Censor\Dictionary;
use PHPUnit\Framework\TestCase;

class CensorTest extends TestCase
{
    public function test_set_dictionary(): void
    {
        $dictionary = Dictionary::withLanguage('en-us');
        $censor = (new Censor)->setDictionary($dictionary);
        self::assertNotEmpty($censor->clean('test')['orig']);
    }

    public function test_add_dictionary(): void
    {
        $dictionary = Dictionary::withLanguage('en-us');
        $censor = (new Censor)->setDictionary($dictionary);
        $censor->addDictionary(Dictionary::withLanguage('fr'));

        self::assertNotEmpty($censor->clean('test')['orig']);
    }

    public function test_whitelist(): void
    {
        $dictionary = Dictionary::withLanguage('en-us');
        $censor = (new Censor)->setDictionary($dictionary);
        $censor->whitelist(['test']);

        $result = $censor->clean('This is a test string');
        self::assertEquals('This is a test string', $result['clean']);
    }

    public function test_set_replace_char(): void
    {
        $dictionary = Dictionary::withLanguage('en-us');
        $censor = (new Censor)->setDictionary($dictionary);
        $censor->setReplaceChar('X');

        /** @var array{clean: string, orig: string} $result */
        $result = $censor->clean('This is a dick string');
        self::assertStringContainsString('X', $result['clean']);
    }

    public function test_clean(): void
    {
        $dictionary = Dictionary::withLanguage('en-us');
        $censor = (new Censor)->setDictionary($dictionary);

        $result = $censor->clean('This is a test string');
        self::assertNotEmpty($result['clean']);
    }
}
