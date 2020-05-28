<?php

namespace DistortedFusion\Env\Tests;

use Illuminate\Filesystem\Filesystem;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    const ENV_EMPTY_STUB = '../stubs/.env_empty';
    const ENV_KEY_STUB = '../stubs/.env_key';
    const ENV_STUB = '../stubs/.env';
    const ENV_URL_STUB = '../stubs/.env_url';
    const ENV_VERSION_STUB = '../stubs/.env_version';

    private $tempDir;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->tempDir = __DIR__.'/tmp';

        mkdir($this->tempDir);
        $this->createTmpEnv(self::ENV_STUB);

        $this->app->useEnvironmentPath($this->tempDir);
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        $files = new Filesystem();
        $files->deleteDirectory($this->tempDir);

        parent::tearDown();
    }

    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \DistortedFusion\Env\EnvServiceProvider::class,
        ];
    }

    /**
     * Get the TMP dir.
     *
     * @return string
     */
    public function getTmpDir(): string
    {
        return $this->tempDir;
    }

    /**
     * Create a temporary .env from the specified stub.
     *
     * @param string $file
     *
     * @return void
     */
    public function createTmpEnv(string $file): void
    {
        file_put_contents(
            $this->getTmpDir().'/.env',
            file_get_contents(__DIR__.'/'.$file)
        );
    }
}
