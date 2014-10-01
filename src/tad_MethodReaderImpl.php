<?php

use PhpParser\Lexer;
use PhpParser\Parser;

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
                $dependencies[$class] = isset($dependencies[$class]) ?: array();
                $dependencies[$class][] = $param->getName();
            }
        }
        return $dependencies;
    }
}