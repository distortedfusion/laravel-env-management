<?php

namespace DistortedFusion\Env\Tests;

use ReflectionClass;
use ReflectionException;

trait ReflectionHelper
{
    /**
     * Call any method of any object, including private and protected.
     *
     * @param        $object
     * @param string $method
     * @param array  $args
     *
     * @throws ReflectionException
     *
     * @return mixed
     *
     * @see https://stackoverflow.com/a/8702347/10452175
     */
    public function callMethod($object, string $method, array $args)
    {
        $class = new ReflectionClass($object);
        $methodObj = $class->getMethod($method);
        $methodObj->setAccessible(true);

        return $methodObj->invokeArgs($object, $args);
    }
}
