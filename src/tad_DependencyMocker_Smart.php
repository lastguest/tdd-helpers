<?php

class tad_DependencyMocker_Smart implements tad_DependencyMocker
{
    protected $className;
    protected $methodNameOrArray;
    protected $extraMethods;
    protected $methodReader;

    public function __construct($className, $methodNameOrArray = null, array $extraMethods = null, tad_MethodReader $methodReader = null)
    {
        if (!is_string($className)) {
            throw new Exception('Class name must be a string');
        }
        $this->className = $className;
        $this->forMethods($methodNameOrArray);
        $this->setExtraMethods($extraMethods);
        $this->methodReader = $methodReader ? $methodReader : new tad_MethodReaderImpl($className, $methodNameOrArray);
    }

    /**
     * Returns an object defining each mocked dependency as a property.
     *
     * The property name is the same as the mocked class name.
     * If no method names are specified using the "forMethods"
     * method then the "__construct" method will be mocked.
     *
     * @return stdClass
     */
    public function getMocks()
    {
        return $this->getMocksObjectOrArray();
    }

    /**
     * Returns an array containing the mocked dependencies.
     *
     * The array format is ['ClassName' => mock]. If no method
     * names are specified using the "forMethods" method then
     * the "__construct" method will be mocked.
     *
     * @return array
     */
    public function getMocksArray()
    {
        return $this->getMocksObjectOrArray();
    }

    /**
     * Sets one or more methods to be mocked.
     *
     * @param $methodNameOrArray
     * @return $this
     */
    public function forMethods($methodNameOrArray)
    {
        if (!is_array($methodNameOrArray) && !is_string($methodNameOrArray)) {
            throw new Exception('Methods must either be a string or an array of strings');
        }
        $this->methodNameOrArray = $methodNameOrArray;
    }

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
    public static function on($className, $methodNameOrArray = null, array $extraMethods = null)
    {
        return new self($className, $methodNameOrArray, $extraMethods);
    }

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
    public function setExtraMethods(array $extraMethods = null)
    {
        $this->extraMethods = $extraMethods;
    }

    protected function getMocksObjectOrArray()
    {
        $dependencies = $this->methodReader->getDependencies();
        $mocks = array();
        $testCase = new tad_TestCase();
        foreach ($dependencies as $class => $args) {
            $reflectionClass = new ReflectionClass($class);
            $definedClassMethods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);
            $classMethodsNames = array_map(function ($method) {
                return $method->name;
            }, $definedClassMethods);
            $classHasExtraMethods = $this->extraMethods && isset($this->extraMethods[$class]);
            if ($classHasExtraMethods) {
                $classMethodsNames = array_merge($classMethodsNames, $this->extraMethods[$class]);
            }
            foreach ($args as $arg) {
                $mocks[$arg] = $testCase->getMockBuilder($class)
                    ->disableOriginalConstructor()
                    ->setMethods($classMethodsNames)
                    ->getMock();
            }
        }
        return $mocks;
    }
}