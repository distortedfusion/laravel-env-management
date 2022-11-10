<?php

namespace DistortedFusion\Env\Tests\Commands;

use DistortedFusion\Env\Commands\Exceptions;
use DistortedFusion\Env\Tests\TestCase;

class AppVersionCommandTest extends TestCase
{
    public function testGettingVersionWhenNoneIsSetShowsError()
    {
        $this->createTmpEnv(self::ENV_STUB);
        $this->app['config']->set('app.version', null);

        $this->artisan('app:version')
            ->expectsOutput('No application version set!')
            ->assertExitCode(1);
    }

    public function testGettingVersionShowsCurrentVersion()
    {
        $this->createTmpEnv(self::ENV_VERSION_STUB);
        $this->app['config']->set('app.version', '0.0.0');

        $this->artisan('app:version')
            ->expectsOutput('0.0.0')
            ->assertExitCode(0);
    }

    public function testSettingVersionPersistsVersionInEnvAndSetsConfig()
    {
        $this->createTmpEnv(self::ENV_VERSION_STUB);
        $this->app['config']->set('app.version', '0.0.0');

        $this->artisan('app:version 9.9.9')
            ->expectsOutput('Application version set successfully.')
            ->assertExitCode(0);

        $this->assertStringContainsString(
            'APP_VERSION=9.9.9',
            file_get_contents($this->getTmpDir().'/.env')
        );

        $this->assertSame($this->app['config']['app.version'], '9.9.9');

        $this->artisan('app:version')
            ->expectsOutput('9.9.9')
            ->assertExitCode(0);
    }

    public function testMissingEnvVariableThrowsException()
    {
        $this->createTmpEnv(self::ENV_EMPTY_STUB);

        $this->expectException(Exceptions\MissingEnvException::class);

        $this->artisan('app:version 9.9.9');
    }

    public function testMissingConfigVariableThrowsException()
    {
        $this->createTmpEnv(self::ENV_VERSION_STUB);

        $this->expectException(Exceptions\MissingConfigException::class);

        $this->artisan('app:version 9.9.9');
    }
}
