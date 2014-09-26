<?php

/**
 * Class tad_DependencyMocker
 *
 * Mocks method dependencies. The supposed workflow is
 *
 *     $mocker = new tad_DependencyMocker($this, $className);
 *     $mockedDependencies = $mocker->setMethods(array('methodOne, methodTwo));
 *
 *     // set expectations and return values on mocked objects
 *     $mockedDependencies->DependencyOne->expects(...
 */
class tad_DependencyMocker
{
    protected $className;
    protected $methodName;
    protected $notation;

    /**
     * @param PHPUnit_Framework_TestCase $testCase
     * @param $className
     */
    public function __construct($className)
    {
        if (!is_string($className)) {
            throw new InvalidArgumentException('Class name must be a string', 1);
        }
        if (!class_exists($className)) {
            throw new InvalidArgumentException("Class $className does not exisit", 2);
        }
        $this->className = $className;
    }

    /**
     * Sets the notation to be used to pick up a method dependencies.
     *
     * By default the "depends" notation will be used.
     *
     * @param $notation
     * @return $this
     */
    public function setNotation($notation)
    {
        $this->notation = $notation;
        return $this;
    }

    /**
     * Returns an object defining each mocked dependency as a property.
     *
     * The property name is the same as the mocked class name.
     *
     * @return stdClass
     */
    public function getMocks()
    {
        return $this->getMocksObjectOrArray(true);
    }

    public function getMocksArray()
    {

        return $this->getMocksObjectOrArray(false);
    }

    /**
     * Sets one or more methods to be mocked.
     *
     * @param $methodName
     * @return $this
     */
    public function setMethods($methodName)
    {
        if (!is_string($methodName) && !is_array($methodName)) {
            throw new InvalidArgumentException('Method name must be a string or an array', 1);
        }
        $this->methodName = $methodName;
        return $this;
    }

    /**
     * @return stdClass
     */
    protected function getMocksObjectOrArray($getObject = true)
    {
        $notation = $this->notation ? '@' . $this->notation : '@depends';
        $methods = is_array($this->methodName) ? $this->methodName : array($this->methodName);
        $mockables = array();
        foreach ($methods as $method) {
            $reflector = new ReflectionMethod($this->className, $method);
            $docBlock = $reflector->getDocComment();
            $lines = explode("\n", $docBlock);
            foreach ($lines as $line) {
                if (count($parts = explode($notation, $line)) > 1) {
                    $classes = trim(preg_replace("/[,;(; )(, )]+/", " ", $parts[1]));
                    $classes = explode(' ', $classes);
                    foreach ($classes as $class) {
                        $mockables[] = $class;
                    }
                }
            }
        }
        $testCase = new tad_SpoofTestCase();
        if ($getObject) {
            $mocks = new stdClass();
            foreach ($mockables as $mockable) {
                $mocks->$mockable = $testCase->getMockBuilder($mockable)->disableOriginalConstructor()->getMock();
            }
        } else {
            $mocks = array();
            foreach ($mockables as $mockable) {
                $mocks[$mockable] = $testCase->getMockBuilder($mockable)->disableOriginalConstructor()->getMock();
            }
        }
        return $mocks;
    }
}

class tad_SpoofTestCase extends PHPUnit_Framework_TestCase{

}