<?php

namespace DistortedFusion\Env\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;

class KeySetCommand extends Command
{
    use Concerns\WritesToEnv;
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'key:set
                    {key : The application key in base64 format}
                    {--force : Force the operation to run when in production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set an existing application key';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() : int
    {
        $key = $this->argument('key');

        $currentKey = $this->laravel['config']['app.key'];

        if (strlen($currentKey) !== 0 && (!$this->confirmToProceed())) {
            return 1;
        }

        $this->writeNewEnvironmentFileWith(
            $this->keyReplacementPattern(),
            'APP_KEY='.$key
        );

        $this->laravel['config']['app.key'] = $key;

        $this->info('Application key set successfully.');

        return 0;
    }

    /**
     * Get a regex pattern that will match env APP_KEY with any random key.
     *
     * @return string
     */
    protected function keyReplacementPattern()
    {
        $escaped = preg_quote('='.$this->laravel['config']['app.key'], '/');

        return "/^APP_KEY{$escaped}/m";
    }
}
