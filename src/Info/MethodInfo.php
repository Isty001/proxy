<?php

namespace Proxy\Info;

class MethodInfo
{
    /**
     * @var \ReflectionMethod
     */
    private $reflectionMethod;

    /**
     * @var array
     */
    private $arguments = [];

    /**
     * @var array
     */
    private $typedArguments = [];

    /**
     * @param \ReflectionMethod $method
     */
    public function __construct(\ReflectionMethod $method)
    {
        $this->reflectionMethod = $method;
        $this->setArguments();
    }

    private function setArguments()
    {
        foreach ($this->reflectionMethod->getParameters() as $parameter) {
            $this->arguments[] = $argument = '$' . $parameter->getName();
            $this->typedArguments[] = (string)$parameter->getType() . ' ' . $argument;
        }
    }

    /**
     * @return string
     */
    public function getArguments() : string
    {
        return implode(', ', $this->arguments);
    }

    /**
     * @return string
     */
    public function getTypedArguments() : string
    {
        return implode(', ', $this->typedArguments);
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->reflectionMethod->getName();
    }

    /**
     * @return string
     */
    public function getReturnType() : string
    {
        $returnType = $this->reflectionMethod->getReturnType();
        if (null !== $returnType) {
            return ': ' . (string)$returnType;
        }
        return '';
    }

    /**
     * @return string
     */
    public function getAnnotation() : string
    {
        return $this->reflectionMethod->getDocComment();
    }
}
