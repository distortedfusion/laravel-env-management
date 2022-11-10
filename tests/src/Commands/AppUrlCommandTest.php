<?php

namespace DistortedFusion\Env\Tests\Commands;

use DistortedFusion\Env\Commands\Exceptions;
use DistortedFusion\Env\Tests\TestCase;

class AppUrlCommandTest extends TestCase
{
    public function testGettingUrlWhenNoneIsSetShowsError()
    {
        $this->createTmpEnv(self::ENV_STUB);
        $this->app['config']->set('app.url', null);

        $this->artisan('app:url')
            ->expectsOutput('No application url set!')
            ->assertExitCode(1);
    }

    public function testGettingUrlShowsCurrentUrl()
    {
        $this->createTmpEnv(self::ENV_URL_STUB);
        $this->app['config']->set('app.url', 'http://localhost');

        $this->artisan('app:url')
            ->expectsOutput('http://localhost')
            ->assertExitCode(0);
    }

    public function testSettingUrlPersistsUrlInEnvAndSetsConfig()
    {
        $this->createTmpEnv(self::ENV_URL_STUB);
        $this->app['config']->set('app.url', 'http://localhost');

        $this->artisan('app:url http://foo')
            ->expectsOutput('Application url set successfully.')
            ->assertExitCode(0);

        $this->assertStringContainsString(
            'APP_URL=http://foo',
            file_get_contents($this->getTmpDir().'/.env')
        );

        $this->assertSame($this->app['config']['app.url'], 'http://foo');

        $this->artisan('app:url')
            ->expectsOutput('http://foo')
            ->assertExitCode(0);
    }

    public function testMissingEnvVariableThrowsException()
    {
        $this->createTmpEnv(self::ENV_EMPTY_STUB);

        $this->expectException(Exceptions\MissingEnvException::class);

        $this->artisan('app:url http://localhost');
    }
}
