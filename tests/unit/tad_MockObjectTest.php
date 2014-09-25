<?php

interface Interface119
{
    public function __call($name, $args);
}

interface Interface120
{
    public function someMethod();
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

class Test231 extends tad_TestableObject
{

    /**
     * @depends Test119, Interface120
     */
    public function __construct()
    {
    }

    /**
     * @depends Test119, Interface120
     */
    public function methodOne()
    {

    }

    /**
     * @depends Test119, Interface119
     */
    public function methodTwo()
    {

    }

    /**
     * @depends Test119, Interface120
     */
    public function methodThree(Test119 $test119, Interface120 $interface120)
    {
        return $test119->methodOne() + $interface120->someMethod();

    }

}

class tad_MockObjectTest extends \PHPUnit_Framework_TestCase
{
    protected function getSutInstance()
    {
        return new tad_MockObject($this, 'Test119', 'Interface119');
    }

    protected function getTest321Instance()
    {
        return new tad_MockObject($this, 'Test231');
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

    /**
     * @test
     * it should allow getting an array of all mocked constructor dependencies
     */
    public function it_should_allow_getting_an_array_of_all_mocked_constructor_dependencies()
    {
        $sut = new tad_MockObject($this, 'Test231');
        $mockDeps = $sut->setMethod('__construct')
            ->getMocks();
        $this->assertObjectHasAttribute('Test119', $mockDeps);
        $this->assertObjectHasAttribute('Interface120', $mockDeps);
        $this->assertTrue(method_exists($mockDeps->Test119, 'methodOne'));
        $this->assertTrue(method_exists($mockDeps->Test119, 'methodTwo'));
        $this->assertTrue(method_exists($mockDeps->Test119, 'methodThree'));
        $this->assertTrue(method_exists($mockDeps->Interface120, 'someMethod'));
    }

    /**
     * @test
     * it should allow getting an array of all mocked method dependencies
     */
    public function it_should_allow_getting_an_array_of_all_mocked_method_dependencies()
    {
        $sut = new tad_MockObject($this, 'Test231');
        $mockDeps = $sut->setMethod('methodOne')
            ->getMocks();
        $this->assertObjectHasAttribute('Test119', $mockDeps);
        $this->assertObjectHasAttribute('Interface120', $mockDeps);
        $this->assertTrue(method_exists($mockDeps->Test119, 'methodOne'));
        $this->assertTrue(method_exists($mockDeps->Test119, 'methodTwo'));
        $this->assertTrue(method_exists($mockDeps->Test119, 'methodThree'));
        $this->assertTrue(method_exists($mockDeps->Interface120, 'someMethod'));
    }

    /**
     * @test
     * it should allow mocking interface dependencies with magic methods
     */
    public function it_should_allow_mocking_interface_dependencies_with_magic_methods()
    {
        $sut = new tad_MockObject($this, 'Test231');
        $mockDeps = $sut->setMethod('methodTwo')
            ->getMocks();
        $this->assertObjectHasAttribute('Test119', $mockDeps);
        $this->assertObjectHasAttribute('Interface119', $mockDeps);
        $this->assertTrue(method_exists($mockDeps->Test119, 'methodOne'));
        $this->assertTrue(method_exists($mockDeps->Test119, 'methodTwo'));
        $this->assertTrue(method_exists($mockDeps->Test119, 'methodThree'));
        $this->assertTrue(method_exists($mockDeps->Interface119, '__call'));
    }

    /**
     * @test
     * it should allow setting expectations on returned methods
     */
    public function it_should_allow_setting_expectations_on_returned_methods()
    {
        $sut = new tad_MockObject($this, 'Test231');
        $mockDeps = $sut->setMethod('methodThree')
            ->getMocks();
        $mockDeps->Test119->expects($this->once())
            ->method('methodOne');
        $mockDeps->Interface120->expects($this->once())
            ->method('someMethod');
        $test231 = new Test231();
        $test231->methodThree($mockDeps->Test119, $mockDeps->Interface120);
    }

    /**
     * @test
     * it should allow setting return values on returned methods
     */
    public function it_should_allow_setting_return_values_on_returned_methods()
    {
        $sut = new tad_MockObject($this, 'Test231');
        $mockDeps = $sut->setMethod('methodThree')
            ->getMocks();
        $mockDeps->Test119->expects($this->once())
            ->method('methodOne')
            ->will($this->returnValue(4));
        $mockDeps->Interface120->expects($this->once())
            ->method('someMethod')
            ->will($this->returnValue(5));
        $test231 = new Test231();
        $this->assertEquals(9, $test231->methodThree($mockDeps->Test119, $mockDeps->Interface120));
    }

}