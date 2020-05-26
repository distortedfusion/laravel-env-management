<?php

namespace DistortedFusion\Env\Commands;

use Illuminate\Console\Command;

class AppVersionCommand extends Command
{
    use Concerns\WritesToEnv;

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
            $this->writeNewEnvironmentFileWith(
                $this->versionReplacementPattern(),
                'APP_VERSION='.$version
            );

            $this->laravel['config']['app.version'] = $version;

            $this->info('Application version set successfully.');
        }

        $this->line('Current version: <comment>'.$this->laravel['config']['app.version'].'</comment>');
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
