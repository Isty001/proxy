<?php

namespace Proxy\Tests\Fixtures;

class TestClass
{
    public function __construct(\stdClass $class, string $string)
    {
        echo 'Instantiated';
    }

    private function privateMethod()
    {
    }

    protected function protectedMethod()
    {
    }

    /**
     * @param string $string
     * @param \stdClass $std
     * @return string
     */
    public function publicMethod(string $string, \stdClass $std) : string
    {
    }

    public function someMethod()
    {
    }

    public function anotherPublicMethod()
    {
    }
}
