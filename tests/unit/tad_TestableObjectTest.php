<?php
class A extends  tad_TestableObject{

	/**
	 * @F functionOne functionTwo
     * @G functionOne functionTwo
	 */
	public function methodOne(){

	}
}
class B extends  tad_TestableObject{

    /**
     * @F functionOne functionTwo
     * @G functionOne functionTwo
     */
    public function methodOne(){

    }
    /**
     * @F functionOne functionTwo
     * @G functionOne functionTwo
     */
    public function methodTwo(){

    }
}
class C extends  tad_TestableObject{

    public function methodOne(){

    }
}
class D extends  tad_TestableObject{

    /**
     * @F functionOne,functionTwo
     * @G functionOne,functionTwo
     */
    public function methodOne(){
    }
    /**
     * @F functionThree, functionFour
     * @G functionThree, functionFour
     */
    public function methodTwo(){
    }
    /**
     * @F functionFive;functionSix
     * @G functionFive;functionSix
     */
    public function methodThree(){
    }
    /**
     * @F functionSeven; functionEight
     * @G functionSeven; functionEight
     */
    public function methodFour(){
    }
    /**
     * @F functionNine functionTen
     * @G functionNine functionTen
     */
    public function methodFive(){
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
	public function it_should_return_a_mock_functions_adapter_with_mocked_methods() {
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
     * it should deal with different separators
     */
    public function it_should_deal_with_different_separators()
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
}