<?php

namespace DistortedFusion\Env\Tests\Commands\Concerns;

use DistortedFusion\Env\Commands\EnvSetCommand;
use DistortedFusion\Env\Tests\TestCase;

class WritesToEnvTest extends TestCase
{
    public function testEnvGetReturnsNullWhenNotSet()
    {
        $this->createTmpEnv(self::ENV_EMPTY_STUB);

        $command = new EnvSetCommand();
        $command->setLaravel($this->app);

        $value = $this->callMethod($command, 'envGet', ['DOES_NOT_EXIST']);

        $this->assertNull($value);
    }
}
