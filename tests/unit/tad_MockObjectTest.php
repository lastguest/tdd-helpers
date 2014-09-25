<?php

interface Interface119
{
    public function __call($name, $args);
}

class Test119 extends tad_TestableObject
{

    /**
     * @Functions functionOne,functionTwo
     */
    public function methodOne()
    {
    }

    /**
     * @baz functionThree, functionFour
     */
    public function methodTwo()
    {
    }

    /**
     * @baz functionFive, functionSix
     */
    public function methodThree()
    {
    }
}

class tad_MockObjectTest extends \PHPUnit_Framework_TestCase
{
    protected function getSutInstance()
    {
        return new tad_MockObject($this, 'Test119', 'Interface119');
    }

    protected function setUp()
    {
    }

    protected function tearDown()
    {
    }

    /**
     * @test
     * it should allow specifying the methods to parse using the forMethods method
     */
    public function it_should_allow_specifying_the_methods_to_parse_using_the_for_methods_method()
    {
        $mock = $this->getSutInstance()
            ->forMethods('methodOne')
            ->setNotation('Functions')
            ->setMethods('__call')
            ->getMock();
        $this->assertTrue(method_exists($mock, '__call'));
        $this->assertTrue(method_exists($mock, 'functionOne'));
        $this->assertTrue(method_exists($mock, 'functionTwo'));
    }

    /**
     * @test
     * it should allow specifying the notations using an array
     */
    public function it_should_allow_specifying_the_notations_using_an_array()
    {
        $mock = $this->getSutInstance()
            ->setNotation(array('Functions', 'baz'))
            ->setMethods('__call')
            ->getMock();
        $this->assertTrue(method_exists($mock, '__call'));
        $this->assertTrue(method_exists($mock, 'functionOne'));
        $this->assertTrue(method_exists($mock, 'functionTwo'));
        $this->assertTrue(method_exists($mock, 'functionThree'));
        $this->assertTrue(method_exists($mock, 'functionFour'));
        $this->assertTrue(method_exists($mock, 'functionFive'));
        $this->assertTrue(method_exists($mock, 'functionSix'));
    }
}