<?php

class tad_DependencyMocker
{
    protected $testCase;
    protected $className;
    protected $methodName;
    protected $notation;

    public function __construct(PHPUnit_Framework_TestCase $testCase, $className)
    {
        if (!is_string($className)) {
            throw new InvalidArgumentException('Class name must be a string', 1);
        }
        if (!class_exists($className)) {
            throw new InvalidArgumentException("Class $className does not exisit", 2);
        }
        $this->testCase = $testCase;
        $this->className = $className;
    }

    public function setNotation($notation)
    {
        $this->notation = $notation;
        return $this;
    }

    public function getMocks()
    {
        $notation = $this->notation ? '@' . $this->notation : '@depends';
        $methods = is_array($this->methodName) ? $this->methodName : array($this->methodName);
        $mockables = array();
        foreach ($methods as $method) {
            $reflector = new ReflectionMethod($this->className, $method);
            $docBlock = $reflector->getDocComment();
            $lines = explode("\n", $docBlock);
            foreach ($lines as $line) {
                if (count($parts = explode($notation, $line)) > 1) {
                    $classes = trim(preg_replace("/[,;(; )(, )]+/", " ", $parts[1]));
                    $classes = explode(' ', $classes);
                    foreach ($classes as $class) {
                        $mockables[] = $class;
                    }
                }
            }
        }
        $mocks = new stdClass();
        foreach ($mockables as $mockable) {
            $mocks->$mockable = $this->testCase->getMockBuilder($mockable)->disableOriginalConstructor()->getMock();
        }
        return $mocks;
    }

    public function setMethod($methodName)
    {
        if (!is_string($methodName) && !is_array($methodName)) {
            throw new InvalidArgumentException('Method name must be a string or an array', 1);
        }
        $this->methodName = $methodName;
        return $this;
    }
}