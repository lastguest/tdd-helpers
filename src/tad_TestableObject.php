<?php


abstract class tad_TestableObject
{

    protected $f;
    protected $g;

    protected static function getMock(PHPUnit_Framework_TestCase $testCase, $methodNameOrArray = null, $notation, $toStubClassName, $alwaysStubMethods = null)
    {
        $className = get_called_class();
        if (!class_exists($className)) {
            throw new InvalidArgumentException("Class $className does not exisit", 2);
        }
        if ($methodNameOrArray && !is_string($methodNameOrArray) && !is_array($methodNameOrArray)) {
            throw new InvalidArgumentException('Method name must either be a string or an array of method names', 3);
        }
        if (!is_string($notation) && !is_array($notation)) {
            throw new InvalidArgumentException('Comment notation must be a string or an array of strings', 4);
        }
        if (!is_string($toStubClassName)) {
            throw new InvalidArgumentException('The name of the class to stub must be a string', 5);
        }
        if ($alwaysStubMethods && !is_array($alwaysStubMethods)) {
            throw new InvalidArgumentException('Methods to always stub must come in an array', 6);
        }
        $reflection = new ReflectionClass($className);
        $notations = is_array($notation) ? $notation : array($notation);
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
        return $testCase->getMockBuilder($toStubClassName)->setMethods($toStub)->getMock();
    }

    public function setFunctionsAdapter(tad_FunctionsAdapter $f = null)
    {
        $this->f = $f ? $f : new tad_FunctionsAdapter();
    }

    public function getFunctionsAdapter()
    {
        return $this->F;
    }

    public function setGlobalsAdapter(tad_GlobalsAdapterInterface $g = null)
    {
        $this->g = $g ? $g : new tad_GlobalsAdapter();
    }

    public function getGlobalsAdapter()
    {
        return $this->g;
    }

    public static function getMockFunctions(PHPUnit_Framework_TestCase $testCase, $methodNameOrArray = null, $notation = null)
    {
        $notation = $notation ? $notation : 'f';
        return self::getMock($testCase, $methodNameOrArray, $notation, 'tad_FunctionsAdapterInterface', array('__call'));
    }

    public static function getMockGlobals(PHPUnit_Framework_TestCase $testCase, $methodNameOrArray = null, $notation = null)
    {
        $notation = $notation ? $notation : 'g';
        return self::getMock($testCase, $methodNameOrArray, $notation, 'tad_GlobalsAdapterInterface', array('__call'));
    }
}