<?php

namespace Proxy;

use Proxy\Info\{ClassInfo, MetaInfo};

class Factory
{
    /**
     * @var string
     */
    private $dir;

    /**
     * @var Dumper
     */
    private $dumper;

    /**
     * @var string
     */
    private $metaFile;

    /**
     * @var MetaInfo[]
     */
    private $metaInfos = [];

    /**
     * @param string $dir
     */
    public function __construct(string $dir)
    {
        $this->dir = $dir;
        $this->dumper = new Dumper($this->dir);
        $this->metaInfos = $this->getMetaData();
        $this->validateProxies();
    }

    /**
     * @return array
     */
    private function getMetaData() : array
    {
        $this->metaFile = "{$this->dir}/meta_infos.txt";
        if (file_exists($this->metaFile)) {
            return unserialize(file_get_contents($this->metaFile));
        }
        return [];
    }

    /**
     * @return void
     */
    private function validateProxies()
    {
        foreach ($this->metaInfos as $class => $metaInfo) {
            $this->validateProxy($metaInfo, $class);
        }
    }

    /**
     * @param MetaInfo $metaInfo
     * @param string $class
     */
    private function validateProxy(MetaInfo $metaInfo, string $class)
    {
        if ($metaInfo->getLastModification() < filemtime($metaInfo->getOriginalFilename())) {
            if (false === class_exists($class)) {
                $this->destroyProxy($metaInfo, $class);
            } else {
                $this->reGenerateProxy($metaInfo, $class);
            }
        }
    }

    /**
     * @param string $class
     * @param array $arguments
     * @return object
     */
    public function create(string $class, ...$arguments)
    {
        return $this->instantiate($class, $arguments);
    }

    /**
     * @param string $class
     * @param array $arguments
     * @return object
     */
    public function createFromArray(string $class, array $arguments = [])
    {
        return $this->instantiate($class, $arguments);
    }

    /**
     * @param string $class
     * @param array $arguments
     * @return object
     */
    private function instantiate(string $class, array $arguments)
    {
        return Instantiator::instantiate($this->getProxyFor($class), $arguments);
    }

    /**
     * @param string $class
     * @return string
     */
    private function getProxyFor(string $class) : string
    {
        if (false === $this->getExistingProxy($class)) {
            $this->dumpProxy($class);
        }
        return $this->getExistingProxy($class);
    }

    /**
     * @param string $class
     * @return object|bool
     */
    private function getExistingProxy(string $class)
    {
        if (isset($this->metaInfos[$class])) {
            $metaInfo = $this->metaInfos[$class];
            $this->validateProxy($metaInfo, $class);

            return $this->getProxyClassFromMeta($metaInfo);
        }
        return false;
    }

    /**
     * @param MetaInfo $metaInfo
     * @return string
     */
    private function getProxyClassFromMeta(MetaInfo $metaInfo)
    {
        if (false === class_exists($metaInfo->getProxyClass())) {
            require $metaInfo->getProxyFile();
        }
        return $metaInfo->getProxyClass();
    }

    /**
     * @param MetaInfo $metaInfo
     * @param string $class
     */
    private function reGenerateProxy(MetaInfo $metaInfo, string $class)
    {
        $this->destroyProxy($metaInfo, $class);
        $this->dumpProxy($class);
    }

    /**
     * @param MetaInfo $metaInfo
     * @param string $class
     */
    private function destroyProxy(MetaInfo $metaInfo, string $class)
    {
        unlink($metaInfo->getProxyFile());
        unset($this->metaInfos[$class]);
    }

    /**
     * @param string $class
     */
    private function dumpProxy(string $class)
    {
        $classInfo = $this->dumper->dumpProxyFor($class);
        $this->updateMetaData($classInfo);
    }

    /**
     * @param ClassInfo $classInfo
     */
    private function updateMetaData(ClassInfo $classInfo)
    {
        $this->metaInfos[$classInfo->getOriginalClass()] = new MetaInfo($classInfo, $this->dir);

        file_put_contents($this->metaFile, serialize($this->metaInfos));
    }
}
