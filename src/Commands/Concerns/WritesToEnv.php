<?php

namespace DistortedFusion\Env\Commands\Concerns;

trait WritesToEnv
{
    protected function envGet(string $key): ?string
    {
        $env = file_get_contents($this->laravel->environmentFilePath());

        if (preg_match("#^ *{$key} *= *[^\r\n]*$#uimU", $env, $matches)) {
            return $matches[0];
        }

        return null;
    }

    /**
     * Determines if a variable is defined in the environment file.
     *
     * @param string $key
     *
     * @return bool
     */
    protected function envHas(string $key): bool
    {
        $env = file_get_contents($this->laravel->environmentFilePath());

        return strpos($env, $key) !== false;
    }

    /**
     * Write a new environment file with the given version.
     *
     * @param string $replacementPattern
     * @param string $replacement
     *
     * @return bool
     *
     * @deprecated
     */
    protected function writeNewEnvironmentFileWith(string $replacementPattern, string $replacement): bool
    {
        $action = file_put_contents($this->laravel->environmentFilePath(), preg_replace(
            $replacementPattern,
            $replacement,
            file_get_contents($this->laravel->environmentFilePath())
        ), LOCK_EX);

        return $action !== false;
    }

    protected function isValidKey(string $key): bool
    {
        if (! preg_match('/^[a-zA-Z_]+$/', $key)) {
            return false;
        }

        return true;
    }

    protected function replacementPattern(string $keyValuePair): string
    {
        $escaped = preg_quote($keyValuePair, '/');

        return "/^{$escaped}$/uimU";
    }
}
