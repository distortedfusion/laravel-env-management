<?php

namespace DistortedFusion\Env\Tests\Commands;

use DistortedFusion\Env\Tests\TestCase;

class AppVersionCommandTest extends TestCase
{
    public function test_getting_version_shows_current_version()
    {
        $this->artisan('app:version')
            ->expectsOutput('Current version: 0.0.0')
            ->assertExitCode(0);
    }

    public function test_setting_version_persists_version_in_env()
    {
        $this->artisan('app:version 9.9.9')
            ->expectsOutput('Application version set successfully.')
            ->expectsOutput('Current version: 9.9.9')
            ->assertExitCode(0);

        $this->assertStringContainsString(
            'APP_VERSION=9.9.9',
            file_get_contents($this->getTmpDir().'/.env')
        );

        $this->assertSame($this->app['config']['app.version'], '9.9.9');
    }
}
