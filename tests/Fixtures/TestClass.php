<?php

namespace Proxy\Tests\Fixtures;

class TestClass
{
    /**
     * @var string
     */
    private $string;

    public function __construct(\stdClass $class, string $string, array $array)
    {
        $this->string = $string;
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

    public function getString() : string
    {
        return $this->string;
    }

    public function anotherPublicMethod()
    {
    }
}
