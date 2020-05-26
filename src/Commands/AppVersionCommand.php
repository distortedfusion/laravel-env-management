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
     * @return int
     */
    public function handle() : int
    {
        $currentVersion = $this->laravel['config']['app.version'];

        if ($version = $this->argument('version')) {
            $this->writeNewEnvironmentFileWith(
                $this->versionReplacementPattern(),
                'APP_VERSION='.$version
            );

            $this->laravel['config']['app.version'] = $version;

            $this->info('Application version set successfully.');

            return 0;
        }

        if (empty($currentVersion)) {
            $this->error('No application version set!');

            return 1;
        }

        $this->line($this->laravel['config']['app.version']);

        return 0;
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
