<?php

interface tad_MethodReader
{
    public function __construct($className, $methodName);

    public function getDependencies();
}