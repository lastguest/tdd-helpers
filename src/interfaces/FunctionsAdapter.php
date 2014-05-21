<?php
namespace tad\interfaces;

/**
 * Functions Adatper interface
 * 
 * The interface is used in the class to allow simple mocking of the class
 * using its interface in tests. PHPUnit mocking, for example:
 * 
 *     $mockF = $this->getMock('\tad\interfaces\FunctionsAdapter');
 */
interface FunctionsAdapter
{
    public function __call($function, $arguments);
}
