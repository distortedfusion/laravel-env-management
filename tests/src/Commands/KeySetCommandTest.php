<?php

namespace DistortedFusion\Env\Tests\Commands;

use DistortedFusion\Env\Commands\Exceptions;
use DistortedFusion\Env\Tests\TestCase;

class KeySetCommandTest extends TestCase
{
    public const TEST_KEY = 'base64:SGVsbG8gV29ybGQh';

    public function testSettingKeyPersistsKeyInEnv()
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

    public function testNothingHappensWhenInProductionAndConfirmationIsNo()
    {
        $this->createTmpEnv(self::ENV_KEY_STUB);
        $this->app['config']->set('app.key', self::TEST_KEY);

        $this->app->detectEnvironment(static fn () => 'production');

        $this->artisan('key:set '.self::TEST_KEY)
            ->expectsConfirmation('Do you really wish to run this command?', 'no')
            ->assertExitCode(1);
    }

    public function testMissingEnvVariableThrowsException()
    {
        $this->createTmpEnv(self::ENV_EMPTY_STUB);

        $this->expectException(Exceptions\MissingEnvException::class);

        $this->artisan('key:set '.self::TEST_KEY);
    }
}
