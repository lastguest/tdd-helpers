<?php

class tad_Generators_Adapter_Utility_FunctionDumper implements PHP52Safe
{
    public static function dumpFunction($functionName)
    {
        $reflectionFunction = new \ReflectionFunction($functionName);

        $name = $reflectionFunction->name;
        $args = array(
            'name' => $name,
            'parameters' => array()
        );

        foreach ($reflectionFunction->getParameters() as $param) {
            $type = $param->getClass() ? $param->getClass()->name : false;
            if (!$type && $param->isArray()) {
                $type = 'array';
            }
            $args['parameters'][$param->name] = array(
                'type' => $type,
                'isPassedByReference' => $param->isPassedByReference(),
                'name' => $param->name,
                'isOptional' => $param->isOptional(),
                'defaultValue' => $param->isDefaultValueAvailable() && $param->getDefaultValue() ? $param->getDefaultValue() : false
            );
        }

        return $args;
    }
} 