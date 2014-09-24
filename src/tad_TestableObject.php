<?php


abstract class tad_TestableObject
{

    protected $F;
    protected $G;

    public function setFunctionsAdapter(tad_FunctionsAdapter $F = null)
    {
        $this->F = $F ? $F : new tad_FunctionsAdapter();
    }

    public function getFunctionsAdapter()
    {
        return $this->F;
    }

    public function setGlobalsAdapter(tad_GlobalsAdapterInterface $G = null)
    {
        $this->G = $G ? $G : new tad_GlobalsAdapter();
    }

    public function getGlobalsAdapter()
    {
        return $this->G;
    }

    public static function getMockFunctionsAdapter(PHPUnit_Framework_TestCase $testCase, $className = null)
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
        $reflection = new ReflectionClass($className);
        $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);
        $toStub = array('__call');
        foreach ($methods as $method) {
            if ($doc = $method->getDocComment()) {
                $lines = explode("\n", $doc);
                foreach ($lines as $line) {
                    if (count($parts = explode('@F', $line)) > 1) {
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
        return $testCase->getMockBuilder('tad_FunctionsAdapterInterface')->setMethods($toStub)->getMock();
    }
} 