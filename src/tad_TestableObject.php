<?php


abstract class tad_TestableObject
{

    protected $f;
    protected $g;

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

    public static function getMocksFor(PHPUnit_Framework_TestCase $testCase, $methodName){
        if (!is_string($methodName)) {
            throw new InvalidArgumentException('Method name must be a string', 1);
        }
        if (!function_exists('get_called_class')) {
            throw new RuntimeException('While the class is PHP 5.2 compatible the getMocksFor method is meant to be used in testing environment based on PHP >= 5.3 version.', 2);
        }
        $className = get_called_class();
        if (!method_exists($className, $methodName)) {
            throw new InvalidArgumentException("Method $methodName does not exist", 3);
        }
        $mocker = new tad_DependencyMocker($testCase, $className);
        return $mocker->setMethod($methodName)
            ->getMocks();
    }
}