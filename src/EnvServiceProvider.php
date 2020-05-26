<?php

namespace DistortedFusion\Env;

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
        $this->defineConfigPublishing();
    }

    /**
     * Define the view publishing configuration.
     *
     * @return void
     */
    public function defineConfigPublishing()
    {
        $this->publishes([
            ENV_MANAGEMENT_PATH.'/config/env-management.php' => config_path('env-management.php'),
        ], 'df-env-config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        if (! defined('ENV_MANAGEMENT_PATH')) {
            define('ENV_MANAGEMENT_PATH', realpath(__DIR__.'/../'));
        }

        $this->mergeConfigFrom(
            ENV_MANAGEMENT_PATH.'/config/env-management.php', 'env-management'
        );

        $this->commands(config('env-management.commands'));
    }
}
