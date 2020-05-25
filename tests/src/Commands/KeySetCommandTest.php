<?php

namespace DistortedFusion\Env\Tests\Commands;

use DistortedFusion\Env\Tests\TestCase;

class KeySetCommandTest extends TestCase
{
    const TEST_KEY = 'base64:SGVsbG8gV29ybGQh';

    public function test_setting_key_persists_key_in_env()
    {
        $this->artisan('key:set '.self::TEST_KEY)
            ->expectsOutput('Application key set successfully.')
            ->assertExitCode(0);

        $this->assertStringContainsString(
            'APP_KEY='.self::TEST_KEY,
            file_get_contents($this->getTmpDir().'/.env')
        );

        $this->assertSame($this->app['config']['app.key'], self::TEST_KEY);
    }

    public function test_nothing_happens_when_key_is_empty()
    {
        $this->artisan('key:set \'\'')
            ->assertExitCode(0);
    }
}
