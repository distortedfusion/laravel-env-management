<?php

namespace DistortedFusion\Env\Commands;

use Illuminate\Console\Command;

class AppUrlCommand extends Command
{
    use Concerns\WritesToEnv;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:url {url?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get or set the current app url.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        if (! $this->envHas('APP_URL')) {
            throw new Exceptions\MissingEnvException('APP_URL is not set in the environment file, add APP_URL= before using the command.');
        }

        $currentUrl = $this->laravel['config']['app.url'];

        if ($url = $this->argument('url')) {
            $this->writeNewEnvironmentFileWith(
                $this->urlReplacementPattern(),
                'APP_URL='.$url
            );

            $this->laravel['config']['app.url'] = $url;

            $this->info('Application url set successfully.');

            return 0;
        }

        if (empty($currentUrl)) {
            $this->error('No application url set!');

            return 1;
        }

        $this->line($this->laravel['config']['app.url']);

        return 0;
    }

    /**
     * Get a regex pattern that will match env APP_URL.
     *
     * @return string
     */
    protected function urlReplacementPattern(): string
    {
        $escaped = preg_quote('='.$this->laravel['config']['app.url'], '/');

        return "/^APP_URL{$escaped}/m";
    }
}
