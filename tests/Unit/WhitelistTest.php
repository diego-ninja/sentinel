<?php

namespace Tests\Unit;

use Ninja\Censor\Whitelist;
use PHPUnit\Framework\TestCase;

class WhitelistTest extends TestCase
{
    public function test_add(): void
    {
        $whitelist = new Whitelist;
        $whitelist->add(['test', 'example']);

        self::assertNotEmpty($whitelist->replace('This is a test string'));
    }

    public function test_replace(): void
    {
        $whitelist = new Whitelist;
        $whitelist->add(['test']);

        $result = $whitelist->replace('This is a test string');
        self::assertStringContainsString('{whiteList0}', $result);
    }

    public function test_replace_reverse(): void
    {
        $whitelist = new Whitelist;
        $whitelist->add(['test']);

        $result = $whitelist->replace('This is a {whiteList0} string', true);
        self::assertStringContainsString('test', $result);
    }
}
