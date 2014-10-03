<?php

interface tad_DependencyMocker
{

    /**
     * @param $className The class that should have its dependencies mocked.
     * @param string /array $methodNameOrArray The methods to mock the dependencies of.
     * @param array $extraMethods An associative array of class/methods that should be explicitly mocked.
     * @param string $notation The notation to use to parse method dependencies.
     */
    public function __construct($className, $methodNameOrArray = null, array $extraMethods = null);

    /**
     * Returns an object defining each mocked dependency as a property.
     *
     * The property name is the same as the mocked class name.
     * If no method names are specified using the "forMethods"
     * method then the "__construct" method will be mocked.
     *
     * @return stdClass
     */
    public function getMocks();

    /**
     * Returns an array containing the mocked dependencies.
     *
     * The array format is ['ClassName' => mock]. If no method
     * names are specified using the "forMethods" method then
     * the "__construct" method will be mocked.
     *
     * @return array
     */
    public function getMocksArray();

    /**
     * Sets one or more methods to be mocked.
     *
     * @param $methodNameOrArray
     * @return $this
     */
    public function forMethods($methodNameOrArray);

    /**
     * Static constructor method for the class.
     *
     * The method is will acccept the same parameters as the `__construct`
     * method and is meant as a fluent chain start.
     *
     * @param $className The class that should have its dependencies mocked.
     * @param string /array $methodNameOrArray The methods to mock the dependencies of.
     * @param array $extraMethods An associative array of class/methods that should be explicitly mocked.
     * @param string $notation The notation to use to parse method dependencies.
     * @return tad_DependencyMocker
     */
    public static function on($className, $methodNameOrArray = null, array $extraMethods = null);

    /**
     * Sets the methods to be explicitly stubbed.
     *
     * The method is useful when stubbing classes that rely on magic methods
     * and that will, hence, expose no public methods. The array to is in the
     * format
     *
     *      [
     *          'ClassName' => ['methodOne', 'methodTwo', 'methodThree'],
     *          'ClassName2' => ['methodOne', 'methodTwo', 'methodThree']
     *      ]
     *
     * @param array $extraMethods a className to array of methods associative array.
     * @return $this
     */
    public function setExtraMethods(array $extraMethods);
}