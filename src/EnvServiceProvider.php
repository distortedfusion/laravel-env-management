<?php

namespace DistortedFusion\Env;

use DistortedFusion\Env\Commands\EnvSetCommand;
use Illuminate\Support\ServiceProvider;

class EnvServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        // ...
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            EnvSetCommand::class,
        ]);
    }
}
