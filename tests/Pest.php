<?php

use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
*/

uses(TestCase::class)->in('Unit', 'Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
*/

expect()->extend('toBeOffensive', fn() => true === $this->offensive());

expect()->extend('toBeClean', fn() => false === $this->offensive());

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
*/

/**
 * @return string[]
 */
function getTestDictionary(): array
{
    return [
        'bad',
        'word',
        'test',
        'fuck',
        'shit',
    ];
}

function createTestDictionaryFile(): string
{
    $path = sys_get_temp_dir() . '/test_dict.php';
    file_put_contents($path, '<?php return ' . var_export(getTestDictionary(), true) . ';');

    return $path;
}

function createContextFiles(): void
{
    $languages = ["en", "es", "pt"];

    $dir = __DIR__ . '/../vendor/orchestra/testbench-core/laravel/resources/language';
    if ( ! file_exists($dir)) {
        mkdir(directory: $dir, recursive: true);
    }

    foreach ($languages as $lang) {
        $source = sprintf(__DIR__ . '/../vendor/orchestra/testbench-core/laravel/resources/language/%s.php', $lang);
        $dest = sprintf(__DIR__ . '/../resources/language/%s.php', $lang);
        file_put_contents($source, file_get_contents($dest));
    }
}
