<?php

namespace DistortedFusion\Env\Tests\Commands;

use DistortedFusion\Env\Commands\Exceptions;
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

    public function test_nothing_happens_when_key_is_not_empty_in_production_and_confirmation_is_no()
    {
        $this->createTmpEnv(self::ENV_KEY_STUB);
        $this->app['config']->set('app.key', self::TEST_KEY);

        // Fool the application to be in production to force the confirmation
        // question.
        $this->app->detectEnvironment(static function () {
            return 'production';
        });

        $this->artisan('key:set '.self::TEST_KEY)
            ->expectsConfirmation('Do you really wish to run this command?', 'no')
            ->expectsOutput('Command Canceled!')
            ->assertExitCode(1);
    }

    public function test_missing_env_variable_throws_exception()
    {
        $this->createTmpEnv(self::ENV_EMPTY_STUB);

        $this->expectException(Exceptions\MissingEnvException::class);

        $this->artisan('key:set '.self::TEST_KEY);
    }
}
