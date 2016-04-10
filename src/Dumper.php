<?php

namespace Proxy;

use Proxy\Info\{ClassInfo, MethodInfo};

class Dumper
{
    /**
     * @var string
     */
    private $dir;

    /**
     * @var array
     */
    private $templates;

    /**
     * @var \ReflectionClass
     */
    private $reflectionClass;

    /**
     * @param string $dir
     */
    public function __construct(string $dir)
    {
        $this->dir = $dir;
        $this->templates = $this->loadTemplates();
    }

    /**
     * @return array
     */
    private function loadTemplates() : array
    {
        $iterator = new \FilesystemIterator(__DIR__ . '/templates', \FilesystemIterator::SKIP_DOTS);
        $templates = [];

        /** @var \SplFileInfo $template */
        foreach ($iterator as $template) {
            $name = $template->getFileInfo()->getBasename('.php');
            $templates[$name] = $template->getPathname();
        }
        return $templates;
    }

    /**
     * @param string $class
     * @return ClassInfo
     */
    public function dumpProxyFor(string $class) : ClassInfo
    {
        $classInfo = $this->createClassInfo($class);
        file_put_contents($classInfo->getProxyFile(), require $this->templates['class']);

        return $classInfo;
    }

    /**
     * @param string $class
     * @return ClassInfo
     */
    private function createClassInfo(string $class) : ClassInfo
    {
        $this->reflectionClass = new \ReflectionClass($class);

        return new ClassInfo($this->reflectionClass, $this->generateMethodsContent(), $this->dir);
    }

    /**
     * @return string
     */
    private function generateMethodsContent() : string
    {
        $methods = '';
        foreach ($this->getPublicMethods() as $method) {
            if (false === $method->isConstructor() && false === $method->isStatic()) {
                $methods .= $this->getMethodContent($method);
            }
        }
        return $methods;
    }

    /**
     * @return \ReflectionMethod[]
     */
    private function getPublicMethods() : array
    {
        return $this->reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC);
    }

    /**
     * @param \ReflectionMethod $method
     * @return string
     */
    private function getMethodContent(\ReflectionMethod $method) : string
    {
        $methodInfo = new MethodInfo($method);

        return require $this->templates['method'];
    }
}
