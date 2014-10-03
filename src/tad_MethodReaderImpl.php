<?php


class tad_MethodReaderImpl implements tad_MethodReader
{
    protected $className;
    protected $methodNames;

    public function __construct($className, $methodNameOrArray)
    {
        $this->className = $className;
        $this->methods = is_array($methodNameOrArray) ? $methodNameOrArray : array($methodNameOrArray);
    }

    public function getDependencies()
    {
        $dependencies = array();
        foreach ($this->methods as $methodName) {
            $method = new ReflectionMethod($this->className, $methodName);
            $params = $method->getParameters();
            foreach ($params as $param) {
                $class = $param->getClass()->getName();
                if (!isset($dependencies[$class])) {
                    $dependencies[$class] = array();
                }
                $dependencies[$class][] = $param->getName();
            }
        }
        $dependencies = array_map(function ($arr) {
            return array_unique($arr);
        }, $dependencies);
        return $dependencies;
    }
}