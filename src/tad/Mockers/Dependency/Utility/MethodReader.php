<?php
namespace tad\Mockers\Dependency\Utility;

class MethodReader implements MethodReaderInterface
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
            $method = new \ReflectionMethod($this->className, $methodName);
            $params = $method->getParameters();
            foreach ($params as $param) {
                $class = $param->getClass();
                // the check is made to filter out any non object argument
                if ($class) {
                    $class = $class->getName();
                    if (!isset($dependencies[$class])) {
                        $dependencies[$class] = array();
                    }
                    $dependencies[$class][] = $param->getName();
                }
            }
        }
        $dependencies = array_map(function ($arr) {
            return array_unique($arr);
        }, $dependencies);
        return $dependencies;
    }

    public function setClassName($className)
    {
        if (!is_null($className) && !is_string($className)) {
            throw new Exception('Class name must either be null or a string');
        }
        $this->className = $className;
    }

    public function setMethodName($methodNameOrArray)
    {
        if (!is_null($methodNameOrArray) && !is_array($methodNameOrArray) && !is_string($methodNameOrArray)) {
            throw new Exception('Method name must either be a string or an array of method names');
        }
        $this->methodNames = is_array($methodNameOrArray) ? $methodNameOrArray : array($methodNameOrArray);
    }
}