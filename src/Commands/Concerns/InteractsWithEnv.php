<?php

namespace DistortedFusion\Env\Commands\Concerns;

trait InteractsWithEnv
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
        return ! is_null($this->envGet($key));
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
