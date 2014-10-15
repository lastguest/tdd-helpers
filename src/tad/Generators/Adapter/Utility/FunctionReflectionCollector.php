<?php

namespace tad\Generators\Adapter\Utility;


class FunctionReflectionCollector implements \PHP52Safe
{

    /**
     * @var array
     */
    protected $functions;

    public function setFunctions(array $functions)
    {
        $this->functions = $functions;
        return $this;
    }

    public function getFunctions()
    {
        return $this->functions;
    }

    public function getReflectedFunctionsArray()
    {
        if (empty($this->functions)) {
            return array();
        }
        $reflectedFunctions = array();
        foreach ($this->functions as $functionName) {
            $args = \tad_Generators_Adapter_Utility_FunctionDumper::dumpFunction($functionName);
            $reflectedFunctions[$args['name']] = $args;
        }

        return $reflectedFunctions;
    }

}