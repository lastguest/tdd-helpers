<?php


abstract class tad_TestableObject
{

    protected $f;
    protected $g;

    protected static function getMockAdapter(PHPUnit_Framework_TestCase $testCase, $className, $notation, $toStubClassName, $alwaysStubMethods = null)
    {
        if (!is_string($className)) {
            // PHP >= 5.3
            if (function_exists('get_called_class')) {
                $className = get_called_class();
            } else {
                // PHP < 5.3
                throw new InvalidArgumentException('Class name must be a string!');
            }
        }
        if (!class_exists($className)) {
            throw new InvalidArgumentException("Class $className does not exisit", 2);
        }
        if (!is_string($notation)) {
            throw new InvalidArgumentException('Comment notation must be a string', 3);
        }
        if (!is_string($toStubClassName)) {
            throw new InvalidArgumentException('The name of the class to stub must be a string', 4);
        }
        if ($alwaysStubMethods && !is_array($alwaysStubMethods)) {
            throw new InvalidArgumentException('Methods to always stub must come in an array', 5);
        }
        $reflection = new ReflectionClass($className);
        $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);
        $toStub = is_array($alwaysStubMethods) ? $alwaysStubMethods : array();
        foreach ($methods as $method) {
            if ($doc = $method->getDocComment()) {
                $lines = explode("\n", $doc);
                foreach ($lines as $line) {
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

    public static function getMockFunctionsAdapter(PHPUnit_Framework_TestCase $testCase, $className = null)
    {
        return self::getMockAdapter($testCase, $className, 'f', 'tad_FunctionsAdapterInterface', array('__call'));
    }

    public static function getMockGlobalsAdapter(PHPUnit_Framework_TestCase $testCase, $className = null)
    {
        return self::getMockAdapter($testCase, $className, 'g', 'tad_GlobalsAdapterInterface', array('__call'));
    }
}