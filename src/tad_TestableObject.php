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
        $className = get_called_class();
        if (!method_exists($className, $methodName)) {
            throw new InvalidArgumentException("Method $methodName does not exist", 2);
        }
        $mocker = new tad_DependencyMocker($testCase, $className);
        return $mocker->setMethod($methodName)
            ->getMocks();
    }
}