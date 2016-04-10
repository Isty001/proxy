<?php

namespace Proxy\Tests;

use Proxy\Factory;
use Proxy\Tests\Fixtures\TestClass;

class FactoryTest extends AbstractProxyTest
{
    /**
     * @var Factory
     */
    private $factory;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
       $this->factory = new Factory(static::$dir);
    }

    public function testProxyClass()
    {
        $proxyClass = $this->getProxyClass();

        $this->assertStringMatchesFormat('TestClass_proxy_%s', $proxyClass);
    }

    public function testProxyObject()
    {
        $proxyObject = $this->factory->create(TestClass::class, new \stdClass(), 'Hello', []);
        $this->assertInstanceOf(TestClass::class, $proxyObject);
        $this->assertEquals('Hello', $proxyObject->getString());

        $anotherProxy = $this->factory->createFromArray(TestClass::class, [new \stdClass(), 'Another Hello', []]);
        $this->assertEquals('Another Hello', $anotherProxy->getString());
    }

    public function testRegeneratedProxy()
    {
        $proxyClass = $this->getProxyClass();
        $this->touchTestClass();
        $regeneratedProxyClass = $this->getProxyClass();

        $this->assertNotEquals($proxyClass, $regeneratedProxyClass);
    }

    public function testStillFreshProxy()
    {
        $proxyClass = $this->getProxyClass();
        $regeneratedProxyClass = $this->getProxyClass();

        $this->assertEquals($proxyClass, $regeneratedProxyClass);
    }

    private function touchTestClass()
    {
        $file = (new \ReflectionClass(TestClass::class))->getFileName();
        touch($file, strtotime('+1 sec'));
        clearstatcache();
    }

    /**
     * @return string
     */
    private function getProxyClass() : string
    {
        return get_class($this->factory->create(TestClass::class));
    }
}
