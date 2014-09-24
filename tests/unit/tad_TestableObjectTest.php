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

class D extends tad_TestableObject
{

    /**
     * @f functionOne,functionTwo
     * @g functionOne,functionTwo
     */
    public function methodOne()
    {
    }

    /**
     * @f functionThree, functionFour
     * @g functionThree, functionFour
     */
    public function methodTwo()
    {
    }

    /**
     * @f functionFive;functionSix
     * @g functionFive;functionSix
     */
    public function methodThree()
    {
    }

    /**
     * @f functionSeven; functionEight
     * @g functionSeven; functionEight
     */
    public function methodFour()
    {
    }

    /**
     * @f functionNine functionTen
     * @g functionNine functionTen
     */
    public function methodFive()
    {
    }
}

class tad_TestableObjectTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
    }

    protected function tearDown()
    {
    }

    /**
     * @test
     * it should return a mock functions adapter with mocked methods
     */
    public function it_should_return_a_mock_functions_adapter_with_mocked_methods()
    {
        $fMock = A::getMockFunctionsAdapter($this);
        $this->assertTrue(method_exists($fMock, '__call'));
        $this->assertTrue(method_exists($fMock, 'functionOne'));
        $this->assertTrue(method_exists($fMock, 'functionTwo'));
    }

    /**
     * @test
     * it should not mock the same functions adapters methods twice
     */
    public function it_should_not_mock_the_same_functions_adapter_methods_twice()
    {
        $fMock = B::getMockFunctionsAdapter($this);
        $this->assertTrue(method_exists($fMock, '__call'));
        $this->assertTrue(method_exists($fMock, 'functionOne'));
        $this->assertTrue(method_exists($fMock, 'functionTwo'));
    }

    /**
     * @test
     * it should always mock the functions adapter call method
     */
    public function it_should_always_mock_the_functions_adpater_call_method()
    {
        $fMock = C::getMockFunctionsAdapter($this);
        $this->assertTrue(method_exists($fMock, '__call'));
    }

    /**
     * @test
     * it should deal with different separators for the functions adapter methods
     */
    public function it_should_deal_with_different_separators_for_the_functions_adapter_methods()
    {
        $fMock = D::getMockFunctionsAdapter($this);
        $this->assertTrue(method_exists($fMock, '__call'));
        $this->assertTrue(method_exists($fMock, 'functionOne'));
        $this->assertTrue(method_exists($fMock, 'functionTwo'));
        $this->assertTrue(method_exists($fMock, 'functionThree'));
        $this->assertTrue(method_exists($fMock, 'functionFour'));
        $this->assertTrue(method_exists($fMock, 'functionFive'));
        $this->assertTrue(method_exists($fMock, 'functionSix'));
        $this->assertTrue(method_exists($fMock, 'functionSeven'));
        $this->assertTrue(method_exists($fMock, 'functionEight'));
        $this->assertTrue(method_exists($fMock, 'functionNine'));
        $this->assertTrue(method_exists($fMock, 'functionTen'));
    }

    /**
     * @test
     * it should return a mock globals adapter with mocked methods
     */
    public function it_should_return_a_mock_globals_adapter_with_mocked_methods()
    {
        $gMock = A::getMockGlobalsAdapter($this);
        $this->assertTrue(method_exists($gMock, '__call'));
        $this->assertTrue(method_exists($gMock, 'functionOne'));
        $this->assertTrue(method_exists($gMock, 'functionTwo'));
    }

    /**
     * @test
     * it should not mock the same globals adapters methods twice
     */
    public function it_should_not_mock_the_same_globals_adapter_methods_twice()
    {
        $gMock = B::getMockGlobalsAdapter($this);
        $this->assertTrue(method_exists($gMock, '__call'));
        $this->assertTrue(method_exists($gMock, 'functionOne'));
        $this->assertTrue(method_exists($gMock, 'functionTwo'));
    }

    /**
     * @test
     * it should always mock the globals adapter call method
     */
    public function it_should_always_mock_the_globals_adpater_call_method()
    {
        $gMock = C::getMockGlobalsAdapter($this);
        $this->assertTrue(method_exists($gMock, '__call'));
    }

    /**
     * @test
     * it should deal with different separators for the globals adapter methods
     */
    public function it_should_deal_with_different_separators_for_the_globals_adapter_methods()
    {
        $gMock = D::getMockGlobalsAdapter($this);
        $this->assertTrue(method_exists($gMock, '__call'));
        $this->assertTrue(method_exists($gMock, 'functionOne'));
        $this->assertTrue(method_exists($gMock, 'functionTwo'));
        $this->assertTrue(method_exists($gMock, 'functionThree'));
        $this->assertTrue(method_exists($gMock, 'functionFour'));
        $this->assertTrue(method_exists($gMock, 'functionFive'));
        $this->assertTrue(method_exists($gMock, 'functionSix'));
        $this->assertTrue(method_exists($gMock, 'functionSeven'));
        $this->assertTrue(method_exists($gMock, 'functionEight'));
        $this->assertTrue(method_exists($gMock, 'functionNine'));
        $this->assertTrue(method_exists($gMock, 'functionTen'));
    }
}