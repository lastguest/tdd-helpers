<?php
namespace tad\Mockers\Dependency\Utility;

interface MethodReaderInterface
{
    public function __construct($className, $methodName);

    public function getDependencies();

    public function setClassName($className);

    public function setMethodName($methodNameOrArray);
}