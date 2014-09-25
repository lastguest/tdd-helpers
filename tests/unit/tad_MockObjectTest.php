<?php

interface Interface119
{
    public function __call($name, $args);
}

interface Interface120
{
    public function someMethod($name, $args);
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
     * @inject Test119, Interface120
     */
    public function __construct()
    {
    }

    /**
     * @inject Test119, Interface120
     */
    public function methodOne(){

    }

    /**
     * @inject Test119, Interface119
     */
    public function methodTwo(){

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
        $this->assertArrayHasKey('Test119', $mockDeps);
        $this->assertArrayHasKey('Interface120', $mockDeps);
        $this->assertTrue(method_exists($mockDeps['Test119'], 'methodOne'));
        $this->assertTrue(method_exists($mockDeps['Test119'], 'methodTwo'));
        $this->assertTrue(method_exists($mockDeps['Test119'], 'methodThree'));
        $this->assertTrue(method_exists($mockDeps['Interface120'], 'someMethod'));
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
        $this->assertArrayHasKey('Test119', $mockDeps);
        $this->assertArrayHasKey('Interface120', $mockDeps);
        $this->assertTrue(method_exists($mockDeps['Test119'], 'methodOne'));
        $this->assertTrue(method_exists($mockDeps['Test119'], 'methodTwo'));
        $this->assertTrue(method_exists($mockDeps['Test119'], 'methodThree'));
        $this->assertTrue(method_exists($mockDeps['Interface120'], 'someMethod'));
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
        $this->assertArrayHasKey('Test119', $mockDeps);
        $this->assertArrayHasKey('Interface119', $mockDeps);
        $this->assertTrue(method_exists($mockDeps['Test119'], 'methodOne'));
        $this->assertTrue(method_exists($mockDeps['Test119'], 'methodTwo'));
        $this->assertTrue(method_exists($mockDeps['Test119'], 'methodThree'));
        $this->assertTrue(method_exists($mockDeps['Interface119'], '__call'));
    }
}