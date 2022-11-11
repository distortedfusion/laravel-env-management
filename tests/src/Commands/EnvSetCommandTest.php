<?php

namespace DistortedFusion\Env\Tests\Commands;

use DistortedFusion\Env\Commands\Exceptions;
use DistortedFusion\Env\Tests\TestCase;
use InvalidArgumentException;

class EnvSetCommandTest extends TestCase
{
    public const TEST_INVALID_KEY = 'Invalid123';
    public const TEST_KEY = 'APP_NAME';
    public const TEST_VALUE = 'DistortedFusion.com';
    public const TEST_KEY_VALUE_PAIR = self::TEST_KEY.'='.self::TEST_VALUE;

    public const WRAPABLE_VALUE_WITH_SPACE = '{"foo": "bar"}';
    public const WRAPABLE_VALUE_WITH_SPACE_WRAPPED = '"{\"foo\": \"bar\"}"';
    public const WRAPABLE_VALUE_WITH_EQUALS_SIGN = 'base64:eyJmb28iOiAiYmFyIn0=';
    public const WRAPABLE_VALUE_WITH_EQUALS_SIGN_WRAPPED = '"base64:eyJmb28iOiAiYmFyIn0="';

    public const ORIGINAL_KEY_VALUE_PAIR = 'APP_NAME=Laravel';

    public function testSettingKeyValuePairUpdatesEnv()
    {
        $this->artisan('env:set '.self::TEST_KEY.' '.self::TEST_VALUE)
            ->expectsOutput('Replacing existing key/value pair ['.self::ORIGINAL_KEY_VALUE_PAIR.'] with ['.self::TEST_KEY_VALUE_PAIR.'] in environment file.')
            ->assertExitCode(0);

        $this->assertStringContainsString(
            self::TEST_KEY_VALUE_PAIR,
            file_get_contents($this->getTmpDir().'/.env')
        );
    }

    public function testSettingKeyValuePairAppendsToEnv()
    {
        $this->createTmpEnv(self::ENV_EMPTY_STUB);

        $this->artisan('env:set '.self::TEST_KEY.' '.self::TEST_VALUE.' --append')
            ->expectsOutput('Appending new key/value pair ['.self::TEST_KEY_VALUE_PAIR.'] to environment file.')
            ->assertExitCode(0);

        $this->assertStringContainsString(
            self::TEST_KEY_VALUE_PAIR,
            file_get_contents($this->getTmpDir().'/.env')
        );
    }

    public function testSettingKeyValuePairWithSpaceOrEqualsSignWrapsValue()
    {
        $this->artisan('env:set '.self::TEST_KEY.' \''.self::WRAPABLE_VALUE_WITH_SPACE.'\'')
            ->assertExitCode(0);

        $this->assertStringContainsString(
            self::TEST_KEY.'='.self::WRAPABLE_VALUE_WITH_SPACE_WRAPPED,
            file_get_contents($this->getTmpDir().'/.env')
        );

        $this->artisan('env:set '.self::TEST_KEY.' '.self::WRAPABLE_VALUE_WITH_EQUALS_SIGN)
            ->assertExitCode(0);

        $this->assertStringContainsString(
            self::TEST_KEY.'='.self::WRAPABLE_VALUE_WITH_EQUALS_SIGN_WRAPPED,
            file_get_contents($this->getTmpDir().'/.env')
        );
    }

    public function testNothingHappensWhenInProductionAndConfirmationIsNo()
    {
        $this->app->detectEnvironment(static fn () => 'production');

        $this->artisan('env:set '.self::TEST_KEY.' '.self::TEST_VALUE)
            ->expectsConfirmation('Do you really wish to run this command?', 'no')
            ->assertExitCode(1);
    }

    public function testInvalidKeyThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->artisan('env:set '.self::TEST_INVALID_KEY.' '.self::TEST_VALUE);
    }

    public function testMissingKeyWithoutAppendThrowsException()
    {
        $this->createTmpEnv(self::ENV_EMPTY_STUB);

        $this->expectException(Exceptions\MissingEnvException::class);

        $this->artisan('env:set '.self::TEST_KEY.' '.self::TEST_VALUE);
    }
}
