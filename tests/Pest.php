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

expect()->extend('toBeOffensive', function () {
    return $this->offensive() === true;
});

expect()->extend('toBeClean', function () {
    return $this->offensive() === false;
});

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