<?php

namespace Proxy\Tests;

abstract class AbstractProxyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected static $dir = __DIR__ . '/proxies';

    /**
     * {@inheritDoc}
     */
    public static function tearDownAfterClass()
    {
        array_map(function ($file) {
            unlink($file);
        }, glob(static::$dir . '/*'));
    }
}
