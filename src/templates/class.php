<?php

/** @var \Proxy\Info\ClassInfo $classInfo */

return "<?php

class {$classInfo->getProxyClass()} extends {$classInfo->getOriginalClass()}
{
    /**
    * @var bool
    */
    private \$initialized = false;

    /**
    * @var {$classInfo->getOriginalClass()}
    */
    private \$instance;

    /**
    * @var array
    */
    private \$arguments;

    /**
    * @param mixed
    */
    public function __construct(...\$arguments)
    {
        \$this->arguments = \$arguments;
    }
    {$classInfo->getMethodsContent()}

    private function initialize()
    {
        if (false === \$this->initialized) {
            \$this->instance = \\Proxy\\Instantiator::instantiate(parent::class, \$this->arguments);
        }
    }
}";
