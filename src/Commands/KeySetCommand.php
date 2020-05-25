<?php

namespace DistortedFusion\Env\Commands;

use Illuminate\Foundation\Console\KeyGenerateCommand;

class KeySetCommand extends KeyGenerateCommand
{
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
     * @return void
     */
    public function handle()
    {
        $key = $this->argument('key');

        // Next, we will replace the application key in the environment file so it is
        // automatically setup for this developer.
        if (! $this->setKeyInEnvironmentFile($key)) {
            return;
        }

        $this->laravel['config']['app.key'] = $key;

        $this->info('Application key set successfully.');
    }
}
