<?php

namespace DistortedFusion\Env\Commands;

use Illuminate\Console\Command;

class AppVersionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:version {version?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get or set the current app version.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($version = $this->argument('version')) {
            $this->writeNewEnvironmentFileWith($version);

            $this->laravel['config']['app.version'] = $version;

            $this->info('Application version set successfully.');
        }

        return $this->line('Current version: <comment>'.$this->laravel['config']['app.version'].'</comment>');
    }

    /**
     * Write a new environment file with the given version.
     *
     * @param  string $version
     * @return void
     */
    protected function writeNewEnvironmentFileWith($version) : void
    {
        file_put_contents($this->laravel->environmentFilePath(), preg_replace(
            $this->versionReplacementPattern(),
            'APP_VERSION='.$version,
            file_get_contents($this->laravel->environmentFilePath())
        ));
    }

    /**
     * Get a regex pattern that will match env APP_VERSION.
     *
     * @return string
     */
    protected function versionReplacementPattern() : string
    {
        $escaped = preg_quote('='.$this->laravel['config']['app.version'], '/');

        return "/^APP_VERSION{$escaped}/m";
    }
}
