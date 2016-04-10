<?php

namespace Proxy\Tests;

use Proxy\Instantiator;
use Proxy\Tests\Fixtures\TestClass;

class InstantiatorTest extends \PHPUnit_Framework_TestCase
{
    public function testInstantiator()
    {
        $instance = Instantiator::instantiate(TestClass::class, [new \stdClass(), 'Hello', [1, 3]]);

        $this->assertInstanceOf(TestClass::class, $instance);
    }
}
