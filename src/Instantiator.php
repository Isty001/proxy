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
        return (new \ReflectionClass($class))->newInstanceArgs(self::flattenArray($arguments));
    }

    /**
     * @param array $array
     * @return array
     */
    private static function flattenArray(array $array) : array
    {
        $flatten = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $flatten = array_merge($flatten, self::flattenArray($value));
            } else {
                $flatten[$key] = $value;
            }
        }
        return $flatten;
    }
}
