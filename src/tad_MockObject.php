<?php

class tad_MockObject
{
    protected $testCase;
    protected $className;
    protected $methodNameOrArray;
    protected $notation;
    protected $toStubClassName;
    protected $alwaysStubMethods;

    public function __construct(PHPUnit_Framework_TestCase $testCase, $className, $toStubClassName, $methodNameOrArray = null, $notation = null, $alwaysStubMethods = null)
    {
        if (!is_string($className)) {
            throw new InvalidArgumentException('Class name must be a string', 1);
        }
        if (!class_exists($className)) {
            throw new InvalidArgumentException("Class $className does not exisit", 2);
        }
        if (!is_string($toStubClassName)) {
            throw new InvalidArgumentException('The name of the class to stub must be a string', 3);
        }
        $this->testCase = $testCase;
        $this->className = $className;
        $this->toStubClassName = $toStubClassName;
        $this->methodNameOrArray = $methodNameOrArray ? $methodNameOrArray : null;
        $this->notation = $notation ? $notation : null;
        $this->alwaysStubMethods = $alwaysStubMethods ? $alwaysStubMethods : null;
    }

//return $mockObject->getMock($methodNameOrArray, $notation, $alwaysStubMethods);
    public function getMock($methodNameOrArray = null, $notation = null, $alwaysStubMethods = null)
    {
        $methodNameOrArray = $methodNameOrArray ? $methodNameOrArray : $this->methodNameOrArray;
        $notation = $notation ? $notation : $this->notation;
        $alwaysStubMethods = $alwaysStubMethods ? $alwaysStubMethods : $this->alwaysStubMethods;

        if ($methodNameOrArray && !is_string($methodNameOrArray) && !is_array($methodNameOrArray)) {
            throw new InvalidArgumentException('Method name must either be a string or an array of method names', 3);
        }
        if (!is_string($notation) && !is_array($notation)) {
            throw new InvalidArgumentException('Comment notation must be a string or an array of strings', 4);
        }
        if ($alwaysStubMethods && !is_array($alwaysStubMethods) && !is_string($alwaysStubMethods)) {
            throw new InvalidArgumentException('Methods to always stub must be a string or an array of method names', 6);
        }
        $reflection = new ReflectionClass($this->className);
        $notations = is_array($notation) ? $notation : array($notation);
        $alwaysStubMethods = is_array($alwaysStubMethods) ? $alwaysStubMethods : array($alwaysStubMethods);
        $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);
        if ($methodNameOrArray) {
            $methodsWhitelist = is_array($methodNameOrArray) ? $methodNameOrArray : array($methodNameOrArray);
            $filteredMethods = array();
            foreach ($methods as $method) {
                if (in_array($method->name, $methodsWhitelist)) {
                    $filteredMethods[] = $method;
                }
            }
            $methods = $filteredMethods;
        }
        $toStub = is_array($alwaysStubMethods) ? $alwaysStubMethods : array();
        foreach ($methods as $method) {
            if ($doc = $method->getDocComment()) {
                $lines = explode("\n", $doc);
                foreach ($lines as $line) {
                    foreach ($notations as $notation) {
                        if (count($parts = explode('@' . $notation, $line)) > 1) {
                            $parts = trim(preg_replace("/[,;(; )(, )]+/", " ", $parts[1]));
                            $adapterMethodNames = explode(' ', $parts);
                            foreach ($adapterMethodNames as $adapterMethodName) {
                                $toStub[] = $adapterMethodName;
                            }
                        }
                    }
                }

            }
        }
        $toStub = array_unique($toStub);
        return $this->testCase->getMockBuilder($this->toStubClassName)->setMethods($toStub)->getMock();
    }

    public function forMethods($methodNameOrArray)
    {
        $this->methodNameOrArray = $methodNameOrArray;
        return $this;
    }

    public function setNotation($notation)
    {
        $this->notation = $notation;
        return $this;
    }

    public function setMethods($methods)
    {
        $this->alwaysStubMethods = $methods;
        return $this;
    }
}