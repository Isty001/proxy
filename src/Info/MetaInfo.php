<?php

namespace Proxy\Info;

class MetaInfo
{
    /**
     * @var string
     */
    private $originalFilename;

    /**
     * @var int
     */
    private $lastModification;

    /**
     * @var string
     */
    private $proxyClass;

    /**
     * @var string
     */
    private $proxyFile;

    /**
     * @param ClassInfo $classInfo
     * @param string $dir
     */
    public function __construct(ClassInfo $classInfo, string $dir)
    {
        $this->originalFilename = $classInfo->getFileName();
        $this->lastModification = filemtime($this->originalFilename);
        $this->proxyClass = $classInfo->getProxyClass();
        $this->proxyFile = $classInfo->getProxyFile();
    }

    /**
     * @return string
     */
    public function getOriginalFilename() : string
    {
        return $this->originalFilename;
    }

    /**
     * @return int
     */
    public function getLastModification() : int
    {
        return $this->lastModification;
    }

    /**
     * @return string
     */
    public function getProxyClass() : string
    {
        return $this->proxyClass;
    }

    /**
     * @return string
     */
    public function getProxyFile() : string
    {
        return $this->proxyFile;
    }
}
