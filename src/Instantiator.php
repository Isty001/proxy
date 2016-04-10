<?php

namespace Proxy;

class Instantiator
{
    /**
     * @param string $class
     * @param array $arguments
     * @return object
     */
    public static function instantiate(string $class, ...$arguments)
    {
        if (is_array($arguments[0])) {
            $arguments = $arguments[0];
        }
        return (new \ReflectionClass($class))->newInstanceArgs($arguments);
    }
}
