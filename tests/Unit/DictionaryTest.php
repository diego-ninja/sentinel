<?php

namespace Tests\Unit;

use Ninja\Censor\Dictionary;
use Ninja\Censor\Exceptions\DictionaryFileNotFound;
use PHPUnit\Framework\TestCase;

class DictionaryTest extends TestCase
{
    public function test_with_language(): void
    {
        $dictionary = Dictionary::withLanguage('en-us');
        self::assertNotEmpty($dictionary->words());
    }

    public function test_from_file(): void
    {
        $file = __DIR__.'/../../resources/dict/en-us.php';
        $dictionary = Dictionary::fromFile($file);
        self::assertNotEmpty($dictionary->words());
    }

    public function test_dictionary_file_not_found(): void
    {
        $this->expectException(DictionaryFileNotFound::class);
        Dictionary::fromFile('nonexistent-file.php');
    }
}
