<?php

/** @var \Proxy\Info\MethodInfo $methodInfo */


return "
    {$methodInfo->getAnnotation()}
    public function {$methodInfo->getName()}({$methodInfo->getTypedArguments()}) {$methodInfo->getReturnType()}
    {
        \$this->initialize();

        return \$this->instance->{$methodInfo->getName()}({$methodInfo->getArguments()});
    }";
