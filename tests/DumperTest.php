<?php

namespace Proxy\Tests;

use Proxy\Dumper;
use Proxy\Info\ClassInfo;
use Proxy\Tests\Fixtures\TestClass;

class DumperTest extends AbstractProxyTest
{
    /**
     * @var Dumper
     */
    private $dumper;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        $this->dumper = new Dumper(static::$dir);
    }

    public function testDumper()
    {
        $classInfo = $this->dumper->dumpProxyFor(TestClass::class);

        $this->assertEquals($this->getExpectedProxyCode($classInfo), $this->removeSpaces(file_get_contents($classInfo->getProxyFile())));
    }

    /**
     * @param ClassInfo $classInfo
     * @return string
     */
    private function getExpectedProxyCode(ClassInfo $classInfo) : string
    {
        $code = '<?php

class %s extends Proxy\Tests\Fixtures\TestClass
{
    /**
    * @var bool
    */
    private $initialized = false;

    /**
    * @var Proxy\Tests\Fixtures\TestClass
    */
    private $instance;

    /**
    * @var array
    */
    private $arguments;

    /**
    * @param mixed
    */
    public function __construct(...$arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * @param string $string
     * @param \stdClass $std
     * @return string
     */
    public function publicMethod(string $string, stdClass $std) : string
    {
        $this->initialize();

        return $this->instance->publicMethod($string, $std);
    }

    public function testMethod()
    {
        $this->initialize();

        return $this->instance->testMethod();
    }

    public function anotherPublicMethod()
    {
        $this->initialize();

        return $this->instance->anotherPublicMethod();
    }

    private function initialize()
    {
        if (false === $this->initialized) {
            $this->instance = \Proxy\Instantiator::instantiate(parent::class, $this->arguments);
        }
    }
}';
        return $this->removeSpaces(sprintf($code, $classInfo->getProxyClass()));
    }

    /**
     * @param string $string
     * @return string
     */
    private function removeSpaces(string $string) : string
    {
        return preg_replace('/\s+/', '', $string);
    }
}
