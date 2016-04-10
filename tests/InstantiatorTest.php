<?php

namespace Proxy\Tests;

use Proxy\Instantiator;
use Proxy\Tests\Fixtures\TestClass;

class InstantiatorTest extends \PHPUnit_Framework_TestCase
{
    public function testInstantiatorArray()
    {
        $instance = Instantiator::instantiate(TestClass::class, [new \stdClass(), 'Hello']);

        $this->assertInstanceOf(TestClass::class, $instance);
    }

    public function testInstantiatorVariadic()
    {
        $instance = Instantiator::instantiate(TestClass::class, new \stdClass(), 'Hello');

        $this->assertInstanceOf(TestClass::class, $instance);
    }
}
