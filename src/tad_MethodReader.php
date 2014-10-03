<?php

interface tad_MethodReader
{
    public function __construct($className, $methodName);

    public function getDependencies();
    public function setClassName($className);
    public function setMethodName($methodNameOrArray);
}