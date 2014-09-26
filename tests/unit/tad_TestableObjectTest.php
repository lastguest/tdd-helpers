<?php
class A extends tad_TestableObject
{

    /**
     * @f functionOne functionTwo
     * @g functionOne functionTwo
     */
    public function methodOne()
    {

    }
}

class B extends tad_TestableObject
{

    /**
     * @f functionOne functionTwo
     * @g functionOne functionTwo
     */
    public function methodOne()
    {

    }

    /**
     * @f functionOne functionTwo
     * @g functionOne functionTwo
     */
    public function methodTwo()
    {

    }
}

class C extends tad_TestableObject
{

    public function methodOne()
    {

    }
}

class Test678 extends tad_TestableObject {

    /**
     * @depends A, B, C
     */
    public function __construct(){
    }

    /**
     * @depends A, B, C
     */
    public function methodOne(){

    }
}
class tad_TestableObjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * it should allow getting mocked dependencies of constructor
     */
    public function it_should_allow_getting_mocked_dependencies_of_constructor()
    {
        $deps = Test678::getMocksFor($this, '__construct');
        $this->assertInstanceOf('stdClass', $deps);
        $this->assertObjectHasAttribute('A', $deps);
        $this->assertObjectHasAttribute('B', $deps);
        $this->assertObjectHasAttribute('C', $deps);
        $this->assertTrue(method_exists($deps->A, 'methodOne'));
        $this->assertTrue(method_exists($deps->B, 'methodOne'));
        $this->assertTrue(method_exists($deps->B, 'methodTwo'));
        $this->assertTrue(method_exists($deps->C, 'methodOne'));
    }

    /**
     * @test
     * it should allow getting mocked dependencies of method
     */
    public function it_should_allow_getting_mocked_dependencies_of_method()
    {
        $deps = Test678::getMocksFor($this, 'methodOne');
        $this->assertInstanceOf('stdClass', $deps);
        $this->assertObjectHasAttribute('A', $deps);
        $this->assertObjectHasAttribute('B', $deps);
        $this->assertObjectHasAttribute('C', $deps);
        $this->assertTrue(method_exists($deps->A, 'methodOne'));
        $this->assertTrue(method_exists($deps->B, 'methodOne'));
        $this->assertTrue(method_exists($deps->B, 'methodTwo'));
        $this->assertTrue(method_exists($deps->C, 'methodOne'));
    }
}