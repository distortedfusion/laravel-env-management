<?php

namespace DistortedFusion\Env\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use InvalidArgumentException;

class EnvSetCommand extends Command
{
    use Concerns\WritesToEnv;
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:set
                                {key}
                                {value}
                                {--append : Append new key/value pairs}
                                {--force : Force the operation to run when in production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Append or replace an environment variable in the .env file.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        if (! $this->confirmToProceed()) {
            return 1;
        }

        $key = $this->argument('key');
        $value = $this->argument('value');

        if (! $this->isValidKey($key)) {
            throw new InvalidArgumentException("Invalid ENV key [{$key}], make sure to only use letters and underscores.");
        }

        if (! ($isExistingKey = $this->envHas($key)) && ! $this->option('append')) {
            throw new Exceptions\MissingEnvException(
                "ENV key [{$key}] is not set in the environment file, add `{$key}=` before using the command or use --append to append the new key/value to the .env."
            );
        }

        // Wrap strings containing whitespace characters or `=`...
        if (preg_match('/\s/', $value) || strpos($value, '=') !== false) {
            $value = '"'.str_replace('"', '\"', $value).'"';
        }

        $keyValuePair = $key.'='.$value;

        $action = $isExistingKey
            ? $this->replaceKeyValuePair($this->envGet($key), $keyValuePair)
            : $this->appendKeyValuePair($keyValuePair);

        return $action !== false ? 0 : 1;
    }

    private function appendKeyValuePair(string $keyValuePair): bool
    {
        $this->info("Appending new key/value pair <comment>[{$keyValuePair}]</comment> to environment file.");

        $action = file_put_contents(
            $this->laravel->environmentFilePath(),
            file_get_contents($this->laravel->environmentFilePath())."\n".$keyValuePair."\n",
            LOCK_EX
        );

        return $action !== false;
    }

    private function replaceKeyValuePair(string $existingKeyValuePair, string $newKeyValuePair): bool
    {
        $this->info("Replacing existing key/value pair <comment>[{$existingKeyValuePair}]</comment> with <comment>[{$newKeyValuePair}]</comment> in environment file.");

        $action = file_put_contents(
            $this->laravel->environmentFilePath(),
            preg_replace(
                $this->replacementPattern($existingKeyValuePair),
                $newKeyValuePair,
                file_get_contents($this->laravel->environmentFilePath())
            ),
            LOCK_EX
        );

        return $action !== false;
    }
}
