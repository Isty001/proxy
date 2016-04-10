<?php

namespace Proxy\Info;

class ClassInfo
{
    /**
     * @var string
     */
    private $reflectionClass;

    /**
     * @var string
     */
    private $methodsContent;

    /**
     * @var string
     */
    private $proxyClass;
    /**
     * @var string
     */
    private $dir;

    /**
     * @param \ReflectionClass $class
     * @param string $methods
     * @param string $dir
     */
    public function __construct(\ReflectionClass $class, string $methods, string $dir)
    {
        $this->reflectionClass = $class;
        $this->methodsContent = $methods;
        $this->dir = $dir;
    }

    /**
     * @return string
     */
    public function getOriginalClass() : string
    {
        return $this->reflectionClass->getName();
    }

    /**
     * @return string
     */
    public function getProxyClass() : string
    {
        if (null === $this->proxyClass) {
            $this->proxyClass = uniqid($this->reflectionClass->getShortName() . '_proxy_');
        }
        return $this->proxyClass;
    }

    /**
     * @return string
     */
    public function getProxyFile()
    {
        return "{$this->dir}/{$this->getProxyClass()}.php";
    }

    /**
     * @return string
     */
    public function getMethodsContent() : string
    {
        return $this->methodsContent;
    }

    /**
     * @return string
     */
    public function getFileName() : string
    {
        return $this->reflectionClass->getFileName();
    }
}
