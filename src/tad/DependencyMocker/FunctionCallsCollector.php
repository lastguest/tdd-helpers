<?php
namespace tad\DependencyMocker;

class FunctionCallsCollector implements \tad_Adapters_IFunctions
{
    protected $called;

    public function __construct()
    {
        $this->called = array();
    }

    public function __call($function, $arguments)
    {
        $reflectionFunction = new \ReflectionFunction($function);
        $this->called[$reflectionFunction->name] = $reflectionFunction;
        return call_user_func_array($function, $arguments);
    }

    public function getCalled()
    {
        return array_values($this->called);
    }
}