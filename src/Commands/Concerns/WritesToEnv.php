<?php

namespace DistortedFusion\Env\Commands\Concerns;

trait WritesToEnv
{
    /**
     * Determines if a variable is defined in the environment file.
     *
     * @param  string $key
     * @return bool
     */
    protected function envHas(string $key) : bool
    {
        $env = file_get_contents($this->laravel->environmentFilePath());

        return strpos($env, $key) !== false;
    }

    /**
     * Write a new environment file with the given version.
     *
     * @param  string $replacementPattern
     * @param  string $replacement
     * @return void
     */
    protected function writeNewEnvironmentFileWith(string $replacementPattern, string $replacement) : void
    {
        file_put_contents($this->laravel->environmentFilePath(), preg_replace(
            $replacementPattern,
            $replacement,
            file_get_contents($this->laravel->environmentFilePath())
        ));
    }
}
