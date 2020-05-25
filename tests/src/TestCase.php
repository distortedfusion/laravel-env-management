<?php

namespace DistortedFusion\Env\Tests;

use Illuminate\Filesystem\Filesystem;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    const ENV_STUB = '../stubs/.env';

    private $tempDir;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this->tempDir = __DIR__.'/tmp';

        mkdir($this->tempDir);
        file_put_contents(
            $this->tempDir.'/.env',
            file_get_contents(__DIR__.'/'.self::ENV_STUB)
        );

        $this->app->useEnvironmentPath($this->tempDir);
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    protected function tearDown() : void
    {
        $files = new Filesystem;
        $files->deleteDirectory($this->tempDir);

        parent::tearDown();
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
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
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.version', '0.0.0');
    }

    /**
     * Get the TMP dir.
     *
     * @return string
     */
    public function getTmpDir() : string
    {
        return $this->tempDir;
    }
}
