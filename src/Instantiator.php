<?php

namespace Proxy;

class Instantiator
{
    /**
     * @param string $class
     * @param array $arguments
     * @return object
     */
    public static function instantiate(string $class, array $arguments)
    {
        return (new \ReflectionClass($class))->newInstanceArgs($arguments);
    }
}
