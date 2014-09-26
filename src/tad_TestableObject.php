<?php

/**
 * Class tad_TestableObject
 *
 * A class that's meant to be used as a parent class for objects developed using TDD techniques.
 */
abstract class tad_TestableObject
{
    /**
     * Gets the mocked dependencies for one or more of the class public methods.
     *
     * The extending class is required to define valid doc blocks
     * for each public method that's meant to have its dependencies
     * mocked using the "@depends" notation.
     * See tad_DependencyMocker class for more in-detail information.
     *
     *      * @depends A, B, CInterface
     *
     * @param PHPUnit_Framework_TestCase $testCase
     * @param $methodName
     * @return stdClass
     */
    public static function getMocksFor(PHPUnit_Framework_TestCase $testCase, $methodName)
    {
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
        return $mocker->setMethods($methodName)
            ->getMocks();
    }
}