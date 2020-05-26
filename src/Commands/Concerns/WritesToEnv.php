<?php

namespace DistortedFusion\Env\Commands\Concerns;

trait WritesToEnv
{
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
